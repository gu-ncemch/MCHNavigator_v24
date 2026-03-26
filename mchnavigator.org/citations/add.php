<?php
	// session_start();
	// if (!isset($_SESSION['myCitations'])) {
	//     $_SESSION['myCitations'] = array();
	// }
	// array_push($_SESSION['myCitations'], $_POST['citationID']);

	// setcookie('NavCitations', serialize($info), time()+(86400 * 365));

	if (!isset($_COOKIE['NavCitations']) || unserialize($_COOKIE['NavCitations']) == false) {
		$myCitations = array();
		setcookie('NavCitations', '', time()+(86400 * 365), '/');
	} else {
		$myCitations = unserialize($_COOKIE['NavCitations']);
	}
	array_push($myCitations, $_POST['citationID']);

	setcookie('NavCitations', serialize($myCitations), time()+(86400 * 365), '/');
?>