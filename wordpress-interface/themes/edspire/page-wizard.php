<?php

if($_SERVER['REQUEST_METHOD'] == "POST") {

	// process form submission
	$learner = $_POST['wiz-learner'];
	$subject = $_POST['wiz-subject'];
	$material = $_POST['wiz-material'];
	$time = $_POST['wiz-time'];
	$important = $_POST['wiz-important'];

	$learner = subarray_intersect( $learner, $wiz_learners, 'val');
	$subject = array_intersect( $subject, array_keys($subject_singular));
	$material = subarray_intersect( $material, $wiz_materials, 'val');
	$time = subarray_intersect( $time, $wiz_time, 'val');
	$important = subarray_intersect( $important, $wiz_matters, 'val');

	$wizard = array(
			"created" => date('Y-m-d H:i:s', time()),
			"version" => "1.0",
			"learner" => $learner,
			"subjects" => $subject,
			"material" => $material,
			"important" => $important,
			"alerting" => 'no thanks'
	);

	if(! IsNullOrEmptyString($time) && is_numeric($time) ) {
		$wizard["time"] = intval($time);
	}

	$owner_id = 5;
	
	if (is_user_logged_in()) {
	
		$current_user = wp_get_current_user();
		
		$owner_id = $current_user->ID;
		
		$wizard["name"] = $current_user->user_login . "'s wizard";
		$wizard["owner_id"] = $current_user->ID;
		$wizard["privacy"] = "private";
		
	} else {
	
		$wizard["privacy"] = "guest";
		$wizard["name"] = "guest user's wizard";
		$wizard["owner_id"] = $owner_id;
		
		session_start();
		$_SESSION['wizard'] = $wizard; // store in the session in case we need the user to login
		
	}
	
	$wizard_id = add_user_meta( $owner_id, 'wizard', json_encode($wizard) );

	header('Location: /wizard/' . $wizard_id . '/');
	exit();

}

// show the blank wizard page
get_header();
	
$nonce = wp_create_nonce("ed_wizard");	
?>

	<div class="headfaker"> </div>

	<div class="w0">
      <article class="pt-style">

        <h1><?php the_title(); ?></h1>
	
		    <form action="/wizard/" method="POST" id="wizard">
			  <? wp_nonce_field( 'ed_wizard' ); ?>
			  <div class="q0">
				<h3>Tell us your motivation for learning</h3>
		
				<ul>
				  <?php 
				  foreach($wiz_learners as $learner): ?>
					<li><input id="learner<?php echo $learner["val"]; ?>" type="radio" name="wiz-learner" value="<?php echo $learner["val"]; ?>"/> <label for="learner<?php echo $learner["val"]; ?>"><?php echo $learner["label"]; ?><?php echo ($learner["val"]=='other' ? ' <input type="text" name="q1o"/>' : ''); ?></label></li>
				  <?php endforeach; ?>
				</ul>
			  </div>
			  
			  <div class="q0">
				<h3>Pick a subject or profession</h3>
				
				  <?php 
				  foreach($subject_grid as $k => $group) :
				  ?>
				  <div class="a0">
				    <ul>
				  <?php   
				  foreach($group as $subject): ?>
					  <li><input id="subject<?php echo $subject; ?>" type="radio" name="wiz-subject" value="<?php echo $subject; ?>"/> <label for="subject<?php echo $subject; ?>"><?php echo $subject_singular[$subject]; ?></label></li>
				  <?php endforeach; ?>
				    </ul>
				  </div>
				  <?php endforeach; ?>
			  </div>
			  
			  <div class="q0">
				<h3>How do you like to learn?</h3>
		
				<ul>
				  <?php $ix = 1; 
				  foreach($wiz_materials as $material): ?>
					<li><input id="material<?php echo $material["val"]; ?>" type="checkbox" name="wiz-material" value="<?php echo $material["val"]; ?>"/> <label for="material<?php echo $material["val"]; ?>"><?php echo $material["label"]; ?></label></li>
				  <?php $ix++; 
				  endforeach; ?>
				</ul>
			  </div>
			  
			  <div class="q0">
				<h3>How much time do you have?</h3>
		
				<ul>
				  <?php 
				  foreach($wiz_time as $time): ?>
					<li><input id="time<?php echo $time["val"]; ?>" type="radio" name="wiz-time" value="<?php echo $time["val"]; ?>"/> <label for="time<?php echo $time["val"]; ?>"><?php echo $time["label"]; ?></label></li>
				  <?php endforeach; ?>
				</ul>
			  </div>
			  
			  <div class="q0">
				<h3>How much do you want to spend?</h3>
		
				<ul>
				  <?php 
				  foreach($wiz_matters as $matters): ?>
					<li><input id="matters<?php echo $matters["val"]; ?>" type="radio" name="wiz-important" value="<?php echo $matters["val"]; ?>"/> <label for="matters<?php echo $matters["val"]; ?>"><?php echo $matters["label"]; ?></label></li>
				  <?php endforeach; ?>
				</ul>
			  </div>
			  <input type="submit" value="Go"/>
		    </form>
	  </article>
    </div>
		
<?php 

get_footer();

?>