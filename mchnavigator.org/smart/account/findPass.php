<?php
$section = 'assessment';
$page = 'Password Reset';
$page_title = "Password Reset";
include ('../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../incl/nav_generic.html'); ?>
<div class="ten columns">
<?php include('../incl/title.html'); ?>	
<p>Fill in your email address below and instructions for resetting your password will be sent there.</p>
<p><em>Not receiving your password reset? Are you registered with a .edu email? If so, this password reset may not work. Please <a href="mailto:jrichards@ncemch.org">contact us</a>, and we'll personally get your password to you (please allow up to one business day for us to respond).</em></p>
<form action="findPass_process.php" method="POST" name="findPass">
	<p>E-mail Address:
		<input type="email" id="email" name="email" value="" required />
		<input type="submit" value="Recover Password" />
	</p>
</form>

</div>
</div>
</div>

<?php include('../../incl/footer.html'); ?>