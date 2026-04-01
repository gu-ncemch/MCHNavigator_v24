<?php
// session_start();
// $myCitations = $_SESSION['myCitations'];
	if (!isset($_COOKIE['NavCitations']) || unserialize($_COOKIE['NavCitations']) == false) {
		$myCitations = array();
		setcookie('NavCitations', '', time()+(86400 * 365), '/');
	} else {
		$myCitations = unserialize($_COOKIE['NavCitations']);
	}

// print_r($myCitations);
?>

<?php
$section = 'trainings';
$page = 'find';
$page_title = "Search Results";
include ('../incl/header.html');
?>





<?php
/* SETUP */
include_once(__DIR__ . "/../../globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$find = $fm->newFindCommand('Web Search');
$sortFields = "";
$selfLink = "results.php?";
$conditional_text = "";
// print_r($_GET);
//extract the data arrays and put them into $key => $value format.
extract($_GET, EXTR_OVERWRITE);
include_once(__DIR__ . "/../../globals/scrubber.php");

if(!empty($sort)){
	$selfLink .= "sort=".$sort."&amp;";
}
if(!empty($Keyword)){
	$Keyword = scrubber($Keyword, 'string');
	$sortFields .= '<input type="hidden" value="'.$Keyword.'" name="Keyword">';
	$selfLink .= "Keyword=".$Keyword."&amp;";
	$find->addFindCriterion('Simple Search', $Keyword);
}
if(!empty($Title)){
	$Title = scrubber($Title, 'string');
	$sortFields .= '<input type="hidden" value="'.$Title.'" name="Title">';
	$selfLink .= "Title=".$Title."&amp;";
	$find->addFindCriterion('Title', $Title);
}
if(!empty($Organization)){
	$Organization = scrubber($Organization, 'string');
	$sortFields .= '<input type="hidden" value="'.$Organization.'" name="Organization">';
	$selfLink .= "Organization=".$Organization."&amp;";
	$find->addFindCriterion('Source', $Organization);
}
if(!empty($Presenter)){
	$Presenter = scrubber($Presenter, 'string');
	$sortFields .= '<input type="hidden" value="'.$Presenter.'" name="Presenter">';
	$selfLink .= "Presenter=".$Presenter."&amp;";
	$find->addFindCriterion('Presenters', $Presenter);
}
if(!empty($Type)){
	$Training = scrubber($Type, 'string');
}
if(!empty($Training)){
	$Training = scrubber($Training, 'string');
	$sortFields .= '<input type="hidden" value="'.$Training.'" name="Training">';
	$selfLink .= "Training=".$Training."&amp;";
	$find->addFindCriterion('Type', $Training);
}
if(!empty($Level)){
	$Level = scrubber($Level, 'string');
	$sortFields .= '<input type="hidden" value="'.$Level.'" name="Level">';
	$selfLink .= "Level=".$Level."&amp;";
	$find->addFindCriterion('Level', $Level);
}
if(!empty($Accessibility)){
	$Accessibility = 'Yes';
	$sortFields .= '<input type="hidden" value="'.$Accessibility.'" name="Accessibility">';
	$selfLink .= "Accessibility=".$Accessibility."&amp;";
	$find->addFindCriterion('Accessibility', $Accessibility);
}
if(!empty($CE) || !empty($CE_Available)){
	$CE = 'Yes';
	$sortFields .= '<input type="hidden" value="'.$CE.'" name="CE">';
	$selfLink .= "CE=".$CE."&amp;";
	$find->addFindCriterion('CE Available', $CE);
}
if(!empty($Competencies)){
	$Competencies = scrubber($Competencies, 'string');
	$sortFields .= '<input type="hidden" value="'.$Competencies.'" name="Competencies">';
	$selfLink .= "Competencies=".$Competencies."&amp;";
	// $find->addFindCriterion('Competencies_v4_5', $Competencies);
	// $find->addFindCriterion('Competencies_v4_5', $Competencies);
	$find->addFindCriterion('Competencies_v4_5', $Competencies);
}
if(!empty($PHCompetencies)){
	$PHCompetencies = scrubber($PHCompetencies, 'string');
	$sortFields .= '<input type="hidden" value="'.$PHCompetencies.'" name="PHCompetencies">';
	$selfLink .= "PHCompetencies=".$PHCompetencies."&amp;";
	$find->addFindCriterion('PH Competencies', $PHCompetencies);
}



// 
// 
// guided search fields
if(!empty($Primary_Audience)){
	$Primary_Audience = scrubber($Primary_Audience, 'string');
	$selfLink .= "Primary_Audience=".$Primary_Audience."&amp;";
	$find->addFindCriterion('Primary Audience', $Primary_Audience);
}
if(!empty($Competencies_v4)){
	$Competencies_v4 = scrubber($Competencies_v4, 'string');
	$selfLink .= "Competencies_v4=".$Competencies_v4."&amp;";
	$find->addFindCriterion('Competencies_v4_5', $Competencies_v4);
}
// Level is already handled
if(!empty($Length)){
	$Length = scrubber($Length, 'string');
	$selfLink .= "Length=".$Length."&amp;";
	if($Length == "self-paced"){
		$find->addFindCriterion('Length', 'Self-paced');
	} else {
		$find->addFindCriterion('Length_INT', '≤'.$Length);
	}
}
if(!empty($Year_Developed)){
	$Year_Developed = scrubber($Year_Developed, 'int');
	$selfLink .= "Year_Developed=".$Year_Developed."&amp;";
	$Year_Developed_Search_Term = '>'.(date("Y")-$Year_Developed);
	// echo $Year_Developed_Search_Term;
	$find->addFindCriterion('Year Developed', $Year_Developed_Search_Term);
}
// Type is already handled
// CE_Available is already handled







$start = isset($start) ? scrubber($start, 'int') : 0;
$start = $start > 0 ? $start-1 : 0;
$sort = isset($sort) ? scrubber($sort, 'string') : "Year Developed";
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
	// echo $result->getMessage();
	$errorCode = $result->code;

	$find2 = $fm->newFindCommand('Web Search');
	$find2->addFindCriterion('Competencies_v4_5', $Competencies_v4);
	$find2->addFindCriterion('Level', $Level);
	$find2->addFindCriterion('Web Ready', "Web Ready");
	$find2->addSortRule($sort, 1, $sortOrder);
	$find2->addSortRule('Title', 2, FILEMAKER_SORT_DESCEND);
	$find2->setRange($start, 10); //10
	$result2 = $find2->execute();
	if (!FileMaker::isError($result2)) {
		$conditional_text = "There are no trainings that meet all your criteria;<br>however, here’s a list of trainings that most closely match what you are looking for:";
		$count       = $result2->getFoundSetCount();
		$records     = $result2->getRecords();
		$firstRecord = $result2->getFirstRecord();
	} else {
		$count = 0;
		// echo $result2->getMessage();
		$errorCode = $result2->code;
		echo "Second search failed too.";
	}
}
?>





<style>
	form .label {
	    font-weight: 600;
	    font-size: 1.4rem;
	    display: block;
	}
	form p { margin: .5rem 0 0; display: block !important; }
	form input[type="text"], form select { box-sizing: border-box; max-width: none; }
	.select .arr {
	    bottom: -10px;
	}
</style>


<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">

<?php #include('../incl/leftnav.html'); ?>

<div class="four columns">
	<h3>Edit Your Search</h3>
	<form method="get" action="results.php">
		<p class="form-group">
			<label class="label" for="Keyword">Keyword:</label>
			<input type="text" name="Keyword" id="Keyword" value="<?php echo $Keyword; ?>"> 
		</p>
		<p class="form-group">
			<label class="label" for="Title">Title:</label>
			<input type="text" name="Title" id="Title" value="<?php echo $Title; ?>">
		</p>
		<p class="form-group">
			<label class="label" for="Organization">Sponsoring Organization:</label>
			<input type="text" name="Organization" id="Organization" value="<?php echo $Organization; ?>">
		</p>
		<p class="form-group">
			<label class="label" for="Presenter">Presenters:</label>
			<input type="text" name="Presenter" id="Presenter" value="<?php echo $Presenter; ?>">
		</p>
		<p class="form-group select">
			<label class="label" for="Training">Training Type:</label>
			<span class="arr"></span>
			<select name="Training" id="Training">
				<option <?php echo $Training == '' ? 'selected' : ''; ?> value="">All Training Types</option>
				<option <?php echo $Training == 'Interactive Learning Tool' ? 'selected' : ''; ?> value="Interactive Learning Tool">Interactive Learning Tool</option>
				<option <?php echo $Training == 'Narrated Slide Presentation' ? 'selected' : ''; ?> value="Narrated Slide Presentation">Narrated Slide Presentation</option>
				<option <?php echo $Training == 'Online Course' ? 'selected' : ''; ?> value="Online Course">Online Course</option>
				<option <?php echo $Training == 'Podcast' ? 'selected' : ''; ?> value="Podcast">Podcast</option>
				<option <?php echo $Training == 'PowerPoint Presentation' ? 'selected' : ''; ?> value="PowerPoint Presentation">PowerPoint Presentation</option>
				<option <?php echo $Training == 'Video' ? 'selected' : ''; ?> value="Video">Video</option>
				<option <?php echo $Training == 'Webinar' ? 'selected' : ''; ?> value="Webinar">Webinar</option>
			</select>
		</p>
		<p class="form-group"><span class="label">Level:</span>
			<label for="Introductory"><input type="radio" <?php echo $Level == 'Introductory' ? 'checked' : ''; ?> value="Introductory" name="Level" id="Introductory"> Introductory</label><br>
			<label for="Intermediate"><input type="radio" <?php echo $Level == 'Intermediate' ? 'checked' : ''; ?> value="Intermediate" name="Level" id="Intermediate"> Intermediate</label><br>
			<label for="Advanced"><input type="radio" <?php echo $Level == 'Advanced' ? 'checked' : ''; ?> value="Advanced" name="Level" id="Advanced"> Advanced</label>
		</p>
		<p class="form-group"><span class="label">Accessible:</span><label for="Accessibility"><input type="checkbox" <?php echo $Accessibility == 'Yes' ? 'checked' : ''; ?> value="Yes" name="Accessibility" id="Accessibility"> Yes</label></p>
		<p class="form-group"><span class="label">Continuing Education:</span><label for="CE"><input type="checkbox" <?php echo $CE == 'Yes' ? 'checked' : ''; ?> value="Yes" name="CE" id="CE"> Yes</label></p>



<?php if( $Competencies == '' || str_contains($Competencies, '.') ){ ?><p class="form-group select">
			<label class="label" for="Competencies">Competency:</label>
			<span class="arr"></span>
			<select name="Competencies" id="Competencies">
				<option <?php echo $Competencies == '' ? 'selected' : ''; ?> value="">All Competencies</option>
				<option <?php echo $Competencies == '1.' ? 'selected' : ''; ?> value="1.">MCH Knowledge Base/Context</option>
				<option <?php echo $Competencies == '2.' ? 'selected' : ''; ?> value="2.">Self-Reflection</option>
				<option <?php echo $Competencies == '3.' ? 'selected' : ''; ?> value="3.">Ethics</option>
				<option <?php echo $Competencies == '4.' ? 'selected' : ''; ?> value="4.">Critical Thinking</option>
				<option <?php echo $Competencies == '5.' ? 'selected' : ''; ?> value="5.">Communication</option>
				<option <?php echo $Competencies == '6.' ? 'selected' : ''; ?> value="6.">Negotiation and Conflict Resolution</option>
				<option <?php echo $Competencies == '7.' ? 'selected' : ''; ?> value="7.">Cultural Competency</option>
				<option <?php echo $Competencies == '8.' ? 'selected' : ''; ?> value="8.">Family-Professional Partnerships</option>
				<option <?php echo $Competencies == '9.' ? 'selected' : ''; ?> value="9.">Developing Others Through Teaching, Coaching, and Mentoring</option>
				<option <?php echo $Competencies == '10.' ? 'selected' : ''; ?> value="10.">Interdisciplinary/Interprofessional Team Building</option>
				<option <?php echo $Competencies == '11.' ? 'selected' : ''; ?> value="11.">Working with Communities and Systems</option>
				<option <?php echo $Competencies == '12.' ? 'selected' : ''; ?> value="12.">Policy</option>
			</select>
		</p><?php } else { ?><input type="hidden" name="Competencies" id="Competencies" value="<?php echo $Competencies; ?>"><?php } ?>





		<p class="form-group select">
			<label class="label" for="PHCompetencies">Public Health Competency:</label>
			<span class="arr"></span>
			<select name="PHCompetencies" id="PHCompetencies">
				<option <?php echo $PHCompetencies == '' ? 'selected' : ''; ?> value="">All Public Health Competencies</option>
				<option <?php echo $PHCompetencies == '1.' ? 'selected' : ''; ?> value="1.">Analytical/Assessment Skills</option>
				<option <?php echo $PHCompetencies == '2.' ? 'selected' : ''; ?> value="2.">Policy Developmental/Program Planning Skills</option>
				<option <?php echo $PHCompetencies == '3.' ? 'selected' : ''; ?> value="3.">Communication Skills</option>
				<option <?php echo $PHCompetencies == '4.' ? 'selected' : ''; ?> value="4.">Cultural Competency</option>
				<option <?php echo $PHCompetencies == '5.' ? 'selected' : ''; ?> value="5.">Community Dimensions of Practice Skills</option>
				<option <?php echo $PHCompetencies == '6.' ? 'selected' : ''; ?> value="6.">Public Health Sciences Skill</option>
				<option <?php echo $PHCompetencies == '7.' ? 'selected' : ''; ?> value="7.">Financial Planning and Management Skills</option>
				<option <?php echo $PHCompetencies == '8.' ? 'selected' : ''; ?> value="8.">Leadership and Systems Thinking Skills</option>
			</select>
		</p>
		<p class="form-group select">
			<label class="label" for="sort">Sorted By:</label>
			<span class="arr"></span>
			<select name="sort">
				<option <?php if($sort == "Year Developed"){ echo " selected";} ?> value="Year Developed">Year Developed (newest first)</option>
				<option <?php if($sort == "Entry Date"){ echo " selected";} ?> value="Entry Date">Most Recently Added</option>
				<option <?php if($sort == "Title"){ echo " selected";} ?> value="Title">Title</option>
				<option <?php if($sort == "Presenters"){ echo " selected";} ?> value="Presenters">Presenter</option>
			</select>
		</p>
		<p style="text-align:center;"><button type="submit">Update Results</button><br><a href="search.php" class="box">New Search</a></p>
	</form>
</div>










<div class="eight columns">
<?php include('../incl/title.html'); ?>

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

			<p><strong><em><?php echo $conditional_text; ?></em></strong></p>
			<p id="resultCount">Displaying records <?php echo $result_min; ?> through <?php echo $result_max; ?> of <?php echo $count; ?> found.</p>

			<?php foreach ($records as $record) {
				include ('results-format.php');
			} // end foreach loop ?>

		<?php } //end count.if ?>

		<p><?php echo $prev; ?> <?php echo $next; ?></p>
		<p style="clear:both; text-align:center;"><a href="search.php" class="box">New Search</a> <a href="/citations/" class="box"><span class="mch-heart-1" style="display: inline; position: relative; top: 3px; margin-left: 20px;"></span> View My Citations</a></p>

</div>
</div>

<script src="/citations/citations.js"></script>

<?php include('../incl/footer.html'); ?>
