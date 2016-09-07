<?php

/** WordPress User Administration API */
require_once(ABSPATH . 'wp-admin/includes/user.php');

wp_enqueue_script('user-profile');

$user_id = get_query_var('profile_id');

$current = get_user_by( 'id', get_current_user_id() );

$profile_mode = "view";

if(empty($user_id) && !empty($current))
	$user_id = $current->user_login;

if(empty($user_id)) {
	goLogin();
} else {
	$user = get_userdatabylogin( $user_id );

	if(empty($user))
		$profile_mode = "view";
}

if(!empty($user)) {
	if($user->user_login == $current->user_login) {
		// we can change things
		$profile_mode = "edit";
		if(isset($_GET['set-privacy'])) {
			if($_GET['set-privacy'] == 'public') {
				update_user_meta( $current->ID, 'profile-privacy', 'public' );
			} else {
				update_user_meta( $current->ID, 'profile-privacy', 'private' );
			}
			header('Location: /profile/');
			exit;
		}
		if(isset($_GET['set-newsletter'])) {
			if($_GET['set-newsletter'] == '1') {
				update_user_meta( $current->ID, 'newsletter', '1' );
			} else {
				update_user_meta( $current->ID, 'newsletter', '0' );
			}
			header('Location: /profile/');
			exit;
		}
		if(isset($_POST['display_name'])) {
			$display_name = substr( wp_kses( $_POST['display_name'], array() ), 0, 64);
			$biography = substr( wp_kses( $_POST['biography'], array('em' => array(),'strong' => array() ) ), 0, 255);
			wp_update_user( array ( 'ID' => $current->ID, 'display_name' => $display_name ) ) ;
			update_user_meta( $current->ID, 'biography', $biography );
			header('Location: /profile/');
			exit;
		}
		if(isset($_POST['update-password'])) {
			$pass1 = $pass2 = '';
			if ( isset( $_POST['pass1'] ))
				$pass1 = $_POST['pass1'];
			if ( isset( $_POST['pass2'] ))
				$pass2 = $_POST['pass2'];
			
			$errors = new WP_Error();
			
			/* checking the password has been typed twice */
			do_action_ref_array( 'check_passwords', array ( $user->user_login, & $pass1, & $pass2 ));
			
			if ( empty($pass1) && !empty($pass2) )
				$errors->add( 'pass', __( '<strong>ERROR</strong>: You entered your new password only once.' ), array( 'form-field' => 'pass1' ) );
			elseif ( !empty($pass1) && empty($pass2) )
			$errors->add( 'pass', __( '<strong>ERROR</strong>: You entered your new password only once.' ), array( 'form-field' => 'pass2' ) );
			
			/* Check for "\" in password */
			if ( false !== strpos( stripslashes($pass1), "\\" ) )
				$errors->add( 'pass', __( '<strong>ERROR</strong>: Passwords may not contain the character "\\".' ), array( 'form-field' => 'pass1' ) );
			
			/* checking the password has been typed twice the same */
			if ( $pass1 != $pass2 )
				$errors->add( 'pass', __( '<strong>ERROR</strong>: Please enter the same password in the two password fields.' ), array( 'form-field' => 'pass1' ) );
			
			if ( !empty( $pass1 ) ) {
				if ( ! $errors->get_error_codes() ) {
					$user->user_pass = $pass1;
					wp_update_user($user);
					header('Location: /profile/');
				}	
			}
		}
		
	} elseif($user->get('profile-privacy') == 'public') {
		// we can show the page, or at least those parts of it the user hasn't explicitly restricted
		
	} else
		go404();
} else
	goLogin();

$biography = wp_kses( get_user_meta($user->ID, 'biography', true), array('em' => array(),'strong' => array() ) );

if(isset($_GET['preview']))
	$profile_mode = "view";

get_header();

?>

<div class="headfaker"> </div>

<div class="w0">
  <article class="pt-profile">
<?php 

if($profile_mode == 'edit') : 


// begin linked in stuff
require_once(__DIR__.'/php/linkedinapi/api.php');

?>		
				<div class="cf box">
				
					<div class="search-pagination standard">
						<h1>Profile</h1>
						<div class="profile-pic"></div><div class="profile-pic-1"></div><div class="profile-pic-2"></div>
					</div>
					
					<div class="col col-content profile"><a name="thecontent"></a>
					  <h2 class="<?php echo ($user->get('profile-privacy') == 'public' ? 'private' : 'public'); ?>">Privacy</h2>
					  <input type="hidden" name="user_login" id="user_login" value="<?php echo esc_attr($user->user_login); ?>"/>
					  <?php if($user->get('profile-privacy') == 'public') : ?>
					  <p>Your profile is <strong>public</strong>. This means when other people visit this page they will be shown a 
					  version of this page which shows <em>only</em> the information that you have specifically set to be <strong>public</strong>.</p>
					  <p><a href="/profile/<?php echo $user_id; ?>/?preview">Click here to see your profile page as other people would see it.</a></p>
					  
					  <p>If you prefer, you can completely hide your profile page
					  <?php else: ?>
					  
					  <?php endif; ?>
					  <a class="privacy-change <?php echo ($user->get('profile-privacy') == 'public' ? 'private' : 'public'); ?>" href="/profile/?set-privacy=<?php echo ($user->get('profile-privacy') == 'public' ? 'private' : 'public'); ?>">make my profile <?php echo ($user->get('profile-privacy') == 'public' ? 'private' : 'public'); ?></a>
					  
					  <h2>Personal information</h2>

					  <form method="POST">
					  <ul>
					    <li><label class="pers">Display name:</label><input type="text" name="display_name" value="<?php echo esc_attr($user->display_name); ?>" />
					    <?php show_privacy( 'privacy_display_name', get_user_meta($user->ID, 'display-name-privacy', true) ); ?></li>
					    
					    <li><label class="pers">Short biography:</label><textarea name="biography"><?php echo $biography; ?></textarea>
					    <?php show_privacy( 'privacy_biography', get_user_meta($user->ID, 'biography-privacy', true) ); ?></li>
					    
					    <li><label class="pers"> </label><input type="submit" value="Save changes" />
					  </ul>
					    
					  </form>
					  
					  <h2>Newsletter</h2>
					  
					  <ul>
					    <li><label class="pers">Email address:</label><?php echo $user->user_email; ?>
					    <div class="privacy"><em>We will never display your email address to anyone else</em></div></li>
					    
					    <li>Receive newsletter? <input type="radio" id="toggle-newsletter-1" name="set-newsletter" value="1" <?php echo ($user->get('newsletter') == '1' ? 'checked="checked"':''); ?> /> <label for="toggle-newsletter-1">Yes</label>
					    <input type="radio" id="toggle-newsletter-0" name="set-newsletter" value="0" <?php echo ($user->get('newsletter') == '0' ? 'checked="checked"':''); ?> /> <label for="toggle-newsletter-0">No</label></li>
					  </ul>
					  
					  <h2>Password</h2>
					  
					  <form method="POST" class="change-pwd">
					  <p>You can use this section to change your password.</p>
					  <p class="description indicator-hint">The password should be at least seven characters long. To make it stronger, use 
					  upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).</p>					  
					  
					  <?php if(isset($errors) && $errors->get_error_codes()) : ?>
					  <div class="error">
					    <p><?php echo $errors->get_error_message(); ?></p>
					  </div>
					  <?php endif; ?>
					    <input type="hidden" name="update-password" value="yes" />
					    <ul>
					      <li><label class="pass" for="pass1">Type a new password</label><input type="password" name="pass1" id="pass1" size="16" value="" autocomplete="off" /></li>
						  <li><label class="pass" for="pass2">Type the new password again</label><input type="password" name="pass2" id="pass2" size="16" value="" autocomplete="off" /></li>
						  <li><div class="pass" id="pass-strength-result"><?php _e('Strength indicator'); ?></div><input type="submit" value="Save password"/></li>
						</ul>
					  </form>
					  
					  <h2>Wizards</h2>
					  
					  <?php 
					  global $wpdb;
					  // $wizards = get_user_meta($user->ID, 'wizard');
					  $wizards = $wpdb->get_results(
					  		"SELECT *
					  		FROM $wpdb->usermeta
					  		WHERE meta_key = 'wizard'
					  		AND user_id = " . $user->ID
					  );
					  $wiztitle = '<ul class="profile-wizards">';
					  foreach($wizards as $wizard):
					  $wiz = json_decode( $wizard->meta_value, true );
					  echo $wiztitle;
					  ?>
					  			<li><a href="/?post_type=resource&use-wpcf=true&wizard_id=<?php echo $wizard->umeta_id; ?>"><?php echo wp_kses( $wiz["name"], array() ); ?></a>
					  			<?php show_privacy( 'privacy_wizard_' . $wizard->umeta_id, $wiz["privacy"] ); ?>
					  			<?php show_alerting( $wizard->umeta_id, $wiz["alerting"] ); ?>
								<button class="delete" onclick="deleteWizard(<?php echo $wizard->umeta_id; ?>)">delete</button>
					  			</li>
					  		<?php
					  		$wiztitle = '';
					  endforeach;
					  if($wiztitle == '') {
					  	echo "</ul>";
					  }	else {
						echo "<p>You haven't created any wizards yet. " . 'Create your first <a href="/wizard/">wizard</a> and you can then subscribe to email alerts when new matching resources appear.</p>';
					  }				  
					  ?>
					  
					  <h2>Pins</h2>
					  <?php 
					    $pins = get_user_meta( $user->ID, 'fav', true);
					    $cPins = 0;
					    foreach($pins as $pin) {
							$cPins++;
					    }
					    if($cPins == 0) {
					    	echo "You haven't pinned any resources yet. ";
					    } else {
					    	echo 'You have pinned <a href="/pins/">' . $cPins . ' resource' . ($cPins == 1 ? '' : 's') . '</a>. ';
					    } 
					  ?>
					  
					  <?php show_privacy( 'privacy_pins', get_user_meta($user->ID, 'pins-privacy', true) ); ?>
<p>&nbsp;</p>
					  <h2>Exclusions</h2>
					  <?php 
					    $pins = get_user_meta( $user->ID, 'del', true);
					    $cPins = 0;
					    foreach($pins as $pin) {
							$cPins++;
					    }
					    if($cPins == 0) {
					    	echo "You haven't excluded any resources yet. ";
					    } else {
					    	echo 'You have excluded <a href="/exclusions/">' . $cPins . ' resource' . ($cPins == 1 ? '' : 's') . '</a>. ';
					    } 
					  ?>
					  
					  <?php show_privacy( 'privacy_pins', get_user_meta($user->ID, 'pins-privacy', true) ); ?>
<p>&nbsp;</p>
<h2>LinkedIn profile</h2>
					  
					  <?php  

					  if( $user->get('linkedin-access') ) {
			              $profile = get_linkedin_profile( json_decode( $user->get('linkedin-access'), true ) );
		              
			              if($profile) {
						?>
						<ul>
					      <li><label class="pass" for="lifname">First name</label>
					      <input type="text" name="lifname" id="lifname" readonly value="<?php echo esc_attr($profile->{'first-name'}); ?>"/></li>
					      <li><label class="pass" for="lilname">Last name</label>
					      <input type="text" name="lilname" id="lilname" readonly value="<?php echo esc_attr($profile->{'last-name'}); ?>"/></li>
					      <li><label class="pass">Public profile</label>
						  <a href="<?php echo esc_attr($profile->{'public-profile-url'}); ?>"><?php echo $profile->{'public-profile-url'}; ?></a></li>
						</ul>
						<br/>
						<form id="linkedin_revoke_form" action="<?php echo esc_url( wp_login_url() );?>" method="get">
					    	<input type="hidden" name="<?php echo LINKEDIN::_GET_TYPE;?>" id="<?php echo LINKEDIN::_GET_TYPE;?>" value="revoke" />
					        <input type="submit" value="Revoke Authorization" />
					    </form>
						
						<?php 
		              } else {
		                // request failed
		                echo "Unable to retrieve your profile from LinkedIn";
		              }
		              ?>
					              
					<?php 
					            } else {
?>
            <form id="linkedin_connect_form" action="<?php echo esc_url( wp_login_url() );?>" method="get">
              <input type="hidden" name="<?php echo LINKEDIN::_GET_TYPE;?>" id="<?php echo LINKEDIN::_GET_TYPE;?>" value="initiate" />
              <input type="submit" value="Connect to LinkedIn" />
            </form>
<?php 
					}
					            
					?>
					  <p>&nbsp;</p>
					</div>

					
				</div>
<?php else: ?>
				<div class="cf box">
				
					<div class="search-pagination standard">
						<h1><?php echo get_user_meta($user->ID, 'display-name-privacy', true) == 'public' ? $user->display_name : $user->user_login; ?></h1><a name="thecontent"></a>
						<div class="profile-pic"></div><div class="profile-pic-1"></div><div class="profile-pic-2"></div>
					</div>
					
					<div class="col col-content profile"><a name="thecontent"></a>
					<?php if( get_user_meta($user->ID, 'biography-privacy', true) == 'public' ): ?>
						<p style="padding-right: 4em;"><?php echo $biography; ?>
					<?php endif; ?>

<?php
global $wpdb; 

$wizards = $wpdb->get_results(
	"SELECT *
		FROM $wpdb->usermeta
		WHERE meta_key = 'wizard'
		AND user_id = " . $user->ID	
	);
$wiztitle = '<h2>Wizards</h2><ul>';
foreach($wizards as $wizard):
	$wiz = json_decode( $wizard->meta_value, true );
	if($wiz["privacy"] == "public"):
		echo $wiztitle;
		?>
			<li><a href="/?post_type=resource&use-wpcf=true&wizard_id=<?php echo $wizard->umeta_id; ?>"><?php echo wp_kses( $wiz["name"], array() ); ?></a></li>
		<?php
		$wiztitle = '';
	endif;
endforeach;
if($wiztitle == '') {
	echo "</ul>";
}

$show_pins = get_user_meta($user->ID, 'pins-privacy', true);
if( $show_pins == "public" ):
	$pintitle = '<h2>Pins</h2><ul>';
	// get pins
	$pins = upb_get_user_meta( $user->ID );
	foreach($pins as $pin):
		// TODO allow sharing per pin
		if(true):
			echo $pintitle;
			?>
				<li><a href="<?php echo get_permalink( $pin ); ?>"><?php echo get_the_title( $pin ); ?></a></li>
			<?php
			$pintitle = '';
		endif;
	endforeach;
endif;

$takens = $wpdb->get_results(
		"SELECT *
  		FROM $wpdb->usermeta
  		WHERE meta_key like 'taken-%'
  		AND user_id = " . $user->ID . " AND meta_value = 1"
);

$taktitle = '<h2>Resources used</h2><ul>';
foreach($takens as $taken):
$taken_id = intval(substr($taken->meta_key, 6));
if( get_user_meta($user->ID, 'privacy_taken-' . $taken_id, true) == 'public' ):
	echo $taktitle;
?>
			<li><a href="<?php echo get_permalink($taken_id); ?>" title="<?php echo esc_attr( sprintf( __( '%s', 'learningengineone' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php echo get_the_title($taken_id); ?></a></li>
<?php
	$taktitle = '';
endif;
endforeach;
if($taktitle == '') {
	echo "</ul>";
}
?>
					</div>
				</div>
<?php endif; ?>
	</article>
</div>
<?php 

get_footer();

function goLogin() {
	header('Location: ' . site_url('login/') );
	exit();
}
?>