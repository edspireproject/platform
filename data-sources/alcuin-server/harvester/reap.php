<?php

/**
 * Add a crawled URL source and screenshot
 * 
 * If a task has been compelted, mark it as done in the Hopper
 */

include '../include/db.php';

$base64img = urldecode(utf8_decode($_POST['img']));
$title = urldecode(utf8_decode($_POST['title']));
$url = urldecode(utf8_decode($_POST['url']));
$text = urldecode(utf8_decode($_POST['text']));
$job = urldecode(utf8_decode($_POST['job']));
$date = date_format(date_create_from_format('d/m/Y H:i:s', urldecode(utf8_decode($_POST['date']))), 'Y-m-d H:i:s');;

$uniqid = uniqid();

if(strlen($uniqid) % 3 == 1)
	$uniqid = "00" . $uniqid;
elseif(strlen($uniqid) % 3 == 2)
	$uniqid = "0" . $uniqid;

$dirs = str_split($uniqid, 3);

$dir = '/home/tomcat/data/nasjah/' . implode('/', $dirs) . '/';

if (!file_exists($dir))
	mkdir($dir, 0777, true);

$base64img = str_replace('data:image/jpeg;base64,', '', $base64img);
$data = base64_decode($base64img);
$png = $dir . $uniqid . '.jpg';
$txt = $dir . $uniqid . '.html';

file_put_contents($png, $data);
file_put_contents($txt, $text);

if($job) {
	$json = json_decode($job, true);
	if($json["id"]) {
		// mark the job as done
		if($stmt = $mysqli->prepare("UPDATE Hopper SET status = 'done' WHERE id = ?")) {
			$stmt->bind_param('i', intval($json["id"]));
			$stmt->execute();
			$stmt->close();
		}
	}
}

// add a record in the db for the crawl
if($stmt = $mysqli->prepare("INSERT INTO Harvester (date, url, title, uniqid, job) VALUES (?, ?, ?, ?, ?) ")) {
	$stmt->bind_param('sssss', $date, $url, $title, $uniqid, $job );
	$stmt->execute();
	$stmt->close();
}


header('Content-Type: application/json');

$result = array();
$result["title"] = $title;
$result["url"] = $url;

echo json_encode( $result );