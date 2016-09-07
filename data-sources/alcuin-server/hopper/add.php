<?php

/**
 * 
 * Add an item to the task Hopper
 *
 */

include '../include/db.php';
include '../include/action.php';

global $ARR_ACTIONS;
$result = array();

$after = isset($_GET['after']) ? strval($_GET['after']) : '';
$action_us = isset($_GET['action']) ? strval($_GET['action']) : '';
$payload = isset($_POST['payload']) ? strval($_POST['payload']) : '';
$status = 'todo';
$action = array_search($action_us, $ARR_ACTIONS) !== false ? $action_us : '';

if($action) {
	$sql = "INSERT INTO Hopper(status,actions,payload";
	if($after) {
		if($stmt = $mysqli->prepare("INSERT INTO Hopper (status,action,payload,after) VALUES (?,?,?,?)"))
			$stmt->bind_param('ssss', $status, $action, $payload, $after);
	} else {
		if($stmt = $mysqli->prepare("INSERT INTO Hopper (status,action,payload) VALUES (?,?,?)"))
			$stmt->bind_param('sss', $status, $action, $payload);
	}

	$stmt->execute();
	$stmt->close();

	$result["after"] = $after;
	$result["action"] = $action;
	$result["status"] = "todo";
	$result["payload"] = json_decode($payload, true);
}

header('Content-Type: application/json');
echo json_encode( $result );