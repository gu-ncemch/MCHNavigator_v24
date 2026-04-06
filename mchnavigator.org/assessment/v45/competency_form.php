<p align="center"><img src="maps/map-<?php echo $section; ?>.svg" alt="Jump to a competency." usemap="#Map" border="0" id="shipmap" style="max-width: 809px; border: none;" /></p>
<map name="Map" id="Map">
	<area shape="circle" coords="34,34,36" href="individual-assessments.php" alt="Menu" />
	<area shape="circle" coords="70,90,26" href="competency_01.php<?php echo $urlappend; ?>" alt="Competency 1: MCH Knowledge Base/Context" />
	<area shape="circle" coords="137,66,26" href="competency_02.php<?php echo $urlappend; ?>" alt="Competency 2: Self-Reflection" />
	<area shape="circle" coords="199,28,26" href="competency_03.php<?php echo $urlappend; ?>" alt="Competency 3: Ethics and Professionalism" />
	<area shape="circle" coords="268,41,26" href="competency_04.php<?php echo $urlappend; ?>" alt="Competency 4: Critical Thinking" />
	<area shape="circle" coords="298,95,26" href="competency_05.php<?php echo $urlappend; ?>" alt="Competency 5: Communication" />
	<area shape="circle" coords="369,90,26" href="competency_06.php<?php echo $urlappend; ?>" alt="Competency 6: Negotiation and Conflict Resolution" />
	<area shape="circle" coords="441,92,26" href="competency_07.php<?php echo $urlappend; ?>" alt="Competency 7: Diversity, Equity, Inclusion, and Accessibility" />
	<area shape="circle" coords="423,23,26" href="competency_08.php<?php echo $urlappend; ?>" alt="Competency 8: Family-Centered Care" />
	<area shape="circle" coords="501,32,26" href="competency_09.php<?php echo $urlappend; ?>" alt="Competency 9: Developing Others Through Teaching and Mentoring" />
	<area shape="circle" coords="577,25,26" href="competency_10.php<?php echo $urlappend; ?>" alt="Competency 10: Interdisciplinary Team Building" />
	<area shape="circle" coords="637,53,26" href="competency_11.php<?php echo $urlappend; ?>" alt="Competency 11: Systems Approach" />
	<area shape="circle" coords="688,97,26" href="competency_12.php<?php echo $urlappend; ?>" alt="Competency 12: Policy and Advocacy" />
	<area shape="circle" coords="773,75,38" href="learning-plan.php" alt="Your Personalized Learning Plan" />
</map>
<script src="../assets/jquery.rwdImageMaps.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(e) {
	$('img[usemap]').rwdImageMaps();
});

function nextModule() {
	$("#pathway").val("full");
	$("#submitForm").trigger('click');
}

function back2menu() {
	$("#pathway").val("single");
	$("#submitForm").trigger('click');
}

function setupAssessmentKeyboardNavigation() {
	var form = document.querySelector('form[name^="competency_"]');
	if (!form) {
		return;
	}

	var radios = Array.prototype.slice.call(form.querySelectorAll('input[type="radio"]'));
	if (!radios.length) {
		return;
	}

	var groupNames = [];
	var groups = {};

	radios.forEach(function(radio) {
		if (!groups[radio.name]) {
			groups[radio.name] = [];
			groupNames.push(radio.name);
		}
		groups[radio.name].push(radio);
	});

	function focusNextTarget(groupIndex) {
		var nextGroupName = groupNames[groupIndex + 1];
		if (nextGroupName && groups[nextGroupName] && groups[nextGroupName][0]) {
			groups[nextGroupName][0].focus();
			return true;
		}

		var notes = form.querySelector('textarea[name="notes"]');
		if (notes) {
			notes.focus();
			return true;
		}

		return false;
	}

	function focusPreviousTarget(groupIndex) {
		var previousGroupName = groupNames[groupIndex - 1];
		if (previousGroupName && groups[previousGroupName] && groups[previousGroupName].length) {
			groups[previousGroupName][groups[previousGroupName].length - 1].focus();
			return true;
		}

		return false;
	}

	radios.forEach(function(radio) {
		radio.addEventListener('keydown', function(event) {
			var groupIndex = groupNames.indexOf(radio.name);
			var group = groups[radio.name] || [];
			var optionIndex = group.indexOf(radio);

			if (event.key === 'Tab') {
				if (event.shiftKey) {
					if (optionIndex > 0) {
						event.preventDefault();
						group[optionIndex - 1].focus();
					} else if (focusPreviousTarget(groupIndex)) {
						event.preventDefault();
					}
				} else {
					if (optionIndex < group.length - 1) {
						event.preventDefault();
						group[optionIndex + 1].focus();
					} else if (focusNextTarget(groupIndex)) {
						event.preventDefault();
					}
				}
			}

			if (event.key === ' ' || event.key === 'Spacebar' || event.key === 'Enter') {
				event.preventDefault();
				radio.checked = true;
				radio.dispatchEvent(new Event('change', { bubbles: true }));
				focusNextTarget(groupIndex);
			}
		});
	});
}

$(document).ready(function() {
	setupAssessmentKeyboardNavigation();
});
</script>

<p><strong><em>Before You Begin.</em> Please assess the importance of this competency as a whole to your work. This will help us prioritize trainings in your learning plan. No matter how you respond to this question, please answer all questions on this page. Thank you.</strong></p>
<p id="assessment-keyboard-help"><strong>Keyboard help:</strong> Use <kbd>Tab</kbd> and <kbd>Shift</kbd>+<kbd>Tab</kbd> to move through answer choices. Press <kbd>Space</kbd> or <kbd>Enter</kbd> to select an answer and move to the next question.</p>

<?php
if ( ! function_exists('v45_repeat_value')) {
	function v45_repeat_value( $row, $field, $index ) {
		$fieldData = $row['fieldData'] ?? array();
		$value = $fieldData[$field] ?? '';
		if ( is_array( $value ) ) {
			return $value[$index] ?? '';
		}
		$repeatKey = $field . '(' . ($index + 1) . ')';
		if (array_key_exists($repeatKey, $fieldData)) {
			return $fieldData[$repeatKey];
		}
		return $index === 0 ? $value : '';
	}
}

$savedResponses = array();
$savedNotes = '';

$savedRequest = array(
	'database' => 'MCH-Navigator',
	'layout' => 'SA_Responses_v45',
	'action' => 'find',
	'parameters' => array(
		'query' => array(
			array(
				'uID' => '=' . (int) $uID,
				'section' => '=' . (int) $section,
			),
		),
		'sort' => array(
			array(
				'fieldName' => 'date',
				'sortOrder' => 'descend',
			),
		),
		'limit' => 1,
	),
);
$savedResult = do_filemaker_request($savedRequest, 'array');

if ((int) ($savedResult['messages'][0]['code'] ?? 500) === 0 && !empty($savedResult['response']['data'][0])) {
	$savedRecord = $savedResult['response']['data'][0];
	$savedNotes = $savedRecord['fieldData']['notes'] ?? '';
	for ($i = 0; $i <= 30; $i++) {
		$responseId = v45_repeat_value($savedRecord, 'responseID', $i);
		$responseType = v45_repeat_value($savedRecord, 'responseType', $i);
		$responseValue = v45_repeat_value($savedRecord, 'response', $i);
		if ($responseId !== '' && $responseType !== '') {
			$savedResponses[$responseId . '-' . $responseType] = (string) $responseValue;
		}
	}
}
?>

<form method="post" action="competency_save.php" name="competency_<?php echo $section; ?>">


	<table class="asstable">
		<tr>
			<th scope="col">&nbsp;</th>
			<th scope="col" class="asscale">None</th>
			<th scope="col" class="asscale">Low</th>
			<th scope="col" class="asscale">Medium</th>
			<th scope="col" class="asscale">High</th>
		</tr>
		<tr>
			<td><strong>Importance</strong></td>
			<td>
				<label for="<?php echo $section;?>I0"><input name="<?php echo $section;?>-I" type="radio" required id="<?php echo $section;?>I0" value="0" <?php echo (($savedResponses[$section . '-I'] ?? '') === '0') ? 'checked' : ''; ?>></label>
			</td>
			<td>
				<label for="<?php echo $section;?>I1"><input name="<?php echo $section;?>-I" type="radio" required id="<?php echo $section;?>I1" value="1" <?php echo (($savedResponses[$section . '-I'] ?? '') === '1') ? 'checked' : ''; ?>></label>
			</td>
			<td>
				<label for="<?php echo $section;?>I2"><input name="<?php echo $section;?>-I" type="radio" required id="<?php echo $section;?>I2" value="2" <?php echo (($savedResponses[$section . '-I'] ?? '') === '2') ? 'checked' : ''; ?>></label>
			</td>
			<td>
				<label for="<?php echo $section;?>I3"><input name="<?php echo $section;?>-I" type="radio" required id="<?php echo $section;?>I3" value="3" <?php echo (($savedResponses[$section . '-I'] ?? '') === '3') ? 'checked' : ''; ?>></label>
			</td>
		</tr>
	</table>


<?php
// get questions
$request = array(
	'database' => 'MCH-Navigator',
	'layout' => 'SA_Questions_v45',
	'action' => 'find',
	'parameters' => array(
		'query' => array(
			array(
				'section' => (string) ((int) $section),
			),
		),
		'sort' => array(
			array(
				'fieldName' => 'type',
				'sortOrder' => 'ascend',
			),
			array(
				'fieldName' => 'order',
				'sortOrder' => 'ascend',
			),
		),
		'limit' => 100,
	),
);
$result = do_filemaker_request($request, 'array');
$records = array();
if ((int) ($result['messages'][0]['code'] ?? 500) !== 0) {
	echo $result['messages'][0]['message'] ?? 'Error loading questions.';
} else {
	foreach ($result['response']['data'] as $row) {
		$records[] = fm_record_shim($row);
	}
}
// give the goods
$secondSet = "Knowledge";
$secondSetSuffix = "-K";
$groupingHeader = '';
$compareHeading = '';
$subgroupingHeader = '';
$comparesubHeading = '';
foreach ($records as $record) {
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
		if($comparesubHeading == 'F'){
			echo "<h3>Foundational</h3>";
		} else if($comparesubHeading == 'A') {
			echo "<h3>Advanced</h3>";
		}
		$subgroupingHeader = $comparesubHeading;
	}
	// isolate the id
	$qID = $record->getField('qID');
	#$qIDname = str_replace(".","",$qID);
	$qIDname = $qID;
	// output it all, finally!
	echo "<p class=\"compQ\"><strong>".$qID."</strong> ".$record->getField('text')."</p>";
	?>
	<table class="asstable">
		<tr>
			<th scope="col">&nbsp;</th>
			<th scope="col" class="asscale">None</th>
			<th scope="col" class="asscale">Low</th>
			<th scope="col" class="asscale">Medium</th>
			<th scope="col" class="asscale">High</th>
		</tr>
		<!-- 	<tr>
		<td><strong>Importance</strong></td>
		<td>
			<label for="<?php echo $qIDname;?>I0"><input name="<?php echo $qIDname;?>-I" type="radio" required id="<?php echo $qIDname;?>I0" value="0"></label>
		</td>
		<td>
			<label for="<?php echo $qIDname;?>I1"><input name="<?php echo $qIDname;?>-I" type="radio" required id="<?php echo $qIDname;?>I1" value="1"></label>
		</td>
		<td>
			<label for="<?php echo $qIDname;?>I2"><input name="<?php echo $qIDname;?>-I" type="radio" required id="<?php echo $qIDname;?>I2" value="2"></label>
		</td>
		<td>
			<label for="<?php echo $qIDname;?>I3"><input name="<?php echo $qIDname;?>-I" type="radio" required id="<?php echo $qIDname;?>I3" value="3"></label>
		</td>
	</tr> -->
		<tr>
			<td>
				<strong><?php echo $secondSet; ?></strong>
			</td>
			<td>
				<label for="<?php echo $qIDname.$secondSetSuffix;?>0">
					<input name="<?php echo $qIDname.$secondSetSuffix;?>" type="radio" required id="<?php echo $qIDname.$secondSetSuffix;?>0" value="0" <?php echo (($savedResponses[$qIDname.$secondSetSuffix] ?? '') === '0') ? 'checked' : ''; ?>></label>
			</td>
			<td>
				<label for="<?php echo $qIDname.$secondSetSuffix;?>1">
					<input name="<?php echo $qIDname.$secondSetSuffix;?>" type="radio" required id="<?php echo $qIDname.$secondSetSuffix;?>1" value="1" <?php echo (($savedResponses[$qIDname.$secondSetSuffix] ?? '') === '1') ? 'checked' : ''; ?>></label>
			</td>
			<td>
				<label for="<?php echo $qIDname.$secondSetSuffix;?>2">
					<input name="<?php echo $qIDname.$secondSetSuffix;?>" type="radio" required id="<?php echo $qIDname.$secondSetSuffix;?>2" value="2" <?php echo (($savedResponses[$qIDname.$secondSetSuffix] ?? '') === '2') ? 'checked' : ''; ?>></label>
			</td>
			<td>
				<label for="<?php echo $qIDname.$secondSetSuffix;?>3">
					<input name="<?php echo $qIDname.$secondSetSuffix;?>" type="radio" required id="<?php echo $qIDname.$secondSetSuffix;?>3" value="3" <?php echo (($savedResponses[$qIDname.$secondSetSuffix] ?? '') === '3') ? 'checked' : ''; ?>></label>
			</td>
		</tr>
	</table>
	<?php } ?>

	<h2>My Examples and Other Notes</h2>

	<p>Please make note of examples in your work that highlight your knowledge and skills in this competency:</p>
	<p><textarea name="notes"><?php echo htmlspecialchars($savedNotes, ENT_QUOTES, 'UTF-8'); ?></textarea></p>
	<p><em>Note: All questions except the “My Examples” are required</em></p>
	<p><em>Save responses and continue to the next assessment below</em></p>
	<p><button class="btnesque" type="button" onclick="javascript:back2menu();">Save</button> <button class="btnesque" type="button" onclick="javascript:nextModule();">Save and Continue</button></p>
	<!-- <p><a href="#" onclick="javascript:back2menu();return false;">&laquo; Save my responses and take me back to the menu</a></p> -->

	<input type="hidden" name="pathway" id="pathway" value="">
	<input type="hidden" name="section" value="<?php echo $section; ?>">
	<input type="submit" id="submitForm" style="display:none;">
</form>
