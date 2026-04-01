<?php
include("../account/cookie.php");
include_once(__DIR__ . "/../../../globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'competency';
$page_title = "Self-Assessment: Competency 2";
$sID = "2";
include ('../../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../../incl/leftnav.html'); ?>
<div class="nine columns">
<?php include('../../incl/title.html'); ?>

<?php if(isset($_GET["saved"])){ ?>
<p class="saved">Your responses for Competency <?php echo $_GET["saved"]; ?> have been saved!</p>
<?php } ?>

<h2>Self-Reflection</h2>
<p><img src="../../images/competency2.jpg" alt="Self-Reflection" class="right border"><strong>Definition.</strong><em> Self-reflection</em> is the process of assessing the impact of personal values, beliefs, communication styles, cultural influences, and experiences on one&rsquo;s personal and professional leadership style. By engaging in self-reflection, MCH leaders:</p>
<ul>
  <li>Develop a deeper understanding of their personal and cultural biases, experiences, values, and beliefs and how these may influence future action and learning.<br />
  </li>
  <li>Identify personal strengths in both informal and organizational contexts.<br />
  </li>
  <li>Explore personal leadership styles and attributes in relation to the settings in which they work.<br />
  </li>
  <li>Strive for balance between private and professional lives to optimize well-being.</li>
</ul>
<p><strong>For More Information. </strong>Read more about this competency on the <a href="https://mchb.hrsa.gov/training/leadership-02.asp" target="_blank">MCH Leadership Competencies website</a>.</p>
<p><strong>For each of the knowledge and skills statement below, respond with  your personal knowledge and skills for that question. </strong></p>
<?php
	$section = 2;
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
