<?php
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

require_once __DIR__ . '/../../filemaker/data-api.php';
$cookieDomain = (($_SERVER['HTTP_HOST'] ?? '') === 'www.mchnavigator.org') ? 'www.mchnavigator.org' : '';

// get user id -------------------------------------------------------------------------------------------------------------
extract($_POST, EXTR_OVERWRITE);
$email = isset($email) ? trim((string) $email) : '';
$password = isset($password) ? (string) $password : '';

$request = array(
	'database' => 'MCH-Navigator',
	'layout' => 'SA_Users',
	'action' => 'find',
	'parameters' => array(
		'query' => array(
			array(
				'email' => '=="' . $email . '"',
				'password' => '=="' . $password . '"',
			),
		),
		'limit' => 1,
	),
);

$result = do_filemaker_request($request, 'array');
$resultCode = (int) ($result['messages'][0]['code'] ?? 500);

if ($resultCode !== 0 || empty($result['response']['data'][0])) {
	$errorMessage = $result['messages'][0]['message'] ?? 'Unknown FileMaker error';
	$errorOnPage = '<!--Database error. ' . htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') . '-->';
	header("HTTP/1.0 401 Unauthorized");
} else {
	$record = $result['response']['data'][0];
		// create cookie -------------------------------------------------------------------------------
		$cookieArrayPut = array(
			'uID' => $record['recordId'],
			'email' => $record['fieldData']['email'] ?? '',
			'admin' => $record['fieldData']['admin'] ?? ''
		);
		setcookie('mchnavsa', serialize($cookieArrayPut), time() + 60 * 60 * 24 * 30, '/', $cookieDomain, isset($_SERVER["HTTPS"]), true);
		header("Location: /smart/dashboard.php");
		exit;
}
?>




<?php
setcookie ('mchnavsa', '', time()-50000, '/', $cookieDomain, isset($_SERVER["HTTPS"]), true);
unset($_COOKIE['mchnavsa']);

$section = 'assessment';
$page = 'Error';
$page_title = "Error";
include ('../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../incl/nav_generic.html'); ?>
<div class="ten columns">
<?php include('../incl/title.html'); ?>

<p>The email and password combination you provided was not found in the database. <a href="index.php">Please return to the login page to try again</a>. If you continue experiencing problems, <a href="mailto:jrichards@ncemch.org">you can email us for assistance</a>.</p>
<?php #echo $errorOnPage; ?>

</div>
</div>
</div>

<?php include('../../incl/footer.html'); ?>
