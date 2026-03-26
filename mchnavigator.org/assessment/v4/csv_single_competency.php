<?php
/* v4 */
$filename = "mch-navigator-learning-plan-v4-" . date('Y-m-d') . ".csv";
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv");


	include_once("all-trainings-array.php");
	
	// NEXT SECTION
	$values = array("No","Low","Medium","High");
	// get responses
	$request = $fm->newFindCommand('SA_Responses_v4');
	$request->addFindCriterion('rID', "=".$rID);
	$result = $request->execute();
	if (FileMaker::isError($result)) {
		echo $result->getMessage();
	} else {
		$responses = $result->getRecords();
	}
	$userResponses = array();
	foreach ($responses as $response) {
		$sub_i = 0;
		$sub_ks = 0;
		$sub_c = 0;
		for($i = 0; $i <= 28; $i++){if($response->getField('responseID', $i) != ""){	$userResponses[$response->getField('responseID', $i)."-".$response->getField('responseType', $i)] = $response->getField('response', $i);	if($response->getField('responseType', $i) == "I"){		$sub_i += $response->getField('response', $i);		$sub_c++;	} else {		$sub_ks += $response->getField('response', $i);		}}
		}
	}


	#print_r($userResponses);
	// get previous responses
	$request = $fm->newFindCommand('SA_Responses_v4');
	$request->addFindCriterion('uID', "=".$uID);
	$request->addFindCriterion('rID', "<".$rID);
	$request->addFindCriterion('section', "=".$section);
	$request->addSortRule('date', 1, FILEMAKER_SORT_DESCEND);
	$result = $request->execute();
	if (FileMaker::isError($result)) {
		$pastDate = "";
	} else {
		$responsesP = $result->getRecords();
		$pastDate = date('n/j/Y',strtotime($responsesP[0]->getField('date')));
	}
	$userResponsesP = array();
	foreach ($responsesP as $responseP) {
		for($i = 0; $i <= 28; $i++){if($responseP->getField('responseID', $i) != ""){	$userResponsesP[$responseP->getField('responseID', $i)."-".$responseP->getField('responseType', $i)] = $responseP->getField('response', $i);}
		}
	}
	?>
<?php
if($plan){
	$priorities[$section] = ($sub_i/$sub_c);
	$understandings[$section] = ($sub_ks/$sub_c);
}
?>
Section,Level,Shortcode,Importance,Importance Level (Numerical),Knowledge,Knowledge Level (Numerical),Description
Overall Summary,<?php echo $responseDate; ?>,-, <?php echo ($sub_i/$sub_c)>1.5 ? "Was" : "Was not"; ?> a priority, <?php echo round($sub_i/$sub_c, 1); ?>, <?php echo $values[ceil($sub_ks/$sub_c)]; ?> understanding, <?php echo round($sub_ks/$sub_c, 1); ?>,"Overall Summary of **<?php echo $name; ?>** The results below were recorded on <?php echo date('l F jS, Y \a\t g:ia',strtotime($responses[0]->getField('date'))); ?>"<?php echo PHP_EOL; ?>






<?php
	// get questions
	$request = $fm->newFindCommand('SA_Questions_v4');
	$request->addFindCriterion('section', "=".$section);
	$request->addSortRule('type', 1, FILEMAKER_SORT_ASCEND);
	$request->addSortRule('order', 2, FILEMAKER_SORT_ASCEND);
	$result = $request->execute();
	if (FileMaker::isError($result)) {
		echo $result->getMessage();
	} else {
		$records = $result->getRecords();
	}
	// give the goods
	$secondSet = "Knowledge";
	$secondSetSuffix = "-K";
	$groupingHeader = '';
	$groupingHeaderText = '';
	$compareHeading = '';
	$subgroupingHeader = '';
	$subgroupingHeaderText = '';
	$comparesubHeading = '';
	
	foreach ($records as $record) {
		// compare types and output the heading if needed
		$compareHeading = $record->getField('type');
		if($groupingHeader != $compareHeading){if($compareHeading == 'S'){	$groupingHeaderText = "Skills";	$secondSet = "Skill";	$secondSetSuffix = "-S";} else {	$groupingHeaderText = "Knowledge";}$groupingHeader = $compareHeading;
		}
		// compare subtypes and output the subheading if needed
		$comparesubHeading = $record->getField('subtype');
		if($subgroupingHeader != $comparesubHeading){if($comparesubHeading == 'B'){	$subgroupingHeaderText = "Foundational";} else if($comparesubHeading == 'A') {	$subgroupingHeaderText = "Advanced";}$subgroupingHeader = $comparesubHeading;
		}
		// isolate the id
		$qID = $record->getField('qID');
		$qID_clean = $record->getField('qID_clean');
		#$qIDname = str_replace(".","",$qID);
		$qIDname = $qID;
		// output it all, finally!
		echo "".$groupingHeaderText.",".$subgroupingHeaderText.",".$qID.",";
?>
<?php echo $values[$userResponses[$qID."-I"]]; ?> Importance, <?php echo $userResponses[$qID."-I"]; ?>, <?php echo $values[$userResponses[$qID.$secondSetSuffix]] . " " . $secondSet; ?>, <?php echo $userResponses[$qID.$secondSetSuffix]; ?>
<?php
		echo ",\"".$record->getField('text')."\"".PHP_EOL;
	}
?>
<?php echo PHP_EOL; ?>My Examples and Notes,-,-,-,-,-,-,"<?php echo $response->getField('notes'); ?>" 
<?php echo PHP_EOL; ?>