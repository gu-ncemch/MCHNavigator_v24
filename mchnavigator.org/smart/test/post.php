<?php
include("../../account/cookie.php");
include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'Phase 3: Sharing &raquo; Post-Test';
include ('../incl/header.html');
?>

<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
	<?php include('../incl/nav_generic.html'); ?>

	<div class="ten columns">
		<div id="page_title"><img src="../images/Dashboard-lightbulb-concept.jpg" alt="lightbulb and paper with pencil">
		  <div class="v">
		    <h1>MCHsmart Post-Test</h1>
		  </div>
		</div>
<p>Please answer the questions you took as a pre-test again to gauge how much you have learned from the MCHsmart curriculum.</p>
		<form method="post" action="save.php">
			<input type="hidden" name="test_type" value="post" readonly="">
			<input type="hidden" name="uID" value="<?php echo $uID; ?>" readonly="">
			<?php include('questions.php'); ?>
			<button type="submit">save</button>
		</form>


	</div>
</div>

<?php include('../incl/footer.html'); ?>