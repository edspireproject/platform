<?php

if(!isset($_GET['url']))
	die();
$url = $_GET['url'];
if(! preg_match("/^(http|https):\/\/./", $url) == 1)
	die();

$data = json_decode(file_get_contents($url));

echo ('<?xml version="1.0" encoding="utf-8" ' . '?' . '>'); echo "\n"; ?>
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
         xmlns="http://purl.org/rss/1.0/"
         xmlns:dc="http://purl.org/dc/elements/1.1/"
         xmlns:enc="http://purl.oclc.org/net/rss_2.0/enc#"
         xmlns:media="http://search.yahoo.com/mrss/"
         xmlns:nj="http://edspire.com/resources/1.0/">
	<channel rdf:about="http://edspire.com/resources/1.0/">
	   <link>http://impex/course/coursera2rss.php?url=<?php echo $url; ?></link>
	</channel>

<?php 

$courses = array(0);
foreach($data->courses as $course) {
  	$add_course = true;
  	if( isset($course->start_year) ) {
	 	$start_date = $course->start_year . "-" . str_pad($course->start_month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($course->start_day, 2, '0', STR_PAD_LEFT);
	  	if( array_key_exists ( $course->topic_id, $courses ) ) {
  			if( $courses[$course->topic_id]->start_date < $start_date )
	  			$add_course = true;
	  	}
	  	if($add_course) {
  			$courses[$course->topic_id] = array("start_date" => $start_date, "duration" => $course->duration_string);
  		}
  	}
}

$unis = array(0);
foreach($data->unis as $uni) {
	$unis[$uni->id] = htmlspecialchars($uni->name);
}

$cats = array(0);
foreach($data->cats as $cat) {
	$cats[$cat->id] = htmlspecialchars($cat->name);
}

$insts = array(0);
foreach($data->insts as $inst) {
 	$insts[$inst->id] = htmlspecialchars($inst->first_name . " " . $inst->last_name);
}

foreach($data->topics as $topic) {
	echo "<item>";
	echo "<title>" . htmlspecialchars($topic->name) . "</title>";
	echo "<nj:provider>Coursera</nj:provider>";
	echo "<link>https://www.coursera.org/course/" . $topic->short_name . "</link>";
	echo "<description></description>";
	echo "<nj:json>https://www.coursera.org/maestro/api/topic/information?topic-id=" . $topic->short_name . "</nj:json>";
	
	foreach($topic->cats as $cat) {
		echo "<nj:subject>" . $cats[$cat] . "</nj:subject>";
	}
	
	foreach($topic->unis as $uni) {
		echo "<nj:university>" . $unis[$uni] . "</nj:university>";
	}
	
	foreach($topic->insts as $inst) {
		echo "<dc:creator>" . $insts[$inst->id] . "</dc:creator>";
	}

	if( array_key_exists ( $topic->id, $courses ) ) {
		echo "<nj:availability>" . $courses[$topic->id]["start_date"] . "</nj:availability>";
		echo "<nj:duration>" . $courses[$topic->id]["duration"] . "</nj:duration>";
	} else {
		echo "<nj:availability></nj:availability>";
		echo "<nj:duration></nj:duration>";
	}

	echo "<nj:workload></nj:workload>";
	echo "<dc:audience></dc:audience>";
	echo "<nj:cost></nj:cost>";

	echo "</item>\n";
	
}
?>
</rdf:RDF>