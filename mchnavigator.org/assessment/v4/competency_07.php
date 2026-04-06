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
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../../incl/leftnav.html'); ?>
<div class="nine columns">
<?php include('../../incl/title.html'); ?>

<?php if(isset($_GET["saved"])){ ?>
<p class="saved">Your responses for Competency <?php echo $_GET["saved"]; ?> have been saved!</p>
<?php } ?>

<h2>Cultural Competency</h2>
<p><strong><img src="../../images/competency7.jpg" alt="Cultural Competency" class="right border">Definition. </strong><em>Cultural competence</em> is a developmental process that occurs along a continuum and evolves over an extended period. It broadly represents knowledge and skills necessary to communicate and interact effectively with people regardless of differences, helping to ensure that the needs of all people and communities are met in a respectful and responsive way in an effort to decrease health disparities and lead to health equity. Becoming culturally competent is an ongoing and fluid process.</p>
<p>Health equity exists when challenges and barriers have been removed for those groups who experience greater obstacles to health based on their racial or ethnic group; religion; socioeconomic status; gender; sexual orientation or gender identity; age; mental health; cognitive, sensory, or physical disability; geographic location; or other characteristics historically linked to discrimination or exclusion.</p>
<p><strong>For More Information. </strong>Read more about this competency on the <a href="https://mchb.hrsa.gov/training/leadership-07.asp" target="_blank">MCH Leadship Competencies website</a>.</p>
<p><strong>For each of the knowledge and skills statement below, respond with  your personal knowledge and skills for that question. </strong></p>

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
