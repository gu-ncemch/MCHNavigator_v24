<?php
include("../account/cookie.php");
require_once __DIR__ . '/../../filemaker/data-api.php';
$section = 'assessment';
$page = 'individual';
$page_title = "Individual Assessments";
include ('../../incl/header.html');

function v45_results_by_section($uID) {
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
		$section = (int) ($record['fieldData']['section'] ?? 0);
		if ($section === 0) {
			continue;
		}
		if (!isset($comps[$section])) {
			$comps[$section] = array();
		}
		$zeroLead = $section < 10 ? "0" : "";
		$comps[$section][] = '<a href="competency_'.$zeroLead.$section.'.php?rID='.($record['fieldData']['rID'] ?? '').'" class="btnDate">'.date('l F jS, Y', strtotime($record['fieldData']['date'] ?? '')).'</a>';
	}

	return $comps;
}
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
	<?php include('../../incl/leftnav.html'); ?>
	<div class="nine columns">
		<?php include('../../incl/title.html'); ?>

		<?php if(isset($_GET["saved"])){ ?>
		<p class="saved">Your responses for Competency <?php echo $_GET["saved"]; ?> have been saved!</p>
		<?php } ?>

		<h2>Self-Assessment: Individual Assessments</h2>
		<p>Use the links below to take the self-assessment on each MCH Leadership Competency individually (<em>each competency takes approximately 5 minutes to complete</em>).</p>
		<p>Competencies that you have completed are marked with a check <img src="../assets/checkmark.gif" class="status" alt="checked">.</p>
		<p>You can return to the <a href="../dashboard.php">Dashboard</a> at any time to access your Personalized Learning Plan.</p>
		<h2>Instructions </h2>
		<ul>
			<li><span style="color: #9A0019">READ</span> the STATEMENTS for each competency from the links below.</li>
			<li><span style="color: #9A0019">REFLECT</span> on how IMPORTANT each competency is to you.</li>
			<li><span style="color: #9A0019">RESPOND</span> with your current level of KNOWLEDGE and your current SKILL SET for each statement.</li>
		</ul>
		<?php
	$comps = v45_results_by_section($uID);

	// display past results function
	$rsection = 1;
	function pastResults(){
		global $comps, $rsection;
		if(isset($comps[$rsection])){
			echo '<blockquote><p>'.implode(" ", $comps[$rsection]).'</p></blockquote>';
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
		</p>
		<div id="progressTOC">
			<h3>SELF</h3>
			<ul>
				<li><?php complete(); ?><a href="competency_01.php"><strong>Competency 1:</strong> MCH Knowledge Base/Context</a></li>
				<li><?php complete(); ?><a href="competency_02.php"><strong>Competency 2:</strong> Self-Reflection</a></li>
				<li><?php complete(); ?><a href="competency_03.php"><strong>Competency 3:</strong> Ethics</a></li>
				<li><?php complete(); ?><a href="competency_04.php"><strong>Competency 4:</strong> Critical Thinking</a></li>
			</ul>
			<h3>OTHERS</h3>
			<ul>
				<li><?php complete(); ?><a href="competency_05.php"><strong>Competency 5:</strong> Communication</a></li>
				<li><?php complete(); ?><a href="competency_06.php"><strong>Competency 6:</strong> Negotiation and Conflict Resolution</a></li>
				<li><?php complete(); ?><a href="competency_07.php"><strong>Competency 7:</strong> Responsive and Effective MCH Systems</a></li>
				<li><?php complete(); ?><a href="competency_08.php"><strong>Competency 8:</strong> Community Expertise and Perspectives</a></li>
				<li><?php complete(); ?><a href="competency_09.php"><strong>Competency 9:</strong> Teaching Coaching, and Mentoring</a></li>
				<li><?php complete(); ?><a href="competency_10.php"><strong>Competency 10:</strong> Interdisciplinary/Interprofessional Team Building</a></li>
			</ul>
			<h3>WIDER COMMUNITY</h3>
			<ul>
				<li><?php complete(); ?><a href="competency_11.php"><strong>Competency 11:</strong> Systems Approach</a></li>
				<li><?php complete(); ?><a href="competency_12.php"><strong>Competency 12:</strong> Policy</a></li>
			</ul>
		</div>

	</div>
</div>

<?php include('../../incl/footer.html'); ?>
