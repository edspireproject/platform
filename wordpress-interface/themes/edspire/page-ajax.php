<?php 
$action = $_REQUEST["action"];

if($action == 'fav') {
	favdel('fav');
} elseif($action == 'del') {
	favdel('del');
} elseif($action == 'unfav') {
	unfavdel('fav');
} elseif($action == 'undel') {
	unfavdel('del');
}

function favdel($fn) {
	verify("ed_" . $fn);
	$result = array();
	$post_id = intval($_REQUEST["post_id"]);
	if($post_id > 0) {
		session_start();
		if(! $_SESSION[$fn] ) {
			$_SESSION[$fn] = array();
		}
		if( ! in_array( $post_id, $_SESSION[$fn] ) ) {
			$_SESSION[$fn][] = $post_id;
		}
		if( is_user_logged_in() ) {
			sync_session_user_meta(get_current_user_id(), $fn);
		}
		$result['result'] = 'true';
		$result['nonce'] = wp_create_nonce("ed_un_" . $fn);
		$result[$fn] = $_SESSION[$fn];
	}
	callback($result);
}

function unfavdel($fn) {
	verify("ed_un_" . $fn);
	$result = array();
	$post_id = intval($_REQUEST["post_id"]);
	if($post_id > 0) {
		session_start();
		if(! $_SESSION[$fn] ) {
			$_SESSION[$fn] = array();
		}
		if(($key = array_search($post_id, $_SESSION[$fn])) !== false) {
			unset($_SESSION[$fn][$key]);
		}
		if( is_user_logged_in() ) {
			sync_session_user_meta(get_current_user_id(), $fn);
		}
		$result['result'] = 'true';
		$result['nonce'] = wp_create_nonce("ed_" . $fn);
		$result[$fn] = $_SESSION[$fn];
	}
	callback($result);
}

function verify($fn) {
	if ( !wp_verify_nonce( $_REQUEST['nonce'], $fn)) {
		exit("Illegal action");
	}
}

function callback($result) {
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		echo json_encode($result);
		exit();
	} else {
		$referer = $_SERVER['HTTP_REFERER'];
		$referer = substr($referer, strpos($referer, '/', 10));
		header("Location: ". $referer );
		exit();
	}
}

if($action == "edit-wizard") {

	verify('ed_wizard');
	
	$wizard_id = intval($_GET["wizard_id"]);

	if($wizard_id > 0) {
		$wizard = get_wizard( $wizard_id );
		
		if($wizard["owner_id"] == get_current_user_id() ) {
			$mode = "edit";
		} elseif($wizard["owner_id"] == 5) {
			$mode = "guest";
		} else
			go404();
		
		if($mode == "edit" && isset($_GET["privacy"])) {
			if($_GET["privacy"] == "public") {
				$wizard["privacy"] = "public";
			} elseif($_GET["privacy"] == "private") {
				$wizard["privacy"] = "private";
			}
			update_wizard($wizard_id, $wizard);
			exit();
		}
		
		if($mode == "edit" && isset($_GET["label"])) {
			$name = $_GET["label"];
			$name = wp_kses( $name, array() );
			$name = substr($name, 0, 64);
			$wizard["name"] = $name;
			update_wizard($wizard_id, $wizard);
			exit();
		}
		
		if($mode == "edit" && isset($_GET["alerting"])) {
			$alerting = $_GET["alerting"];
			if($alerting == 'no thanks' || $alerting == 'weekly' || $alerting == 'monthly') {
				$wizard["alerting"] = $alerting;
				update_wizard($wizard_id, $wizard);
			}
			exit();
		}
		
		if(isset($_GET["learner"])) {
			$learner = $_GET["learner"];
			$learner = subarray_intersect( $learner, $wiz_learners, 'val');
			$wizard["learner"] = $learner;
			update_wizard($wizard_id, $wizard);
			exit();
		}

		if(isset($_GET["important"])) {
			$important = $_GET["important"];
			$important = subarray_intersect( $important, $wiz_matters, 'val');
			$wizard["important"] = $important;
			update_wizard($wizard_id, $wizard);
			exit();
		}
		
		if(isset($_GET["time"])) {
			$time = $_GET["time"];
			if(! IsNullOrEmptyString($time) && is_numeric($time) ) {
				$wizard["time"] = intval($time);
				update_wizard($wizard_id, $wizard);
			}
			exit();
		}
		
		if(isset($_GET["style"])) {
			$material = $_GET["style"];
			$material = subarray_intersect( $material, $wiz_materials, 'val');
			$wizard["material"] = $material;
			update_wizard($wizard_id, $wizard);
			exit();
		}
		
		if(isset($_GET["subject"])) {
			$subject = $_GET["subject"];
			var_dump( $subject );
			$subject = subarray_intersect( $subject, $subjects, 'val');
			$wizard["subjects"] = $subject;
			var_dump( $wizard );
			update_wizard($wizard_id, $wizard);
			exit();
		}
		
	}
} elseif($action == "copy-wizard") {
	
	verify('ed_wizard');
	
	if(!is_user_logged_in())
		go404();
	
	$wizard_id = intval($_GET["wizard_id"]);
	
	if($wizard_id > 0) {
		$wizard = get_wizard( $wizard_id );
	
		if($wizard["owner_id"] == 5 || ($wizard["owner_id"] != get_current_user_id() && $wizard["privacy"] == "public")) {
			$wizard["owner_id"] = get_current_user_id();
			$wizard["name"] = "Copy of " . $wizard["name"];
			$wizard["privacy"] = $wizard["privacy"] == "guest" ? "private" : "public";
			
			$wizard_id = add_user_meta( get_current_user_id(), 'wizard', json_encode($wizard) );
			
			header('Location: /?post_type=resource&use-wpcf=true&wizard_id=' . $wizard_id);
			exit();
		}
	}
	
} elseif($action == "delete-wizard") {
	
	verify('ed_wizard');
	
	if(!is_user_logged_in())
		go404();
	
	$wizard_id = intval($_GET["wizard_id"]);
	
	if($wizard_id > 0) {
		$wizard = get_wizard( $wizard_id );
	
		if($wizard["owner_id"] == get_current_user_id()) {
			$wizard["owner_id"] = 0 - $wizard["owner_id"];
			$wizard["privacy"] = "deleted";
			update_wizard($wizard_id, $wizard);
			
			// and switch to a different user
			global $wpdb;
			
			$wpdb->update(
					'le_usermeta',
					array( 'user_id' => 20 ),
					array( 'umeta_id' => $wizard_id ),
					array( '%d' ),
					array( '%d' )
			);
		}
	}
	
	exit();
	
} elseif($action == "edit-privacy") {
	
	verify('ed_privacy');
	
	if(!is_user_logged_in())
		go404();
	
	$prop_priv_map = array(
			'privacy_pins' => 'pins-privacy',
			'privacy_display_name' => 'display-name-privacy',
			'privacy_biography' => 'biography-privacy',
			);
	
	if(isset($_GET["property"])) {
		$property = $_GET["property"];
		if(array_key_exists( $property, $prop_priv_map )) {
			if(isset($_GET["privacy"])) {
				if($_GET["privacy"] == "public") {
					update_user_meta( get_current_user_id(), $prop_priv_map[$property], 'public' );
				} elseif($_GET["privacy"] == "private") {
					update_user_meta( get_current_user_id(), $prop_priv_map[$property], 'private' );
				}
			}
		} elseif( strpos($property, 'privacy_taken-') === 0 ) {
			$item_id = intval( substr($property, 14) );
			if(isset($_GET["privacy"])) {
				if($_GET["privacy"] == "public") {
					update_user_meta( get_current_user_id(), 'privacy_taken-' . $item_id, 'public' );
				} elseif($_GET["privacy"] == "private") {
					update_user_meta( get_current_user_id(), 'privacy_taken-' . $item_id, 'private' );
				}
			}
		}
	}
	exit();

} elseif($action == "calendar-on") {
	verify('ed_calendar');
	set_meta('calendar-' . intval($_GET["resource_id"]), true);
	exit();
} elseif($action == "calendar-off") {
	verify('ed_calendar');
	set_meta('calendar-' . intval($_GET["resource_id"]), false);
	exit();
} elseif($action == "profile-on") {
	verify('ed_profile');
	set_meta('taken-' . intval($_GET["resource_id"]), true);
	exit();
} elseif($action == "profile-off") {
	verify('ed_profile');
	set_meta('taken-' . intval($_GET["resource_id"]), false);
	exit();
}

function set_meta($meta_key, $meta_value) {
	if(!is_user_logged_in())
		go404();
	
	update_user_meta( get_current_user_id(), $meta_key, $meta_value );
}

$referer = $_SERVER['HTTP_REFERER'];
$referer = substr($referer, strpos($referer, '/', 10));
 
header('Location: ' . $referer); 
exit();
?>