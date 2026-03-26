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
</script>

<p><strong><em>Before You Begin.</em> Please assess the importance of this competency as a whole to your work. This will help us prioritize trainings in your learning plan. No matter how you respond to this question, please answer all questions on this page. Thank you.</strong></p>

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
				<label for="<?php echo $section;?>I0"><input name="<?php echo $section;?>-I" type="radio" required id="<?php echo $section;?>I0" value="0"></label>
			</td>
			<td>
				<label for="<?php echo $section;?>I1"><input name="<?php echo $section;?>-I" type="radio" required id="<?php echo $section;?>I1" value="1"></label>
			</td>
			<td>
				<label for="<?php echo $section;?>I2"><input name="<?php echo $section;?>-I" type="radio" required id="<?php echo $section;?>I2" value="2"></label>
			</td>
			<td>
				<label for="<?php echo $section;?>I3"><input name="<?php echo $section;?>-I" type="radio" required id="<?php echo $section;?>I3" value="3"></label>
			</td>
		</tr>
	</table>


	<?php
// get questions
$request = $fm->newFindCommand('SA_Questions_v45');
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
					<input name="<?php echo $qIDname.$secondSetSuffix;?>" type="radio" required id="<?php echo $qIDname.$secondSetSuffix;?>0" value="0"></label>
			</td>
			<td>
				<label for="<?php echo $qIDname.$secondSetSuffix;?>1">
					<input name="<?php echo $qIDname.$secondSetSuffix;?>" type="radio" required id="<?php echo $qIDname.$secondSetSuffix;?>1" value="1"></label>
			</td>
			<td>
				<label for="<?php echo $qIDname.$secondSetSuffix;?>2">
					<input name="<?php echo $qIDname.$secondSetSuffix;?>" type="radio" required id="<?php echo $qIDname.$secondSetSuffix;?>2" value="2"></label>
			</td>
			<td>
				<label for="<?php echo $qIDname.$secondSetSuffix;?>3">
					<input name="<?php echo $qIDname.$secondSetSuffix;?>" type="radio" required id="<?php echo $qIDname.$secondSetSuffix;?>3" value="3"></label>
			</td>
		</tr>
	</table>
	<?php } ?>

	<h2>My Examples and Other Notes</h2>

	<p>Please make note of examples in your work that highlight your knowledge and skills in this competency:</p>
	<p><textarea name="notes"></textarea></p>
	<p><em>Note: All questions except the “My Examples” are required</em></p>
	<p><em>Save responses and continue to the next assessment below</em></p>
	<p><button class="btnesque" type="button" onclick="javascript:back2menu();">Save</button> <button class="btnesque" type="button" onclick="javascript:nextModule();">Save and Continue</button></p>
	<!-- <p><a href="#" onclick="javascript:back2menu();return false;">&laquo; Save my responses and take me back to the menu</a></p> -->

	<input type="hidden" name="pathway" id="pathway" value="">
	<input type="hidden" name="section" value="<?php echo $section; ?>">
	<input type="submit" id="submitForm" style="display:none;">
</form>
