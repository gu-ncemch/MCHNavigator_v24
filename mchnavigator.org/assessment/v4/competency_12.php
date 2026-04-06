<?php
include("../account/cookie.php");
include_once(__DIR__ . "/../../../globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'competency';
$page_title = "Self-Assessment: Competency 12";
$sID = "12";
include ('../../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../../incl/leftnav.html'); ?>
<div class="nine columns">
<?php include('../../incl/title.html'); ?>

<?php if(isset($_GET["saved"])){ ?>
<p class="saved">Your responses for Competency <?php echo $_GET["saved"]; ?> have been saved!</p>
<?php } ?>

<h2>Policy</h2>
<p><strong><img src="../../images/competency12.jpg" alt="Policy and Advocacy" class="right border">Definition. </strong>It is important for MCH leaders to possess policy skills, particularly in changing and competitive economic and political environments. MCH leaders understand the resources necessary to improve health and well-being for children, youth, families, and communities, and the need to be able to articulate those needs in the context of policy development and implementation.</p>
<p>A <em>public policy</em> is a law, regulation, procedure, administrative action, or voluntary practice of government that affects groups or populations and influences resource allocation.</p>
<p><strong>For More Information. </strong>Read more about this competency on the <a href="https://mchb.hrsa.gov/training/leadership-12.asp" target="_blank">MCH Leadship Competencies website</a>.</p>
<p><strong>For each of the knowledge and skills statement below, respond with  your personal knowledge and skills for that question. </strong></p>


<?php
	$section = 12;
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
