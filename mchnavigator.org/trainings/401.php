<?php
header("HTTP/1.0 404 Not Found");
$section = 'trainings';
$page = 'training';
$page_title = "Training Not Found";
include ('../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../incl/leftnav.html'); ?>
<div class="nine columns">
<?php include('../incl/title.html'); ?>	

<p>We suggest you try one of the links below:</p>
<ul>
	<li><a href="/trainings/">Trainings</a></li>
	<li><a href="/trainings/search.php">Trainings Search</a></li>
	<li><a href="/trainings/a-z.php">A-Z Trainings</a></li>
	<li><a href="/">MCH Navigator Home Page</a></li>
	<li><a href="/connect/contact.php">Contact Us</a></li>
</ul>

</div>
</div>

<?php include('../incl/footer.html'); ?>