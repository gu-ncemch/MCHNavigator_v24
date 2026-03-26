<?php
	#print_r($record);
	// get the data
	#$id = $record->getRecordID(); #if using the direct method
	$id = $record->getField('Record Number'); #if using the rougher method
	$Title = $record->getField('Title') != "" ? $record->getField('Title') : "n.a.";
	$YearDeveloped = $record->getField('Year Developed') != "" ? $record->getField('Year Developed') : "n.a.";
	$Source = $record->getField('Source') != "" ? $record->getField('Source') : "n.a.";
	$Source = $record->getField('Source URL') != "" ? '<a href="'.$record->getField('Source URL').'" target="_blank" rel="external">'.$Source.'</a>' : $Source;
	$Presenters = $record->getField('Presenters') != "" ? $record->getField('Presenters') : "n.a.";
	$Type = $record->getField('Type') != "" ? $record->getField('Type') : "n.a.";
	$Level = $record->getField('Level') != "" ? $record->getField('Level') : "n.a.";
	$Length = $record->getField('Length') != "" ? $record->getField('Length') : "n.a.";
	//$URL2 = $record->getField('URL 2') != "" ? ' <em>URL 2:</em> <a href="'.$record->getField('URL 2').'" target="_blank" rel="external">'.$record->getField('URL 2').'</a>.' : "";


	$URL1 = $record->getField('URL') != "" ? $record->getField('URL') : "";
	$URL1Notes = $record->getField('URL Notes') != "" ? $record->getField('URL Notes') : "";

	$URL2 = $record->getField('URL 2') != "" ? $record->getField('URL 2') : "";
	$URL2Notes = $record->getField('URL 2 Notes') != "" ? $record->getField('URL 2 Notes') : "";

	$Title = $URL1 != "" ? '<a href="'.$URL1.'">'.$Title.'</a>' : $Title;
	$URL2 = $URL2 != "" ? ' <a href="'.$URL2.'" target="_blank" rel="external">'.$URL2Notes.'</a>' : "";

	$Annotation = $record->getField('Annotation');
	$LearningObjectives = $record->getField('Learning Objectives');
	$Competencies = $record->getField('Competencies Addressed');
	$SpecialInstructions = $record->getField('Special Instructions');
	$ContinuingEducation = $record->getField('CE Details');
?>

<div class="record" id="record<?php echo $id; ?>" style="border-bottom: 1px solid #f2f2f2; display: block; clear: both; display: table; margin-bottom: 1rem;">

	<div style="display: table-cell; vertical-align: top;">
	<p><strong><?php echo $Title; ?>.</strong> <em>Year Developed: </em><?php echo $YearDeveloped; ?>. <em>Source:</em> <?php echo $Source; ?>. <em>Presenter(s):</em> <?php echo $Presenters; ?>. <em>Type:</em> <?php echo $Type; ?>. <em>Level:</em> <?php echo $Level; ?>. <em>Length:</em> <?php echo $Length; ?>.<?php echo $URL2; ?></p>

	<div class="detail"> <?php echo $Annotation != "" ? "<p><em>Annotation:</em> ".$Annotation."</p>" : null; ?> <?php echo $LearningObjectives != "" ? "<p><em>Learning Objectives:</em> ".$LearningObjectives."</p>" : null; ?> <?php echo $Competencies != "" ? "<p><em>Competencies Addressed:</em> ".$Competencies."</p>" : null; ?> <?php echo $SpecialInstructions != "" ? "<p><em>Special Instructions:</em> ".$SpecialInstructions."</p>" : null; ?> <?php echo $ContinuingEducation != "" ? "<p><em>Continuing Education:</em> ".$ContinuingEducation."</p>" : null; ?> </div>
	</div>



	<div style="display: table-cell; vertical-align: top; text-align: center;">
		<ul class="buttons">
			<li class="basic labeled"><a href="javascript:detail(<?php echo $id; ?>);" title="More Details"><span class="mch-expand"></span><br><small>More</small></a></li>
			<li class="detail labeled"><a href="javascript:basic(<?php echo $id; ?>);" title="Less Details"><span class="mch-compress"></span><br><small>Less</small></a></li>
			<li class="detail"><a href="detail.php?id=<?php echo $id; ?>&amp;do=print" title="Print"><span class="mch-print-1"></span></a></li>
			<li class="detail"><a href="detail.php?id=<?php echo $id; ?>" title="Permalink"><span class="mch-link"></span></a></li>
			<li class="detail"><?php
				$citationAction = in_array($id, $myCitations) ? 'remove' : 'add';
				$citationText = $citationAction == "add" ? '<span class="mch-heart-empty"></span>' : '<span class="mch-heart-1"></span>';
				echo '<a href="#" class="citation '.$citationAction.'" data-id="'.$id.'">'.$citationText.'</a>'; ?></li>
			<li class="detail">
				<!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_32x32_style" addthis:url="https://www.mchnavigator.org/trainings/detail.php?id=<?php echo $id; ?>"><a class="addthis_button_compact"><span class="mch-share"></span></a></div>
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-52b466c06332e20e"></script><!-- AddThis Button END -->
			</li>
		</ul>
	</div>

</div>