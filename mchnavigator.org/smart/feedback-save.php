<?php include("account/cookie.php"); ?>
<?php
include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
include_once("/home/dh_mch_sftp/globals/scrubber.php");


// prep data --------------------------------------------------------------------------------------------------------------
extract($_POST, EXTR_OVERWRITE);
$uID				= isset($uID) ? scrubber($uID, 'string') : '';
$expectations		= isset($expectations) ? scrubber($expectations, 'string') : '';
$most_valuable		= isset($most_valuable) ? scrubber($most_valuable, 'string') : '';
$least_valuable		= isset($least_valuable) ? scrubber($least_valuable, 'string') : '';
$difficulty			= isset($difficulty) ? scrubber($difficulty, 'string') : '';
$application		= isset($application) ? scrubber($application, 'string') : '';

// see if email already exists ------------------------------------------------------------------------------------------------------------
$fm      = db_connect("MCH-Navigator");

$record = $fm->createRecord('MCH_Smart_Feedback');
$record->setField('uID', $uID);
$record->setField('expectations', $expectations);
$record->setField('most_valuable', $most_valuable);
$record->setField('least_valuable', $least_valuable);
$record->setField('difficulty', $difficulty);
$record->setField('application', $application);
$result = $record->commit();

if (FileMaker::isError($result)) {
	echo $result->getMessage();
} 




include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'Feedback';
include ('incl/header.html');
?>

<div class="container wrapper">
	<?php include('incl/nav_generic.html') ?>

	<div class="ten columns">
		<div id="page_title"><img src="images/Dashboard-lightbulb-concept.jpg" alt="lightbulb and paper with pencil">
		  <div class="v">
		    <h1>Program Evaluation</h1>
		  </div>
		</div>

		<p><strong><img src="images/great-job.jpg" width="350" height="233" alt="Great Job" class="right border" />Congratulations! You have completed the entire curriculum.</strong></p>
		
		<p>We hope that you have increased your knowledge, skills, and efficacy related to the MCH Leadership Competencies	and have taken a large step on your personal learning journey.</p>
		
		<h3 style="margin-bottom: 1em;">You may access your <a href="certificate.php"><strong>Certificate of Completion</strong></a> here with our admiration.</h3>
		
		<p>You can always return to the <strong><a href="dashboard.php">Dashboard</a></strong> to access resources at anytime. Remember, the MCH Leadership Competencies are the building blocks of the work you do everyday, whether it's in the classroom or other academic environment, a state or local health department, or as a family or community representative. We are all part of the MCH community.	</p>
	</div>
</div>

<?php include('incl/footer.html') ?>