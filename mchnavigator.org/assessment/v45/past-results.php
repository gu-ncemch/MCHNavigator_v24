<?php
include("../account/cookie.php");
require_once __DIR__ . '/../../filemaker/data-api.php';
$section = 'assessment';
$page = 'main';
$page_title = "Results";
include ('../../incl/header.html');

function v45_past_results_by_section($uID) {
	$request = array(
		'database' => 'MCH-Navigator',
		'layout' => 'SA_Responses_v45',
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
	$comps = array();
	if ((int) ($result['messages'][0]['code'] ?? 500) !== 0 || empty($result['response']['data'])) {
		return $comps;
	}

	foreach ($result['response']['data'] as $record) {
		$currentSection = (int) ($record['fieldData']['section'] ?? 0);
		if ($currentSection === 0) {
			continue;
		}
		if (!isset($comps[$currentSection])) {
			$comps[$currentSection] = array();
		}
		$zeroLead = $currentSection < 10 ? "0" : "";
		$comps[$currentSection][] = '<a href="competency_'.$zeroLead.$currentSection.'.php?rID='.($record['fieldData']['rID'] ?? '').'" class="btnDate">'.date('l F jS, Y', strtotime($record['fieldData']['date'] ?? '')).'</a>';
	}

	return $comps;
}
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
	<?php include('../../incl/leftnav.html'); ?>
	<div class="nine columns">
		<?php include('../../incl/title.html'); ?>
		<p><a href="/account/edit.php" class="btnesque">Edit Profile</a> <a href="/account/logout.php" class="btnesque">Logout</a></p>
		<h2>Past Results for Individual Competencies</h2>
		<p>This online self-assessment remembers your answers for each session. Use the links below to access your past results for each self-assessment competency by clicking on the date box below. </p>
		<?php if(isset($_GET["saved"])){ ?>
		<p class="saved">Your responses for Competency <?php echo $_GET["saved"]; ?> have been saved!</p>
		<?php } ?>
		<p>Competencies that you have taken are marked with a check mark. </p>
		<?php
	$comps = v45_past_results_by_section($uID);

	// display past results function
	$rsection = 1;
	function pastResults(){
		global $comps, $rsection;
		if(isset($comps[$rsection])){
			echo '<blockquote><ul><li>'.implode("</li><li>", $comps[$rsection]).'</li></ul></blockquote>';
		} else{
			echo "<blockquote><p>You have not yet completed this competency.</p></blockquote>";
		}
		$rsection++;
	}

	// display past results function
	$csection = 1;
	function complete(){
		global $comps, $csection;
		if(isset($comps[$csection])){
			echo '<img src="../assets/checkmark.gif" class="status"> ';
		} else{
			echo '<img src="../assets/incomplete.gif" class="status"> ';
		}
		$csection++;
	}
?>
		<div id="progressTOC">
			<h3>Self</h3>
			<h4><?php complete(); ?>
				<strong>Competency 1:</strong> MCH Knowledge Base/Context
			</h4>
			<?php pastResults(); ?>
			<h4><?php complete(); ?>
				<strong>Competency 2:</strong> Self-Reflection
			</h4>
			<?php pastResults(); ?>
			<h4><?php complete(); ?>
				<strong>Competency 3:</strong> Ethics and Professionalism
			</h4>
			<?php pastResults(); ?>
			<h4><?php complete(); ?>
				<strong>Competency 4:</strong> Critical Thinking
			</h4>
			<?php pastResults(); ?>
			<h3>Others</h3>
			<h4><?php complete(); ?>
				<strong>Competency 5:</strong> Communication
			</h4>
			<?php pastResults(); ?>
			<h4><?php complete(); ?>
				<strong>Competency 6:</strong> Negotiation and Conflict Resolution
			</h4>
			<?php pastResults(); ?>
			<h4><?php complete(); ?>
				<strong>Competency 7:</strong> Creating Responsive and Effective MCH Systems
			</h4>
			<?php pastResults(); ?>
			<h4><?php complete(); ?>
				<strong>Competency 8:</strong> Community Expertise and Perspectives
			</h4>
			<?php pastResults(); ?>
			<h4><?php complete(); ?>
				<strong>Competency 9:</strong> Teaching Coaching, and Mentoring
			</h4>
			<?php pastResults(); ?>
			<h4><?php complete(); ?>
				<strong>Competency 10:</strong> Interdisciplinary/Interprofessional Team Building
			</h4>
			<?php pastResults(); ?>
			<h3>Wider Community</h3>
			<h4><?php complete(); ?>
				<strong>Competency 11:</strong> Systems Approach
			</h4>
			<?php pastResults(); ?>
			<h4><?php complete(); ?>
				<strong>Competency 12:</strong> Policy
			</h4>
			<?php pastResults(); ?>
		</div>

	</div>
</div>

<?php include('../../incl/footer.html'); ?>
