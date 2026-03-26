<!doctype html>
<html class="no-js" lang="">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Assesserella 4,000</title>


	<link rel="stylesheet" href="just-the-docs-default.css">

</head>

<body>
	<h1>Assesserella 4,000</h1>
	<a href="spreadsheet.php" id="other-step">Upload Spreadsheet</a>
	<section>
		<h2>Check Emails</h2>
		<p>One per line:</p>
		<form>
			<textarea name="emails" action="" method="get" style="height:5rem;"></textarea>
			<button type="submit">Assesserellinate These Emails!</button>
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
$tab2[] = 'date, importance, response_summary_knowledge, response_summary_skills, section, SA_Users::email';

foreach ($emails as $email) {

	$user_version = null;
	$user_data = null;

	$response = do_filemaker_request( build_request($email, 'SA_Responses_v4'), 'array' );
	if ( empty($response['response'])) {
		// $response = do_filemaker_request( build_request($email, 'SA_Responses_v4'), 'array' );
		// if ( empty($response['response'])) {
		$user_version = 'no responses from user: '.$email;
		$tab1[] = $email.', Not in database, 0';
		// } else {
		// $user_version = $email . ' is 4.0';
		// $tab1[] = $email.', 4.0, '.$response['response']['dataInfo']['foundCount'];
		// $user_data = $response['response']['data'];
		// }
	} else {
		$user_version = $email . ' is 4.0';
		$tab1[] = $email.', 4.0, '.$response['response']['dataInfo']['foundCount'];
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


</body>

</html>
