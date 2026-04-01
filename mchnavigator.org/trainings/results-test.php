<!DOCTYPE html>
<html lang="en"><!-- InstanceBegin template="/Templates/standard.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->Year Developed
<title>MCH Navigator | A Training Portal for MCH Professionals</title>
<!-- InstanceEndEditable -->
<!-- meta -->
<?php
	$include_path = "/home/dh_mch_sftp/mchnavigator.org";
?>
<?php $submenu_open = "mch"; ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><![endif]-->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="apple-touch-icon" href="/apple-touch-icon.png" />

<!-- CSS ================================================== -->
<link rel="stylesheet" href="../css/style.css" type="text/css" />
<?php if(basename(__FILE__) != "results.php"){ ?>
<link rel="stylesheet" href="../css/addthis.css" type="text/css" />
<?php } ?>
<link rel="stylesheet" href="../css/responsive.css" type="text/css" />
<link rel="stylesheet" href="../fonts/fonts.css">
<!--[if lt IE 9 ]>
<link rel="stylesheet" href="/css/ie.css" type="text/css" />
<![endif]-->

<!-- JS ================================================== -->
<script src="https://cdn.ncemch.org/js/jquery/jquery.min.js"></script>

<!-- Any other stuff ================================================== -->
<!-- InstanceBeginEditable name="head" -->
<?php $submenu_open = "search"; ?>
<script type="text/javascript">
	function detail(rid){
		$("#record"+rid+" li.basic").hide();
		$("#record"+rid+" li.detail").show();
		$("#record"+rid+" div.detail").slideToggle("fast");
	}
	function basic(rid){
		$("#record"+rid+" li.basic").show();
		$("#record"+rid+" li.detail").hide();
		$("#record"+rid+" div.detail").slideToggle("fast");
	}
</script>
<style type="text/css">
.addthis_default_style .at300b, .addthis_default_style .at300bo, .addthis_default_style .at300m { padding: 10px !important; }

#shareLI { display:none !important; }
.box{padding:10px 20px;}
.labeled { text-align:center; line-height:10px;}
a small{ font-size:10px;}
</style>
<!-- InstanceEndEditable -->
<style type="text/css">
#leftnav #<?php echo $submenu_open;
?> > a, #leftnav li a:hover {
 color: #fff !important;
 background-color: #681919 !important;
}
#<?php echo $submenu_open;
?> a[href$="<?php echo basename(__FILE__); ?>"] {
 background-color: #AD9F9F !important;
}
</style>

</head>
<body class="vertical">
<a class="accessible" href="#main">[Skip to Content]</a>
<div id="branding">
	<div class="restrain"><a href="http://www.georgetown.edu/" id="gu">Georgetown University</a> <a href="http://healthinfogroup.org/">Health Information Group</a> | <a href="http://ncemch.org/">NCEMCH</a> </div>
</div>
<div id="wrapper">
	<div class="container">
		<div id="header"> <a href="http://www.mchnavigator.org/index.php" id="main_logo"><img src="../images/main_logo.png" alt="MCH Navigator"></a><img src="../images/funded.png" alt="Funded by the U.S. Maternal &amp; Child Health Bureau" id="funded">
			<div class="clearfix"></div>
		</div>
		<!-- /header -->
		<div id="topnav">
			<?php include $include_path . "/includes/topnav.php"; ?>
		</div>
		<div id="leftnav" class="largeonly">
			<?php include $include_path . "/includes/leftnav.php"; ?>
		</div>
		<div id="menu_bttn" class="smallonly"> <a href="javascript:void(0);" onClick="javascript:$('#leftnav').toggle('fast');return false;"><span class="icon icon-reorder"></span>Menu</a> </div>
		<!-- /leftnav -->
		<div id="content"><a id="main"></a>
			<div id="page_title"> <!-- InstanceBeginEditable name="titleImg" --><img width="240" height="100" alt="Trainings" src="../images/top-compass.jpg"><!-- InstanceEndEditable -->
				<div class="v"> <!-- InstanceBeginEditable name="titleText" -->
				<h1>Search Results</h1>
					<p>Your customized list of learning opportunities</p>
			<?php
/* SETUP */
include_once(__DIR__ . "/../../globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$find = $fm->newFindCommand('Web Search');
$sortFields = "";
$selfLink = "results.php?";

//extract the data arrays and put them into $key => $value format.
extract($_GET, EXTR_OVERWRITE);
include_once(__DIR__ . "/../../globals/scrubber.php");

if(isset($sort)){
	$selfLink .= "sort=".$sort."&amp;";
}
if(isset($Keyword)){
	$Keyword =  scrubber($Keyword, 'string');
	$sortFields .= '<input type="hidden" value="'.$Keyword.'" name="Keyword">';
	$selfLink .= "Keyword=".$Keyword."&amp;";
	$find->addFindCriterion('Simple Search', $Keyword);
}
if(isset($Title)){
	$Title =  scrubber($Title, 'string');
	$sortFields .= '<input type="hidden" value="'.$Title.'" name="Title">';
	$selfLink .= "Title=".$Title."&amp;";
	$find->addFindCriterion('Title', $Title);
}
if(isset($Organization)){
	$Organization =  scrubber($Organization, 'string');
	$sortFields .= '<input type="hidden" value="'.$Organization.'" name="Organization">';
	$selfLink .= "Organization=".$Organization."&amp;";
	$find->addFindCriterion('Source', $Organization);
}
if(isset($Presenter)){
	$Presenter =  scrubber($Presenter, 'string');
	$sortFields .= '<input type="hidden" value="'.$Presenter.'" name="Presenter">';
	$selfLink .= "Presenter=".$Presenter."&amp;";
	$find->addFindCriterion('Presenters', $Presenter);
}
if(isset($Training)){
	$Training =  scrubber($Training, 'string');
	$sortFields .= '<input type="hidden" value="'.$Training.'" name="Training">';
	$selfLink .= "Training=".$Training."&amp;";
	$find->addFindCriterion('Type', $Training);
}
if(isset($Level)){
	$Level =  scrubber($Level, 'string');
	$sortFields .= '<input type="hidden" value="'.$Level.'" name="Level">';
	$selfLink .= "Level=".$Level."&amp;";
	$find->addFindCriterion('Level', $Level);
}
if(isset($Accessibility)){
	$Accessibility =  'Yes';
	$sortFields .= '<input type="hidden" value="'.$Accessibility.'" name="Accessibility">';
	$selfLink .= "Accessibility=".$Accessibility."&amp;";
	$find->addFindCriterion('Accessibility', $Accessibility);
}
if(isset($CE)){
	$CE =  'Yes';
	$sortFields .= '<input type="hidden" value="'.$CE.'" name="CE">';
	$selfLink .= "CE=".$CE."&amp;";
	$find->addFindCriterion('CE Available', $CE);
}
if(isset($Competencies)){
	$Competencies =  scrubber($Competencies, 'string');
	$sortFields .= '<input type="hidden" value="'.$Competencies.'" name="Competencies">';
	$selfLink .= "Competencies=".$Competencies."&amp;";
	$find->addFindCriterion('Competencies', $Competencies);
}
if(isset($PHCompetencies)){
	$PHCompetencies =  scrubber($PHCompetencies, 'string');
	$sortFields .= '<input type="hidden" value="'.$PHCompetencies.'" name="PHCompetencies">';
	$selfLink .= "PHCompetencies=".$PHCompetencies."&amp;";
	$find->addFindCriterion('PH Competencies', $PHCompetencies);
}

$start = isset($start) ? scrubber($start, 'int') : 0;
$start = $start > 0 ? $start-1 : 0;
$sort = isset($sort) ? scrubber($sort, 'string') : "Entry Date";
if($sort == "Title" || $sort == "Presenters"){
	$sortOrder = FILEMAKER_SORT_ASCEND;
} else{
	$sortOrder = FILEMAKER_SORT_DESCEND;
}

//sort rule
$find->addFindCriterion('Web Ready', "Web Ready");
$find->addSortRule($sort, 1, $sortOrder);
$find->addSortRule('Title', 2, FILEMAKER_SORT_DESCEND);

$find->setRange($start, 10); //10
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
			<?php
		  if($count == 0){ ?>
			<p>No results found. (Error <?php echo $errorCode; ?>)</p>
			<?php } else {
						$result_min = $start == 0 ? 1 : $start+1;
						$result_max = $start == 0 ? 10 : $start+10;
						$result_max = $result_max > $count ? $count : $result_max;
						$prev = $result_min != 1 ? '<a href="'.$selfLink.'start='.($result_min-10).'" class="box" style="float:left;">&laquo; Previous</a>' : "";
						$next = $result_max != $count ? '<a href="'.$selfLink.'start='.($result_max+1).'" class="box" style="float:right;">Next &raquo;</a>' : "";
			?>
			<form>
<p id="resultCount">Displaying records <?php echo $result_min; ?> through <?php echo $result_max; ?> of <?php echo $count; ?> found. Sorted by
				<select name="sort">
					<!--<option value="Year Developed"<?php if($sort == "Year Developed"){ echo " selected";} ?>>Year Developed</option>-->
					<option value="Entry Date"<?php if($sort == "Entry Date"){ echo " selected";} ?>>Most Recently Added</option>
					<option value="Title"<?php if($sort == "Title"){ echo " selected";} ?>>Title</option>
					<option value="Presenters"<?php if($sort == "Presenters"){ echo " selected";} ?>>Presenter</option>
				</select>
				<?php echo $sortFields; ?><input type="submit" value="Resort">
			</p>
</form>
			<?php foreach ($records as $record) {
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

					$Title = '<a href="detail.php?id='.$id.'">'.$Title.'</a>';
					$URL2 = $URL2 != "" ? ' <a href="'.$URL2.'" target="_blank" rel="external">'.$URL2Notes.'</a>' : "";

					$Annotation = $record->getField('Annotation');
					$LearningObjectives = $record->getField('Learning Objectives');
					$Competencies = $record->getField('Competencies Addressed');
					$SpecialInstructions = $record->getField('Special Instructions');
					$ContinuingEducation = $record->getField('CE Details');
					?>
			<hr>
			<div id="record<?php echo $id; ?>">
				<ul class="buttons">
					<li class="basic labeled"><a href="javascript:detail(<?php echo $id; ?>);" title="More Details"><span class="icon icon-expand"></span><br>
<small>More</small></a></li>
					<li class="detail labeled"><a href="javascript:basic(<?php echo $id; ?>);" title="Less Details"><span class="icon icon-contract"></span><br>
<small>Less</small></a></li>
					<li class="detail"><a href="detail.php?id=<?php echo $id; ?>&amp;do=print" title="Print"><span class="icon icon-print"></span></a></li>
					<li class="detail"><a href="detail.php?id=<?php echo $id; ?>" title="Permalink"><span class="icon icon-link"></span></a></li>
					<li class="detail"><!-- AddThis Button BEGIN -->
						<div class="addthis_toolbox addthis_default_style addthis_32x32_style" addthis:url="http://127.0.0.1/xampp/localfiles/trainings/detail.php?id=<?php echo $id; ?>"><a class="addthis_button_compact"><span class="icon icon-share"></span></a></div>
						<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-52b466c06332e20e"></script><!-- AddThis Button END --></li>
				</ul>
				<p><strong><?php echo $Title; ?>.</strong> <em>Year Developed: </em><?php echo $YearDeveloped; ?>. <em>Source:</em> <?php echo $Source; ?>. <em>Presenter(s):</em> <?php echo $Presenters; ?>. <em>Type:</em> <?php echo $Type; ?>. <em>Level:</em> <?php echo $Level; ?>. <em>Length:</em> <?php echo $Length; ?>.<?php echo $URL2; ?></p>
				<div class="detail"> <?php echo $Annotation != "" ? "<p><em>Annotation:</em> ".$Annotation."</p>" : null; ?> <?php echo $LearningObjectives != "" ? "<p><em>Learning Objectives:</em> ".$LearningObjectives."</p>" : null; ?> <?php echo $Competencies != "" ? "<p><em>Competencies Addressed:</em> ".$Competencies."</p>" : null; ?> <?php echo $SpecialInstructions != "" ? "<p><em>Special Instructions:</em> ".$SpecialInstructions."</p>" : null; ?> <?php echo $ContinuingEducation != "" ? "<p><em>Continuing Education:</em> ".$ContinuingEducation."</p>" : null; ?> </div>
			</div>
			<?php
				} // end record loop
				} //end count.if ?>
			<hr>
			<p><?php echo $prev; ?> <?php echo $next; ?></p>
			<p style="clear:both; text-align:center;"><a href="search.php" class="box">New Search</a></p>
</div>
</div>

<?php include('../incl/footer.html'); ?>
