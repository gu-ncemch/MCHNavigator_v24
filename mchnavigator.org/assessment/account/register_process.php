<?php
	session_start();
	session_destroy();
	session_start();
	require_once __DIR__ . '/../../filemaker/data-api.php';

$errorOnPage = null;
$cookieDomain = (($_SERVER['HTTP_HOST'] ?? '') === 'www.mchnavigator.org') ? 'www.mchnavigator.org' : '';


// prep data --------------------------------------------------------------------------------------------------------------
// print_r($_POST);
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
$gender      = isset($gender) ? scrubber($gender, 'string') : '';
$special_group      = isset($special_group) ? scrubber($special_group, 'string') : '';
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
if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $errors = 'Your Email Address is required.<br>';
}
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
$find_request = array(
	'database' => 'MCH-Navigator',
	'layout' => 'SA_Users',
	'action' => 'find',
	'parameters' => array(
		'query' => array(
			array(
				'email' => '=="' . $email . '"',
			),
		),
		'limit' => 1,
	),
);

$result = do_filemaker_request($find_request, 'array');
$find_code = (int) ($result['messages'][0]['code'] ?? 500);

if ($find_code === 0 && !empty($result['response']['data'])) {
	// email already registered
	$errorOnPage = 100;
} else if ($find_code === 401) {
	// create new registration record
	$create_request = array(
		'database' => 'MCH-Navigator',
		'layout' => 'SA_Users',
		'action' => 'create',
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
				'gender' => $gender,
				'special_group' => $special_group,
				'age' => $age,
				'race' => $race,
				'ethnicity' => $ethnicity,
				'mixed' => $mixed,
			),
		),
	);

	$result = do_filemaker_request($create_request, 'array');
	$create_code = (int) ($result['messages'][0]['code'] ?? 500);

	if ($create_code !== 0 || empty($result['response']['recordId'])) {
		// creation error
		$errorOnPage = 200;
	} else {
		// get user id -------------------------------------------------------------------------------------
		$newID = $result['response']['recordId'];
		// create cookie -----------------------------------------------------------------------------------
		$cookieArrayPut = array(
			'uID' => $newID,
			'email' => $email
		);
		//setcookie( name, value, expire, path, domain, secure, httponly);
		setcookie('mchnavsa', serialize($cookieArrayPut), time() + 60 * 60 * 24 * 30, '/', $cookieDomain, isset($_SERVER["HTTPS"]), true);

		#header("Location: https://www.brightfutures.org/wellchildcare/login/dashboard.php");
		#exit;
	}
} else {
	// processing Error
	$errorOnPage = 400;
}
?>
<?php
$section = 'assessment';
$page = 'main';
$page_title = "Register";
include ('../../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../../incl/leftnav.html'); ?>
<div class="nine columns">
<?php include('../../incl/title.html'); ?>
<?php if ($errorOnPage == 100) { ?>
<p>A user with that email address already exists. <a href="http://mchnavigator.org/assessment/account/">Click here to login</a>.
	<!-- If you have previously registered for an online course developed by Georgetown University, you can use your existing registration information.-->
</p>
<?php } else if($errorOnPage == 200){ ?>
<p>There was an error creating your registration record. Please contact <a href="mailto:mchnavigator@ncemch.org">mchnavigator@ncemch.org</a> for further assistance.
  <!--" . $result->getMessage() . " -->
</p>
<?php }  else if($errorOnPage == 400){ ?>
<p>Processing Error.  Please contact <a href="mailto:mchnavigator@ncemch.org">mchnavigator@ncemch.org</a> for further assistance.
  <!--" . $result->getMessage() . " -->
</p>
<?php } else { ?>
<p>Your account has successfully been created. Please click here to <a href="/assessment/dashboard.php">access your dashboard and begin the self-assessment</a>.
<?php
	# MAIL
	$to = $email;
	$from = "no-reply@mchnavigator.org";
	$fromname = "MCH Navigator";
	$replyto = "MCHnavigator@ncemch.org";
	$replytoname = "MCH Navigator";
	$subject = "MCH Navigator Registration";
	$message = 'Your password for the MCH Navigator Self Assessment is '.$password.'. Go to https://www.mchnavigator.org/assessment/ to access your self assessment.';

	// build the email
	include_once(__DIR__ . '/../../../globals/phpmailer/setup.php');
	$mail->setFrom($from, $fromname);
	$mail->addAddress($to);
	$mail->addReplyTo($replyto, $replytoname);
	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $message;

	// send it and output a message
	try {
	    $mail->send();
	    // success
		echo "An email has been sent to $to.";
	} catch (Exception $e) {
		// http_response_code(206);
	    // failure
	    echo '<p>Mailer Error: ' . $mail->ErrorInfo . '</p>';
	    echo "<p>We tried sending a email to $to but something went wrong along the way. Please make a record of your password in a safe location.</p>";
	}
?>
	<!--" . $result->getMessage() . " -->
</p>
	<?php } ?>
</div>
</div>

<?php include('../../incl/footer.html'); ?>
