<?php
include("../account/cookie.php");
require_once __DIR__ . '/../../filemaker/data-api.php';
$section = 'assessment';
$page = 'competency';
$page_title = "Self-Assessment: Competency 8";
$sID = "8";
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

		<h2>Community Expertise and Perspectives</h2>
		<p><strong><img src="../../images/competency8.jpg" alt="Family Centered Care" class="right border">Definition.</strong> <em>Community Expertise and Perspectives</em> ensure the health and wellbeing of children, including those with special health care needs, and their families through respectful professional collaboration and shared decision making. Partnerships with organizations and with families and individuals recognize the unique strengths and expertise that participants bring to the relationship when engaged in program planning, program implementation, and policy activities in leadership roles in a developmentally appropriate manner. Partnerships with these organizations can help MCH leaders connect with families and youth to ensure meaningful representation of service recipients' insights.</p>
		<p><strong>For More Information. </strong>Read more about this competency on the <a href="https://mchb.hrsa.gov/training/leadership-08.asp" target="_new">MCH Leadership Competencies website</a>.</p>
		<p><strong>For each of the knowledge and skills statement below, respond with your personal knowledge and skills for that question. </strong></p>

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
