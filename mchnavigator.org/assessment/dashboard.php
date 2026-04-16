<?php

include("account/cookie.php");
require_once __DIR__ . '/../filemaker/data-api.php';
$section = 'assessment';
$page = 'main';
$page_title = "Self-Assessment";
include ('../incl/header.html');

function get_assessment_results_by_comp($layout, $uID) {
	$request = array(
		'database' => 'MCH-Navigator',
		'layout' => $layout,
		'action' => 'find',
		'parameters' => array(
			'query' => array(
				array(
					'uID' => '=' . (int) $uID,
				),
			),
			'sort' => array(
				array(
					'fieldName' => 'section',
					'sortOrder' => 'ascend',
				),
				array(
					'fieldName' => 'date',
					'sortOrder' => 'descend',
				),
			),
			'limit' => 500,
		),
	);

	$result = do_filemaker_request($request, 'array');
	if ((int) ($result['messages'][0]['code'] ?? 500) !== 0 || empty($result['response']['data'])) {
		return array();
	}

	$comps = array();
	foreach ($result['response']['data'] as $record) {
		$section = $record['fieldData']['section'] ?? '';
		$date = $record['fieldData']['date'] ?? '';
		$rID = $record['fieldData']['rID'] ?? '';
		if ($section === '' || $rID === '') {
			continue;
		}
		if (!isset($comps[$section])) {
			$comps[$section] = array();
		}
		$zeroLead = ((int) $section < 10) ? '0' : '';
		$comps[$section][] = '<a href="competency_' . $zeroLead . $section . '.php?rID=' . $rID . '" class="btnDate">' . date('l F jS, Y', strtotime($date)) . '</a>';
	}

	return $comps;
}
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
	<?php include('../incl/leftnav.html'); ?>
	<div class="nine columns">
		<?php include('../incl/title.html'); ?>
		<p align="right"><strong><?php echo $email; ?></strong> &nbsp; <a href="account/edit.php"><i class="icon mch-user" aria-hidden="true"></i>Edit Profile</a> &nbsp; <a href="account/logout.php"><i class="icon mch-triangle-stroked" aria-hidden="true"></i>Logout</a></p>

		<?php if(isset($_GET["saved"])){ ?>
		<p class="saved">Your responses for Competency <?php echo $_GET["saved"]; ?> have been saved!<br>
			You can take additional competencies or see your Personalized Learning Plan below.</p>
		<?php } ?>

		<section class="well">
			<h2>Navigation and Progress</h2>
			<p><strong><img src="../images/self-assessment-1.jpg" width="299" height="200" alt="Ethics" class="right border">Instructions:</strong> This online self-assessment is designed to enhance your professional competence. You can take the full self-assessment in one sitting or you can take it in increments by logging back in (the full self-assessment takes approximately 1 hour to complete; each of the 12 competencies takes about 5 minutes to complete). </p>
			<p>After you take the self-assessment, either in full or part, you can access a <strong><a href="#personalized-learning-plan">Personalized Learning Plan</a></strong>.</p>
			<p>If you have questions about the self-assessment or are experiencing difficulties with it, please <a href="mailto:mchnavigator@ncemch.org">contact</a> the MCH Navigator Team.</p>
			<!--  -->
			<button class="accordion"> <strong><i class="icon mch-check-square-o" aria-hidden="true"></i> Tips for taking the self-assessment...</strong></button>
			<div class="panel">
				<p>Remember to answer questions <em>based on your key responsibilites as an MCH professional.</em> The self-assessment is most valuable when you are completely candid; your <strong><a href="#personalized-learning-plan">Personalized Learning Plan</a></strong> will better meet your needs when you acknowledge areas where you need growth as well as areas where you are knowledgeable and skilled. </p>
				<p>For both Option 1 and Option 2 your responses will be saved when you click on submit at the end of each competency; you can return to either the full self-assessment (Option 1) or individual competencise (Option 2) and your answers will be saved for those competencies that you have completed.<br />
					<br />
					To provide context, please use the following proficiency scale as you respond to each of the competencies:
				</p>
				<ul>
					<li><strong>None: </strong>You are aware of the competency, but it is not applicable to your professional role or you have little or no knowledge/experience in applying it in your current role. </li>
					<li><strong>Low:</strong> You can apply the competency in simple situations and requires frequent guidance.</li>
					<li><strong>Medium:</strong> You can apply the competency in somewhat difficult situations and requires occasional guidance.</li>
					<li><strong>High:</strong> You can apply the competency in considerably difficult situations and generally requires little or no guidance.</li>
				</ul>
			</div>
			<!--  -->
			<hr>
			<div class=" half">
				<h3><a id="full"></a><i class="icon mch-cogs" aria-hidden="true"></i> Option 1: Take the Full Self-Assessment</h3>
				<p>The full self-assessment consists of all 12 competencies (<em>takes approximately 1 hour to complete</em>).</p>
				<p><a href="v45/competency_01.php?pathway=full&r=<?php echo time(); ?>" class="button small">Take the Full Assessment</a></p>
			</div>
			<div class="half">
				<h3><a id="individual"></a><i class="icon mch-cog" aria-hidden="true"></i> Option 2: Take Assessments for Individual Competencies</h3>
				<p>You can take each Competency individually (<em>each competency takes approximately 5 minutes to complete</em>).</p>
				<p><a href="v45/individual-assessments.php" class="button small">Take Individual Assessments</a> </p>
			</div>
		</section>

		<section class="well">
			<h2 id="personalized-learning-plan"><i class="icon mch-scroll" aria-hidden="true"></i> Your Personalized Learning Plan</h2>
			<p><strong>We have updated the online self-assessment to be aligned with Version 4.5 of the MCH Leadership Competencies (August 2024)! </strong></p>
			<p>No matter what version of the self-assessment you have completed, you can access your results below. Results from both assessments are comparable as you monitor your progress over time.</p>

			<!-- V4.5 -->
			<?php
			$comps45 = get_assessment_results_by_comp('SA_Responses_v45', $uID);
			?>
			<hr>
			<h3><a id="results"></a>Your current results </h3>
			<?php if (sizeof($comps45) == 12){ ?>
			<p><strong>Congratulations!</strong> You have completed the entire self-assessment!</p>
			<?php } ?>
			<?php if (sizeof($comps45) > 0){ ?>
			<p><a href="v45/learning-plan.php" class="button small button-primary">Review your most recent results and your Personal Learning Plan</a></p>
			<p>You can also see <a href="v45/past-results.php">past results for each competency</a> that you have taken to track your progress over time.</p>
			<?php } else{ ?>
			<p>Check back here for your results after you have completed Version 4.5 of the self-assessment in full or in part.</p>
			<?php } ?>

			<!-- V4 -->
			<!-- <?php
			$comps4 = get_assessment_results_by_comp('SA_Responses_v4', $uID);
			?>
			<hr>
			<h3><a id="results"></a>Version 4.0 Results </h3>
			<h4>(For users who have taken the self-assessment from January 2019 - mid-August 2024)</h4>
			<?php if (sizeof($comps4) == 12){ ?>
			<p><strong>Congratulations!</strong> You have completed the entire self-assessment!</p>
			<?php } ?>
			<?php if (sizeof($comps4) > 0){ ?>
			<p><a href="v4/learning-plan.php" class="button small button-primary">Review your most recent results and your Personal Learning Plan</a></p>
			<p>You can also see <a href="v4/past-results.php">past results for each competency</a> that you have taken to track your progress over time.</p>
			<?php } else{ ?>
			<p>You have not taken Version 4.0 of the self-assessment in full or in part.</p>
			<?php } ?> -->
		</section>

		<!-- FEEDBACK -->
		<p>Also, please provide <a href="https://www.surveymonkey.com/r/MCHcompetencies4" target="_blank"><strong>feedback</strong></a> about the self-assessment and your experiences using it.</p>
	</div>
</div>

<?php include('../incl/footer.html'); ?>
