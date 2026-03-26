<?php
include("../account/cookie.php");
include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'main';
$page_title = "Results";
include ('../../incl/header.html');
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
	// get questions
	$request = $fm->newFindCommand('SA_Responses_v45');
	$request->addFindCriterion('uID', "=".$uID);
	$request->addSortRule('section', 1, FILEMAKER_SORT_ASCEND);
	$request->addSortRule('date', 2, FILEMAKER_SORT_DESCEND);
	$result = $request->execute();
	if (FileMaker::isError($result)) {
		#echo $result->getMessage();
	} else {
		$records = $result->getRecords();
	}
	// give the goods
	$comps = array();
	$groupingHeader = '';
	$compareHeading = '';
	foreach ($records as $record) {
		// compare types and output the heading if needed
		$compareHeading = $record->getField('section');
		if($groupingHeader != $compareHeading){
			$comps[$compareHeading] = array();
			//echo $compareHeading;
			$groupingHeader = $compareHeading;
		}
		// output it all, finally!
		$zeroLead = $compareHeading < 10 ? "0" : "";
		// date with timestamp == array_push($comps[$compareHeading], '<a href="competency_'.$zeroLead.$compareHeading.'.php?rID='.$record->getField('rID').'" class="btnDate">'.date('l F jS, Y \a\t g:ia',strtotime($record->getField('date'))).'</a>');
		array_push($comps[$compareHeading], '<a href="competency_'.$zeroLead.$compareHeading.'.php?rID='.$record->getField('rID').'" class="btnDate">'.date('l F jS, Y',strtotime($record->getField('date'))).'</a>');
	}

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
