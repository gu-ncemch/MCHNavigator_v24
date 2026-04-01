<?php
	// session_start();
	// $myCitations = $_SESSION['myCitations'];
	if (!isset($_COOKIE['NavCitations']) || unserialize($_COOKIE['NavCitations']) == false) {
		$myCitations = array();
		setcookie('NavCitations', '', time()+(86400 * 365), '/');
	} else {
		$myCitations = unserialize($_COOKIE['NavCitations']);
	}
	// echo 'cookie = '.$_COOKIE['NavCitations'].'<br>array = ';
	// echo $myCitations;
	// print_r($myCitations);
	// print_r($_COOKIE);
?>



<?php 
$section = 'trainings';
$page = 'index';
$page_title = "My Citations";
include ('../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
	<?php include('../incl/leftnav.html'); ?>
	<div class="nine columns">
		<?php include('../incl/title.html'); ?>	



		<?php /* SETUP */
			include_once(__DIR__ . "/../../globals/filemaker_init.php");
			$fm = db_connect("MCH-Navigator");

			foreach ($myCitations as $id) {
				$find = $fm->newFindCommand('Navigator');
				$find->addFindCriterion('Record Number', $id);
				$result = $find->execute();

				if (!FileMaker::isError($result)) {
					$record = $result->getFirstRecord();
					include ('../trainings/results-format.php');
				} else {
					echo "ERROR: ".$result->code;
					// header("Location: http://mchnavigator.org/a-z.php");
					// readfile ('401.php');
					// exit;
				}
			}
		?>

		<p class="record">
			<?php if(sizeof($myCitations) > 0){ ?>
				<a href="#" class="purge">Clear All Citations</a>
			<?php } ?>
		</p>
		<p style="clear:both; text-align:center;"><a href="/trainings/search.php">Search Trainings</a></p>
		
		<script>citationsPage = true;</script>
		<script src="citations.js"></script>











	</div>
</div>
<?php include('../incl/footer.html'); ?>