<?php

$f_ocws = array("availability", "provider", "provider_link", "teachers", "subjects");

$f_videos = array("platform", "provider", "provider_link", "video_length", "teachers", "subjects");

$f_courses = array("availability", "background", "cost", "course_format", "duration", "next_start",
		"platform", "provider", "provider_difficulty", "provider_link", "university", "workload", "video_intro",
		"video_link", "text_raw", "teachers", "subjects", "cost_val", "cost_cur", "cost_sub", "workload_min", "workload_max", "schedule", "style");

$f_subject_tax = array(4, 5, 6, 7, 8, 9, 10, 11, 12, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 31, 32, 33, 35, 36, 37, 39, 41, 42, 43, 44, 47, 53, 54);

$f_subjects = array("History", "Linguistics", "Literature", "Theatre, music and dance", "Philosophy", "Religion", 
		"Art", "Anthropology", "Archaeology", "Cultural and ethnic studies", "Economics", "Gender and sexuality", 
		"Geography", "Political science", "Psychology", "Social sciences", "Space and astronomy", "Earth sciences", 
		"Biology", "Chemistry", "Physics", "Computer sciences", "Finance and accountancy", "Mathematics", "Statistics", 
		"Agriculture", "Architecture and Design", "Business", "Education", "Engineering", "Environmental studies and Forestry", 
		"Health", "Journalism, media studies and communication", "Law", "Library and museum studies", "Military", 
		"Transportation", "Lifestyle", "Technology");

function startsWith($haystack, $needle) {
	return $needle === "" || strpos($haystack, $needle) === 0;
}
function endsWith($haystack, $needle) {
	return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}

// this dedups the le_postmeta table - could be a dangerous query to run so be careful
function deDup() {
	
	$sql = "delete from le_postmeta where meta_id in " .
		    "(select B from (select max(meta_id) AS B from le_postmeta group by post_id, meta_key, meta_value having count(*) > 1) as something)";
	
	$rc = 1;
	
	while( $rc > 0 ) {
	
		$result = @mysql_query($sql);
	
		$rc = mysql_affected_rows($conn);
		
	}
}
?>
