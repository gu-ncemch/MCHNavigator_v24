<?php
/* v4 */
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

include("../account/cookie.php");
require_once __DIR__ . '/../../filemaker/data-api.php';
$responseDate = null;

function getPlan($section, $name){
	global $uID, $responseDate;

	$request = array(
		'database' => 'MCH-Navigator',
		'layout' => 'SA_Responses_v45',
		'action' => 'find',
		'parameters' => array(
			'query' => array(
				array(
					'uID' => (string) ((int) $uID),
					'section' => (string) ((int) $section),
				),
			),
			'sort' => array(
				array(
					'fieldName' => 'date',
					'sortOrder' => 'descend',
				),
			),
			'limit' => 1,
		),
	);
	$result = do_filemaker_request($request, 'array');

	if ((int) ($result['messages'][0]['code'] ?? 500) !== 0 || empty($result['response']['data'][0])) {
		// echo 'You have not yet completed Competency '.$section.'<br>';
	} else {
		$record = $result['response']['data'][0];
		$rID = $record['fieldData']['rID'] ?? '';
		$responseDate = $record['fieldData']['date'] ?? '';
		// echo $section.'-'.$responseDate.'<br>';
		include("csv_single_competency.php");
	}
}
?>
<?php getPlan(1,"Competency 1: MCH Knowledge Base/Context"); ?>
<?php getPlan(2,"Competency 2: Self-Reflection"); ?>
<?php getPlan(3,"Competency 3: Ethics"); ?>
<?php getPlan(4,"Competency 4: Critical Thinking"); ?>
<?php getPlan(5,"Competency 5: Communication"); ?>
<?php getPlan(6,"Competency 6: Negotiation and Conflict Resolution"); ?>
<?php getPlan(7,"Competency 7: Creating Responsive and Effective MCH Systems"); ?>
<?php getPlan(8,"Competency 8: Community Expertise and Perspectives"); ?>
<?php getPlan(9,"Competency 9: Teaching and Mentoring"); ?>
<?php getPlan(10,"Competency 10: Interdisciplinary Team Building"); ?>
<?php getPlan(11,"Competency 11: Systems Approach"); ?>
<?php getPlan(12,"Competency 12: Policy and Advocacy"); ?>
