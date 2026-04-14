<?php
include("../account/cookie.php");
require_once __DIR__ . '/../../filemaker/data-api.php';
$section = 'assessment';
$page = 'competency';
$page_title = "Self-Assessment: Competency 11";
$sID = "11";
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

		<h2>Systems Approach</h2>
		<p><strong><img src="../../images/competency11.jpg" alt="Communities and Systems" class="right border">Definition.</strong>Improving the health and well-being of mothers, children, and families is a complex process influenced by multiple interconnected factors.<em> Systems thinking</em> recognizes this complexity and examines the connections between components—including norms, laws, resources, infrastructure, and individual behaviors—that affect outcomes. Systems thinking explores how these components interact at multiple levels and the leadership needed to drive meaningful improvements across those levels.</p>
		<p><strong>For More Information. </strong>Read more about this competency on the <a href="https://mchb.hrsa.gov/training/leadership-11.asp" target="_blank">MCH Leadship Competencies website</a>.</p>
		<p><strong>For each of the knowledge and skills statement below, respond with your personal knowledge and skills for that question. </strong></p>

		<?php
	$section = 11;
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
