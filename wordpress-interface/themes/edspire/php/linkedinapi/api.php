<?php

// a load of wrapper functions to do linked stuff for edspire

// TODO better error handling and logging

require_once('linkedin_3.2.0.class.php');

// display constants
global $BASE_API_CONFIG;
$BASE_API_CONFIG = array(
		'appKey'       => '7veqz3o3x8l4',
		'appSecret'    => '9xJLUXATlM7GZiJA',
		'callbackUrl'  => NULL
);

function get_linkedin_profile($token) {
	global $BASE_API_CONFIG;
	$API_CONFIG = $BASE_API_CONFIG;
	$OBJ_linkedin = new LinkedIn($API_CONFIG);
	$OBJ_linkedin->setTokenAccess($token);
	$OBJ_linkedin->setResponseFormat(LINKEDIN::_RESPONSE_XML);
	
	$response = $OBJ_linkedin->profile('~:(id,first-name,last-name,email-address,public-profile-url)');
	if($response['success'] === TRUE)
		return new SimpleXMLElement($response['linkedin']);
	else
		return false;
}

function connect_linkedin() {
	global $BASE_API_CONFIG;
	$API_CONFIG = $BASE_API_CONFIG;
	
	if($_SERVER['HTTPS'] == 'on') {
		$protocol = 'https';
	} else {
		$protocol = 'http';
	}
	
	// set the callback url
	$API_CONFIG['callbackUrl'] = wp_login_url() . '?' . LINKEDIN::_GET_TYPE . '=initiate&' . LINKEDIN::_GET_RESPONSE . '=1';
	$OBJ_linkedin = new LinkedIn($API_CONFIG);
	
	// check for response from LinkedIn
	$_GET[LINKEDIN::_GET_RESPONSE] = (isset($_GET[LINKEDIN::_GET_RESPONSE])) ? $_GET[LINKEDIN::_GET_RESPONSE] : '';
	if(!$_GET[LINKEDIN::_GET_RESPONSE]) {
		// LinkedIn hasn't sent us a response, the user is initiating the connection
	
		// send a request for a LinkedIn access token
		$response = $OBJ_linkedin->retrieveTokenRequest();
		if($response['success'] === TRUE) {
			// store the request token
			$_SESSION['oauth']['linkedin']['request'] = $response['linkedin'];
	
			// redirect the user to the LinkedIn authentication/authorisation page to initiate validation.
			header('Location: ' . LINKEDIN::_URL_AUTH . $response['linkedin']['oauth_token']);
		} else {
			// bad token request
			echo "Request token retrieval failed:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($OBJ_linkedin, TRUE) . "</pre>";
		}
	} else {
		// LinkedIn has sent a response, user has granted permission, take the temp access token, the user's secret and the verifier to request the user's real secret key
		$response = $OBJ_linkedin->retrieveTokenAccess($_SESSION['oauth']['linkedin']['request']['oauth_token'], $_SESSION['oauth']['linkedin']['request']['oauth_token_secret'], $_GET['oauth_verifier']);
		if($response['success'] === TRUE) {
			// the request went through without an error, gather user's 'access' tokens
			$access_tokens = $response['linkedin'];
	
			// if the user is currently logged in, associate this linkedin account with them
			// otherwise create a new account, log them in ... and then associate this linkedin account with them (Oh, it's a scythe)
			if(is_user_logged_in()) {
				$user = get_user_by( 'id', get_current_user_id() );
				update_user_meta( $user->ID, 'linkedin-access', json_encode($access_tokens) );
			} else {
				// try and get a local user by their secret token
				$users = get_users(array('meta_key' => 'linkedin-token', 'meta_value' => json_encode($access_tokens) ));
				if($users) {
					$user = $users[0];
					wp_clear_auth_cookie();
					wp_set_current_user ( $user->ID );
					wp_set_auth_cookie  ( $user->ID );
				} else {
					// try and get a local user by their linked in email address
					$OBJ_linkedin = new LinkedIn($API_CONFIG);
					$OBJ_linkedin->setTokenAccess($access_tokens);
					$OBJ_linkedin->setResponseFormat(LINKEDIN::_RESPONSE_XML);
					$profile = $OBJ_linkedin->profile('~:(id,first-name,last-name,email-address)');
					if($profile['success'] === TRUE) {
						$profile['linkedin'] = new SimpleXMLElement($profile['linkedin']);
						$email = $profile['linkedin']->{'email-address'};
						$user = get_user_by( 'email', $email );
						
						if(!$user) {
							// register a new user
							$username = '' . $profile['linkedin']->{'first-name'} . '-' . $profile['linkedin']->id;
							$errors = register_new_user($username, $email);
							if ( !is_wp_error($errors) ) {
								echo "Error creating a new user" . $errors;
							}
						}
						// log the user in
						wp_clear_auth_cookie();
						wp_set_current_user ( $user->ID );
						wp_set_auth_cookie  ( $user->ID );
						update_user_meta( $user->ID, 'linkedin-access', json_encode($access_tokens) );
						
					} else {
						// request failed
						echo "Error retrieving profile information:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response) . "</pre>";
			        }
				}
			}
			
			// redirect the user to their profile page
			header('Location: /profile/' );
		} else {
			// bad token access
			echo "Access token retrieval failed:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($OBJ_linkedin, TRUE) . "</pre>";
		}
	}
}

function revoke_linkedin() {
	global $BASE_API_CONFIG;
	$API_CONFIG = $BASE_API_CONFIG;	

	if(is_user_logged_in()) {
		$user = get_user_by( 'id', get_current_user_id() );
		
		if( $user->get('linkedin-access') ) {
		
			$OBJ_linkedin = new LinkedIn($API_CONFIG);
			$OBJ_linkedin->setTokenAccess(json_decode( $user->get('linkedin-access'), true ));
			$response = $OBJ_linkedin->revoke();
			if($response['success'] === TRUE) {
				// revocation successful, clear user's tokens
				update_user_meta( $user->ID, 'linkedin-access', '' );
				header('Location: /profile/' );
			} else {
				// revocation failed
				echo "Error revoking user's token:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($OBJ_linkedin, TRUE) . "</pre>";
			}
		} else {
			echo "User has no LinkedIn account connected";
		}
	} else {
		echo "User isn't logged in";
	}
}