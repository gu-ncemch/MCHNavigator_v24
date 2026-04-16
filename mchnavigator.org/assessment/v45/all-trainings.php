<?php include("../account/cookie.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>All Assessments</title>
	<style type="text/css">
	table {
		width: 100%;
	}

	td {
		width: 33%;
		vertical-align: top;
	}

	.err {
		background-color: #900;
		color: #fff;
		padding: 10px;
	}

	li.true {
		background-color: yellow;
	}

	</style>
</head>

<body>
	<p>The following is a real-time analysis of the <strong>WEB READY</strong> trainings in the MCH Navigator database. The trainings here will appear as they would in the Learning Plan.</p>
	<?php
require_once __DIR__ . '/../../filemaker/data-api.php';

// get all trainings
$request = array(
	'database' => 'MCH-Navigator',
	'layout' => 'all-trainings',
	'action' => 'find',
	'parameters' => array(
		'query' => array(
			array(
				'Web Ready' => '=Web Ready',
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

if ((int) ($result['messages'][0]['code'] ?? 500) !== 0 || empty($result['response']['data'])) {
	#echo $result->getMessage();
	echo '<p>You have not yet completed this Competency.</p><p>&nbsp;</p>';
} else {
	$all_trainings = array();

	foreach ($result['response']['data'] as $training) {
		$item = array(
			'<li><a href="/trainings/detail.php?id=' . ($training['fieldData']['Record Number'] ?? '') . '" target="_blank">' . ($training['fieldData']['Title'] ?? '') . '</a> ' . ($training['fieldData']['Level'] ?? '') . ', ' . ($training['fieldData']['Length'] ?? '') . ' (' . ($training['fieldData']['Entry Date'] ?? '') . ')</li>',
			$training['fieldData']['Competencies_v4_5'] ?? ''
		);
		array_push($all_trainings, $item);
	}
}
// print_r($all_trainings);

// only show relevant trianings
// $c is the competency (ex: 1K1)
// $l is the level
function show_trainings($c, $l)
{
	global $all_trainings;
	$tcount = 0;
	foreach ($all_trainings as $li) {
		// we need to make sure it only captures the exact, ex: 1K1 should not match 11K1 or 1K11...
		$check = '- '.preg_replace('/\s+/', ' ', $li[1]).' -';

		if (strpos($check, ' '.$c.' ') !== false && strpos($li[0], $l) !== false) {
			echo $tcount == 0 ? '<ol>' : '';
			echo $li[0];
			$tcount++;
		}
	}
	echo $tcount > 0 ? "</ol>" : '<p class="err">oops, no trainings here</p>';
}
#show_trainings("1K4", "Introductory");
#print_r($all_trainings);

// get all questions
$request_q = array(
	'database' => 'MCH-Navigator',
	'layout' => 'SA_Questions_v45',
	'action' => 'range',
	'queryString' => '?_limit=200',
);
$result_q = do_filemaker_request($request_q, 'array');

if ((int) ($result_q['messages'][0]['code'] ?? 500) !== 0) {
	echo $result_q['messages'][0]['message'] ?? 'Error loading questions.';
} else {
	$questions = array();
	foreach ($result_q['response']['data'] as $row) {
		$questions[] = fm_record_shim($row);
	}
}
	foreach ($questions as $question) {
		echo '<hr><h3>'.$question->getField('qID').'</h3><table><tr><th>Introductory</th><th>Intermediate</th><th>Advanced</th></tr><tr><td>';
			show_trainings($question->getField('qID_clean'), "Introductory");
		echo '</td><td>';
			show_trainings($question->getField('qID_clean'), "Intermediate");
		echo '</td><td>';
			show_trainings($question->getField('qID_clean'), "Advanced");
		echo '</td></tr></table>';
	}
?>
</body>
</html>
