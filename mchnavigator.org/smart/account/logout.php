<?php
setcookie ('mchnavsa', '', time()-50000, '/', 'www.mchnavigator.org', isset($_SERVER["HTTPS"]), true);
unset($_COOKIE['mchnavsa']);

$section = 'assessment';
$page = 'Logged Out';
$page_title = "Logged Out";
include ('../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../incl/nav_generic.html'); ?>
<div class="ten columns">
<?php include('../incl/title.html'); ?>

<p>Thank you for learning with MCHsmart. You have been logged out for now but can <a href="https://www.mchnavigator.org/smart/account/">log back in</a> and resume where you left off.</p>
<p>You may be interested in these additional MCH Leadership Competency learning resources:</p>
<p><a href="https://www.mchnavigator.org/trainings/search.php">MCH Navigator Search Page</a>: Search by competency, title, presenter, or topic.</p>
<p><a href="https://www.mchnavigator.org/trainings/a-z.php">A-Z Trainings List</a>: See an alphabetical listing of learning opportunities. You can filter by keyword at the top of the page.</p>
<p><a href="https://www.mchnavigator.org/trainings/topics.php">Training Guides</a>: Access our Core MCH Learning Guides, Topical Training Spotlights and Training Briefs.</p>

</div>
</div>
</div>

<?php include('../../incl/footer.html'); ?>
