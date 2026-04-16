<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false); header("Pragma: no-cache"); // HTTP/1.0
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

# --------------------------------------- knock out unlogged people
if (isset($_COOKIE['mchnavsa'])) {
	$cookieArrayGet = unserialize($_COOKIE['mchnavsa']);
	$email = $cookieArrayGet['email'] ?? '';
	$uID = $cookieArrayGet['uID'] ?? '';
	$admin = $cookieArrayGet['admin'] ?? '';
	#echo "logged in as ".$uID;
} else {
	#echo '<!-- else -->';
	header('HTTP/1.0 403 Forbidden');
	header("Location: /assessment/account/index.php#loginrequired");
	exit;
}
?>
