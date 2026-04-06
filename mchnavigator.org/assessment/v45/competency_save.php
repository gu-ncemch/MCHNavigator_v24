<?php

include("../account/cookie.php");

require_once __DIR__ . '/../../filemaker/data-api.php';


// prep data ----------------------------------------------------------
extract($_POST, EXTR_OVERWRITE);

$fieldData = array(
	'uID' => (string) $uID,
	'section' => (string) $section,
	'notes' => isset($notes) ? (string) $notes : '',
);

$responseCount = 1;
foreach($_POST as $k => $v){
	if($k != "section" && $k != "notes" && $k != "pathway"){
		#prep work
		$idBits = explode("-", $k);
		$idBits[0] = str_replace("_",".",$idBits[0]);
		$fieldData['responseID(' . $responseCount . ')'] = (string) $idBits[0];
		$fieldData['responseType(' . $responseCount . ')'] = (string) $idBits[1];
		$fieldData['response(' . $responseCount . ')'] = is_numeric($v) ? (float) $v : (string) $v;
		$responseCount++;
	}
}

$request = array(
	'database' => 'MCH-Navigator',
	'layout' => 'SA_Responses_v45',
	'action' => 'create',
	'parameters' => array(
		'fieldData' => $fieldData,
	),
);
$result = do_filemaker_request($request, 'array');
if ((int) ($result['messages'][0]['code'] ?? 500) !== 0) {
	echo '<pre>';
	print_r($result);
	echo '</pre>';
	exit;
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
