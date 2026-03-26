<?php
include("../account/cookie.php");
include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'competency';
$page_title = "Self-Assessment: Competency 11";
$sID = "11";
include ('../../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../../incl/leftnav.html'); ?>
<div class="nine columns">
<?php include('../../incl/title.html'); ?>

<?php if(isset($_GET["saved"])){ ?>
<p class="saved">Your responses for Competency <?php echo $_GET["saved"]; ?> have been saved!</p>
<?php } ?>

<h2>Working with Communities and Systems</h2>
<p><strong><img src="../../images/competecy11.jpg" alt="Communities and Systems" class="right border">Definition.</strong> Improving the health and well-being of children, youth, families, and communities is a complex process because so many intersecting factors influence the MCH population. Systems thinking recognizes complexity and examines the linkages and interactions among components— norms, laws, resources, infrastructure, and individual behaviors—that influence outcomes. Systems thinking addresses how these components interact at multiple levels, including individual organizations; the collective stakeholders; and the communities where the children, youth, and families reside. </p>
<p>The achievement of MCH goals requires leadership within the community and among organizations to advance the collective impact of stakeholders that constitute the larger system.</p>
<p><strong>For More Information. </strong>Read more about this competency on the <a href="https://mchb.hrsa.gov/training/leadership-11.asp" target="_blank">MCH Leadship Competencies website</a>.</p>
<p><strong>For each of the knowledge and skills statement below, respond with  your personal knowledge and skills for that question. </strong></p>

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
