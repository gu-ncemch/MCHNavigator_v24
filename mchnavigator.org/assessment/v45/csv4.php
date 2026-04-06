<?php
/* v4 */
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

include("../account/cookie.php");
include_once(__DIR__ . "/../../../globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$responseDate = null;

function getPlan($section, $name){
	global $fm, $uID, $responseDate;

	// $uID = 18;
	$request = $fm->newFindCommand('SA_Responses_v45');
	$request->addFindCriterion('uID', "=".$uID);
	$request->addFindCriterion('section', "=".$section);
	// echo $uID;
	$request->addSortRule('date', 1, FILEMAKER_SORT_DESCEND);
	$request->setRange(0, 1);
	$result = $request->execute();

	if (FileMaker::isError($result)) {
		// echo 'You have not yet completed Competency '.$section.'<br>';
	} else {
		$records = $result->getRecords();
		$record = $records[0];
		$rID = $record->getField('rID');
		$responseDate = $record->getField('date');
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
