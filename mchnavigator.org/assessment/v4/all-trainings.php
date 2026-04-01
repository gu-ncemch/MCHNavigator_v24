<?php include("../account/cookie.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>All Assessments</title>
<style type="text/css">
table{width:100%;}
td{ width:33%; vertical-align:top;}
.err{ background-color:#900; color:#fff; padding:10px;}
li.true{ background-color: yellow; }
</style>
</head>

<body>
<p>The following is a real-time analysis of the <strong>WEB READY</strong> trainings in the MCH Navigator database. The trainings here will appear as they would in the Learning Plan.</p>
<?php
include_once(__DIR__ . "/../../../globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");

// get all trainings
$request = $fm->newFindCommand('all-trainings');
	$request->addFindCriterion('Web Ready', "=Web Ready");
	$request->addSortRule('BestOf', 1, FILEMAKER_SORT_DESCEND);
	$request->addSortRule('Title', 2, FILEMAKER_SORT_ASCEND);
$result = $request->execute();

if (FileMaker::isError($result)) {
	#echo $result->getMessage();
	echo '<p>You have not yet completed this Competency.</p><p>&nbsp;</p>';
} else {
	$records = $result->getRecords();
	
	$all_trainings = array();
	
	foreach ($records as $training) {
		$item = array(
			'<li class="' . $training->getField('BestOf') . '"><a href="/trainings/detail.php?id=' . $training->getField('Record Number') . '" target="_blank">' . $training->getField('Title') . '</a> ' . $training->getField('Level') . ', ' . $training->getField('Length') . '</li>',
			$training->getField('Competencies_v4')
		);
		array_push($all_trainings, $item);
	}
}

// only show relevant trianings
function show_trainings($c, $l)
{
	global $all_trainings;
	$tcount = 0;
	foreach ($all_trainings as $li) {
		if (strpos($li[1], $c) !== false && strpos($li[0], $l) !== false) {
			echo $tcount == 0 ? "<ol>" : "";
			echo $li[0];
			$tcount++;
		}
	}
	echo $tcount > 0 ? "</ol>" : '<p class="err">oops, no trainings here</p>';
}
#show_trainings("1K4", "Introductory");
#print_r($all_trainings);

// get all questions
$fm = db_connect("MCH-Navigator");
$request_q = $fm->newFindCommand('SA_Questions_v4');
$result_q = $request_q->execute();

if (FileMaker::isError($result_q)) {
	echo $result_q->getMessage();
} else {
	$questions = $result_q->getRecords();
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