<?php 
$section = 'trainings';
$page = 'find';
$page_title = "Quick-Finds & Search";
include ('../incl/header.html');
?>

<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
	<?php include('../incl/leftnav.html'); ?>
	<div class="nine columns">
		<?php include('../incl/title.html'); ?>
		<div id="page_title"> <img width="240" height="100" alt="Trainings" src="../images/top-compass.jpg">
			<div class="v">
				<h1>Find Trainings</h1>
				<p>Search for Learning Opportunities by Competency or Keyword</p>
				<p>Use one  of the following searches to find competency-based trainings that address the  needs of the MCH workforce. You can access an <a href="a-z.php">Alphabetical List of Trainings</a> or take an online <a href="../assessment/index.php">Self-Assessment</a> to identify your training needs and develop a customized learning plan. </p>
				<h2>Training Topics, Primers, and Bundles</h2>
				<p>Take pre-selected trainings from our <a href="topics.php"><strong>original training primers and bundles</strong></a> such as <a href="MCH-101.php">MCH 101</a>, <a href="orientations/index.php">MCH Orientations</a>, <a href="MCH-conceptual-models.php">MCH Conceptual Models</a>, <a href="MCH-planning-cycle.php">MCH Planning Cycle</a>, <a href="communication.php">Communication</a>, <a href="epidemiology.php">Epidemiology</a>, <a href="leadership.php">Leadership</a>, and <a href="management.php">Management</a>.</p>
				<h2>Search the Database</h2>
				<p>There are 3 easy ways to find learning opportunities by searching the MCH Navigator database:</p>
				<h3>1. MCH Competencies</h3>
				<form method="get" action="results.php">
					<p>
						<select name="Competencies" id="Competencies">
							<option selected="" value=""> -- Select Competency -- </option>
							<option value="1.">MCH Knowledge Base/Context</option>
        <option value="2.">Self-Reflection</option>
        <option value="3.">Ethics</option>
        <option value="4.">Critical Thinking</option>
        <option value="5.">Communication</option>
        <option value="6.">Negotiation and Conflict Resolution</option>
        <option value="7.">Cultural Competency</option>
        <option value="8.">Family-Professional Partnerships</option>
        <option value="9.">Developing Others Through Teaching, Coaching, and Mentoring</option>
        <option value="10.">Interdisciplinary/Interprofessional Team Building</option>
        <option value="11.">Working with Communities and Systems</option>
        <option value="12.">Policy</option>
						</select>
					</p>
					<p>
						<label for="Competencies">
							<input type="submit" value="Find Learning Opportunities">
						</label>
					</p>
				</form>
				<p><a href="competencies.php">View Advanced MCH Competency Search</a></p>
				<h3>2. Public Health Competencies</h3>
				<form method="get" action="results.php">
					<p>
						<select name="PHCompetencies" id="PHCompetencies">
							<option selected="" value=""> -- Select Public Health Competency -- </option>
							<option value="1.">Analytical/Assessment Skills</option>
							<option value="2.">Policy Developmental/Program Planning Skills</option>
							<option value="3.">Communication Skills</option>
							<option value="4.">Cultural Competency</option>
							<option value="5.">Community Dimensions of Practice Skills</option>
							<option value="6.">Public Health Sciences Skill</option>
							<option value="7.">Financial Planning and Management Skills</option>
							<option value="8.">Leadership and Systems Thinking Skills</option>
						</select>
					</p>
					<p>
						<label for="PHCompetencies">
							<input type="submit" value="Find Learning Opportunities">
						</label>
					</p>
				</form>
				<p><a href="phcompetencies.php">View Advanced Public Health Competency Search</a></p>
				<h3>3. Keyword </h3>
				<form method="get" action="results.php">
					<p>
						<label for="Keyword"><strong>Keyword</strong> <em>(e.g., topic, organization)</em>:</label>
						<input type="text" value="" name="Keyword" id="Keyword">
					</p>
					<p class="adv">
						<label for="Organization"><strong>Sponsoring Organization:</strong></label>
						<input type="text" value="" name="Organization" id="Organization">
					</p>
					<p class="adv">
						<label for="Presenter"><strong>Presenter(s):</strong></label>
						<input type="text" value="" name="Presenter" id="Presenter">
					</p>
					<p class="adv">
						<label for="Training"><strong>Training Type:</strong></label>
						<select name="Training" id="Training">
							<option selected="" value=""> -- Select Training Type -- </option>
							<option value="Conference Archive">Conference Archive</option>
							<option value="Interactive Learning Tool">Interactive Learning Tool</option>
							<option value="Narrated Slide Presentation">Narrated Slide Presentation</option>
							<option value="Online Course">Online Course</option>
							<option value="Video">Video</option>
							<option value="Video Conference">Video Conference</option>
							<option value="Video Course">Video Course</option>
							<option value="Video Lecture">Video Lecture</option>
							<option value="Video Webinar">Video Webinar</option>
							<option value="Webinar Archive">Webinar Archive</option>
						</select>
					</p>
					<p class="adv"> <strong>Level:</strong>
						<input type="radio" value="Introductory" name="Level" id="Introductory">
						<label for="Introductory">Introductory</label>
						<input type="radio" value="Intermediate" name="Level" id="Intermediate">
						<label for="Intermediate">Intermediate</label>
						<input type="radio" value="Advanced" name="Level" id="Advanced">
						<label for="Advanced">Advanced</label>
					</p>
					<p class="adv"> <strong>Accessible:</strong>
						<input type="checkbox" value="Yes" name="Accessibility" id="Accessibility">
						<label for="Accessibility">Yes</label>
					</p>
					<p class="adv"> <strong>Continuing Education:</strong>
						<input type="checkbox" value="Yes" name="CE" id="CE">
						<label for="CE">Yes</label>
					</p>
					<p> <a href="javascript:keywordBasic();" class="adv">View Basic Keyword Search</a><a href="javascript:keywordAdv();" class="basic">View Advanced Keyword Search</a></p>
					<script type="text/javascript">
						function keywordBasic(){
							$(".adv").hide("fast");
							$(".basic").show("fast");
							$( ".adv input" ).prop( "disabled", true );
							$( ".adv select" ).prop( "disabled", true );
						}
						function keywordAdv(){
							$(".adv").show("fast");
							$(".basic").hide("fast");
							$( ".adv input" ).prop( "disabled", false );
							$( ".adv select" ).prop( "disabled", false );
						}
						keywordBasic();
					</script>
					<p>
						<input type="submit" value="Find Learning Opportunities">
						<input type="reset" value="Clear">
					</p>
				</form>
				<hr>
				<hr>
				<hr>
				<hr>
				<img src="../images/leadership.jpg" alt="Search by Competency and Category" class="half right">
				<hr>
				<img src="../images/leadership.jpg" alt="Search by Competency and Category" class="half right">
				<hr>
				<img src="../images/keyword.jpg" alt="Search by Keyword" class="half right">
				<hr>
				<img src="../images/train.jpg" alt="HRSA-TRAIN" class="half right">
				<p class="updated">Updated: ?? June 2014 ??</p>
			</div>
		</div>
	</div>
</div>
<?php include('../incl/footer.html'); ?>
