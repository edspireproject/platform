<?php

/**
 * 
 * List items that have been harvested
 * 
 */

include '../include/db.php';

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 15;
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;

$sql = "select * from Harvester order by date desc limit " . $limit;
if($start > 0)
	$sql .= " offest " . $start;

header('Content-Type: application/json');

if($rs = $mysqli->query($sql)) {
	echo "[";
	$separator = "";
	while ($row = $rs->fetch_assoc()) {
		// spit it out to the client
		echo $separator . "{";
		echo '"id":' . $row["id"] . ', ';
		echo '"date":' . json_encode($row["date"]) . ',';
		echo '"url":' . json_encode($row["url"]) . ',';
		echo '"title":' . json_encode($row["title"]) . ',';
		echo '"uniqid":' . json_encode($row["uniqid"]) . '';
		echo "}";
		$separator = ",";
	}
	echo "]";

	// free up memory
	$rs->free();
}

// clean up
$mysqli->close();
