<?php

/**
 * 
 * Show Hopper summary statistics
 * 
 */

include '../include/db.php';

$sql = "SELECT action, case when length(status) > 8 then 'taken' else status end as status, count(*) as total " .
		"FROM Hopper group by action, case when length(status) > 8 then 'taken' else status end order by action";

header('Content-Type: application/json');

if($rs = $mysqli->query($sql)) {
	echo "[";
	$separator = "";
	while ($row = $rs->fetch_assoc()) {
		// spit it out to the client
		echo $separator . "{";
		echo '"action":"' . $row["action"] . '",';
		echo '"status":"' . $row["status"] . '",';
		echo '"total":' . $row["total"];
		echo "}";
		$separator = ",";
	}
	echo "]";

	// free up memory
	$rs->free();
}

// clean up
$mysqli->close();

