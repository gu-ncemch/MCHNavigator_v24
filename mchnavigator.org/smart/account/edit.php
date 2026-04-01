<?php
include("cookie.php");
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache'); 
	
include_once(__DIR__ . "/../../../globals/filemaker_init.php");
$fm      = db_connect("MCH-Navigator");

// get user record
$record = $fm->getRecordById('SA_Users', $uID);
$section = 'assessment';
$page = 'Self Assessment';
$page_title = "Self Assessment";
include ('../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../incl/nav_generic.html'); ?>
<div class="ten columns">
<?php include('../incl/title.html'); ?>	

<h2>Update Your Information</h2>
<p>Here is a summary of
	your user information.
	Use the form below to make any corrections. (* indicates required field)</p>
<form method="post" action="edit_process.php" name="mchnav_sa" id="mchnav_sa">
	<h2>Background</h2>
	<div class="indent">
		<p>
			<label for="name_first">First Name<sup>*</sup></label>
			<input id="name_first" name="name_first" type="text" placeholder="First Name" required value="<?php echo $record->getField('name_first'); ?>">
		</p>

		<p>
			<label for="name_last">Last Name<sup>*</sup></label>
			<input id="name_last" name="name_last" type="text" placeholder="Last Name" required value="<?php echo $record->getField('name_last'); ?>">
		</p>

		<p>
			<label for="email">Email<sup>*</sup></label>
			<input id="email" name="email" type="email" placeholder="Email" required value="<?php echo $record->getField('email'); ?>">
		</p>

		<p>
			<label for="password">Password<sup>*</sup></label>
			<input id="password" name="password" type="password" autocomplete="off" placeholder="Password" required value="<?php echo $record->getField('password'); ?>">
		</p>

		<p>
			<label for="password2">Confirm Password<sup>*</sup></label>
			<input id="password2" name="password2" type="password" autocomplete="off" placeholder="Confirm Password" required value="<?php echo $record->getField('password'); ?>">
		</p>

		<p>
			<label for="state">State/U.S. Territory<sup>*</sup></label>
			<span class="select">
				<span class="arr"></span>	
				<select id="state" name="state">
					<option value="">Please Select</option>
					<option value="Alabama">Alabama</option>
					<option value="Alaska">Alaska</option>
					<option value="Arizona">Arizona</option>
					<option value="Arkansas">Arkansas</option>
					<option value="California">California</option>
					<option value="Colorado">Colorado</option>
					<option value="Connecticut">Connecticut</option>
					<option value="Delaware">Delaware</option>
					<option value="District of Columbia">District of Columbia</option>
					<option value="Florida">Florida</option>
					<option value="Georgia">Georgia</option>
					<option value="Hawaii">Hawaii</option>
					<option value="Idaho">Idaho</option>
					<option value="Illinois">Illinois</option>
					<option value="Indiana">Indiana</option>
					<option value="Iowa">Iowa</option>
					<option value="Kansas">Kansas</option>
					<option value="Kentucky">Kentucky</option>
					<option value="Louisiana">Louisiana</option>
					<option value="Maine">Maine</option>
					<option value="Maryland">Maryland</option>
					<option value="Massachusetts">Massachusetts</option>
					<option value="Michigan">Michigan</option>
					<option value="Minnesota">Minnesota</option>
					<option value="Mississippi">Mississippi</option>
					<option value="Missouri">Missouri</option>
					<option value="Montana">Montana</option>
					<option value="Nebraska">Nebraska</option>
					<option value="Nevada">Nevada</option>
					<option value="New Hampshire">New Hampshire</option>
					<option value="New Jersey">New Jersey</option>
					<option value="New Mexico">New Mexico</option>
					<option value="New York">New York</option>
					<option value="North Carolina">North Carolina</option>
					<option value="North Dakota">North Dakota</option>
					<option value="Ohio">Ohio</option>
					<option value="Oklahoma">Oklahoma</option>
					<option value="Oregon">Oregon</option>
					<option value="Pennsylvania">Pennsylvania</option>
					<option value="Rhode Island">Rhode Island</option>
					<option value="South Carolina">South Carolina</option>
					<option value="South Dakota">South Dakota</option>
					<option value="Tennessee">Tennessee</option>
					<option value="Texas">Texas</option>
					<option value="Utah">Utah</option>
					<option value="Vermont">Vermont</option>
					<option value="Virginia">Virginia</option>
					<option value="Washington">Washington</option>
					<option value="West Virginia">West Virginia</option>
					<option value="Wisconsin">Wisconsin</option>
					<option value="Wyoming">Wyoming</option>
				</select>
			</span>
		</p>

		<p>
			<label for="you">Which of the following best describes you?<sup>*</sup></label>
			<span class="select">
				<span class="arr"></span>
				<select id="you" name="you" onChange="javascript:other_you();">
					<option value="">Please Select</option>
					<option value="State MCH/Title V agency staff">State MCH/Title V agency staff</option>
					<option value="State Medicaid office">State Medicaid office</option>
					<option value="State governor's office/legislature">State governor's office/legislature</option>
					<option value="MCHB training grant - faculty member">MCHB training grant - faculty member</option>
					<option value="MCHB training grant - student">MCHB training grant - student</option>
					<option value="Other HRSA-funded grant">Other HRSA-funded grant</option>
					<option value="Health provider/professional">Health provider/professional</option>
					<option value="Education provider/professional">Education provider/professional</option>
					<option value="Community-based/local organization staff">Community-based/local organization staff</option>
					<option value="Family representative">Family representative</option>
					<option value="Not-for-profit organization">Not-for-profit organization</option>
					<option value="Other">Other, please specify:</option>
				</select>
			</span>
			<input id="you_other" name="you_other" type="text" placeholder="Other Description" class="other" title="Other, please specify" value="<?php echo $record->getField('you_other'); ?>">
		</p>

		<p>
			<label for="years">How long have you worked in MCH?</label>
			<span class="select">
				<span class="arr"></span>
				<select id="years" name="years">
					<option value="">Please Select</option>
					<option value="None/New Hire">None/New Hire</option>
					<option value="1-5 years">1-5 years</option>
					<option value="6-10 years">6-10 years</option>
					<option value="11-15 years">11-15 years</option>
					<option value="More than 15 years">More than 15 years</option>
				</select>
			</span>
		</p>

		<p>
			<label for="usage">How are you using this self-assessment?</label>
			<span class="select">
				<span class="arr"></span>
				<select id="usage" name="usage" onChange="javascript:other_usage();">
					<option value="">Please Select</option>
					<option value="individual use">individual use</option>
					<option value="part of a group">part of a group</option>
					<option value="work requirement/part of professional development">work requirement/part of professional development</option>
					<option value="Other">Other, please specify:</option>
				</select>
			</span>
			<input id="usage_other" name="usage_other" type="text" placeholder="Other Usage" class="other" title="Other, please specify" value="<?php echo $record->getField('usage_other'); ?>">
		</p>

		<p>
			<label for="usage">Special Group (please indicate if you are taking this as part of a group)</label>
			<input id="special_group" name="special_group" type="text" placeholder="e.g., specific LEND program, state Title V program" value="<?php echo $record->getField('special_group'); ?>">
		</p>
	</div>

	<h2>Gender and Age</h2>
	<div class="indent">
		<fieldset>
			<legend>Gender</legend>
			<label for="self-describe"><input type="radio" value="Prefer to self-describe" id="self-describe" name="gender">
			<input name="gender" value="<?php
			$genders = array("Prefer not to say", "Female", "Male", "Non-binary/ third gender", "Transgender");
			if(!in_array($record->getField('gender'), $genders)){ echo $record->getField('gender'); }
		?>" placeholder="Prefer to self-describe as" type="text" style="padding: 0;margin: 0;font-size: 1rem;border-width: 0 0 1px 0;" onclick="javascipt:$('#self-describe').prop('checked', true);"></label>
			<label for="notSaying"><input type="radio" value="Prefer not to say" id="notSaying" name="gender" checked="checked"> Prefer not to say</label>
			<label for="Female"><input type="radio" value="Female" id="Female" name="gender"> Female</label>
			<label for="Male"><input type="radio" value="Male" id="Male" name="gender"> Male</label>
			<label for="Non-binary"><input type="radio" value="Non-binary/third gender" id="Non-binary" name="gender"> Non-binary/third gender</label>
			<label for="Transgender"><input type="radio" value="Transgender" id="Transgender" name="gender">
			Transgender</label>
		</fieldset>

		<p>
			<label for="age">Age</label>
			<span class="select">
				<span class="arr"></span>
				<select id="age" name="age">
					<option value="">Please Select</option>
					<option value="0-20">0-20</option>
					<option value="21-30">21-30</option>
					<option value="31-40">31-40</option>
					<option value="41-50">41-50</option>
					<option value="51-60">51-60</option>
					<option value="61+">61+</option>
				</select>
			</span>
		</p>
	</div>

	<h2>Race and Ethnicity</h2>
	<div class="indent">
		<fieldset>
			<legend>Race <small>(select all that apply)</small></legend>
			<label for="r1"><input type="checkbox" value="American Indian or Alaska Native" id="r1" name="race[]"> American Indian or Alaska Native</label>
			<label for="r2"><input type="checkbox" value="Asian" id="r2" name="race[]"> Asian </label>
			<label for="r3"><input type="checkbox" value="Black or African American" id="r3" name="race[]"> Black or African American</label>
			<label for="r4"><input type="checkbox" value="Native Hawaiian/Other Pacific Islander" id="r4" name="race[]"> Native Hawaiian/Other Pacific Islander</label>
			<label for="r5"><input type="checkbox" value="White" id="r5" name="race[]"> White</label>
		</fieldset>

		<fieldset>
			<legend>Ethnicity</legend>
			<label for="e1"><input type="radio" value="Hispanic or Latino/a" id="e1" name="ethnicity"> Hispanic or Latino/a</label>
			<label for="e2"><input type="radio" value="Not Hispanic or Latino/a" id="e2" name="ethnicity"> Not Hispanic or Latino/a</label>
		</fieldset>
	</div>
	<!--<button type="submit">Update Information</button>-->
	<button type="button" class="button orange" onClick="matchPwd();">Update Information</button>
</form>
<style type="text/css">.other{display: none;}</style>
<script>
	// setup selects and groups
	$("#state").val('<?php echo $record->getField('state'); ?>');
	$("#you").val('<?php echo $record->getField('you'); ?>');
	<?php 
		if($record->getField('you') == "Other"){
			echo '$("#you_other").show();';
		}
		if($record->getField('usage') == "Other"){
			echo '$("#usage_other").show();';
		}
		$racebits = explode(chr(10), $record->getField('race'));
		foreach($racebits as $r){
			echo '$("input[value=\''.$r.'\']").prop("checked", true);';
		}
	?>
	$("#years").val('<?php echo $record->getField('years'); ?>');
	$("#usage").val('<?php echo $record->getField('usage'); ?>');
	$("#<?php echo $record->getField('gender'); ?>").prop('checked', true);
	$("#age").val('<?php echo $record->getField('age'); ?>');
	$("input[value='<?php echo $record->getField('ethnicity'); ?>']").prop('checked', true);
	
	// functions for others
	function other_you(){
		$("#you").val() == "Other" ? $("#you_other").show() : $("#you_other").hide();
	}
	function other_usage(){
		$("#usage").val() == "Other" ? $("#usage_other").show() : $("#usage_other").hide();
	}
	<?php
		if(in_array($record->getField('gender'), $genders)){
			?>$("#<?php echo $record->getField('gender'); ?>").prop('checked', true);<?php
		} else {
			?>$('#self-describe').prop('checked', true);<?php
		}
	?>
	function matchPwd(){
		if($("#password").val().length < 5){
			alert('Your password is too short. Please make your password at least 5 characters long.');
			$("#password").focus();
		} else if($("#password").val() == $("#password2").val()){
			$("#mchnav_sa").submit();
		} else{
			alert('Your passwords do not match.');
			$("#password").focus();
		}
	}
</script> 
</div>
</div>
</div>

<?php include('../../incl/footer.html'); ?>