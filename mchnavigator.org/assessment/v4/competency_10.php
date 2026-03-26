<?php
include("../account/cookie.php");
include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'competency';
$page_title = "Self-Assessment: Competency 10";
$sID = "10";
include ('../../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../../incl/leftnav.html'); ?>
<div class="nine columns">
<?php include('../../incl/title.html'); ?>

<?php if(isset($_GET["saved"])){ ?>
<p class="saved">Your responses for Competency <?php echo $_GET["saved"]; ?> have been saved!</p>
<?php } ?>

<h2>Interdisciplinary/Interprofessional Team Building</h2>
<p><strong><img src="../../images/competency10.jpg" alt="Team Building" class="right border">Definition.</strong> MCH systems are <em>interdisciplinary/interprofessional (ID/IP)</em> in nature. ID/IP practice provides a supportive environment in which the skills and expertise of team members from different disciplines, including a variety of professionals, MCH populations, and community partners, are acknowledged and seen as essential and synergistic. Input from each team member is elicited and valued in making collaborative, outcome-driven decisions to address individual, community-level, or systems-level problems.</p>
<p>Members of an ID/IP team may include a variety of professionals, MCH populations, family and self-advocate leaders, and community partners. The &quot;team&quot;, which is the core of ID/IP practice, is characterized by mutual respect among stakeholders, shared leadership, equal or complementary investment in the process, and acceptance of responsibility for outcomes.</p>
<p><strong>For More Information. </strong>Read more about this competency on the <a href="https://mchb.hrsa.gov/training/leadership-10.asp" target="_blank">MCH Leadership Competencies website</a>.</p>
<p><strong>For each of the knowledge and skills statement below, respond with  your personal knowledge and skills for that question. </strong></p>

<?php
	$section = 10;
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
