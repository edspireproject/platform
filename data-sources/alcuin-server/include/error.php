<?php 

/**
 * Exception handling and logging
 */

function go500($msg = '') {
	error_log( '500: ' . $msg );
	status_header( 500 );
	echo $msg;
	exit;
}

?>