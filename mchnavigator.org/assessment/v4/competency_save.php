<?php

include("../account/cookie.php");

include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
include_once("/home/dh_mch_sftp/globals/scrubber.php");


// prep data ----------------------------------------------------------
extract($_POST, EXTR_OVERWRITE);

// give the data up to the data gods -------------------------------------------------------
$fm      = db_connect("MCH-Navigator");

$record = $fm->newAddCommand('SA_Responses_v4');
$record->setField('uID', $uID);
$record->setField('section', $section);
$record->setField('notes', $notes);
$responseCount = 0;
foreach($_POST as $k => $v){
	if($k != "section" && $k != "notes" && $k != "pathway"){
		#prep work
		$idBits = explode("-", $k);
		$idBits[0] = str_replace("_",".",$idBits[0]);
		#save it
		$record->setField('responseID', $idBits[0], $responseCount);
		$record->setField('responseType', $idBits[1], $responseCount);
		$record->setField('response', $v, $responseCount);
		#save it
		// echo 'responseID ==> '.$idBits[0]." -- ";
		// echo 'responseType ==> '.$idBits[1]." -- ";
		// echo 'response ==> '.$v."<br>";
		$responseCount++;
	}
}
$result = $record->execute();
if (FileMaker::isError($result)) {
	echo "error!";
	echo $result->getMessage();
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
