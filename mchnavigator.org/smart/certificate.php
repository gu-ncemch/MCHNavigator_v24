<?php
include("account/cookie.php");
include_once(__DIR__ . "/../../globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'Certificate';
include ('incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
	<?php include('incl/nav_generic.html'); ?>

	<div class="ten columns">
		<div id="page_title"><img src="images/Dashboard-lightbulb-concept.jpg" alt="lightbulb and paper with pencil">
		  <div class="v">
		    <h1>Certificate</h1>
		  </div>
		</div>


<style>
#cert p {
    text-align: center;
}
</style>


<?php
include( "account/cookie.php" );
include_once(__DIR__ . "/../../globals/filemaker_init.php");
$fm = db_connect( "MCH-Navigator" );
// get user record
// echo $uID;
$record = $fm->getRecordById( 'MCH_Smart_Dashboard', $uID );

$display_name = $record->getField('name_first')." ".$record->getField('name_last');
if( $display_name == " "){ $display_name = $record->getField('email'); }
?>



			<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" id="cert">
				<tr>
					<td><p>This certifies that on <?php echo $record->getField('Smart_Posttest_Date'); ?> </p>
					  <p><?php echo $display_name; ?></p>
					  <p>has participated in the MCH Navigator's educational activity focused on the MCH Leadership Competencies titled</p>
						<h2><p class="subHeader"><strong>MCHsmart: Smart Learning for the MCH Community</strong><br />
						Self-Reflective | MCH Competency Based | Actionable | Relevant | Targeted</p></h2>
						<p>Up to 12 CPH Recertification Credits from the <a href="https://www.nbphe.org/" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://www.nbphe.org/&amp;source=gmail&amp;ust=1655394848469000&amp;usg=AOvVaw3kV06CLva4DJCFPbyz9Aii">National Board of Public Health Examiners</a> are available for completion of this curriculum as listed in the <a href="https://activityfinder.nbphe.org/" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://activityfinder.nbphe.org/&amp;source=gmail&amp;ust=1655394848469000&amp;usg=AOvVaw21SwF91tQPQTb9NwPzRP-P">CPH Activity Finder</a>. Credits may also be used to qualify you for continuing education through your employer or professional organization. Use this certificate to document completion of the curriculum. </p>
						<p><img src="../images/JRichards-Sig.png" alt="CME signature" width="286" height="93" /><br />
						<font size="2" face="Arial, Helvetica, sans-serif">John Richards<br />
						Research Professor and Executive Director,<br />
						National Center for Education in Maternal and Child Health
						<br />
					  </font><font size="2" face="Arial, Helvetica, sans-serif">Georgetown University Medical Center</font></p>
					  <p><font size="2" face="Arial, Helvetica, sans-serif"><span class="subHeader"><img src="images/MCHN-NCEMCH-Logos.png" width="1200" height="175" alt="MCH Navigator and NCEMCH Logos" /></span></font></p></td>
				</tr>
			</table>
			<p align="center"><a href="certificate-print.php" target="_blank">Print (opens in new tab/window)</a></p>
	  <h3>&nbsp;</h3>

	</div>
</div>

<?php include('incl/footer.html'); ?>