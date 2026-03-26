<?php

	include_once("all-trainings-array.php");
	
	// NEXT SECTION
	$values = array("No","a Low","a Medium","a High");
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
	// print_r($responses);
	foreach ($responses as $response) {
		$sub_i = 0;
		$sub_ks = 0;
		$sub_c = 0;
		for($i = 0; $i <= 30; $i++){
			if($response->getField('responseID', $i) != ""){
				// echo '#'.$i." ".$response->getField('responseID', $i).'@'.$response->getField('responseType', $i).'='.$response->getField('response', $i).'<br>';
				$userResponses[$response->getField('responseID', $i)."-".$response->getField('responseType', $i)] = $response->getField('response', $i);
				if($response->getField('responseType', $i) == "I"){
					$sub_i += $response->getField('response', $i);
				} else {
					$sub_ks += $response->getField('response', $i);
					$sub_c++;
				}
			}
		}
		// print_r($userResponses);
	}
	// get previous responses
	/*$request = $fm->newFindCommand('SA_Responses_v4');
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
		for($i = 0; $i <= 30; $i++){
			if($responseP->getField('responseID', $i) != ""){
				$userResponsesP[$responseP->getField('responseID', $i)."-".$responseP->getField('responseType', $i)] = $responseP->getField('response', $i);
			}
		}
	}*/
	// print_r($userResponsesP);
	// echo 
	?>
<p><strong>Overall Summary of this Competency:</strong> You indicated that this competency had <u><?php echo $values[$sub_i]; ?> Priority (<?php echo $sub_i; ?>)</u> for you now and you appear to have <u><?php echo $values[ceil($sub_ks/$sub_c)]; ?> Understanding (<?php echo round($sub_ks/$sub_c, 1); ?>)</u> of the knowledge and skills. <em>Note: this is an average summary for each competency</em>.</p>



<?php

if($plan){
	// $priorities[$section] = ($sub_i/$sub_c);
	$priorities[$section] = ($sub_i);
	$understandings[$section] = round($sub_ks/$sub_c, 1);
}
?>

<?php
# make it all hidden if on the learning plan page
if($sub_i == 0){
	echo '<p>Since you marked this competency as no importance to you, we are not recommending specific learning opportunities. However, if you later decide that you want to pursue training in this area, you can browse our collection of <a href="/trainings/results.php?Competencies='.$section.'.">trainings on this competency</a>.</p>';
} else {
	if(isset($plan) && $plan){ ?>
		<button class="accordion"> <strong><i class="icon mch-check-square-o" aria-hidden="true"></i> View Assessment Details</strong></button>
		<div class="panel">
	<?php } ?>

		<p>The results below were recorded on <?php echo date('l F jS, Y \a\t g:ia',strtotime($responses[0]->getField('date'))); ?></p>
		





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
			$compareHeading = '';
			$subgroupingHeader = '';
			$comparesubHeading = '';
			
			foreach ($records as $record) {
				// print_r($record);
				// compare types and output the heading if needed
				$compareHeading = $record->getField('type');
				if($groupingHeader != $compareHeading){
					if($compareHeading == 'S'){
						echo "<h2>Skills</h2>";
						$secondSet = "Skill";
						$secondSetSuffix = "-S";
					} else {
						echo "<h2>Knowledge</h2>";
					}
					$groupingHeader = $compareHeading;
				}
				// compare subtypes and output the subheading if needed
				$comparesubHeading = $record->getField('subtype');
				if($subgroupingHeader != $comparesubHeading){
					if($comparesubHeading == 'B'){
						echo "<h3>Foundational</h3>";
					} else if($comparesubHeading == 'A') {
						echo "<h3>Advanced</h3>";
					}
					$subgroupingHeader = $comparesubHeading;
				}
				// isolate the id
				$qID = $record->getField('qID');
				$qID_clean = $record->getField('qID_clean');
				#$qIDname = str_replace(".","",$qID);
				$qIDname = $qID;
				// output it all, finally!
				echo "<p><strong>".$qID."</strong> ".$record->getField('text')."</p>";
		?>
		<div class="results">
			<p><strong>Your Results:</strong> You reported that you had <u><?php echo $values[$userResponses[$qID.$secondSetSuffix]] . " " . $secondSet; ?> (<?php echo $userResponses[$qID.$secondSetSuffix]; ?>)</u> of this competency.</p>
		<?php
		// display the trainings
			// $a = $userResponses[$qID."-I"];
			// $b = $userResponses[$qID.$secondSetSuffix];
			if($sub_i > 0){
				echo '<p><strong>Recommended Trainings:</strong></p>';
				$requestBO = $fm->newFindCommand('Competencies_v4');
    			$requestBO->addFindCriterion('Web Ready', "Web Ready");
				$requestBO->addFindCriterion('BestOf', "true");
				if($userResponses[$qID.$secondSetSuffix] <= 1){
					$requestBO->addFindCriterion('Learning Plan', $qID_clean.'-Introductory');
				} else if($userResponses[$qID.$secondSetSuffix] <= 2){
					$requestBO->addFindCriterion('Learning Plan', $qID_clean.'-Intermediate');
				} else if($userResponses[$qID.$secondSetSuffix] <= 3){
					$requestBO->addFindCriterion('Learning Plan', $qID_clean.'-Advanced');
				}
				$requestBO->addSortRule('title', 1, FILEMAKER_SORT_ASCEND);
				$resultBO = $requestBO->execute();
				if (FileMaker::isError($resultBO)) {
					echo $resultBO->getMessage();
				} else {
					$competenciesBO = $resultBO->getRecords();
					// echo $resultBO->getFoundSetCount();
					echo "<ul>";
					foreach ($competenciesBO as $c) {
						echo '<li><a href="/trainings/detail.php?id='.$c->getField('Record Number').'">'.$c->getField('Title').'</a></li>';
					}
					echo "</ul>";
				}
			}
		// end <div class="results">
		?>
		<hr>
		</div> <!-- end class="results" -->

		<?php
		} # end for each  records
		if($response->getField('notes') != ""){ ?>
			<h2>My Examples and Other Notes</h2>
			<p><em><?php echo $response->getField('notes'); ?></em></p>
		<?php } // end notes logic ?>







	<?php
	if(isset($plan) && $plan){
		echo "</div>"; # end <div class="panel">
	}
} // end of show trainings logic
?>


<?php if(!isset($plan)){ ?><p align="center"><a href="past-results.php" class="btnesque">Back to <strong>Past Results for Individual Competencies</strong></a></p><?php } ?>