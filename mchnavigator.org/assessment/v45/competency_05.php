<?php
include("../account/cookie.php");
include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'competency';
$page_title = "Self-Assessment: Competency 5";
$sID = "5";
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

		<h2>Communication</h2>
		<p><strong><img src="../../images/competency5.jpg" alt="Communication" class="right border">Definition. </strong><em>Communication</em> is the verbal, nonverbal, and written sharing of information. The communication process consists of a sender who develops and presents the message and the receiver who works to understand the message. Communication involves both the message and how the message is presented. Health communication is an essential part of  influencing behavior that can lead to improved health.</p>
		<p><em>Skillful communication</em> is the ability to convey information to and receive information from others effectively. It includes  components of attentive listening and clarity in writing for or presenting to a variety of audiences. An understanding of effective communication strategies  ensure clear and accessible information exchange between MCH professionals and the individuals and families they serve.</p>
<p><strong>For More Information. </strong>Read more about this competency on the <a href="https://mchb.hrsa.gov/training/leadership-05.asp" target="_blank">MCH Leadship Competencies website</a>.</p>
		<p><strong>For each of the knowledge and skills statement below, respond with your personal knowledge and skills for that question. </strong></p>
		<?php
	$section = 5;
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
