<?php
include("../account/cookie.php");
include_once(__DIR__ . "/../../../globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'competency';
$page_title = "Self-Assessment: Competency 6";
$sID = "6";
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

		<h2>Negotiation and Conflict Resolution</h2>
		<p><strong><img src="../../images/competency6.jpg" alt="Negotiation and Conflict Resolution" class="right border">Definition.</strong><em>Negotiation</em> is a cooperative process where participants try to find a solution that meets the legitimate interests of involved parties. <em>Conflict resolution</em> is the process of resolving or managing a dispute by sharing each party's perspective and adequately addressing their interests so that they are satisfied with the outcome.		</p>
		<p>MCH professionals approach conflict and negotiations with a focus on constructive dialogue and mutual understanding. They acknowledge that relationship building and trust development are imperative long-term outcomes. They also recognize when compromise is appropriate to overcome an impasse and when persistence toward a different solution is warranted.</p>
		<p><strong>For More Information. </strong>Read more about this competency on the <a href="https://mchb.hrsa.gov/training/leadership-06.asp" target="_blank">MCH Leadship Competencies website</a>.</p>
		<p><strong>For each of the knowledge and skills statement below, respond with your personal knowledge and skills for that question. </strong></p>
		<?php
	$section = 6;
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
