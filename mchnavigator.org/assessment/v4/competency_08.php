<?php
include("../account/cookie.php");
include_once(__DIR__ . "/../../../globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'competency';
$page_title = "Self-Assessment: Competency 8";
$sID = "8";
include ('../../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../../incl/leftnav.html'); ?>
<div class="nine columns">
<?php include('../../incl/title.html'); ?>

<?php if(isset($_GET["saved"])){ ?>
<p class="saved">Your responses for Competency <?php echo $_GET["saved"]; ?> have been saved!</p>
<?php } ?>

<h2>Family-Professional Partnerships</h2>
<p><strong><img src="../../images/competency8.jpg" alt="Family Centered Care" class="right border">Definition.</strong><em> Family-professional partnerships</em> at all levels of the system of care ensure the health and wellbeing of children, including those with special health care needs, and their families through respectful family-professional collaboration and shared decision making. Partnerships with family-run organizations and with families and individuals from the target population honor the strengths, culture, traditions, and expertise that everyone brings to the relationship when engaged in program planning, program implementation, and policy activities in leadership roles in a developmentally respectful manner. Partnerships with these organizations can also help MCH leaders connect with families and youth from diverse backgrounds to ensure the perspectives of the communities who receive services are represented.</p>
<p><strong>For More Information. </strong>Read more about this competency on the <a href="https://mchb.hrsa.gov/training/leadership-08.asp" target="_new">MCH Leadership Competencies website</a>.</p>
<p><strong>For each of the knowledge and skills statement below, respond with  your personal knowledge and skills for that question. </strong></p>

<?php
	$section = 8;
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
