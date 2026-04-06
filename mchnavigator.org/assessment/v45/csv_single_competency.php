<?php
/* v4 */
$filename = "mch-navigator-learning-plan-v4-" . date('Y-m-d') . ".csv";
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv");


	include_once("all-trainings-array.php");

	// NEXT SECTION
	$values = array("No","Low","Medium","High");
	if ( ! function_exists('csv_repeat_value')) {
	function csv_repeat_value( $row, $field, $index ) {
		$value = $row['fieldData'][$field] ?? '';
		if ( is_array( $value ) ) {
			return $value[$index] ?? '';
		}
		return $index === 0 ? $value : '';
	}}
	// get responses
	$request = array(
		'database' => 'MCH-Navigator',
		'layout' => 'SA_Responses_v45',
		'action' => 'find',
		'parameters' => array(
			'query' => array(
				array(
					'rID' => scrubber($rID, 'string'),
				),
			),
			'limit' => 10,
		),
	);
	$result = do_filemaker_request($request, 'array');
	$responses = array();
	if ((int) ($result['messages'][0]['code'] ?? 500) !== 0) {
		echo $result['messages'][0]['message'] ?? 'Error loading responses.';
	} else {
		$responses = $result['response']['data'];
	}
	$userResponses = array();
	foreach ($responses as $response) {
		$sub_i = 0;
		$sub_ks = 0;
		$sub_c = 0;
		for($i = 0; $i <= 28; $i++){if(csv_repeat_value($response, 'responseID', $i) != ""){	$userResponses[csv_repeat_value($response, 'responseID', $i)."-".csv_repeat_value($response, 'responseType', $i)] = csv_repeat_value($response, 'response', $i);	if(csv_repeat_value($response, 'responseType', $i) == "I"){		$sub_i += csv_repeat_value($response, 'response', $i);		$sub_c++;	} else {		$sub_ks += csv_repeat_value($response, 'response', $i);		}}
		}
	}


	#print_r($userResponses);
	// get previous responses
	$request = array(
		'database' => 'MCH-Navigator',
		'layout' => 'SA_Responses_v45',
		'action' => 'find',
		'parameters' => array(
			'query' => array(
				array(
					'uID' => (string) ((int) $uID),
					'rID' => '<' . scrubber($rID, 'string'),
					'section' => (string) ((int) $section),
				),
			),
			'sort' => array(
				array(
					'fieldName' => 'date',
					'sortOrder' => 'descend',
				),
			),
			'limit' => 50,
		),
	);
	$result = do_filemaker_request($request, 'array');
	if ((int) ($result['messages'][0]['code'] ?? 500) !== 0 || empty($result['response']['data'])) {
		$pastDate = "";
		$responsesP = array();
	} else {
		$responsesP = $result['response']['data'];
		$pastDate = date('n/j/Y',strtotime($responsesP[0]['fieldData']['date'] ?? ''));
	}
	$userResponsesP = array();
	foreach ($responsesP as $responseP) {
		for($i = 0; $i <= 28; $i++){if(csv_repeat_value($responseP, 'responseID', $i) != ""){	$userResponsesP[csv_repeat_value($responseP, 'responseID', $i)."-".csv_repeat_value($responseP, 'responseType', $i)] = csv_repeat_value($responseP, 'response', $i);}
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
Overall Summary,<?php echo $responseDate; ?>,-, <?php echo ($sub_i/$sub_c)>1.5 ? "Was" : "Was not"; ?> a priority, <?php echo round($sub_i/$sub_c, 1); ?>, <?php echo $values[ceil($sub_ks/$sub_c)]; ?> understanding, <?php echo round($sub_ks/$sub_c, 1); ?>,"Overall Summary of **<?php echo $name; ?>** The results below were recorded on <?php echo date('l F jS, Y \a\t g:ia',strtotime($responses[0]['fieldData']['date'] ?? '')); ?>"<?php echo PHP_EOL; ?>






<?php
	// get questions
	$request = array(
		'database' => 'MCH-Navigator',
		'layout' => 'SA_Questions_v45',
		'action' => 'find',
		'parameters' => array(
			'query' => array(
				array(
					'section' => (string) ((int) $section),
				),
			),
			'sort' => array(
				array(
					'fieldName' => 'type',
					'sortOrder' => 'ascend',
				),
				array(
					'fieldName' => 'order',
					'sortOrder' => 'ascend',
				),
			),
			'limit' => 100,
		),
	);
	$result = do_filemaker_request($request, 'array');
	if ((int) ($result['messages'][0]['code'] ?? 500) !== 0) {
		echo $result['messages'][0]['message'] ?? 'Error loading questions.';
		$records = array();
	} else {
		$records = array();
		foreach ($result['response']['data'] as $row) {
			$records[] = fm_record_shim($row);
		}
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
<?php echo PHP_EOL; ?>My Examples and Notes,-,-,-,-,-,-,"<?php echo $response['fieldData']['notes'] ?? ''; ?>"
<?php echo PHP_EOL; ?>
