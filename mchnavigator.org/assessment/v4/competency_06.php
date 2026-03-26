<?php
include("../account/cookie.php");
include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'competency';
$page_title = "Self-Assessment: Competency 6";
$sID = "6";
include ('../../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../../incl/leftnav.html'); ?>
<div class="nine columns">
<?php include('../../incl/title.html'); ?>

<?php if(isset($_GET["saved"])){ ?>
<p class="saved">Your responses for Competency <?php echo $_GET["saved"]; ?> have been saved!</p>
<?php } ?>

<h2>Negotiation and Conflict Resolution</h2>
<p><strong><img src="../../images/competecy6.jpg" alt="Negotiation and Conflict Resolution" class="right border">Definition.</strong><em> Negotiation</em> is a cooperative process where participants try to find a solution that meets the legitimate interests of involved parties; it is a discussion intended to produce an agreement.</p>
<p><em>Conflict resolution</em> is the process of resolving or managing a dispute by sharing each party&rsquo;s points of view and adequately addressing their interests so that they are satisfied with the outcome.</p>
<p>MCH professionals approach negotiations and conflict with objectivity and are open to new information but aware of long-term desired outcomes that include relationship-building and development of trust. They recognize when compromise is appropriate to overcome an impasse and when persistence toward a different solution is warranted.</p>
<p><strong>For More Information. </strong>Read more about this competency on the <a href="https://mchb.hrsa.gov/training/leadership-06.asp" target="_blank">MCH Leadship Competencies website</a>.</p>
<p><strong>For each of the knowledge and skills statement below, respond with  your personal knowledge and skills for that question. </strong></p>
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
