<?php
include("../account/cookie.php");
include_once(__DIR__ . "/../../../globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'competency';
$page_title = "Self-Assessment: Competency 9";
$sID = "9";
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

		<h2>Teaching Coaching, and Mentoring</h2>
		<p><strong><img src="../../images/competency9.jpg" alt="Teaching and Mentoring" class="right border">Definition. </strong><em>Teaching, coaching, and mentoring</em> are three primary strategies used to develop others. The relationships between teachers and students, coaches and participants, and mentors and mentees are collaborative relationships that contribute to building and strengthening the public health workforce.</p>
		<p><em>Teaching</em> involves designing a learning environment, which can include developing objectives and curricula; providing resources and training opportunities; modeling effective learning processes; and evaluating learning outcomes.</p>
		<p><em>Coaching</em> refers to methods of training and supporting individuals or groups to maximize their potential by developing skills, exploring perspectives, setting goals, taking appropriate actions, and reflecting on outcomes.</p>
		<p><em>Mentoring</em> is a collaborative learning relationship in which a mentor and mentee work together toward achieving mutually defined goals that will develop participants' skills, abilities, knowledge, and professional understanding.</p>
		<p><strong>For More Information. </strong>Read more about this competency on the <a href="https://mchb.hrsa.gov/training/leadership-09.asp" target="_blank">MCH Leadship Competencies website</a>.</p>
		<p><strong>For each of the knowledge and skills statement below, respond with your personal knowledge and skills for that question. </strong></p>

		<?php
	$section = 9;
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
