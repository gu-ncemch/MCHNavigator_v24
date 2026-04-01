<?php
include("../account/cookie.php");
include_once(__DIR__ . "/../../../globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'competency';
$page_title = "Self-Assessment: Competency 7";
$sID = "7";
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

		<h2>Responsive and Effective MCH Systems</h2>
		<p><strong><img src="../../images/competency7.jpg" alt="Diversity, Equity, Inclusion, and Accessibility" class="right border">Definition. </strong><em>Professional Responsiveness</em> is a developmental process that occurs along a continuum and evolves over an extended period. It broadly represents the knowledge and skills necessary to communicate and interact effectively with people, helping to ensure that the needs of individuals and communities are met in a respectful and comprehensive way. Developing professional responsiveness is an ongoing and adaptive process.</p>
		<p><em>Effective healthcare</em> seeks to understand and address the unique challenges faced by different population groups, recognizing the importance of comprehensive and individualized approaches to health and well-being.</p>
		<p><strong>For More Information. </strong>Read more about this competency on the <a href="https://mchb.hrsa.gov/training/leadership-07.asp" target="_blank">MCH Leadship Competencies website</a>.</p>
		<p><strong>For each of the knowledge and skills statement below, respond with your personal knowledge and skills for that question. </strong></p>

		<?php
	$section = 7;
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
