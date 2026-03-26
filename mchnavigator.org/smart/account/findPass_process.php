<?php
	include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
	$fm = db_connect("MCH-Navigator");

	//get user info
	$request = $fm->newFindCommand('SA_Users');
	$request->addFindCriterion('email', "==\"" . $_POST['email'] . "\"");
	$result = $request->execute();
	$record = $result->getFirstRecord();

	if (FileMaker::isError($result)) {
		$errorOnPage = $result->getMessage();
	}

	$errorOnPage = '';

$section = 'assessment';
$page = 'Password Reset';
$page_title = "Password Reset";
include ('../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../incl/nav_generic.html'); ?>
<div class="ten columns">
<?php include('../incl/title.html'); ?>

<?php if ($errorOnPage != '') {
	echo '<p>' . $errorOnPage . '</p>';
} else { ?>
<?php
	# MAIL
	$to = $_POST['email'];
	$from = "no-reply@mchnavigator.org";
	$fromname = "MCHsmart";
	$replyto = "MCHnavigator@ncemch.org";
	$replytoname = "MCHsmart";
	$subject = "MCHsmart Account";
	$message = 'Your password for MCHsmart is '.$record->getField('password').'. Go to https://www.mchnavigator.org/smart/account/ to access your dashboard.';

	// build the email
	include_once("/home/dh_mch_sftp/globals/phpmailer/setup.php");
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
<p>Go here to read an article with <a href="http://www.intouchbroadcast.com/articles/11/1/Adding-an-Email-Address-to-your-Safe-Senders-List/Page1.html" target="_blank">more information on how to add an Allowed Sender</a>.</p>
<p>If you do not receive an e-mail in the next 30 minutes, please contact us at <a href="mailto:mchnavigator@ncemch.org">mchnavigator@ncemch.org</a></p>
<?php } ?>

</div>
</div>
</div>

<?php include('../../incl/footer.html'); ?>
