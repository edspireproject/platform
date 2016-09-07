<?php

/**
 * 
 * Any Hopper items that are still processing past their "after" date should be reverted to "todo"
 * 
 */

include '../include/db.php';

$sql = "update Hopper set status = 'todo', after = addtime(now(), '01:00:00') where after < now() and status not in ('todo', 'done', 'abort')";

header('Content-Type: application/json');

if($stmt = $mysqli->prepare($sql)) {
	$stmt->execute();
	$stmt->close();
}

// clean up
$mysqli->close();