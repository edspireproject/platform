<?php 

global $subject_singular, $style_singular;

$mixed = array();

$post_type = get_post_type();
$provider = get_post_meta($post->ID, 'wpcf-provider', true);
$format = get_post_meta($post->ID, 'wpcf-format', true);
$provider_difficulty = get_post_meta($post->ID, 'wpcf-provider-difficulty', true);
$university = get_post_meta($post->ID, 'wpcf-university', true);
$posttags = get_the_tags($post->ID);
$provider_link = get_post_meta($post->ID, 'wpcf-provider-link', true);
$cost_cur = strval(get_post_meta($post->ID, 'wpcf-cost-cur', true));
$cost_val = strval(get_post_meta($post->ID, 'wpcf-cost-val', true));
$cost_sub = strval(get_post_meta($post->ID, 'wpcf-cost-sub', true));
$cost = format_cost( $cost_cur, $cost_val, $cost_sub );
$availability = strval(get_post_meta($post->ID, 'wpcf-availability', true));
$next_start = strval(get_post_meta($post->ID, 'wpcf-next-start', true));
$schedule = strval(get_post_meta($post->ID, 'wpcf-schedule', true));
$duration = strval(get_post_meta($post->ID, 'wpcf-duration', true));
$length = get_post_meta($post->ID, 'wpcf-video-length', true);
$workload = strval(get_post_meta($post->ID, 'wpcf-workload', true));
$workload_min = strval(get_post_meta($post->ID, 'wpcf-workload-min', true));
$workload_max = strval(get_post_meta($post->ID, 'wpcf-workload-max', true));
$work = format_workload( $workload, $workload_min, $workload_max );
$next = format_next_start( $schedule, $next_start );

$subject = $subject_singular[strval(get_post_meta($post->ID, 'edspire-primary-subject', true))];
$style = $style_singular[strval(get_post_meta($post->ID, 'edspire-style', true))];


$itemtype = "http://schema.org/ScholarlyArticle";
$taught = "Taught";
if($format == 'video')
	$taught = "Presented";


$mixed["nasjahId"] = $post->ID;
$mixed["itemtype"] = $itemtype;
if($provider != "")
	$mixed["provider"] = $provider;
$mixed["title"] = get_the_title();
$mixed["url"] = $provider_link;
$mixed["style"] = $style;
$mixed["cost"] = $cost;
if($university != "")
	$mixed["university"] = $university;
if($next != "")
	$mixed["next"] = $next;
if($work != "")
	$mixed["work"] = $work;
if($duration != "")
	$mixed["duration"] = $duration;
if($length != "")
	$mixed["length"] = $length;
if($format != "")
	$mixed["format"] = $format;
$mixed["subject"] = $subject;

$teachers = array();

$mykey_values = get_post_custom_values('wpcf-teacher');
if( $mykey_values ) {
	foreach ( $mykey_values as $key => $value ) {
		$teachers[] = $value;
	}
}

if($teachers) {
	$mixed["teachers"] = $teachers;
}

$mixed["post"] = $post;

$videoUrl = get_post_meta($post->ID, 'wpcf-video-intro', true);
if( substr($videoUrl, 0, 4) === 'http' ) {
	$mixed["intro-video"] = $videoUrl;
}

echo json_encode( $mixed );

?>