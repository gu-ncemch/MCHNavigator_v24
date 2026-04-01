<?php

include("../account/cookie.php");

require_once __DIR__ . '/../../filemaker/data-api.php';


// prep data ----------------------------------------------------------
extract($_POST, EXTR_OVERWRITE);

$responseIDs = array();
$responseTypes = array();
$responseValues = array();
foreach($_POST as $k => $v){
	if($k != "section" && $k != "notes" && $k != "pathway"){
		#prep work
		$idBits = explode("-", $k);
		$idBits[0] = str_replace("_",".",$idBits[0]);
		$responseIDs[] = $idBits[0];
		$responseTypes[] = $idBits[1];
		$responseValues[] = $v;
	}
}

$request = array(
	'database' => 'MCH-Navigator',
	'layout' => 'SA_Responses_v45',
	'action' => 'create',
	'parameters' => array(
		'fieldData' => array(
			'uID' => $uID,
			'section' => $section,
			'notes' => $notes,
			'responseID' => $responseIDs,
			'responseType' => $responseTypes,
			'response' => $responseValues,
		),
	),
);
$result = do_filemaker_request($request, 'array');
if ((int) ($result['messages'][0]['code'] ?? 500) !== 0) {
	echo "error!";
	echo $result['messages'][0]['message'] ?? 'Unknown FileMaker error';
}

$zeroLead = $section < 9 ? "0" : "";
#print_r($_POST);
#exit;
if($pathway == "full" && $section < 12){
	//echo "we are moving on to comp #".($section+1);
	header("Location: competency_".$zeroLead.($section+1).".php?saved=".$section);
} else{
	//echo "we are going back to the progress page";
	header("Location: ../dashboard.php?saved=".$section);
}
?>
