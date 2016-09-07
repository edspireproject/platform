<?php

/**
 * 
 * Marks a Hopper item as done
 *
 */

include '../include/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($stmt = $mysqli->prepare("UPDATE Hopper SET status = 'done' WHERE id = ?")) {
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->close();
}

?>