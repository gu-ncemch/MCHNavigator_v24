<?php
setcookie ('mchnavsa', '', time()-50000, '/', 'www.mchnavigator.org', isset($_SERVER["HTTPS"]), true);
unset($_COOKIE['mchnavsa']);

$section = 'assessment';
$page = 'competency';
$page_title = "Logged Out";
include ('../../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../../incl/leftnav.html'); ?>
<div class="nine columns">
<?php include('../../incl/title.html'); ?>

<p>Thank you for taking the MCH Navigator self-assessment. You have been logged out for now but can <a href="index.php">log back in</a> and resume where you left off.</p>
<p>Other resources that you may be interested in:</p>
<p><a href="../trainings/search.php">Search Page</a>: search by competency, title, presentor, or topic.</p>
<p><a href="../trainings/a-z.php">A-Z List</a>: see an alphabetical listing of learing opportunities. You can filter by keyword at the top of the page.</p>
<p><a href="../trainings/topics.php">Training Bundles</a>: access our core MCH bundels, Training Spotlights, Training Briefs, and Training Lists.</p>

</div>
</div>

<?php include('../../incl/footer.html'); ?>
