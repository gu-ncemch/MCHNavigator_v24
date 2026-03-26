<?php
$css = '<style type="text/css">.noprint{display:none;}</style>';



if($_POST["action"]=="email"){
	include("../account/cookie.php");

	# MAIL
	$to = $email
	$from = "no-reply@mchnavigator.org";
	$fromname = "MCH Navigator";
	$replyto = "MCHnavigator@ncemch.org";
	$replytoname = "MCH Navigator";
	$subject = "MCH Navigator Personalized Learning Plan";
	$message = '<!doctype html><html lang="en"><head><meta charset="utf-8"><title>MCH Navigator Personalized Learning Plan</title>'.$css.'</head><body>'.$_POST["html"].'</body></html>';

	// build the email
	include_once("/home/dh_mch_sftp/globals/phpmailer/setup.php");
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
		echo "<p>An email containing your personalized learning plan has just been sent to you. You can now close this window to return to the self-assessment.</p>";
	} catch (Exception $e) {
		// http_response_code(206);
	    // failure
	    echo '<p>Mailer Error: ' . $mail->ErrorInfo . '</p>';
		echo '<p>Yikes, we couldn\'t send an email for some reason. Please try again in a few minutes or contact <a href="mailto:mchnavigator@ncemch.org">MCHnavigator@ncemch.org</a>.</p>'; 
	}
} else if($_POST["action"]=="pdf"){
	// PDF
	require_once("../../dompdf/dompdf_config.inc.php");
	$dompdf = new DOMPDF();
	//$html   = '<!doctype html><html lang="en"><head><meta charset="utf-8"><title>MCH Navigator Personalized Learning Plan</title>'.$css.'</head><body onload="window.print()">'.$_POST["html"].'</body></html>';
	
	$dompdf->load_html($_POST["html"]);
	$dompdf->render();
	
	$dompdf->stream("mch-navigator-personalized-learning-plan.pdf");
} else{
	// PRINT
	echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><title>MCH Navigator Personalized Learning Plan</title>'.$css.'</head><body onload="window.print()">'.$_POST["html"].'</body></html>';
}
?>
