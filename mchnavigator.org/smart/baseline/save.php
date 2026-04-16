<?php
require_once __DIR__ . '/../../filemaker/data-api.php';

extract($_POST, EXTR_OVERWRITE);

$find_request = array(
	'database' => 'MCH-Navigator',
	'layout' => 'MCH_Smart_Baseline',
	'action' => 'find',
	'parameters' => array(
		'query' => array(
			array(
				'uID' => '=="' . (string) $uID . '"',
			),
		),
		'limit' => 1,
	),
);

$find_result = do_filemaker_request($find_request, 'array');
$fieldData = array();

foreach ($_POST as $fieldname => $response) {
	if (strpos($fieldname, 'Competency_') === 0) {
		$fieldData[$fieldname] = (string) $response;
	}
}

if (empty($fieldData)) {
	echo "Error saving responses.";
	echo " No competency fields were provided.";
	exit;
}

if ((int) ($find_result['messages'][0]['code'] ?? 500) === 0 && !empty($find_result['response']['data'][0])) {
	$record = $find_result['response']['data'][0];
	$challengeValue = $record['fieldData']['uID'] ?? (string) $uID;
	$edit_request = array(
		'database' => 'MCH-Navigator',
		'layout' => 'MCH_Smart_Baseline',
		'action' => 'edit',
		'record' => (int) ($record['recordId'] ?? 0),
		'challenge_field' => 'uID',
		'challenge_value' => $challengeValue,
		'parameters' => array(
			'fieldData' => $fieldData,
		),
	);
	$result = do_filemaker_request($edit_request, 'array');
} else {
	$fieldData['uID'] = (string) $uID;
	$create_request = array(
		'database' => 'MCH-Navigator',
		'layout' => 'MCH_Smart_Baseline',
		'action' => 'create',
		'parameters' => array(
			'fieldData' => $fieldData,
		),
	);
	$result = do_filemaker_request($create_request, 'array');
}

if ((int) ($result['messages'][0]['code'] ?? 500) !== 0) {
	echo "Error saving responses.";
	echo $result['messages'][0]['message'] ?? ' Unknown FileMaker error.';
} else {
	echo "Success!";
}
?>
