<?php

/**
 * 
 * Take an item from the task Hopper
 * 
 * TODO make this safe for multiple minions
 */

include '../include/db.php';
include '../include/error.php';
include '../include/action.php';

$supports = isset($_GET['supports']) ? strval($_GET['supports']) : '';
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 1;

$actions = parse_actions($supports);

if(! $actions )
	go500("Minion doesn't support any actions");

$sql = "select * from Hopper where after < now() and status = 'todo' and action in (";
$connective = "";
foreach($actions as $action) {
	$sql.= $connective . "'" . $action . "'";
	$connective = ",";
}
$sql .= ") limit " . $limit;

header('Content-Type: application/json');

if($rs = $mysqli->query($sql)) {
	echo "[";
	$separator = "";
	while ($row = $rs->fetch_assoc()) {
		// spit it out to the client
		echo $separator . "{";
		echo '"id":' . $row["id"] . ', ';
		echo '"after":"' . $row["after"] . '",';
		echo '"status":"' . $row["status"] . '",';
		echo '"action":"' . $row["action"] . '",';
		echo '"payload":' . $row["payload"];
		echo "}";
		$separator = ",";
	}
	echo "]";

	// free up memory
	$rs->free();
}

// clean up
$mysqli->close();
