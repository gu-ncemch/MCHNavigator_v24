<?php
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

include_once(__DIR__ . "/../../../globals/filemaker_init.php");

// get user id -------------------------------------------------------------------------------------------------------------
extract($_POST, EXTR_OVERWRITE);
$fm      = db_connect("MCH-Navigator");

$request = $fm->newFindCommand('SA_Users');
$request->setLogicalOperator(FILEMAKER_FIND_AND);
$request->addFindCriterion('email', "==\"" . $email . "\"");
$request->addFindCriterion('password', "==\"" . $password . "\"");
$result = $request->execute();

if (FileMaker::isError($result)) {
	$errorOnPage = "<!--Databasae error. " . $result->getMessage() . '-->';
	header("HTTP/1.0 401 Unauthorized");
} else {
	$record = $result->getFirstRecord();
		// create cookie -------------------------------------------------------------------------------
		$cookieArrayPut = array(
			'uID' => $record->getRecordId(),
			'email' => $record->getField('email'),
			'admin' => $record->getField('admin')
		);
		setcookie('mchnavsa', serialize($cookieArrayPut), time() + 60 * 60 * 24 * 30, '/', 'www.mchnavigator.org', isset($_SERVER["HTTPS"]), true);
		header("Location: /smart/dashboard.php");
		exit;
}
?>




<?php
setcookie ('mchnavsa', '', time()-50000, '/', 'www.mchnavigator.org', isset($_SERVER["HTTPS"]), true);
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
