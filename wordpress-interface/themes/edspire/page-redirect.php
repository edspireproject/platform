<?php 
// This should analyse the querystring, dumping the relevant params into session variables and then doing a 301 redirect to /search/

session_start();

echo "<pre>";
echo $_GET['url'] . "\n";
echo urldecode($_GET['url']) . "\n";
echo urlencode("?");
echo "</pre>";

if(!isset($_GET['url'])) {
	header("HTTP/1.1 301 Moved Permanently");
	header('Location: ' . site_url());
	exit();
}

$url = urldecode($_GET['url']);

$parts = explode('?', $url, 2);

$page = $parts[0];

$qs = array();

if($parts[1]) {
	$params = explode('&', $parts[1]);
	foreach($params as $param) {
		$kv = explode('=', $param, 2);
		if($kv[1]) {
			$qs[$kv[0]] = urldecode($kv[1]);
		}
	}
}

if(array_key_exists('wpcf-cost', $qs)) {
	if($qs['wpcf-cost'] === '0') {
		$_SESSION['price'] = 1;
	} elseif($qs['wpcf-cost'] === '1')
		$_SESSION['price'] = 2;
	elseif($qs['wpcf-cost'] === '2')
		$_SESSION['price'] = 3;
	elseif($qs['wpcf-cost'] === '3')
		$_SESSION['price'] = 4;
}

if(array_key_exists('wpcf-schedule', $qs)) {
	if($qs['wpcf-schedule'] === '0')
		$_SESSION['availability'] = 1;
	elseif($qs['wpcf-schedule'] === '1')
		$_SESSION['availability'] = 2;
	elseif($qs['wpcf-schedule'] === '2')
		$_SESSION['availability'] = 3;
	elseif($qs['wpcf-schedule'] === '3')
		$_SESSION['availability'] = 4;
	elseif($qs['wpcf-schedule'] === '4')
		$_SESSION['availability'] = 5;
}

if(array_key_exists('wpcf-provider', $qs)) {
	$_SESSION['provider'] = sanitize_text_field( $qs['wpcf-provider'] );
}

if(array_key_exists('wpcf-teacher', $qs)) {
	$_SESSION['teacher'] = sanitize_text_field( $qs['wpcf-teacher'] );
}

if(array_key_exists('wpcf-university', $qs)) {
	$_SESSION['university'] = sanitize_text_field( $qs['wpcf-university'] );
}

header("HTTP/1.1 301 Moved Permanently");
header('Location: ' . site_url('search/'));

exit();
?>