<?php


		include("../account/cookie.php");
		require_once __DIR__ . '/../../filemaker/data-api.php';
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
		$fieldData = array(
			'uID' => $uID,
		);

		#echo '<script type="text/javascript">$( document ).ready(function() { $("input").prop("disabled", true);';
		foreach($_POST as $fieldname => $response){
			$fieldData[$fieldname] = $response;
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
		$existingScore = null;
		$find_request = array(
			'database' => 'MCH-Navigator',
			'layout' => 'MCH_Smart_Test_Responses',
			'action' => 'find',
			'parameters' => array(
				'query' => array(
					array(
						'uID' => '=="' . $uID . '"',
						'test_type' => '=="' . $test_type . '"',
					),
				),
				'limit' => 1,
			),
		);
		$resultToDelete = do_filemaker_request($find_request, 'array');
		$findCode = (int) ($resultToDelete['messages'][0]['code'] ?? 500);
		$existingRecordId = null;
		$existingChallengeValue = null;
		if ($findCode === 0 && !empty($resultToDelete['response']['data'][0])) {
			$existingRecord = $resultToDelete['response']['data'][0];
			$existingRecordId = (int) ($existingRecord['recordId'] ?? 0);
			$recordIDtoDelete = $existingRecordId;
			$existingScore = (int) ($existingRecord['fieldData']['score'] ?? 0);
			$existingChallengeValue = $existingRecord['fieldData']['uID'] ?? (string) $uID;
		}

		// Preserve original behavior for post tests where lower/equal scores are not recorded.
		if ($test_type == 'post' && $existingScore !== null && $score <= $existingScore) {
			header("Location: /smart/test/review.php?type=".$test_type);
			die();
		}

		$fieldData['score'] = $score;
		if (!empty($existingRecordId)) {
			$save_request = array(
				'database' => 'MCH-Navigator',
				'layout' => 'MCH_Smart_Test_Responses',
				'action' => 'edit',
				'record' => $existingRecordId,
				'challenge_field' => 'uID',
				'challenge_value' => $existingChallengeValue,
				'parameters' => array(
					'fieldData' => $fieldData,
				),
			);
		} else {
			$save_request = array(
				'database' => 'MCH-Navigator',
				'layout' => 'MCH_Smart_Test_Responses',
				'action' => 'create',
				'parameters' => array(
					'fieldData' => $fieldData,
				),
			);
		}
		do_filemaker_request($save_request, 'array');

		header("Location: /smart/test/review.php?type=".$test_type);
		die();
		?>
