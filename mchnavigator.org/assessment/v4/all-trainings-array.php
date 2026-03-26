<?php
// get all web ready trainings
$request = $fm->newFindCommand('all-trainings');
	$request->addFindCriterion('Web Ready', "=Web Ready");
	$request->addFindCriterion('BestOf', "true");
	#$request->addSortRule('BestOf', 1, FILEMAKER_SORT_DESCEND);
	$request->addSortRule('Title', 1, FILEMAKER_SORT_ASCEND);
$result = $request->execute();

if (FileMaker::isError($result)) {
	echo $result->getMessage();
} else {
	$records = $result->getRecords();
	
	global $all_trainings;
	$all_trainings = array();
	
	foreach ($records as $training) {
		$item = array(
			'<li><a href="/trainings/detail.php?id=' . $training->getField('Record Number') . '" target="_blank">' . $training->getField('Title') . '</a> ' . $training->getField('Level') . ', ' . $training->getField('Length') . '</li>',
			$training->getField('Competencies_v4')
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