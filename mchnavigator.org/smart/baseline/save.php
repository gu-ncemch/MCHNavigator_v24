<?php
// header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
// header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s') . ' GMT');
// header('Cache-Control: no-store, no-cache, must-revalidate');
// header('Cache-Control: post-check=0, pre-check=0', false);
// header('Pragma: no-cache'); 

include_once("/home/dh_mch_sftp/globals/filemaker_init.php");

// get user id -------------------------------------------------------------------------------------------------------------
extract($_POST, EXTR_OVERWRITE);
$fm      = db_connect("MCH-Navigator");

// $rec = $fm->getRecordById('MCH_Smart_Baseline', $recordID);

$request = $fm->newFindCommand('MCH_Smart_Baseline');
// echo $uID;

$request->addFindCriterion('uID', "==\"" . $uID . "\"");
$result = $request->execute();
if (!FileMaker::isError($result)) {
	// record exists: update
	$records = $result->getRecords();
    $rec = $records[0];
} else {
	// no record: create
	$rec = $fm->createRecord('MCH_Smart_Baseline');
	$rec->setField("uID", $uID);
}

// if( FileMaker::isError($rec) ){
// 	echo $rec->getMessage();
// 	$rec = $fm->createRecord('MCH_Smart_Baseline');
// 	$rec->setField("uID", $_POST['uID']);
// }

// print_r($_POST);
foreach($_POST as $fieldname => $response){
	if(strpos($fieldname,"Competency_") !== false){
		$rec->setField($fieldname, $response);
	}
}

$result = $rec->commit();

if (FileMaker::isError($result)) {
	echo "Error saving responses.";
	echo $result->getMessage();
} else { echo "Success!"; }
?>