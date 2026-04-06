<?php
include("cookie.php");
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

require_once __DIR__ . '/../../filemaker/data-api.php';

// get user record
$request = array(
	'database' => 'MCH-Navigator',
	'layout' => 'SA_Users',
	'action' => 'single',
	'record' => (int) $uID,
);

$result = do_filemaker_request($request, 'array');
$recordData = $result['response']['data'][0] ?? array(
	'recordId' => (int) $uID,
	'fieldData' => array(),
);
$record = fm_record_shim($recordData);

$section = 'assessment';
$page = 'main';
$page_title = "Self Assessment";
include ('../../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
	<?php include('../../incl/leftnav.html'); ?>
	<div class="nine columns">
		<?php include('../../incl/title.html'); ?>
		<p style="float:right; margin:15px 0 15px 15px;"><a href="logout.php" class="btnesque">Logout</a></p>
		<h2>Update Your Information</h2>
		<p>Here is a summary of
			your user information.
			Use the form below to make any corrections. (* indicates required field)</p>
		<form method="post" action="edit_process.php" name="mchnav_sa" id="mchnav_sa">
			<h2>Background</h2>
			<div class="indent">
				<h3 for="name_first">First Name</h3>
				<input id="name_first" name="name_first" type="text" placeholder="First Name" value="<?php echo $record->getField('name_first'); ?>">
				
				<h3 for="name_last">Last Name</h3>
				<input id="name_last" name="name_last" type="text" placeholder="Last Name" value="<?php echo $record->getField('name_last'); ?>">
	
				<h3>Email*</h3>
				<input id="email" name="email" type="email" placeholder="Email" required value="<?php echo $record->getField('email'); ?>">

				<h3>Password*</h3>
				<input id="password" name="password" type="password" autocomplete="off" placeholder="Password" required value="<?php echo $record->getField('password'); ?>">

				<h3>Confirm Password*</h3>
				<input id="password2" name="password2" type="password" autocomplete="off" placeholder="Confirm Password" required value="<?php echo $record->getField('password'); ?>">

				<h3>State*</h3>
				<div class="select">
					<span class="arr"></span>
					<select id="state" name="state">
						<option value="">Please Select</option>
						<option value="Alabama">Alabama</option>
						<option value="Alaska">Alaska</option>
						<option value="American Samoa">American Samoa</option>
						<option value="Arizona">Arizona</option>
						<option value="Arkansas">Arkansas</option>
						<option value="California">California</option>
						<option value="Colorado">Colorado</option>
						<option value="Connecticut">Connecticut</option>
						<option value="Delaware">Delaware</option>
						<option value="District of Columbia">District of Columbia</option>
						<option value="Federated States of Micronesia">Federated States of Micronesia</option>
						<option value="Florida">Florida</option>
						<option value="Georgia">Georgia</option>
						<option value="Guam">Guam</option>
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
						<option value="Marshall Islands">Marshall Islands</option>
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
						<option value="Northern Mariana Islands ">Northern Mariana Islands </option>
						<option value="Ohio">Ohio</option>
						<option value="Oklahoma">Oklahoma</option>
						<option value="Oregon">Oregon</option>
						<option value="Palau">Palau</option>
						<option value="Pennsylvania">Pennsylvania</option>
						<option value="Puerto Rico">Puerto Rico</option>
						<option value="Rhode Island">Rhode Island</option>
						<option value="South Carolina">South Carolina</option>
						<option value="South Dakota">South Dakota</option>
						<option value="Tennessee">Tennessee</option>
						<option value="Texas">Texas</option>
						<option value="Utah">Utah</option>
						<option value="Vermont">Vermont</option>
						<option value="Virginia ">Virginia </option>
						<option value="Virgin Islands ">Virgin Islands </option>
						<option value="Washington">Washington</option>
						<option value="West Virginia">West Virginia</option>
						<option value="Wisconsin">Wisconsin</option>
						<option value="Wyoming ">Wyoming </option>
					</select>
				</div>

				<h3>Which of the following best describes you?*</h3>
				<div class="select">
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
				</div>
				<input id="you_other" name="you_other" type="text" placeholder="Other Description" class="other" value="<?php echo $record->getField('you_other'); ?>">

				<h3>How long have you worked in MCH?</h3>
				<div class="select">
					<span class="arr"></span>
					<select id="years" name="years">
						<option value="">Please Select</option>
						<option value="None/New Hire">None/New Hire</option>
						<option value="1-5 years">1-5 years</option>
						<option value="6-10 years">6-10 years</option>
						<option value="11-15 years">11-15 years</option>
						<option value="More than 15 years">More than 15 years</option>
					</select>
				</div>

				<h3>How are you using this self-assessment?</h3>
				<div class="select">
					<span class="arr"></span>
					<select id="usage" name="usage" onChange="javascript:other_usage();">
						<option value="">Please Select</option>
						<option value="individual use">individual use</option>
						<option value="part of a group">part of a group</option>
						<option value="work requirement/part of professional development">work requirement/part of professional development</option>
						<option value="Other">Other, please specify:</option>
					</select>
				</div>
				<input id="usage_other" name="usage_other" type="text" placeholder="Other Usage" class="other" value="<?php echo $record->getField('usage_other'); ?>">

				<h3 for="email">Special Group</h3>
				Please indicate if you are taking this as part of a group <br>
				<input id="special_group" name="special_group" type="text" placeholder="e.g., specific LEND program, state Title V program" value="<?php echo $record->getField('special_group'); ?>" style="max-width: 604px;">

			</div>


			<h2>Gender and Age</h2>
			<div class="indent">
				<h3></label>Gender</label></h3>
				<p>
					<input type="radio" value="Prefer to self-describe" id="self-describe" name="gender">
					<label for="self-describe"><input name="gender" value="<?php
			$genders = array("Prefer not to say", "Female", "Male", "Non-binary/ third gender", "Transgender");
			if(!in_array($record->getField('gender'), $genders)){ echo $record->getField('gender'); }
		?>" placeholder="Prefer to self-describe as" type="text" style="padding: 0;margin: 0;font-size: 1rem;border-width: 0 0 1px 0;" onclick="javascipt:$('#self-describe').prop('checked', true);"></label><br />
					<input type="radio" value="Prefer not to say" id="notSaying" name="gender">
					<label for="notSaying">Prefer not to say</label><br />
					<input type="radio" value="Female" id="Female" name="gender">
					<label for="Female">Female</label><br />
					<input type="radio" value="Male" id="Male" name="gender">
					<label for="Male">Male</label><br />
					<input type="radio" value="Non-binary/ third gender" id="Non-binary" name="gender">
					<label for="Non-binary">Non-binary/ third gender</label><br />
					<input type="radio" value="Transgender" id="Transgender" name="gender">
					<label for="Transgender">Transgender</label>
				</p>

				<h3><label>Age</label></h3>
				<p>
				<div class="select">
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
				</div>
				</p>
			</div>


			<h2>Race and Ethnicity</h2>
			<div class="indent">
				<h3>Race <em>*select all that apply</em></h3>
				<p>
					<input type="checkbox" value="American Indian or Alaska Native" id="r1" name="race[]">
					<label for="r1">American Indian or Alaska Native</label>
					<br>
					<input type="checkbox" value="Asian" id="r2" name="race[]">
					<label for="r2">Asian </label>
					<br>
					<input type="checkbox" value="Black or African American" id="r3" name="race[]">
					<label for="r3">Black or African American</label>
					<br>
					<input type="checkbox" value="Native Hawaiian/Other Pacific Islander" id="r4" name="race[]">
					<label for="r4">Native Hawaiian/Other Pacific Islander</label>
					<br>
					<input type="checkbox" value="White" id="r5" name="race[]">
					<label for="r5"> White</label>
				</p>
				<h3>Ethnicity</h3>
				<p>
					<input type="radio" value="Hispanic or Latino/a" id="e1" name="ethnicity">
					<label for="e1">Hispanic or Latino/a</label><br />
					<input type="radio" value="Not Hispanic or Latino/a" id="e2" name="ethnicity">
					<label for="e2">Not Hispanic or Latino/a</label>
				</p>
			</div>
			<!--<button type="submit">Update Information</button>-->
			<button type="button" onClick="matchPwd();">Update Information</button>
		</form>
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
		<?php
		if(in_array($record->getField('gender'), $genders)){
			?>$("#<?php echo $record->getField('gender'); ?>").prop('checked', true);
		<?php
		} else {
			?>$('#self-describe').prop('checked', true);
		<?php
		}
	?>

		$("#age").val('<?php echo $record->getField('age'); ?>');
		$("input[value='<?php echo $record->getField('ethnicity'); ?>']").prop('checked', true);

		// functions for others
		function other_you() {
			$("#you").val() == "Other" ? $("#you_other").show() : $("#you_other").hide();
		}

		function other_usage() {
			$("#usage").val() == "Other" ? $("#usage_other").show() : $("#usage_other").hide();
		}

		function matchPwd() {
			if ($("#password").val().length < 5) {
				alert('Your password is too short. Please make your password at least 5 characters long.');
				$("#password").focus();
			} else if ($("#password").val() == $("#password2").val()) {
				$("#mchnav_sa").submit();
			} else {
				alert('Your passwords do not match.');
				$("#password").focus();
			}
		}
		</script>
	</div>
</div>

<style>
h2 {
	margin-top: 2rem;
	font-weight: 700;
}

h3 {
	margin: 1.25rem 0 0;
}

input[type="radio"]+label {
	margin-right: 1rem;
}

</style>
<?php include('../../incl/footer.html'); ?>
