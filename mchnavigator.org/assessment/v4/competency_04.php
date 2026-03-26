<?php
include("../account/cookie.php");
include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'competency';
$page_title = "Self-Assessment: Competency 4";
$sID = "4";
include ('../../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../../incl/leftnav.html'); ?>
<div class="nine columns">
<?php include('../../incl/title.html'); ?>

<?php if(isset($_GET["saved"])){ ?>
<p class="saved">Your responses for Competency <?php echo $_GET["saved"]; ?> have been saved!</p>
<?php } ?>

<h2>Critical Thinking</h2>
<p><strong><img src="../../images/competency4.jpg" alt="Critical Thinking" class="right border">Definition.</strong> Complex challenges faced by MCH populations and the systems that serve them necessitate critical thinking. <em>Critical thinking</em> is the ability to identify an issue or problem, frame it as a specific question, consider it from multiple perspectives, evaluate relevant information, and develop a reasoned resolution.</p>
<p><em>Evidence-based decision-making</em> is the conscientious, explicit, and judicious use of current best evidence to guide practice, policy, and research. It is an advanced manifestation of critical thinking skills.</p>
<p><em>Implementation</em> science is also a vital component of critical thinking in order to promote the adoption and integration of evidence-based practices, interventions, and policies.</p>
<p><strong>For More Information. </strong>Read more about this competency on the <a href="https://mchb.hrsa.gov/training/leadership-04.asp" target="_blank">MCH Leadship Competencies website</a>. </p>
<p><strong>For each of the knowledge and skills statement below, respond with  your personal knowledge and skills for that question. </strong></p>
<?php
	$section = 4;
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
