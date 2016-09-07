<?php

if (isset($_GET['url']) && isset($_GET['code'])) {
	// check it
	$url = urldecode($_GET['url']);
	$hash = $_GET['code'];

	dblog('url', $url . '|' . $hash . '|' . hashUrl($url));
	
	if( $hash == hashUrl($url) ) {
		// log it
		dblog('url', $url);
		
		echo $url . "\n";
		
		// redirect it
		header('Location: ' . $url , true, 302);
		exit();
	}
}

go404();

?>