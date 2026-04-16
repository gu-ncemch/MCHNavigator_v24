<?php
	$fieldData = $record['fieldData'] ?? array();

	$id = $fieldData['Record Number'] ?? '';
	$Title = ($fieldData['Title'] ?? '') !== '' ? $fieldData['Title'] : 'n.a.';
	$YearDeveloped = ($fieldData['Year Developed'] ?? '') !== '' ? $fieldData['Year Developed'] : 'n.a.';
	$Source = ($fieldData['Source'] ?? '') !== '' ? $fieldData['Source'] : 'n.a.';
	$sourceUrl = $fieldData['Source URL'] ?? '';
	$Source = $sourceUrl !== '' ? '<a href="' . $sourceUrl . '" target="_blank" rel="external">' . $Source . '</a>' : $Source;
	$Presenters = ($fieldData['Presenters'] ?? '') !== '' ? $fieldData['Presenters'] : 'n.a.';
	$Type = ($fieldData['Type'] ?? '') !== '' ? $fieldData['Type'] : 'n.a.';
	$Level = ($fieldData['Level'] ?? '') !== '' ? $fieldData['Level'] : 'n.a.';
	$Length = ($fieldData['Length'] ?? '') !== '' ? $fieldData['Length'] : 'n.a.';

	$URL1 = $fieldData['URL'] ?? '';
	$URL1Notes = $fieldData['URL Notes'] ?? '';

	$URL2 = $fieldData['URL 2'] ?? '';
	$URL2Notes = $fieldData['URL 2 Notes'] ?? '';

	$Title = $URL1 !== '' ? '<a href="' . $URL1 . '">' . $Title . '</a>' : $Title;
	$URL2 = $URL2 !== '' ? ' <a href="' . $URL2 . '" target="_blank" rel="external">' . $URL2Notes . '</a>' : '';

	$Annotation = $fieldData['Annotation'] ?? '';
	$LearningObjectives = $fieldData['Learning Objectives'] ?? '';
	$Competencies = $fieldData['Competencies Addressed'] ?? '';
	$SpecialInstructions = $fieldData['Special Instructions'] ?? '';
	$ContinuingEducation = $fieldData['CE Details'] ?? '';
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
