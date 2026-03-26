<?php
include("../../account/cookie.php");
include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'Pretest';
include ('../incl/header.html');
?>




<div class="container wrapper">
	<?php include('../incl/nav_generic.html'); ?>

	<div class="ten columns">
		<div id="page_title"><img src="../images/Dashboard-lightbulb-concept.jpg" alt="lightbulb and paper with pencil">
		  <div class="v">
		    <h1>MCH Smart Pretest</h1>
		  </div>
		</div>

		<p>Please answer the following questions to the best of your ability. On the next screen, you will be able to check your responses with the correct answers. Your answers will serve as baseline data for your progress through MCHsmart. We will not share your answers except in disaggregated summaries across all user groups.</p>

		
		<form method="post" action="save.php">
			<input type="hidden" name="test_type" value="pre" readonly="">
			<input type="hidden" name="uID" value="<?php echo $uID; ?>" readonly="">
			<?php include('questions.php'); ?>
			<button type="submit">save</button>
		</form>
		

	</div>
</div>

<?php include('../incl/footer.html'); ?>