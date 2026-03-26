<?php 
$section = 'comments';
$page = 'calendar';
$page_title = "Training Calendar";
include ('../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../incl/leftnav.html'); ?>
<div class="nine columns">
<?php include('../incl/title.html'); ?>	
<div class="row">
<div class="seven columns">
<h2><i class="icon mch-star-empty" aria-hidden="true"></i> Learn More About MCH and Public Health</h2>
<p>The MCH Navigator collects learning opportunities that support the <a href="../trainings/competencies.php">MCH Leadership Competences</a> and that have been <a href="../about/screening-process.php">vetted</a> by a interdisciplinary advisory board of academics and members of the Title V workforce.</p>
<p>However, the range of online training is diverse. Numerous learning opportunities related to MCH topics (e.g., infant mortality, well-child care) and public health in general (e.g., emerging diseases, public health law) arise every day.</p>
<p>This Training Calendar provides access to emerging (yet unvetted) learning opportunities. Check back often to see what trainings are available in real time. Or join us on <a href="https://twitter.com/mchnavigator">Twitter</a> to receive announcements about these trainings.</p>
<p>We welcome submissions to the Training Calendar and for dissemination through our social media channels. Please use our <a href="submit.php">submission form</a> to let us know of upcoming trainings.</p>
<h2>&nbsp;</h2>
</div>
<div class="five columns">
<h3><i class="icon mch-calendar"></i> UPCOMING TRAININGS</h3>
<?php
	/* SETUP */
	include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
	$fm = db_connect("MCH-Navigator");
	$find = $fm->newFindCommand('NewsEvents');
	
	$find->addFindCriterion('date', ">=" . date("m/d/Y"));
	
	$find->addSortRule('date', 1, FILEMAKER_SORT_ASCEND);
	
	$find->setRange(0, 3);
	$result = $find->execute();
	
	if (!FileMaker::isError($result)) {
		$count       = $result->getFoundSetCount();
		$records     = $result->getRecords();
		$firstRecord = $result->getFirstRecord();
	} else {
		$count     = 0;
		$errorCode = $result->code;
	}
	foreach ($records as $record) {
		echo '<div class="trainings"><div class="date"><span>' . date("M", strtotime($record->getField('date'))) . '<br>' . date("j", strtotime($record->getField('date'))) . '</span></div>' . '<span class="summ">' . $record->getField('text');
		if ($record->getField('url') != "") {
			echo ' <a href="' . $record->getField('url') . '">' . $record->getField('url_text') . '</a>';
		}
		echo '</span></div>';
	}
?>

</div>
</div>

</div>
</div>

<?php include('../incl/footer.html'); ?>