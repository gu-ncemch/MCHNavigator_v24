<?php
include("../../account/cookie.php");
include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'Review';
include ('../incl/header.html');
?>

<div class="container wrapper">
	<?php include('../incl/nav_generic.html'); ?>

	<div class="ten columns">
		<div id="page_title"><img src="../images/Dashboard-lightbulb-concept.jpg" alt="lightbulb and paper with pencil">
		  <div class="v">
		    <h1>MCHsmart <?php echo ucwords($_GET['type']); ?>-Test</h1>
		  </div>
		</div>


<style type="text/css">
	.user_answer { color: #ed015c; }
	.correct{ color: #8ec640 !important; background-color: transparent !important; }
	.user_answer label::before { line-height: 0; font-family:"fontastic"; content:"\e0bd"; margin-left: -37px; position: relative; top: 2px;     width: 20px;
    display: inline-block;
    text-align: center;}
	.correct label::before { line-height: 0; font-family:"ncemch-modules"; content:"\2b"; margin-left: -37px; position: relative; top: 3px;    width: 20px;
    display: inline-block;
    text-align: center; }
	fieldset.choice ul input {
	    display: none;
	}
	.user_answer label, .correct label { left: 40px !important; }
	fieldset.choice ul label {
	    left: 27px;
	}
	.explaination {
	    display: block;
	}
</style>


		<?php

		include("../../account/cookie.php");

		include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
		include_once("/home/dh_mch_sftp/globals/scrubber.php");

		$correct_answers = array(
			"Competency_1_1" => "B",
			"Competency_1_2" => "D",
			"Competency_1_3" => "False",
			"Competency_2_1" => "C",
			"Competency_2_2" => "A",
			"Competency_2_3" => "True",
			"Competency_3_1" => "D",
			"Competency_3_2" => "True",
			"Competency_3_3" => "D",
			"Competency_4_1" => "False",
			"Competency_4_2" => "B",
			"Competency_4_3" => "C",
			"Competency_5_1" => "C",
			"Competency_5_2" => "D",
			"Competency_5_3" => "False",
			"Competency_6_1" => "B",
			"Competency_6_2" => "A",
			"Competency_6_3" => "True",
			"Competency_7_1" => "B",
			"Competency_7_2" => "D",
			"Competency_7_3" => "False",
			"Competency_8_1" => "True",
			"Competency_8_2" => "C",
			"Competency_8_3" => "D",
			"Competency_9_1" => "B",
			"Competency_9_2" => "D",
			"Competency_9_3" => "False",
			"Competency_10_1" => "True",
			"Competency_10_2" => "A",
			"Competency_10_3" => "C",
			"Competency_11_1" => "A",
			"Competency_11_2" => "D",
			"Competency_11_3" => "False",
			"Competency_12_1" => "B",
			"Competency_12_2" => "C",
			"Competency_12_3" => "False"
		);

		// need some way to mark these too


		// prep data ----------------------------------------------------------
		extract($_GET, EXTR_OVERWRITE);
		// echo $uID;
		// echo $type;

		// give the data up to the data gods -------------------------------------------------------
		$fm = db_connect("MCH-Navigator");
		$find = $fm->newFindCommand('MCH_Smart_Test_Responses');
		$find->addFindCriterion('uID', $uID);
		$find->addFindCriterion('test_type', $type);
		$result = $find->execute();


		if (FileMaker::isError($result)) {
			// echo "error!";
			echo $result->getMessage();
		} else {
			// echo "good";
			// $records = $result->getRecords();
			$record = $result->getFirstRecord();
			$your_score = $record->getField('score').'%';

			// print_r($record);
			echo '<script type="text/javascript">$( document ).ready(function() { $("input").prop("disabled", true);';

			// use js to mark the user answers
			foreach($correct_answers as $fieldname => $correct){
				if(strpos($fieldname,"Competency_") !== false){
					echo '$("input[name=\''.$fieldname.'\'][value=\''.$correct.'\']").parent().parent().addClass("correct");' . PHP_EOL;
				}
			}

			// use js to mark the user answers
			foreach($record->_impl->_fields as $fieldname => $response){
				if(strpos($fieldname,"Competency_") !== false){
					echo '$("input[name=\''.$fieldname.'\'][value=\''.$response[0].'\']").parent().parent().addClass("user_answer");' . PHP_EOL;
					echo '$("input[name=\''.$fieldname.'\'][value=\''.$response[0].'\']").prop("checked", true);' . PHP_EOL;
				}
			}

			echo '});</script>';
		}


?>

	  <h3>You answered <?php echo $your_score; ?> of the questions correctly.</h3>
	  	<p>A detailed scoring of your answers is below:</p>

	  <p><strong>
	  	Any incorrect answers you gave are highlighted in <span style="color:#ed015c;"><i class="mch-exclamation-triangle"></i> red</span>.<br>
	  	Correct answers are  highlighted in <span style="color:#8ec640;"><i class="mch-check-square-o"></i> green</span>.</strong></p>

	  <?php
		if ($type == "post") {
			?>
		<p>Congratulations for completing the post-test. Please compare this score with your pre-test score as a measure of your learning with MCHsmart. If you&rsquo;d like to review a section of the curriculum again, <a href="https://www.mchnavigator.org/smart/dashboard.php#learning">return to the Dashboard</a> and select the content that you would like to review.</p>

		<p>The next step on your learning journey is to share your reflections with other learners about the thoughts and insights you had as you progressed through the curriculum on the MCHtalk blog. Use the link below to start this process.</p>

		<p><a href="/smart/reflections.php" class="button">Reflections Opportunity</a></p>
<?php } else {
			?>
			<p>Now that you have a sense of what you know about each competency, you can plan where to focus your attention within MCHsmart. Review your answers and then click the button at the bottom of the page to start the curriculum.</p>
			<p><a href="/smart/dashboard.php#learning" class="button">Start the Curriculum</a></p>
		<?php }
		?>

		<p>&nbsp;</p>
		<?php include('questions.php'); ?>

	</div>
</div>

<?php include('../incl/footer.html'); ?>
