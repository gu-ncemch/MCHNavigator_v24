<?php
// don't do anything is there is nothing to do
if(!isset($_POST['emails'])) {
	header("Location: export.php");
	exit;
}

// turn input into array
$email_array = explode(chr(10), $_POST['emails']);

// setup
include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");

$CSV = "obfuscated user id, email, date, section, ki, kk, si, ss".PHP_EOL;

// loop through each user
$numberToWord = array("None", "Low", "Medium", "High");
foreach ($email_array as $user) { 
	// clear old data
	$people = NULL;
	$responses = NULL;
	// get people
	$whoToFind = str_replace("@", "\@", $user);
	$request_people = $fm->newFindCommand('SA_Users');
	$request_people->addFindCriterion('email', $whoToFind);
	$request_people->addSortRule('email', 1, FILEMAKER_SORT_ASCEND);
	$result_people = $request_people->execute();
	if (!FileMaker::isError($result_people)) {
		$people = $result_people->getRecords();
		if($result_people->getFoundSetCount() > 0 ){
			// get person data
			foreach ($people as $person) {
				$current_uID = $person->getField('id');
				// get scores
				$request_responses = $fm->newFindCommand('SA_Responses');
				$request_responses->addFindCriterion('uID', "=".$current_uID);
				$request_responses->addSortRule('section', 1, FILEMAKER_SORT_ASCEND);
				$request_responses->addSortRule('date', 2, FILEMAKER_SORT_DESCEND);
				$result_responses = $request_responses->execute();
				if (!FileMaker::isError($result_responses)) {
					$responses = $result_responses->getRecords();
					if($result_responses->getFoundSetCount() > 0 ){
						// output responses
						foreach ($responses as $response) {
							$CSV .= $current_uID.", ";
							$CSV .= $response->getField('SA_Users::email').", ";
							$CSV .= $response->getField('date').", ";
							$CSV .= $response->getField('section').", ";
							$CSV .= $response->getField('response_summary_KI').", ";
							$CSV .= $response->getField('response_summary_KK').", ";
							$CSV .= $response->getField('response_summary_SI').", ";
							$CSV .= $response->getField('response_summary_SS').", ";
							for($i = 0; $i <= 28; $i++){
								if($response->getField('responseID', $i) != ""){
									$CSV .= $response->getField('responseID', $i).$response->getField('responseType', $i).", ";
									$CSV .= $numberToWord[$response->getField('response', $i)]." (".$response->getField('response', $i).")";
									$CSV .= $i == 28 ? ", " : "";
								}
							}
							$CSV .= PHP_EOL;
						}
					}
				}
			}

		}
	}
}

// output as CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=mch-nav-assessment-'.time().'.csv');
echo $CSV;
?>