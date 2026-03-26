<?php
$section = 'trainings';
$page = 'a-z';
$page_title = "A-Z Trainings";
include ('../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
  <?php include('../incl/leftnav.html'); ?>
<div class="nine columns">
	<?php include('../incl/title.html'); ?>	

	<p> You can refine this list by typing a key word below. For expanded search capabilities - including searching by competency, topic, or presenter - use the <a href="search.php">Search</a> page.</p>






	<?php
		/* FILEMAKER SETUP */
		include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
		$fm = db_connect("MCH-Navigator");
		$find = $fm->newFindCommand('Web Search');
		$sortFields = "";
		
		//extract the data arrays and put them into $key => $value format.
		extract($_GET, EXTR_OVERWRITE);
		include_once("/home/dh_mch_sftp/globals/scrubber.php");
		
		//sort rule
		$find->addFindCriterion('Web Ready', "Web Ready");
		$find->addSortRule("Title", 1, FILEMAKER_SORT_ASCEND);
		
		// $find->setRange(0, 75);
		$result = $find->execute();
		
		if (!FileMaker::isError($result)) {
			$count       = $result->getFoundSetCount();
			$records     = $result->getRecords();
			$firstRecord = $result->getFirstRecord();
		} else {
			$count = 0;
			$errorCode = $result->code;
		}
	?>

	<form>
	  <p><strong>Filter by Keyword:</strong> <input id="search-navigation" name="search-highlight" placeholder="Type to begin filtering..." type="text" autocomplete="on" onKeyPress="return disableEnterKey(event)" data-list=".list" style="display: inline-block; border-radius: 5px; padding: 7px;border: solid 1px #ccc;width: 300px;"></p>
	</form>


	<?php $previousLetter = "#"; ?>
		<h2>#</h2>
		<ul class="list accordion_section">
			<?php foreach ($records as $record) {
				$ID = $record->getField('Record Number');
				$Title = $record->getField('Title') != "" ? $record->getField('Title') : "n.a.";
				$Year = $record->getField('Year Developed') != "" ? $record->getField('Year Developed') : "n.a.";
				$Source = $record->getField('Source') != "" ? $record->getField('Source') : "n.a.";
				$Presenters = $record->getField('Presenters') != "" ? $record->getField('Presenters') : "n.a.";
				$Type = $record->getField('Type') != "" ? $record->getField('Type') : "n.a.";
				$Level = $record->getField('Level') != "" ? $record->getField('Level') : "n.a.";
				$Length = $record->getField('Length') != "" ? $record->getField('Length') : "n.a.";
			?>

			<?php
				$leadingLetter = substr(preg_replace("/[^A-Za-z0-9 ]/", '', $Title), 0, 1);
				$currentLetter = ctype_alpha($leadingLetter) ? $leadingLetter : "#";
				
				if ($currentLetter != $previousLetter){
					echo '</ul><h2>'.$currentLetter.'</h2><ul class="list accordion_section">';
					$previousLetter = $currentLetter;
				}
			?>
			<li>
				<?php echo '<strong><a href="/trainings/detail.php?id=' . $ID . '">' . $Title . '</a></strong>'; ?>. 
				<em>Year Developed:</em> <?php echo $Year; ?>. 
				<em>Source:</em> <?php echo $Source; ?>. 
				<em>Presenter(s):</em> <?php echo $Presenters; ?>. 
				<em>Type:</em> <?php echo $Type; ?>. 
				<em>Level:</em> <?php echo $Level; ?>. 
				<em>Length:</em> <?php echo $Length; ?>.
			</li>

			<?php } // end record loop ?>
		</ul>


</div>
</div>

<?php include('../incl/footer.html'); ?>