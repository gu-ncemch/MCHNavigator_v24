<?php
$section = 'assessment';
$page = 'MCH Navigator';
$page_title = "Access MCHsmart";
$route = "assessment";
if(strpos($_SERVER["HTTP_REFERER"], "smart") !== false){
	$route = "smart";
}
// echo $route;
include ('../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../incl/nav_generic.html'); ?>
<div class="ten columns">
<?php include('../incl/title.html'); ?>




<div class="row">
  <div class="six columns">
	<h2><a id="register"></a><i class="icon mch-playback-play" aria-hidden="true"></i>  Register</h2>
	<p>Sign up to take the free MCHsmart  curriculum and access resources. There will be three components of the course: (1) <strong>Self-Reflection</strong>, where you reflect on what you alreadky know about the MCH Leadership Competencies through a pre-test; (2) <strong>Learning</strong>, where you have the opportunity to explore the MCH Leadership Competencies as deeply as you'd like through a series of self-paced modules; and (3) <strong>Sharing</strong>, where you test your recent learning, share  thoughts and insights about what you have learned, and provide feedback on the entire curriculum. </p>
	<p>The course is self-paced, so you can take as much time as you need. At the end, you will be able to print a certificate of completion for your records or to satisfy school/work requirements.	</p>
	<p><strong>Note, if you have previously registered for the MCH Navigator's Self-Assessment, you are automatically registered for MCHsmart. You can log in to the right</strong></p>
	<p>
	  <button onClick="window.location.href='register.php';" type="button">Register</button>
		<?php if (isset($_SESSION['MCHloginError'])) {
			  echo "<p align=\"center\"><font color=\"#990000\">" . $_SESSION['MCHloginError'] . "</font></p>" ;
			  $_SESSION['MCHloginError'] = null;
		   } //end if
		?>
	</p>
	</div>
	<div class="six columns">
	<form action="login.php" method="POST" name="mchnav_login" class="half" id="loginrequired">
			<input name="route" type="hidden" value="<?php echo $route; ?>">
		<h2><i class="icon mch-playback-play" aria-hidden="true"></i> Log In</h2>
		<p>If you are returning to the MCHsmart curriculum after a break or have already registered for the MCH Navigator Self-Assessment, log in here:</p>
		<p>
			<label for="email" class="b">Email Address <small>(case sensitive)</small></label>
			<input name="email" placeholder="Email Address" type="email" id="email" value="" required>
		</p>
		<p>
			<label for="password" class="b">Password</label>
			<input name="password" placeholder="Password" type="password" id="password" value="" required autocomplete="off"><br>
			<a href="findPass.php"><em>forgot your password?</em></a>
		<p>
			<input type="submit" value="Log In">
			<a href="javascript:$('#helpmsg').toggle();void(0);"><em>Log-In Help</em></a></p>
	</form>
	<div class="clearfix"></div>
	<div id="helpmsg" style="display:none;">
		<h3>Log-In Help</h3>
		<ul>
			<li>Don't forget that the field for your email address is case sensitive. If you are having difficulty, try using all caps or an initial capital letter, since these are errors that occur often.<br>
			</li>
			<li>If you continue to have difficulty, and the Forgot Your Password link does not work, please <a href="mailto:jrichards@ncemch.org">email</a> us.<br>
			</li>
		</ul>
	</div>
	</div>
</div>


</div>
</div>
</div>

<?php include('../../incl/footer.html'); ?>
