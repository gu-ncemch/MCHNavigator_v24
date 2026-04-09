<?php
include("../account/cookie.php");
include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
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

		<h2>Lived Experience in MCH</h2>
		<p><strong><img src="../../images/competency8.jpg" alt="Lived Experience in MCH" class="right border">Definition.</strong> Recognizing the lived experience of MCH populations ensures their health and well-being through respectful collaboration and shared decision-making. Additionally, partnerships with organizations led by individuals with relevant lived experience honor the strengths and expertise that everyone brings to program planning, implementation, evaluation, and policy activities. These partnerships can help MCH leaders understand the unique and valuable perspectives of the communities that receive services. </p>
		<p>Historically in the field of MCH, the concept of family-centered care was developed within the community of parents, advocates, and health professionals working with CYSHCN. The goal was that all care should be received in family-centered, comprehensive, coordinated systems. It is now widely recognized that family members and individuals with lived experience themselves, including those with disabilities and special health care needs, provide critical insights into the successful development of effective policies, practices, and program delivery. </p>
		<p>There is a difference between the perspectives of family members and individuals with relevant experience in MCH. Their viewpoints constitute two distinct, valued perspectives, and each provides unique knowledge to clinical, training, and public health programs and the field. </p>
		<p>The key to effective partnerships with individuals with lived experience in MCH entails:</p>
		<ul>
		  <li>Making shared decisions when planning and implementing activities.</li>
		  <li>Addressing the priorities of individuals with lived experience in MCH using a strengths-based approach.</li>
		  <li>Recognizing the agency of individuals with lived experience in MCH in decision-making as they approach transition age and across the lifespan.</li>
		  <li>Connecting individuals with lived experience in MCH to needed services that meet their unique needs.</li>
		  <li>Acknowledging that community factors can influence health and that broader systems of care greatly impact individuals with disabilities and/or special health care needs.		</li>
	  </ul>
		<p><strong>For each of the knowledge and skills statements below, respond with your personal knowledge and skills for that question. </strong></p>

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
