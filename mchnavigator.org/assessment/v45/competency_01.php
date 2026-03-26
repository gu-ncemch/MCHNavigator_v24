<?php
include("../account/cookie.php");
include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'competency';
$page_title = "Self-Assessment: Competency 1";
$sID = "1";
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

		<h2>MCH Knowledge Base/Context</h2>
		<p><img src="../../images/competency1.jpg" alt="Assessment" class="right border"><strong>Definition.</strong><em> Maternal and child healt</em>h (MCH) is a specialty area within the larger field of public health, distinguished by:</p>
        <ul>
          <li>Promotion of the health and well-being of mothers, children, and families. Focus directed to key population domains: women, infants, children, adolescents, young adults, caregivers, and children and youth with special health care needs (CYSHCN).</li>
          <li>A focus on individuals within their family and community contexts, and the systems of care that support these individuals.</li>
          <li>A developmental perspective that recognizes distinct periods of human growth, identifying opportunities for targeted interventions to support positive health outcomes throughout the life cycle.</li>
        </ul>
        <p><strong>For More Information. </strong>Read more about this competency on the <a href="https://mchb.hrsa.gov/training/leadership-01.asp" target="_blank">MCH Leadership Competencies website</a>.</p>
		<p><strong>For each of the knowledge and skills statement below, respond with your personal knowledge and skills for that question. </strong></p>
		<?php
	$section = 1;
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
