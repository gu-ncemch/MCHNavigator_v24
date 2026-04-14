<?php
require_once __DIR__ . '/../filemaker/data-api.php';

// session_start();
// $myCitations = $_SESSION['myCitations'];
if (!isset($_COOKIE['NavCitations']) || unserialize($_COOKIE['NavCitations']) == false) {
	$myCitations = array();
	setcookie('NavCitations', '', time() + (86400 * 365), '/');
} else {
	$myCitations = unserialize($_COOKIE['NavCitations']);
}

$section = 'trainings';
$page = 'find';
$page_title = 'Search Results';
include('../incl/header.html');

function get_query_value($key, $type = 'string', $default = '')
{
	if (!isset($_GET[$key]) || $_GET[$key] === '') {
		return $default;
	}

	return scrubber($_GET[$key], $type);
}

$Keyword = get_query_value('Keyword');
$Title = get_query_value('Title');
$Organization = get_query_value('Organization');
$Presenter = get_query_value('Presenter');
$Training = get_query_value('Training');
$Type = get_query_value('Type');
$Level = get_query_value('Level');
$Accessibility = get_query_value('Accessibility');
$CE = get_query_value('CE');
$CE_Available = get_query_value('CE_Available');
$Competencies = get_query_value('Competencies');
$PHCompetencies = get_query_value('PHCompetencies');
$Primary_Audience = get_query_value('Primary_Audience');
$Competencies_v4 = get_query_value('Competencies_v4');
$Length = get_query_value('Length');
$Year_Developed = get_query_value('Year_Developed', 'int', 0);
$start = get_query_value('start', 'int', 0);
$sort = get_query_value('sort', 'string', 'Year Developed');

if ($Type !== '' && $Training === '') {
	$Training = $Type;
}

if ($Accessibility !== '') {
	$Accessibility = 'Yes';
}

if ($CE !== '' || $CE_Available !== '') {
	$CE = 'Yes';
}

$start = $start > 0 ? $start - 1 : 0;
$sortOrder = ($sort === 'Title' || $sort === 'Presenters') ? 'ascend' : 'descend';

$selfParams = array();
$query = array(
	'Web Ready' => '=Web Ready',
);

if ($sort !== '') {
	$selfParams['sort'] = $sort;
}
if ($Keyword !== '') {
	$selfParams['Keyword'] = $Keyword;
	$query['Simple Search'] = $Keyword;
}
if ($Title !== '') {
	$selfParams['Title'] = $Title;
	$query['Title'] = $Title;
}
if ($Organization !== '') {
	$selfParams['Organization'] = $Organization;
	$query['Source'] = $Organization;
}
if ($Presenter !== '') {
	$selfParams['Presenter'] = $Presenter;
	$query['Presenters'] = $Presenter;
}
if ($Training !== '') {
	$selfParams['Training'] = $Training;
	$query['Type'] = $Training;
}
if ($Level !== '') {
	$selfParams['Level'] = $Level;
	$query['Level'] = $Level;
}
if ($Accessibility !== '') {
	$selfParams['Accessibility'] = $Accessibility;
	$query['Accessibility'] = $Accessibility;
}
if ($CE !== '') {
	$selfParams['CE'] = $CE;
	$query['CE Available'] = $CE;
}
if ($Competencies !== '') {
	$selfParams['Competencies'] = $Competencies;
	$query['Competencies_v4_5'] = $Competencies;
}
if ($PHCompetencies !== '') {
	$selfParams['PHCompetencies'] = $PHCompetencies;
	$query['PH Competencies'] = $PHCompetencies;
}
if ($Primary_Audience !== '') {
	$selfParams['Primary_Audience'] = $Primary_Audience;
	$query['Primary Audience'] = $Primary_Audience;
}
if ($Competencies_v4 !== '') {
	$selfParams['Competencies_v4'] = $Competencies_v4;
	$query['Competencies_v4_5'] = $Competencies_v4;
}
if ($Length !== '') {
	$selfParams['Length'] = $Length;
	if ($Length === 'self-paced') {
		$query['Length'] = 'Self-paced';
	} else {
		$query['Length_INT'] = '≤' . $Length;
	}
}
if ($Year_Developed > 0) {
	$selfParams['Year_Developed'] = $Year_Developed;
	$query['Year Developed'] = '>' . (date('Y') - $Year_Developed);
}

$selfLink = 'results.php?' . htmlspecialchars(http_build_query($selfParams), ENT_QUOTES) . '&amp;';
$conditional_text = '';
$errorCode = '';
$count = 0;
$records = array();

$request = array(
	'database' => 'MCH-Navigator',
	'layout' => 'Web Search',
	'action' => 'find',
	'parameters' => array(
		'query' => array($query),
		'sort' => array(
			array(
				'fieldName' => $sort,
				'sortOrder' => $sortOrder,
			),
			array(
				'fieldName' => 'Title',
				'sortOrder' => 'descend',
			),
		),
		'offset' => $start + 1,
		'limit' => 10,
	),
);

$result = do_filemaker_request($request, 'array');

if ((int) ($result['messages'][0]['code'] ?? 500) === 0) {
	$count = (int) ($result['response']['dataInfo']['foundCount'] ?? 0);
	$records = $result['response']['data'] ?? array();
} else {
	$errorCode = $result['messages'][0]['code'] ?? '';

	$fallbackQuery = array(
		'Web Ready' => '=Web Ready',
	);
	if ($Competencies_v4 !== '') {
		$fallbackQuery['Competencies_v4_5'] = $Competencies_v4;
	}
	if ($Level !== '') {
		$fallbackQuery['Level'] = $Level;
	}

	$fallbackRequest = array(
		'database' => 'MCH-Navigator',
		'layout' => 'Web Search',
		'action' => 'find',
		'parameters' => array(
			'query' => array($fallbackQuery),
			'sort' => array(
				array(
					'fieldName' => $sort,
					'sortOrder' => $sortOrder,
				),
				array(
					'fieldName' => 'Title',
					'sortOrder' => 'descend',
				),
			),
			'offset' => $start + 1,
			'limit' => 10,
		),
	);
	$result2 = do_filemaker_request($fallbackRequest, 'array');
	if ((int) ($result2['messages'][0]['code'] ?? 500) === 0) {
		$conditional_text = "There are no trainings that meet all your criteria;<br>however, here’s a list of trainings that most closely match what you are looking for:";
		$count = (int) ($result2['response']['dataInfo']['foundCount'] ?? 0);
		$records = $result2['response']['data'] ?? array();
	} else {
		$errorCode = $result2['messages'][0]['code'] ?? $errorCode;
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

<?php if ($Competencies == '' || str_contains($Competencies, '.')) { ?><p class="form-group select">
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
				<option <?php if ($sort == 'Year Developed') { echo ' selected'; } ?> value="Year Developed">Year Developed (newest first)</option>
				<option <?php if ($sort == 'Entry Date') { echo ' selected'; } ?> value="Entry Date">Most Recently Added</option>
				<option <?php if ($sort == 'Title') { echo ' selected'; } ?> value="Title">Title</option>
				<option <?php if ($sort == 'Presenters') { echo ' selected'; } ?> value="Presenters">Presenter</option>
			</select>
		</p>
		<p style="text-align:center;"><button type="submit">Update Results</button><br><a href="search.php" class="box">New Search</a></p>
	</form>
</div>

<div class="eight columns">
<?php include('../incl/title.html'); ?>

			<?php
			if ($count == 0) { ?>
			<p>No results found.<?php echo $errorCode !== '' ? ' (Error ' . $errorCode . ')' : ''; ?></p>
			<?php } else {
				$result_min = $start == 0 ? 1 : $start + 1;
				$result_max = $start == 0 ? 10 : $start + 10;
				$result_max = $result_max > $count ? $count : $result_max;
				$prev = $result_min != 1 ? '<a href="' . $selfLink . 'start=' . ($result_min - 10) . '" class="box" style="float:left;">&laquo; Previous</a>' : '';
				$next = $result_max != $count ? '<a href="' . $selfLink . 'start=' . ($result_max + 1) . '" class="box" style="float:right;">Next &raquo;</a>' : '';
			?>

			<p><strong><em><?php echo $conditional_text; ?></em></strong></p>
			<p id="resultCount">Displaying records <?php echo $result_min; ?> through <?php echo $result_max; ?> of <?php echo $count; ?> found.</p>

			<?php foreach ($records as $record) {
				include('results-format.php');
			} ?>

		<?php } ?>

		<p><?php echo $prev ?? ''; ?> <?php echo $next ?? ''; ?></p>
		<p style="clear:both; text-align:center;"><a href="search.php" class="box">New Search</a> <a href="/citations/" class="box"><span class="mch-heart-1" style="display: inline; position: relative; top: 3px; margin-left: 20px;"></span> View My Citations</a></p>

</div>
</div>

<script src="/citations/citations.js"></script>

<?php include('../incl/footer.html'); ?>
