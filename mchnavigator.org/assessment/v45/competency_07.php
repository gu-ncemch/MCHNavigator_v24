<?php
include("../account/cookie.php");
include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
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

		<h2>Community Health Factors</h2>
		<p><strong><img src="../../images/competency7.jpg" alt="Community Health Factors" class="right border">Definition. </strong>Promoting the health of women, children and families, especially those in underserved areas, requires an understanding of the complex community factors that influence health. Community factors such as transportation, housing, lifestyle, access to health care services, environmental factors, and social support can have a significant impact on health. Engaging with communities to identify and address community factors can improve the health and quality of life of individuals in those communities. To address these factors, the MCH workforce may work synergistically and collaboratively across sectors to help individuals and communities prevent disease and promote healthy living.</p>
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
