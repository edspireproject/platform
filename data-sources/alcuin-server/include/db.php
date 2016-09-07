<?php

/**
 * Database access
 */

$dbun = '{username}';
$dbpw = '{password}';

$mysqli = new mysqli('{database-url}', $dbun, $dbpw, "{alcuin-database-name}");

if ($mysqli->connect_errno) {
	error_log ( "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error );
}

?>