<?php


session_start();
	session_destroy();
	session_start();
	include_once(__DIR__ . "/../../../globals/filemaker_init.php");
	include_once(__DIR__ . "/../../../globals/scrubber.php");
$errorOnPage = null;

// prep data --------------------------------------------------------------------------------------------------------------
// print_r($_POST);
extract($_POST, EXTR_OVERWRITE);
$name_first	 = isset($name_first) ? scrubber($name_first, 'name_first') : '';
$name_last	 = isset($name_last) ? scrubber($name_last, 'name_last') : '';
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
$fm      = db_connect("MCH-Navigator");

$request = $fm->newFindCommand('SA_Users');
$request->addFindCriterion('email', "==\"" . $email . "\"");
$result = $request->execute();
#echo $result->getMessage();
if (!FileMaker::isError($result)) {
	// email already registered
	$errorOnPage = 100;
} else if ($result->getMessage() == 'No records match the request') {
	// create new registration record
	#echo 200;
	//$record = $fm->createRecord('SA_Users');
	$record = $fm->newAddCommand('SA_Users');
	$record->setField('name_first', $name_first);
	$record->setField('name_last', $name_last);
	$record->setField('email', $email);
	$record->setField('password', $password);
	$record->setField('state', $state);
	$record->setField('you', $you);
	$record->setField('you_other', $you_other);
	$record->setField('years', $years);
	$record->setField('usage', $usage);
	$record->setField('usage_other', $usage_other);
	$record->setField('special_group', $special_group);
	$record->setField('gender', $gender);
	$record->setField('age', $age);
	$record->setField('race', $race);
	$record->setField('ethnicity', $ethnicity);
	$record->setField('mixed', $mixed);
	$record->setField('initial_registration', "MCHsmart");
	//date_default_timezone_set("America/New_York");
	//$record->setField('date_lastlogin', date("n/j/Y g:i:s A"));
	$result = $record->execute();

	if (FileMaker::isError($result)) {
		// creation error
		$errorOnPage = 200;
	} else {
		// get user id -------------------------------------------------------------------------------------
		$result_datum = $result->getRecords();
		$newID = $result_datum[0]->getRecordId();
		// create cookie -----------------------------------------------------------------------------------
		$cookieArrayPut = array(
			'uID' => $newID,
			'email' => $email
		);
		//setcookie( name, value, expire, path, domain, secure, httponly);
		setcookie('mchnavsa', serialize($cookieArrayPut), time() + 60 * 60 * 24 * 30, '/', 'www.mchnavigator.org', isset($_SERVER["HTTPS"]), true);

		#header("Location: https://www.brightfutures.org/wellchildcare/login/menu.php");
		#exit;
	}
} else {
	// processing Error
	$errorOnPage = 400;
}
?>
<?php
$section = 'assessment';
$page = 'Register';
$page_title = "Register";
include ('../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../incl/nav_generic.html'); ?>
<div class="ten columns">
<?php include('../incl/title.html'); ?>
<?php if ($errorOnPage == 100) { ?>
<p>A user with that email address already exists. <a href="https://mchnavigator.org/smart/account/">Click here to login</a>.
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
<p>Your account has successfully been created. Welcome to MCHsmart!</p>
<p>Now that you have registered, <a href="https://www.mchnavigator.org/smart/dashboard.php"><strong>continue to the DASHBOARD</strong></a> to start the curriculum.</p>
<p>&nbsp;</p>
<h3>Optional and Additional Resources:</h3>
<p>If you would like to gain a better sense of your personal knowledge and skills regarding the MCH Leadership Competencies, you can also access the <a href="../../assessment/index.php" target="_blank">online self-assessment</a> (opens in a new tab/window). You can take the full self-assessment in one sitting or you can take it in increments by logging back in (the full self-assessment takes approximately 1 hour to complete; each of the 12 competencies takes about 5 minutes to complete). Your login for the self-assessment is the same as for MCHsmart.</p>
<p>You may be interested in these additional MCH Leadership Competency learning resources (all resources open in new tabs/windows):</p>
<p><a href="https://www.mchnavigator.org/trainings/search.php" target="_blank">MCH Navigator Search Page</a>: Search by competency, title, presenter, or topic.</p>
<p><a href="https://www.mchnavigator.org/trainings/a-z.php" target="_blank">A-Z Trainings List</a>: See an alphabetical listing of learning opportunities. You can filter by keyword at the top of the page.</p>
<p><a href="https://www.mchnavigator.org/trainings/topics.php" target="_blank">Training Guides</a>: Access our Core MCH Learning Guides, Topical Training Spotlights and Training Briefs.</p>
<?php
	# MAIL
	$to = $email;
	$from = "no-reply@mchnavigator.org";
	$fromname = "MCHsmart";
	$replyto = "MCHnavigator@ncemch.org";
	$replytoname = "MCHsmart";
	$subject = "MCHsmart Account";
	$message = '<p>Thank you for registering for the MCHsmart online curriculum. You have taken the first step on a learning journey to advance your knowledge, skills, and efficacy in integrating the MCH Leadership Competencies into your daily practice.</p>';
	$message .= '<p>This curriculum has been designed to be comprehensive and is estimated to take about 12 hours to complete.  However, you can dig in as deeply or as surface-level depending on your need and available time. You can return to the curriculum at any point to continue your learning.</p>';
	$message .= '<p>Your password for the MCHsmart curriculum is '.$password.'. Please note that you can also use this password to access the MCH Navigator’s online self-assessment at <a href="https://www.mchnavigator.org/assessment/">https://www.mchnavigator.org/assessment/</a>.</p>';
	$message .= '<p>Go to <a href="https://www.mchnavigator.org/smart">https://www.mchnavigator.org/smart</a> to access the MCHsmart curriculum.  Here’s to a good learning experience!</p>';

	// build the email
	include_once(__DIR__ . '/../../../globals/phpmailer/setup.php');
	$mail->setFrom($from, $fromname);
	$mail->addAddress($to);
	$mail->addReplyTo($replyto, $replytoname);
	$mail->isHTML(false);
	$mail->Subject = $subject;
	$mail->Body = $message;

	// send it and output a message
	try {
	    $mail->send();
	    // success
		echo "<p>An email has been sent to $to. If you do not get an email within a few minutes, whitelist MCHnavigator@ncemch.org in your email service.</p>";
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
</div>

<?php include('../../incl/footer.html'); ?>
