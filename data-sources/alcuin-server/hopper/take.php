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

// mark the records we're going to harvest with a guid
$guid = uniqid();

$sql = "update Hopper set after = addtime(now(), '01:00:00'), status = ? where after < now() and status = 'todo' and action in (";
$connective = "";
foreach($actions as $action) {
	$sql.= $connective . "'" . $action . "'";
	$connective = ",";
}
$sql .= ") limit " . $limit;

header('Content-Type: application/json');

if($stmt = $mysqli->prepare($sql)) {
	$stmt->bind_param('s', $guid);
	$stmt->execute();
	$stmt->close();

	if($rs = $mysqli->query("select * from Hopper where status = '". $guid . "'")) {
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
}

// clean up
$mysqli->close();
