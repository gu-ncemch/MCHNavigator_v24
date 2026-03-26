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
<h2><img src="../images/telescope.jpg" alt="help" width="300" height="200" class="right border" /><i class="icon mch-star" aria-hidden="true"></i> Self-Directed Learning</h2>
<p><strong>Know what you want to learn? </strong>Use one  of the following mechanisms to find competency-based trainings that address the  needs of the MCH workforce, students, and community. </p>
<h2><i class="icon mch-scroll" aria-hidden="true"></i> Quick Finds</h2>
<p><strong>Learn based on your job function or need. </strong>Access  semi-structured <a href="topics.php">Learning Guides</a>: our original Learning Bundles, Spotlights, and Briefs.</p>
<p><strong>Explore  on your own or with guidance. </strong>You can access an <a href="a-z.php">Alphabetical List of Trainings</a> or take an online <a href="../assessment/index.php">Self-Assessment</a>. </p>
<p><strong>Learn while on-the-go. </strong>You can  learn in short bursts with one of our <a href="../microlearning/index.php">Microlearning</a> programs, including the <a href="../5min/index.php">5-Minute MCH</a>.</p>
<h2><i class="icon mch-search" aria-hidden="true"></i> Search</h2>
<p>There are 3 easy ways to find learning opportunities by searching the database of the <strong>MCH Navigator course catalog</strong>:</p>

<h3>1. Simple Search</h3>

<form method="get" action="results.php">
      <input type="text" placeholder="Keyword" name="Keyword" id="Keyword"> 
      <span style="display: block;"><a href="javascript:keywordAdv();" class="basic">View Advanced Keyword Search</a></span>

<span class="adv" style="display: none; width: 100%;">
      <input type="text" placeholder="Title" name="Title" id="Title">
      <input type="text" style="min-width: 300px;" placeholder="Sponsoring Organization" name="Organization" id="Organization">
      <input type="text" placeholder="Presenters" name="Presenter" id="Presenter">

      <h3>Training Type</h3>
      <div class="select">
      <span class="arr"></span>
      <select name="Training" id="Training">
        <option selected="" value=""> -- Select Training Type -- </option>
        <option value="Interactive Learning Tool">Interactive Learning Tool</option>
        <option value="Narrated Slide Presentation">Narrated Slide Presentation</option>
        <option value="Online Course">Online Course</option>
        <option value="Podcast">Podcast</option>
        <option value="PowerPoint Presentation">PowerPoint Presentation</option>
        <option value="Video">Video</option>
        <option value="Webinar">Webinar</option>
      </select>
	</div>
	<h3>Level</h3>
		<label for="Introductory"><input type="radio" value="Introductory" name="Level" id="Introductory"> Introductory</label>
		<label for="Intermediate"><input type="radio" value="Intermediate" name="Level" id="Intermediate"> Intermediate</label>
		<label for="Advanced"><input type="radio" value="Advanced" name="Level" id="Advanced"> Advanced</label>
	
		<span style="display: block;">Accessible: <input type="checkbox" value="Yes" name="Accessibility" id="Accessibility"> <label for="Accessibility">Yes</label></span>
		<span style="display: block;">Continuing Education: <input type="checkbox" value="Yes" name="CE" id="CE"> <label for="CE">Yes</label></span>
		<p><a href="javascript:keywordBasic();" class="adv">View Basic Keyword Search</a></p>   
</span>
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
<span style="display: block; margin: 1rem 0;">
	<input type="submit" value="Search">
	<input type="reset" value="Clear">
</span>
</form>

<div class="row">
<div class="six columns">
<h3>2. Search MCH Competencies</h3>
<form method="get" action="results.php">
<div class="select">
	<span class="arr"></span>
      <select name="Competencies" id="Competencies">
        <option selected="" value=""> -- Select Competency -- </option>
        <option value="1.">MCH Knowledge Base/Context</option>
        <option value="2.">Self-Reflection</option>
        <option value="3.">Ethics</option>
        <option value="4.">Critical Thinking</option>
        <option value="5.">Communication</option>
        <option value="6.">Negotiation and Conflict Resolution</option>
        <option value="7.">Creating Responsive and Effective MCH Systems</option>
        <option value="8.">Honoring Lived Experience</option>
        <option value="9.">Teaching, Coaching, and Mentoring</option>
        <option value="10.">Interdisciplinary/Interprofessional Team Building</option>
        <option value="11.">Systems Approach</option>
        <option value="12.">Policy</option>
      </select>
	</div>
      <label for="Competencies">
        <input type="submit" value="Find Learning Opportunities">
      </label>
  </form>
  <p><a href="competencies.php">View Advanced MCH Competency Search</a></p>
</div>
<div class="six columns">
<h3>3. Search Public Health Competencies</h3>
  <form method="get" action="results.php">
  <div class="select">
  <span class="arr"></span>
      <select name="PHCompetencies" id="PHCompetencies">
        <option selected="" value=""> -- Select Public Health Competency -- </option>
        <option value="1.">Data Analytics/Assessment Skills</option>
        <option value="2.">Policy Developmental/Program Planning Skills</option>
        <option value="3.">Communication Skills</option>
        <option value="4.">Health Outcomes Skills</option>
        <option value="5.">Community Dimensions of Practice Skills</option>
        <option value="6.">Public Health Sciences Skill</option>
        <option value="7.">Management/Financial Skills</option>
        <option value="8.">Leadership and Systems Thinking Skills</option>
      </select>
</div>
      <label for="PHCompetencies">
        <input type="submit" value="Find Learning Opportunities">
      </label>
  </form>
  <p><a href="phcompetencies.php">View Advanced Public Health Competency Search</a></p>
</div>
</div>
	
</div>
</div>

<?php include('../incl/footer.html'); ?>
