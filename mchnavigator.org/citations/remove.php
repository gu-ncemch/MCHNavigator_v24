<?php
	// session_start();
	// if (isset($_SESSION['myCitations'])) {
	//     $key = array_search($_POST['citationID'], $_SESSION['myCitations']);
	// 	if ($key !== false) {
	// 	    unset($_SESSION['myCitations'][$key]);
	// 	}
	// }

	if (isset($_COOKIE['NavCitations']) || unserialize($_COOKIE['NavCitations']) != false) {
		$myCitations = unserialize($_COOKIE['NavCitations']);
	    $key = array_search($_POST['citationID'], $myCitations);
		if ($key !== false) {
		    unset($myCitations[$key]);
		    setcookie('NavCitations', serialize($myCitations), time()+(86400 * 365), '/');
		}
	}
?>