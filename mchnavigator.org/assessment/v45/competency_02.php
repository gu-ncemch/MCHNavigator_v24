<?php
include("../account/cookie.php");
require_once __DIR__ . '/../../filemaker/data-api.php';
$section = 'assessment';
$page = 'competency';
$page_title = "Self-Assessment: Competency 2";
$sID = "2";
include ('../../incl/header.html');
?>
<link rel="stylesheet" href="../styles.css">
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
	<?php include('../../incl/leftnav.html'); ?>
	<div class="nine columns">
		<?php include('../../incl/title.html'); ?>

		<?php if(isset($_GET["saved"])){ ?>
		<p class="saved">Your responses for Competency <?php echo $_GET["saved"]; ?> have been saved!</p>
		<?php } ?>

		<h2>Self-Reflection</h2>
		<p><img src="../../images/competency2.jpg" alt="Self-Reflection" class="right border"><strong>Definition.</strong><em> Self-reflection</em> is the process of assessing the impact of values, beliefs, communication, and experiences on one's personal and professional leadership style. By engaging in self-reflection, MCH leaders:</p>
		<ul>
		  <li>Develop a deeper understanding of personal experiences, values, and beliefs, and how these may influence future action and learning.</li>
		  <li>Identify personal strengths in both informal and organizational contexts.</li>
		  <li>Explore personal leadership styles and attributes, and how those are valued in current and potential work settings.</li>
		  <li>Establish and maintain professional boundaries in ways that prioritize their physical, mental, and emotional health.</li>
	  </ul>
		<p><strong>For More Information. </strong>Read more about this competency on the <a href="https://mchb.hrsa.gov/training/leadership-02.asp" target="_blank">MCH Leadership Competencies website</a>.</p>
		<p><strong>For each of the knowledge and skills statement below, respond with your personal knowledge and skills for that question. </strong></p>
		<?php
	$section = 2;
	if(isset($_GET["rID"])){
		$rID = $_GET["rID"];
		include("competency_past.php");
	}else{
		include("competency_form.php");
	}
?>
	</div>
</div>

<?php include('../../incl/footer.html'); ?>
