<?php include("../account/cookie.php");

include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
$fm      = db_connect("MCH-Navigator");
?>
<!DOCTYPE html>
<html lang="en">
<!-- InstanceBegin template="/Templates/standard.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
	<!-- InstanceBeginEditable name="doctitle" -->
	<title>Assessment | MCH Navigator</title>
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
	<?php $submenu_open = "assessment"; ?>
	<link rel="stylesheet" href="selfie.css" type="text/css" />
	<style type="text/css">
	#map {
		line-height: 0;
		width: 100%;
	}

	#map img {
		width: 12.5%;
		height: auto;
	}

	</style>
	<!-- InstanceEndEditable -->
	<style type="text/css">
	#leftnav #<?php echo $submenu_open;

	?>>a,
	#leftnav li a:hover {
		color: #fff !important;
		background-color: #681919 !important;
	}

	#<?php echo $submenu_open;

	?>a[href$="<?php echo basename(__FILE__); ?>"] {
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
				<div id="page_title">
					<!-- InstanceBeginEditable name="titleImg" --><img width="240" height="100" alt="Self-Assessment" src="../images/top-wheel.jpg"><!-- InstanceEndEditable -->
					<div class="v">
						<!-- InstanceBeginEditable name="titleText" -->
						<h1>map test</h1>
						<p>Family-Centered Care</p>
						<!-- InstanceEndEditable -->
					</div>
				</div>
				<!-- InstanceBeginEditable name="content" -->
				<?php
				// get questions
				$request = $fm->newFindCommand('SA_Responses');
				$request->addFindCriterion('uID', "=".$uID);
				$request->addSortRule('section', 1, FILEMAKER_SORT_ASCEND);
				$request->addSortRule('date', 2, FILEMAKER_SORT_DESCEND);
				$result = $request->execute();
				if (FileMaker::isError($result)) {
					#echo $result->getMessage();
				} else {
					$records = $result->getRecords();
				}
				// give the goods
				$comps = array();
				$groupingHeader = '';
				$compareHeading = '';
				foreach ($records as $record) {
					// compare types and output the heading if needed
					$compareHeading = $record->getField('section');
					if($groupingHeader != $compareHeading){
						$comps[$compareHeading] = array();
						//echo $compareHeading;
						$groupingHeader = $compareHeading;
					}
					// output it all, finally!
					array_push($comps[$compareHeading], '-');
				}
			?>
				<?php
				echo '<div id="map"><img src="//placehold.it/75">';
				for($i=1; $i<7; $i++){
					if(isset($comps[$i])){
						echo '<a href=""><img src="//placehold.it/75"></a>';
					} else if(1==2){
						echo '<img src="//placehold.it/75/990000">';
					} else{
						echo '<a href=""><img src="//placehold.it/75/009900"></a>';
					}
				}
				echo '<img src="//placehold.it/75"><br><img src="//placehold.it/75">';
				for($i=7; $i<13; $i++){
					if(isset($comps[$i])){
						echo '<a href=""><img src="//placehold.it/75"></a>';
					} else if(1==2){
						echo '<img src="//placehold.it/75/990000">';
					} else{
						echo '<a href=""><img src="//placehold.it/75/009900"></a>';
					}
				}
				echo '<img src="//placehold.it/75"></div>'; ?>
				<!-- InstanceEndEditable -->
				<p id="copyright">&copy; Georgetown University</p>
			</div>
			<!-- /content -->
			<div class="clearfix"></div>
		</div>
		<!-- /container -->
		<div class="largeonly" id="footer">
			<?php include $include_path . "/includes/footer.php"; ?>
		</div>
		<!-- /footer -->
	</div>
	<!-- /wrapper -->
	<script type="text/javascript" src="../scripts/readmore.js"></script>
	<script>
	$('#info').readmore({
		moreLink: '<a href="#">Usage, examples, and options</a>',
		collapsedHeight: 384,
		afterToggle: function(trigger, element, expanded) {
			if (!expanded) { // The "Close" link was clicked
				$('html, body').animate({
					scrollTop: $(element).offset().top
				}, {
					duration: 100
				});
			}
		}
	});
	$('article').readmore({
		speed: 500
	});
	</script>
</body>
<!-- InstanceEnd -->
</html>
