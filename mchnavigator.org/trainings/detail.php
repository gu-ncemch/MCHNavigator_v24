<?php 
$section = 'trainings';
$page = 'find';
$page_title = "Trainings";
include ('../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../incl/leftnav.html'); ?>
<div class="nine columns">
<?php include('../incl/title.html'); ?>	

<?php /* SETUP */
include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");

/* by id 
$record = $fm->getRecordById('Navigator', $_GET['id']);*/

/* by record number (custom) */
$find = $fm->newFindCommand('Navigator');
$find->addFindCriterion('Record Number', $_GET['id']);
$result = $find->execute();

if (!FileMaker::isError($result)) {
	$record = $result->getFirstRecord();
} else {
	//echo "ERROR: ".$result->code;
	//header("Location: http://mchnavigator.org/a-z.php");
	readfile ('401.php');
	exit;
}
// error trappings

#print_r($record);
//use id vs fmid?
//echo $_GET['id'];
//echo $record->getRecordID();

function cleanBlock($text){
	$url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
	$text = preg_replace($url, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $text);
	// make database html?
	$text = nl2br($text);
	$text = str_replace("<br />","</p><p>",$text);
	$text = preg_replace('/^\s+|\n|\r|\s+$/m', '', $text);
	$text = str_replace("<p></p>","",$text);
	$text = preg_replace("/<p>â€¢(.+?)<\/p>/is", "<li>$1</li>", $text);
	$text = str_replace("</li><p>","</li></ul><p>",$text);
	$text = str_replace("</p><li>","</p><ul><li>",$text);
	$text = str_replace("â€œ","&lsquo;",$text);
	$text = str_replace("â€","&rsquo;",$text);
	$text = str_replace("â€™","&rsquo;",$text);
	if(substr($text, 0, 4) == "<li>"){
		$text = "<ul>".$text;
	}
	if(substr($text, -5) == "</li>"){
		$text .= "</ul>";
	}
	return $text;
}

// get the data
$Title = $record->getField('Title');
$Source = $record->getField('Source');
$URL = $record->getField('Source URL');
$Type = $record->getField('Type');
$Level = $record->getField('Level');
$Presenters = $record->getField('Presenters');
$DateDeveloped = $record->getField('Date Developed');
$Length = $record->getField('Length');

$Annotation = $record->getField('Annotation');
$Annotation = cleanBlock($Annotation);

$LearningObjectives = $record->getField('Learning Objectives');
if($LearningObjectives != ""){
	$LearningObjectives = cleanBlock($LearningObjectives);
	$LearningObjectives = "<p>".$LearningObjectives."</p>";
	#$LearningObjectives = str_replace("<li></li>","",$LearningObjectives);
}

$CompetenciesAddressed = $record->getField('Competencies Addressed');
$CompetenciesAddressed = cleanBlock($CompetenciesAddressed);

$SpecialInstructions = $record->getField('Special Instructions');
if($record->getField('Special Instructions') == "Yes"){
	$ContinuingEducation = $record->getField('CE Details');
} else {
	$ContinuingEducation = "";
}

$URL2 = $record->getField('URL 2');

?>


<h2><?php echo $Title; ?></h2>
<?php
	$DateDeveloped = $record->getField('Date Developed') != "" ? $record->getField('Date Developed') : "n.a.";
	$Presenters = $record->getField('Presenters') != "" ? $record->getField('Presenters') : "n.a.";
	$Type = $record->getField('Type') != "" ? $record->getField('Type') : "n.a.";
	$Level = $record->getField('Level') != "" ? $record->getField('Level') : "n.a.";
	$Length = $record->getField('Length') != "" ? $record->getField('Length') : "n.a.";
	
	$URL1 = $record->getField('URL') != "" ? $record->getField('URL') : "";
	$URL1Notes = $record->getField('URL Notes') != "" ? $record->getField('URL Notes') : "";
	
	$URL2 = $record->getField('URL 2') != "" ? $record->getField('URL 2') : "";
	$URL2Notes = $record->getField('URL 2 Notes') != "" ? $record->getField('URL 2 Notes') : "";

	echo $URL1 != "" ? '<p><strong>URL 1:</strong> '.$URL1Notes.' <a href="'.$URL1.'" rel="external">'.$URL1.'</a></p>' : null;
	echo $URL2 != "" ? '<p><strong>URL 2:</strong> '.$URL2Notes.' <a href="'.$URL2.'" rel="external">'.$URL2.'</a></p>' : null;
	#echo $Type != "" ? "<p><strong>Type:</strong> ".$Type."</p>" : null;
	#echo $Level != "" ? "<p><strong>Level:</strong> ".$Level."</p>" : null;
	#echo $Presenters != "" ? "<p><strong>Presenter(s):</strong> ".$Presenters."</p>" : null;
	#echo $DateDeveloped != "" ? "<p><strong>Date Developed:</strong> ".$DateDeveloped."</p>" : null;
	#echo $Length != "" ? "<p><strong>Length:</strong> ".$Length."</p>" : null;
?>
<p><em>Date Developed: </em><?php echo $DateDeveloped; ?>. <em>Source:</em> <?php echo $Source; ?>. <em>Presenter(s):</em> <?php echo $Presenters; ?>. <em>Type:</em> 

<?php echo $Type; ?>. <em>Level:</em> <?php echo $Level; ?>. <em>Length:</em> <?php echo $Length; ?>.</p>
	<?php echo $Annotation != "" ? "<h3>Annotation</h3> <p>".$Annotation."</p>" : null;
	echo $LearningObjectives != "" ? "<h3>Learning Objectives</h3> ".$LearningObjectives."" : null;
	echo $CompetenciesAddressed != "" ? "<h3>Competencies Addressed</h3> <p>".$CompetenciesAddressed."</p>" : null;
	echo $SpecialInstructions != "" ? "<h3>Special Instructions</h3> <p>".$SpecialInstructions."</p>" : null; ?>
	<ul>
		<?php
	echo $ContinuingEducation != "" ? "<li><strong>Continuing Education Details:</strong> ".$ContinuingEducation."</li>" : null; ?>
	</ul>
	
</div>
</div>

<?php include('../incl/footer.html'); ?>
