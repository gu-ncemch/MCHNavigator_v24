<?php
// get all web ready trainings
require_once __DIR__ . '/../../filemaker/data-api.php';

$request = array(
	'database' => 'MCH-Navigator',
	'layout' => 'all-trainings',
	'action' => 'find',
	'parameters' => array(
		'query' => array(
			array(
				'Web Ready' => '=Web Ready',
				'BestOf' => 'true',
			),
		),
		'sort' => array(
			array(
				'fieldName' => 'Title',
				'sortOrder' => 'ascend',
			),
		),
		'limit' => 500,
	),
);
$result = do_filemaker_request($request, 'array');

global $all_trainings;
$all_trainings = array();

if ((int) ($result['messages'][0]['code'] ?? 500) === 0 && !empty($result['response']['data'])) {
	foreach ($result['response']['data'] as $training) {
		$item = array(
			'<li><a href="/trainings/detail.php?id=' . ($training['fieldData']['Record Number'] ?? '') . '" target="_blank">' . ($training['fieldData']['Title'] ?? '') . '</a> ' . ($training['fieldData']['Level'] ?? '') . ', ' . ($training['fieldData']['Length'] ?? '') . '</li>',
			$training['fieldData']['Competencies_v4_5'] ?? ''
		);
		array_push($all_trainings, $item);
	}
}
#print_r($all_trainings);
function show_trainings($c, $l){
	global $all_trainings;

	$tcount = 0;
	foreach ($all_trainings as $li) {
		if (strpos($li[1], $c) !== false && strpos($li[0], $l) !== false) {
			echo $tcount == 0 ? "<ol>" : "";
			echo $li[0];
			$tcount++;
		}
	}
	echo $tcount > 0 ? "</ol>" : '<ul><li>There are currently no trainings available at your skill level.</li></ul>';
}
?>
