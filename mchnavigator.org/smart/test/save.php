<?php


		include("../../account/cookie.php");
		include_once(__DIR__ . "/../../../globals/filemaker_init.php");
		include_once(__DIR__ . "/../../../globals/scrubber.php");
		$fm = db_connect("MCH-Navigator");
		$section = 'assessment';
		$page = 'Test';


		$user_points = 0;
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


		// prep data ----------------------------------------------------------
		extract($_POST, EXTR_OVERWRITE);

		// give the data up to the data gods -------------------------------------------------------
		$fm      = db_connect("MCH-Navigator");


		$recordToAdd = $fm->newAddCommand('MCH_Smart_Test_Responses');
		$recordToAdd->setField('uID', $uID);

		#echo '<script type="text/javascript">$( document ).ready(function() { $("input").prop("disabled", true);';
		foreach($_POST as $fieldname => $response){
			$recordToAdd->setField($fieldname, $response);
			// echo $fieldname . ' = ' . $response . PHP_EOL;
			if(strpos($fieldname,"Competency_") !== false){
				// echo $correct_answers[$fieldname] . ' ?= ' . $response . PHP_EOL;
				# echo '$("input[name=\''.$fieldname.'\'][value=\''.$response.'\']").prop("checked", true);' . PHP_EOL;
				// echo $fieldname . ' = ' . $response . PHP_EOL;
				if($correct_answers[$fieldname] == $response) { $user_points++; }
			}
		}
		#echo '});</script>';
		$score = round($user_points/36*100);



		// if this is the post test and they have already taken it, delete the old one
		$recordIDtoDelete = null;
		// if($test_type == "post"){
			// echo "post logic";
			$requestToDelete = $fm->newFindCommand('MCH_Smart_Test_Responses');
			$requestToDelete->addFindCriterion('uID', "==\"" . $uID . "\"");
			// $requestToDelete->addFindCriterion("test_type", "post");
			$requestToDelete->addFindCriterion("test_type", $test_type);
			$resultToDelete = $requestToDelete->execute();
			if (!FileMaker::isError($resultToDelete)) {
				$records = $resultToDelete->getRecords();
				$record = $records[0];
				$recordIDtoDelete = $record->getField('recordID');
				// echo $record->getField('score');
				// echo $recordID;
				// move this so it goes after a successful save...
				// $record_to_delete = $fm->getRecordById('MCH_Smart_Test_Responses', $recordID);
				// $record_to_delete->delete();
				if($test_type == "post" && $score > $record->getField('score')){
					$newDelete = $fm->newDeleteCommand('MCH_Smart_Test_Responses', $recordIDtoDelete);
					$deleteResult = $newDelete->execute();
					// echo "Your score (".$score."%) has been recorded.";
				} else {
					// echo "This score (".$score."%) is less than or equal to previous results (".$record->getField('score')."%) and has not been recorded.";
				}
			}
		// }




		$recordToAdd->setField('score', $score);

		$resultToAdd = $recordToAdd->execute();

		if (FileMaker::isError($resultToAdd)) {
			// echo "Error!";
			// echo $resultToAdd->getMessage();
		} else {
			// saved
			if(!empty($recordIDtoDelete)){
				$newDelete = $fm->newDeleteCommand('MCH_Smart_Test_Responses', $recordIDtoDelete);
				$deleteResult = $newDelete->execute();
			}
		}

		header("Location: https://www.mchnavigator.org/smart/test/review.php?type=".$test_type);
		die();
		?>
