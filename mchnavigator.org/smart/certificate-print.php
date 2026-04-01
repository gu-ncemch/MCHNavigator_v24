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

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Certificate of Completion - MCHsmart | NCEMCH</title>
<style type="text/css">
	@import "https://fonts.googleapis.com/css?family=Raleway:400,400i,600,600i|Source+Sans+Pro:400,400i,600,600i";
	body{font-family:"Source Sans Pro",Helvetica,Arial,sans-serif;}
</style>
</head>
<body onload="window.pr int();">
<table width="800px" border="1" align="center" cellpadding="20" cellspacing="0">
	<tr>
		<td align="center">
			<p>This certifies that on <?php echo $record->getField('Smart_Posttest_Date'); ?> </p>
			<p><?php echo $display_name; ?></p>
			<p>has participated in the MCH Navigator's educational activity focused on the MCH Leadership Competencies titled</p>
			<h2><p class="subHeader"><img src="images/mch-smart-logo-web.png" width="799" height="179" alt="MCHsmart Online Curriculum"></p>
			</h2>
			<p>Up to 12 CPH Recertification Credits from the <a href="https://www.nbphe.org/" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://www.nbphe.org/&amp;source=gmail&amp;ust=1655394848469000&amp;usg=AOvVaw3kV06CLva4DJCFPbyz9Aii">National Board of Public Health Examiners</a> are available for completion of this curriculum as listed in the <a href="https://activityfinder.nbphe.org/" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://activityfinder.nbphe.org/&amp;source=gmail&amp;ust=1655394848469000&amp;usg=AOvVaw21SwF91tQPQTb9NwPzRP-P">CPH Activity Finder</a>. Credits may also be used to qualify you for continuing education through your employer or professional organization. Use this certificate to document completion of the curriculum. </p>
			<p><img src="../images/JRichards-Sig.png" alt="CME signature" width="286" height="93" /><br />
			<font size="2" face="Arial, Helvetica, sans-serif">John Richards<br />
			Research Professor and Executive Director,<br />
			National Center for Education in Maternal and Child Health
			<br />
			</font><font size="2" face="Arial, Helvetica, sans-serif">Georgetown University Medical Center</font></p>
			<p><font size="2" face="Arial, Helvetica, sans-serif"><span class="subHeader"><img src="images/MCHN-NCEMCH-Logos.png" width="1200" height="175" alt="MCH Navigator and NCEMCH Logos"></span><br>
		    <br>
		    </font></p>
		</td>
	</tr>
</table>
</body>
</html>