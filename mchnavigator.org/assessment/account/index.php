<?php
$section = 'assessment';
$page = 'assess';
$page_title = "MCH Navigator";
$route = "assessment";
if(strpos($_SERVER["HTTP_REFERER"], "smart") !== false){
	$route = "smart";
}
// echo $route;
include ('../../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../../incl/leftnav.html'); ?>
<div class="nine columns">
<?php include('../../incl/title.html'); ?>




<div class="row">
  <div class="six columns">
	<h2><a id="register"></a><i class="icon mch-playback-play" aria-hidden="true"></i>  Register</h2>
	<p>Register to take the online self-assessment. You can answer the questions in one sitting or over the course of time. You can also take the self-assessment multiple times and track your learning across your career.</p>
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
		<p>If you are returning to the self-assessment after a break, log in here:</p>
		<p>
			<label for="email" class="b">Email Address </label>(case sensitive)<br>
			<input name="email" placeholder="Email Address" type="email" id="email" value="" required>
		</p>
		<p>
			<label for="password" class="b">Password</label>
			<a href="findPass.php"><em>forgot your password?</em></a><br>
			<input name="password" placeholder="Password" type="password" id="password" value="" required autocomplete="off">
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
			<li>If you continue to have difficulty, and the Forgot Your Password link does not work, please <a href="mailto:mchnavigator@ncemch.org">email</a> us.<br>
			</li>
		</ul>
	</div>
	</div>
</div>


</div>
</div>

<?php include('../../incl/footer.html'); ?>
