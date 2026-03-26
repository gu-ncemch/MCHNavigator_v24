<!doctype html>
<html class="no-js" lang="">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Self Assessment Report Export</title>


	<link rel="stylesheet" href="just-the-docs-default.css">
	<style>
	body {
		padding: 1rem;
	}

	textarea,
	table {
		width: 100%;
		margin: 1rem auto;
	}

	table {
		border: solid 5px #999;
		border-collapse: collapse;
	}

	td {
		border: solid 1px #ccc;
		text-align: center;
	}

	.datarow:has(input:checked[value=""]) {
		background-color: #ddd;
	}

	.datarow:has(input:checked[value="pre"]) {
		background-color: yellow;
	}

	.datarow:has(input:checked[value="post"]) {
		background-color: #66FF99;
	}

	tr.datarow label {
		margin-right: 25px;
		cursor: pointer;
	}

	</style>

</head>

<body>
	<h1>Self Assessment Report Export</h1>
	<section>
		<h2>Step 1: Emails</h2>
		<form>
			<textarea name="emails" action="" method="get" style="height:5rem;"></textarea>
			<button type="submit">get data for these emails!</button>
		</form>
	</section>

	<!--
tking@ncemch.org
tking_v4@ncemch.org
nobody@fake.com
-->


	<?php
/**
 * No emails? Stop.
 */
if( ! $_GET['emails'] ){
  exit;
}

/**
 * Connect to FM API.
 */
function do_filemaker_request( $filemaker_request, $format = 'array' ) {
  // Send a request to the API and get the response.
  $curl = curl_init( 'https://filemaker.ncemch.org/' );
  curl_setopt( $curl, CURLOPT_POSTFIELDS, $filemaker_request );
  curl_setopt($curl, CURLOPT_REFERER, $_SERVER['SERVER_NAME'] );
  curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
  $response = curl_exec( $curl );
  curl_close( $curl );

  // Send it back to the web app.
  if ( 'array' === $format ) {
    // Transform it to an associative array.
    return json_decode( $response, true );
  } elseif ( 'json' === $format ) {
    // Transform it to a JSON object.
    return json_decode( $response );
  } else {
    // Return nothing, something is wrong.
    return;
  }
}





/**
 * Get FM data.
 */
function build_request($email, $version) {

  $filemaker_request = array(
    'database' => 'MCH-Navigator',
    'layout'   => $version,
    'action'     => 'find',
    'parameters' => '{
    "query": [
            {
                "SA_Users::email": "\"' . urldecode( trim($email) ) . '\""
            }
        ],
        "sort": [
            { "fieldName": "date", "sortOrder": "ascend" }
        ]
    }',
  );

  return $filemaker_request;
}




/**
 * Loop through all emails and generate data tables.
 */
$emails = explode( PHP_EOL, $_GET['emails'] );

$tab1 = array();
$tab1[] = 'email, version, responses';

$tab2 = array();
$tab2[] = 'date, response, knowledge, skills, section, email';

foreach ($emails as $email) {

	$user_version = null;
	$user_data = null;

	$response = do_filemaker_request( build_request($email, 'SA_Responses_v45'), 'array' );
	if ( empty($response['response'])) {
		$response = do_filemaker_request( build_request($email, 'SA_Responses_v4'), 'array' );
		if ( empty($response['response'])) {
		$user_version = 'no responses from user: '.$email;
		$tab1[] = $email.', Not in database, 0';
		} else {
		$user_version = $email . ' is 4.0';
		$tab1[] = $email.', 4.0, '.$response['response']['dataInfo']['foundCount'];
		$user_data = $response['response']['data'];
		}
	} else {
		$user_version = $email . ' is 4.5';
		$tab1[] = $email.', 4.5, '.$response['response']['dataInfo']['foundCount'];
		$user_data = $response['response']['data'];
	}

	if($user_data){
		$previous_section = 9000;
		foreach ($user_data as $entry) {
		if( $entry['fieldData']['section'] == $previous_section ){
		} else {
			$previous_section = $entry['fieldData']['section'];
		}
		$tab2[] = $entry['fieldData']['date'].', '.$entry['fieldData']['response(1)'].', '.$entry['fieldData']['response_summary_knowledge'].', '.$entry['fieldData']['response_summary_skills'].', '.$entry['fieldData']['section'].', '.$entry['fieldData']['SA_Users::email'];
		}
	}

}

// output all users
echo '<h2>Results:</h2><table>';
foreach ( $tab1 as $line ) {
    echo '<tr><td>'.str_replace(", ", "</td><td>", $line).'</td></tr>'.PHP_EOL;
}
echo '</table>';




// output all raw data
echo '<table>';
foreach ( $tab2 as $key => $line ) {
    echo '<tr id="row_'.$key.'" class="datarow"><td>'.str_replace(', ', '</td><td>', $line).'</td></tr>'.PHP_EOL;
}
echo '</table>';

?>
	<script>
	function saveTextAsFile(textToWrite, fileNameToSaveAs) {
		var textFileAsBlob = new Blob([textToWrite], {
			type: 'text/plain'
		});
		var downloadLink = document.createElement("a");
		downloadLink.download = fileNameToSaveAs;
		downloadLink.innerHTML = "Download File";
		if (window.webkitURL != null) {
			// Chrome allows the link to be clicked
			// without actually adding it to the DOM.
			downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
		} else {
			// Firefox requires the link to be added to the DOM
			// before it can be clicked.
			downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
			downloadLink.onclick = destroyClickedElement;
			downloadLink.style.display = "none";
			document.body.appendChild(downloadLink);
		}
		downloadLink.click();
	}
	</script>
	<textarea id="csv" hidden><?php
foreach ( $tab2 as $line ) {
    echo $line.PHP_EOL;
}
?></textarea><br>
	<button onclick="saveTextAsFile(csv.value,'export.csv')">Download Raw Data</button>


	<hr>
	<hr>


	<script>
	// DO THAT STAT
	// let shittyArray = [];
	let userScores = {};

	function getUserData() {
		userScores = {};
		const prePostSelectAll = document.querySelectorAll('tr.datarow input:checked');
		// console.log(prePostSelectAll);
		prePostSelectAll.forEach(function(prePostSelect) {
			// prePostSelect.addEventListener('change', (event) => {
			// 	try {
			let testType = prePostSelect.value;
			let csvData = prePostSelect.parentElement.parentElement.dataset.csv.split(", ");
			let name = csvData[5];
			let section = csvData[4];
			let knowledge = csvData[2];
			let skills = csvData[3];

			if (!userScores.hasOwnProperty(name)) {
				userScores[name] = {};
			}
			if (!userScores[name].hasOwnProperty(section)) {
				userScores[name][section] = {};
			}
			userScores[name][section][testType + "_k"] = knowledge;
			userScores[name][section][testType + "_s"] = skills;
			// console.log(userScores);
			// document.getElementById("user1").value = JSON.stringify(userScores);
			// } catch (err) {
			// 	console.log('Failed.: ' + err); // Inform user if copy fails
			// }
		});
		// });
		getTotalData();
	}
	// do puke
	function getTotalData() {
		let individualTables = "";
		let userAverages = {};
		for (let i = 1; i <= 12; i++) {
			userAverages["comp_" + i] = {
				"pre_k": [],
				"post_k": [],
				"pre_s": [],
				"post_s": []
			}
		};
		// console.log(userAverages);
		// @todo don't run this on change
		// @todo highlight pre/post/no rows

		// INDIVIDUALS
		Object.keys(userScores).forEach(user => {
			datum = userScores[user];
			// console.log(user, datum);
			individualTables += "<h2>" + user + "</h2><table><tr><td>-</td><td>Pre-training knowledge</td><td>Post-training knowledge</td><td>Pre-training skills</td><td>Post-training skills</td></tr>";
			Object.keys(datum).forEach(section => {
				// console.log("comp " + section + " > ", datum[section]);
				if (datum[section]["pre_k"] != undefined) {
					userAverages["comp_" + section]["pre_k"].push(datum[section]["pre_k"]);
				}
				if (datum[section]["pre_s"] != undefined) {
					userAverages["comp_" + section]["pre_s"].push(datum[section]["pre_s"]);
				}
				if (datum[section]["post_k"] != undefined) {
					userAverages["comp_" + section]["post_k"].push(datum[section]["post_k"]);
				}
				if (datum[section]["post_s"] != undefined) {
					userAverages["comp_" + section]["post_s"].push(datum[section]["post_s"]);
				}
				individualTables += "<tr><td>comp " + section + "</td><td>" + datum[section]["pre_k"] + "</td><td>" + datum[section]["post_k"] + "</td><td>" + datum[section]["pre_s"] + "</td><td>" + datum[section]["post_s"] + "</tr></td>";
				// console.log("comp " + section + " " + datum[section]["pre_k"] + " " + datum[section]["post_k"] + " " + datum[section]["pre_s"] + " " + datum[section]["post_s"]);
			});
			individualTables += "</table>";
		});
		individualTables = individualTables.replaceAll("undefined", "0"); // @todo should this be 0 or -
		// console.log(individualTables);
		document.getElementById("individualTables").innerHTML = individualTables;
		// AVERAGES
		// console.log(userAverages);
		finalAverage = "<h2>averages</h2><table><tr><td>-</td><td>Pre-training knowledge</td><td>Post-training knowledge</td><td>Pre-training skills</td><td>Post-training skills</td></tr>";
		Object.keys(userAverages).forEach(comp => {
			datum = userAverages[comp];
			// console.log(comp, datum);
			finalAverage += "<tr><td>" + comp + "</td><td>" + calcAvg(datum["pre_k"]) + "</td><td>" + calcAvg(datum["post_k"]) + "</td><td>" + calcAvg(datum["pre_s"]) + "</td><td>" + calcAvg(datum["post_s"]) + "</tr></td>";
		});
		finalAverage += "</table>";
		// console.log(finalAverage);
		document.getElementById("finalAverage").innerHTML = finalAverage;
	}
	// calcAvg
	function calcAvg(arr) {
		if (arr.length === 0) {
			return 0; // Avoid division by zero if the array is empty
		}

		const sum = arr.reduce((total, currentValue) => total + Number(currentValue), 0);
		return Math.round(sum / arr.length * 10) / 10;
	}
	</script>

	<button onclick="getUserData()">Crunch the Numbers</button>
	<div id="individualTables"></div>
	<div id="finalAverage"></div>

</body>

</html>
