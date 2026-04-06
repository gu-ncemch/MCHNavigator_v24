<?php
include("../account/cookie.php");
include_once(__DIR__ . "/../../../globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'main';
$page_title = "Progress";
include ('../../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../../incl/leftnav.html'); ?>
<div class="nine columns">
<?php include('../../incl/title.html'); ?>

<p><strong><img src="../../images/self-assessment-1.jpg" width="299" height="200" alt="Ethics" class="right border">Instructions:</strong> This online self-assessment is designed to meet your needs. You can take the full self-assessment in one sitting or you can take it in increments by logging back in (the full self-assessment takes approximately 1 hour to complete; each of the 12 competencies takes about 5 minutes to complete). You can track your progress below using the interactive Competency Map. You can also take each competency multiple times to track your knowledge and skills over time. After you take the self-assessment, either in full or part, you can access a Personalized Learning Plan.</p>
<p>If you have questions about the self-assessment or are experiencing difficulties with it, please <a href="mailto:mchnavigator@ncemch.org">contact</a> the MCH Navigator Team.</p>
<p>Also, please provide <a href="../feedback.php">feedback</a> about the self-assessment and your experiences using it.</p>
<?php if(isset($_GET["saved"])){ ?>
<p class="saved">Your responses for Competency <?php echo $_GET["saved"]; ?> have been saved!</p>
<?php } ?>
<h2>Table of Contents</h2>
<ul>
  <li><a href="#full">Take the Full Self-Assessment</a> or <a href="#individual">Take Individual Competency Self-Assessments</a></li>
  <li><a href="#chart">Chart Your Progress</a></li>
  <li><a href="#results">View Your Results and Recieve a Personalized Learning Plan</a></li>
</ul>
<h2><a id="full"></a>Full Self-Assessment</h2>
<p><a href="competency_01.php?pathway=full" class="btnesque">Take the Full Assessment</a> Consists of all 12 competencies (<em>takes approximately 1 hour to complete</em>)</p>
<h2><a id="chart"></a>Chart Your Progress</h2>
<p>You can chart your progress below with the Competency Map on this page and throughout the self-assessment.</p>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="3%">&nbsp;</td>
    <td width="3%"><img src="../../images/dotted-circle.jpg" alt="Check" width="26" height="24"></td>
    <td width="94%">A dotted circle  around a numbered assessment indicates that it has not yet been taken.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><img src="../assets/checkmark.gif" alt="Check" width="23" height="21"></td>
    <td>A checked assessment indicates that it has been completed. </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><img src="../../images/red-circle.jpg" alt="Check" width="26" height="24"></td>
    <td>A thick circle  around a numbered assessment  indicates your location in the Self-Assessment process.</td>
  </tr>
</table>
<p><img src="../../images/map.jpg" alt="your progress thus far" id="map" /></p>
<h2><a id="individual"></a>Individual Competencies and Progress</h2>
<p>You can take each Competency individually (<em>each competency takes approximately 5 minutes to complete</em>). Competencies that you have taken are marked with a check <img src="../assets/checkmark.gif" height="24" width="26" alt="checked">. You can view your past responses to any competency by clicking on the date.</p>
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
			echo '<img src="checkmark.gif" height="24" width="26"> ';
		} else{
			echo '<img src="incomplete.gif" height="24" width="26"> ';
		}
		$csection++;
	}
?>
<div id="progressTOC"><h3>Self</h3>
<h4><?php complete(); ?><a href="competency_01.php"><strong>Competency 1:</strong> MCH Knowledge Base/Context</a></h4>
<?php pastResults(); ?>
<h4><?php complete(); ?><a href="competency_02.php"><strong>Competency 2:</strong> Self-Reflection</a></h4>
<?php pastResults(); ?>
<h4><?php complete(); ?><a href="competency_03.php"><strong>Competency 3:</strong> Ethics and Professionalism</a></h4>
<?php pastResults(); ?>
<h4><?php complete(); ?><a href="competency_04.php"><strong>Competency 4:</strong> Critical Thinking</a></h4>
<?php pastResults(); ?>
<h3>Others</h3>
<h4><?php complete(); ?><a href="competency_05.php"><strong>Competency 5:</strong> Communication</a></h4>
<?php pastResults(); ?>
<h4><?php complete(); ?><a href="competency_06.php"><strong>Competency 6:</strong> Negotiation and Conflict Resolution</a></h4>
<?php pastResults(); ?>
<h4><?php complete(); ?><a href="competency_07.php"><strong>Competency 7:</strong> Diversity, Equity, Inclusion, and Accessibility</a></h4>
<?php pastResults(); ?>
<h4><?php complete(); ?><a href="competency_08.php"><strong>Competency 8:</strong> Family-Centered Care</a></h4>
<?php pastResults(); ?>
<h4><?php complete(); ?><a href="competency_09.php"><strong>Competency 9:</strong> Developing Others Through Teaching and Mentoring</a></h4>
<?php pastResults(); ?>
<h4><?php complete(); ?><a href="competency_10.php"><strong>Competency 10:</strong> Interdisciplinary Team Building</a></h4>
<?php pastResults(); ?>
<h3>Wider Community</h3>
<h4><?php complete(); ?><a href="competency_11.php"><strong>Competency 11:</strong> Systems Approach</a></h4>
<?php pastResults(); ?>
<h4><?php complete(); ?><a href="competency_12.php"><strong>Competency 12:</strong> Policy and Advocacy</a></h4>
<?php pastResults(); ?></div>
<p>&nbsp;</p>
<h2><a id="results"></a>Results and Personalized Learning Plan</h2>
<?php if (sizeof($comps) == 12){ ?>
<p><strong>Congratulations!</strong> You have completed the self-assessment!</p>
<?php } ?>
<?php if (sizeof($comps) > 0){ ?>
<p><a href="learning-plan.php" class="btnesque">Review your results and Personal Learning Plan</a></p>
<?php } else{ ?>
<p>Check back here for your results after you have completed the self-assessment in full or in part.</p>
<?php } ?>

</div>
</div>

<?php include('../../incl/footer.html'); ?>
