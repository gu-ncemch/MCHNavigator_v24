<?php
include("../account/cookie.php");
include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'competency';
$page_title = "Self-Assessment: Competency 9";
$sID = "9";
include ('../../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../../incl/leftnav.html'); ?>
<div class="nine columns">
<?php include('../../incl/title.html'); ?>

<?php if(isset($_GET["saved"])){ ?>
<p class="saved">Your responses for Competency <?php echo $_GET["saved"]; ?> have been saved!</p>
<?php } ?>

<h2>Developing Others Through Teaching, Coaching, and Mentoring</h2>
<p><strong><img src="../../images/competency9.jpg" alt="Teaching and Mentoring" class="right border">Definition. </strong>Teaching, coaching, and mentoring are three primary strategies used to develop others.</p>
<p><em>Teaching</em> involves designing the learning environment, which includes developing learning objectives and curricula; providing resources and training opportunities; modeling the process of effective learning; and evaluating whether learning occurred.</p>
<p><em>Coaching</em> provides the guidance and structure needed for people to capably examine their assumptions, set realistic goals, take appropriate actions, and reflect on their actions (and the resulting outcomes or implications).</p>
<p><em>Mentoring</em> is influencing the career development and professional growth of another by acting as an advocate, teacher, guide, role model, benevolent authority, door opener, resource, cheerful critic, or career enthusiast.</p>
<p><strong>For More Information. </strong>Read more about this competency on the <a href="https://mchb.hrsa.gov/training/leadership-09.asp" target="_blank">MCH Leadship Competencies website</a>.</p>
<p><strong>For each of the knowledge and skills statement below, respond with  your personal knowledge and skills for that question. </strong></p>

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
