<?php include("cookie.php"); ?>
<?php
require_once __DIR__ . '/../../filemaker/data-api.php';

$currentEmail = $email;
$currentAdmin = $admin;
$errorOnPage = null;
$cookieDomain = (($_SERVER['HTTP_HOST'] ?? '') === 'www.mchnavigator.org') ? 'www.mchnavigator.org' : '';


// prep data --------------------------------------------------------------------------------------------------------------
extract($_POST, EXTR_OVERWRITE);
$name_first  = isset($name_first) ? scrubber($name_first, 'string') : '';
$name_last   = isset($name_last) ? scrubber($name_last, 'string') : '';
$email       = isset($email) ? scrubber($email, 'email') : '';
$password    = isset($password) ? scrubber($password, 'string') : '';
$state       = isset($state) ? scrubber($state, 'string') : '';
$you         = isset($you) ? scrubber($you, 'string') : '';
$you_other   = isset($you_other) ? scrubber($you_other, 'string') : '';
$years       = isset($years) ? scrubber($years, 'string') : '';
$usage       = isset($usage) ? scrubber($usage, 'string') : '';
$usage_other = isset($usage_other) ? scrubber($usage_other, 'string') : '';
$special_group      = isset($special_group) ? scrubber($special_group, 'string') : '';
$gender      = isset($gender) ? scrubber($gender, 'string') : '';
$age         = isset($age) ? scrubber($age, 'string') : '';
$race        = isset($race) ? scrubber($race, 'array') : '';
$race        = str_replace(",",chr(13),$race);
$ethnicity   = isset($ethnicity) ? scrubber($ethnicity, 'string') : '';
if (strlen($race) > 0) {
	$mixed = "true";
} else {
	$mixed = "false";
}

$errors = '';
$errors .= empty($email) ? 'Your Email Address is required.<br>' : '';
if (empty($password)) {
	$errors .= 'A Password is required.<br>';
}
if (strlen($password) < 5) {
	$errors .= 'Your password is too short. Please make your password at least 5 characters long.<br>';
}
if ($password != $password2) {
	$errors .= 'Your passwords do not match.<br>';
}
/* else if (!empty($Password) && $Password != $Confirm) {
	$errors .= 'Your Passwords do not match.<br>';
} else if (!preg_match("#.*^(?=.{6,15})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $Password)){
	$errors .= "Your password is not secure enough. Passwords must be 6-15 characters and contain at least 1 number, 1 uppercase letter, and 1 lowercase letter.<br>";
}*/
$errors .= empty($state) ? 'Your State is required.<br>' : '';
$errors .= empty($you) ? 'You must answer the question "Which of the following best describes you?".<br>' : '';

if($errors != ''){
	echo $errors;
	#header("Location: register.php");
	exit;
}



// see if email already exists ------------------------------------------------------------------------------------------------------------
$record_request = array(
	'database' => 'MCH-Navigator',
	'layout' => 'SA_Users',
	'action' => 'single',
	'record' => (int) $uID,
);

$record = do_filemaker_request($record_request, 'array');
$record_code = (int) ($record['messages'][0]['code'] ?? 500);

if ($record_code !== 0 || empty($record['response']['data'][0])) {
	// email already registered
	$errorOnPage = 100;
} else {
	$update_request = array(
		'database' => 'MCH-Navigator',
		'layout' => 'SA_Users',
		'action' => 'edit',
		'record' => (int) $uID,
		'challenge_field' => 'email',
		'challenge_value' => $currentEmail,
		'parameters' => array(
			'fieldData' => array(
				'name_first' => $name_first,
				'name_last' => $name_last,
				'email' => $email,
				'password' => $password,
				'state' => $state,
				'you' => $you,
				'you_other' => $you_other,
				'years' => $years,
				'usage' => $usage,
				'usage_other' => $usage_other,
				'special_group' => $special_group,
				'gender' => $gender,
				'age' => $age,
				'race' => $race,
				'ethnicity' => $ethnicity,
				'mixed' => $mixed,
			),
		),
	);

	$result = do_filemaker_request($update_request, 'array');
	$update_code = (int) ($result['messages'][0]['code'] ?? 500);

	if ($update_code !== 0) {
		// save error
		$errorOnPage = 200;
	} else {
		$cookieArrayPut = array(
			'uID' => $uID,
			'email' => $email,
			'admin' => $currentAdmin,
		);
		setcookie('mchnavsa', serialize($cookieArrayPut), time() + 60 * 60 * 24 * 30, '/', $cookieDomain, isset($_SERVER["HTTPS"]), true);
	}
}
$section = 'assessment';
$page = 'main';
$page_title = "Account Settings";
include ('../../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../../incl/leftnav.html'); ?>
<div class="nine columns">
<?php include('../../incl/title.html'); ?>

<p style="float:right; margin:15px 0 15px 15px;"><a href="edit.php" class="btnesque">Edit Profile</a> <a href="logout.php" class="btnesque">Logout</a></p>

<?php if ($errorOnPage == 100) { ?>
<p>A user with that email address already exists. <a href="http://mchnavigator.org/assessment/account/">Click here to login</a>.
	<!-- If you have previously registered for an online course developed by Georgetown University, you can use your existing registration information.-->
</p>
<?php } else if($errorOnPage == 200){ ?>
<p>There was an error saving your registration record. Please contact <a href="mailto:mchnavigator@ncemch.org">mchnavigator@ncemch.org</a> for further assistance.
  <!--" . $result->getMessage() . " -->
</p>
<?php }  else if($errorOnPage == 400){ ?>
<p>Processing Error.  Please contact <a href="mailto:mchnavigator@ncemch.org">mchnavigator@ncemch.org</a> for further assistance.
  <!--" . $result->getMessage() . " -->
</p>
<?php } else { ?>
<p>Your account has successfully been saved. Please click here to <a href="dashboard.php">access your dashboard and begin the self-assessment</a>.
	<!--" . $result->getMessage() . " -->
Or <a href="edit.php">click here to return to your account settings</a> for further edits.</p>
	<?php } ?>
</div>
</div>

<?php include('../../incl/footer.html'); ?>
