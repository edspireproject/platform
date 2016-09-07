<?php 

/**
 * Look for a record in the Harvest table and if found, try and serve the raw image data from disk  
 */

include '../include/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT uniqid from Harvester where id = ?";
		
$file = false;

if($stmt = $mysqli->prepare($sql)) {
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->bind_result($uniqid);
	
	if($stmt->fetch()){
		
		$dirs = str_split($uniqid, 3);
		$file = '/home/tomcat/data/nasjah/' . implode('/', $dirs) . '/' . $uniqid . '.jpg';
				
	}
}

if( $file ) {
	$type = 'image/jpeg';
	header('Content-Type:'.$type);
	header('Content-Length: ' . filesize($file));
	readfile($file);
}