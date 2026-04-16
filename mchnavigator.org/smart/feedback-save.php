<?php include("account/cookie.php"); ?>
<?php
require_once __DIR__ . '/../filemaker/data-api.php';


// prep data --------------------------------------------------------------------------------------------------------------
extract($_POST, EXTR_OVERWRITE);
$uID				= isset($uID) ? scrubber($uID, 'string') : '';
$expectations		= isset($expectations) ? scrubber($expectations, 'string') : '';
$most_valuable		= isset($most_valuable) ? scrubber($most_valuable, 'string') : '';
$least_valuable		= isset($least_valuable) ? scrubber($least_valuable, 'string') : '';
$difficulty			= isset($difficulty) ? scrubber($difficulty, 'string') : '';
$application		= isset($application) ? scrubber($application, 'string') : '';

// save feedback ------------------------------------------------------------------------------------------------------------
$create_request = array(
	'database' => 'MCH-Navigator',
	'layout' => 'MCH_Smart_Feedback',
	'action' => 'create',
	'parameters' => array(
		'fieldData' => array(
			'uID' => $uID,
			'expectations' => $expectations,
			'most_valuable' => $most_valuable,
			'least_valuable' => $least_valuable,
			'difficulty' => $difficulty,
			'application' => $application,
		),
	),
);

$result = do_filemaker_request($create_request, 'array');
$resultCode = (int) ($result['messages'][0]['code'] ?? 500);

if ($resultCode !== 0) {
	$errorMessage = $result['messages'][0]['message'] ?? 'Unknown FileMaker error';
	echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8');
}




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