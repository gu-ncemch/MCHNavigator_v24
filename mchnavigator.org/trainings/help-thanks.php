<!DOCTYPE html>
<html lang="en"><!-- InstanceBegin template="/Templates/standard.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>How To Use and Help | A Training Portal for MCH Professionals</title>
<!-- InstanceEndEditable -->
<!-- meta -->
<?php
	$include_path = "/home/dh_mch_sftp/mchnavigator.org";
?>
<?php $submenu_open = "mch"; ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><![endif]-->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="apple-touch-icon" href="/apple-touch-icon.png" />

<!-- CSS ================================================== -->
<link rel="stylesheet" href="../css/style.css" type="text/css" />
<?php if(basename(__FILE__) != "results.php"){ ?>
<link rel="stylesheet" href="../css/addthis.css" type="text/css" />
<?php } ?>
<link rel="stylesheet" href="../css/responsive.css" type="text/css" />
<link rel="stylesheet" href="../fonts/fonts.css">
<!--[if lt IE 9 ]>
<link rel="stylesheet" href="/css/ie.css" type="text/css" />
<![endif]-->

<!-- JS ================================================== -->
<script src="https://cdn.ncemch.org/js/jquery/jquery.min.js"></script>

<!-- Any other stuff ================================================== -->
<!-- InstanceBeginEditable name="head" -->
<?php $submenu_open = "trainings"; ?>
<!-- InstanceEndEditable -->
<style type="text/css">
#leftnav #<?php echo $submenu_open;
?> > a, #leftnav li a:hover {
 color: #fff !important;
 background-color: #681919 !important;
}
#<?php echo $submenu_open;
?> a[href$="<?php echo basename(__FILE__); ?>"] {
 background-color: #AD9F9F !important;
}
</style>

</head>
<body class="vertical">
<a class="accessible" href="#main">[Skip to Content]</a>
<div id="branding">
	<div class="restrain"><a href="http://www.georgetown.edu/" id="gu">Georgetown University</a> <a href="http://healthinfogroup.org/">Health Information Group</a> | <a href="http://ncemch.org/">NCEMCH</a> </div>
</div>
<div id="wrapper">
	<div class="container">
		<div id="header"> <a href="http://www.mchnavigator.org/index.php" id="main_logo"><img src="../images/main_logo.png" alt="MCH Navigator"></a><img src="../images/funded.png" alt="Funded by the U.S. Maternal &amp; Child Health Bureau" id="funded">
			<div class="clearfix"></div>
		</div>
		<!-- /header -->
		<div id="topnav">
			<?php include $include_path . "/includes/topnav.php"; ?>
		</div>
		<div id="leftnav" class="largeonly">
			<?php include $include_path . "/includes/leftnav.php"; ?>
		</div>
		<div id="menu_bttn" class="smallonly"> <a href="javascript:void(0);" onClick="javascript:$('#leftnav').toggle('fast');return false;"><span class="icon icon-reorder"></span>Menu</a> </div>
		<!-- /leftnav -->
		<div id="content"><a id="main"></a>
			<div id="page_title"> <!-- InstanceBeginEditable name="titleImg" --><img width="240" height="100" alt="Trainings" src="../images/top-compass.jpg"><!-- InstanceEndEditable -->
				<div class="v"> <!-- InstanceBeginEditable name="titleText" -->
				  <h1>Help</h1>
				<p>Having Problems with this Site or the Learning Opportunities?</p>
		  <p><img src="../images/thanks-1.jpg" alt="Thanks" class="right border"><strong>Thank you for submitting your help request! </strong>We're sorry that you are having issues with our website or with learning opportunities that we have collected. A staff member will be in touch with you soon to answer your question.</p>
		  <p>In the meantime, here are some links that might be useful:</p>
		  <h2>Additional Resources</h2>
		  <ul>
		    <li>Please take a look at our <a href="topics.php">Training Topics</a> for hand-selected learning opportunities on a wide range of MCH competencies and topics.</li>
		    <li>For resources on a wide spectrum of MCH topics, please visit the <a href="http://www.ncemch.org">National Center for Education in Maternal and Child Health</a> at Georgeotwn Univeristy.</li>
		  </ul>
		  <hr>
          <p class="updated">Updated: January 2014</p>
	   </div>
</div>

<?php include('../incl/footer.html'); ?>
