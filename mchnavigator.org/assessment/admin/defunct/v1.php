<style>
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

</style>

<form>
	<textarea name="emails" action="" method="get" style="height:5rem;">ainsleytorres@berkeley.edu</textarea>
	<button type="submit">get that data!</button>
</form>

<!-- tking@ncemch.org
		tking_v4@ncemch.org
		nobody@fake.com -->


<?php

if( ! $_GET['emails'] ){
  exit;
}

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






// $emails = array ("tking@ncemch.org","tking_v4@ncemch.org","nobody@void.zip");
// $emails = array ("tking_v4@ncemch.org");
$emails = explode( PHP_EOL, $_GET['emails'] );

$tab1 = array();
$tab1[] = 'email, version, responses';
// count of reords

$tab2 = array();
$tab2[] = 'date, response, response_summary_knowledge, response_summary_skills, section, uID, SA_Users::email, attempt';

foreach ($emails as $email) {

  $user_version = null;
  $user_data = null;

  // print_r($filemaker_request);
  $response = do_filemaker_request( build_request($email, 'SA_Responses_v45'), 'array' );
  // print_r($response);
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





  // $tab2[] = 'date, response, response_summary_knowledge, response_summary_skills, section uID, SA_Users::email';
  if($user_data){
    // print_r($user_data);
    $previous_section = 9000;
    $attempt = 1;
    foreach ($user_data as $entry) {
      // print_r($entry);
      // echo "section ".$entry['fieldData']['section']." -- on > ".$entry['fieldData']['date'].PHP_EOL;
      // echo "K= ".$entry['fieldData']['response_summary_knowledge'].PHP_EOL;
      // echo "S= ".$entry['fieldData']['response_summary_skills'].PHP_EOL;
      if( $entry['fieldData']['section'] == $previous_section ){
        $attempt++;
      } else {
        $previous_section = $entry['fieldData']['section'];
        $attempt = 1;
      }
      $tab2[] = $entry['fieldData']['date'].', '.$entry['fieldData']['response(1)'].', '.$entry['fieldData']['response_summary_knowledge'].', '.$entry['fieldData']['response_summary_skills'].', '.$entry['fieldData']['section'].', '.$entry['fieldData']['uID'].', '.$entry['fieldData']['SA_Users::email'].', '.$attempt;
      // ...iterations
      // it's time to either find a graphing js/php solution or go to excel and see what it needs to build a chart
    }
  }



  /*

    export all iterations and stop calling them pre/post; but grouping them by date? what if it is 2-3 days?

  export "raw data" for keisha but not to share

another file with tabs is
should also do a chart for each student of pre / post / skill / knowledge
AND a running total of all of them
*/
}

echo '<table>';
foreach ( $tab1 as $line ) {
    // $val = explode(",", $line);
    // fputcsv($fp, $val);
    echo '<tr><td>'.str_replace(", ", "</td><td>", $line).'</td></tr>'.PHP_EOL;
}
echo '</table>';




  // print_r($tab2);

echo '<table>';
foreach ( $tab2 as $key => $line ) {
    // $val = explode(",", $line);
    // fputcsv($fp, $val);
    echo '<tr id="row_'.$key.'" class="datarow"><td>'.str_replace(", ", "</td><td>", $line).'</td><td>';
    echo '<select class="prepost"><option value="">-</option><option value="pre">pre</option><option value="post">post</option></select>';
    echo '<input class="csv" type="hidden" value="'.$line.'">';
    echo '</td></tr>'.PHP_EOL;
}
echo '</table>';

echo count($tab2);





echo 'THATS IT';
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
//
const prePostSelectAll = document.querySelectorAll("tr.datarow select");
prePostSelectAll.forEach(function(prePostSelect) {
	prePostSelect.addEventListener('change', (event) => {
		try {
			// let testType = event.currentTarget.value;
			// let csvData = event.currentTarget.parentElement.querySelector('input.csv').value;
			// console.log(testType);
			// console.log(csvData);
			let dataRows = document.querySelectorAll("tr.datarow");
			dataRows.forEach(function(row) {
				// console.log(row);
				let testType = row.querySelector('select').value;
				if (testType) {
					let csvData = row.querySelector('input.csv').value;
					// console.log(testType);
					console.log(csvData + ', ' + testType);
				}
			});
			// navigator.clipboard.writeText(path);
			// notice.innerHTML = encodeHTMLEntities(path) + ' copied to clipboard!';
			// showNotice();
		} catch (err) {
			console.log('Failed.: ' + err); // Inform user if copy fails
		}
	});
});
</script>
<textarea id="csv" hidden><?php
foreach ( $tab2 as $line ) {
    // $val = explode(",", $line);
    // fputcsv($fp, $val);
    echo $line.PHP_EOL;
}
?></textarea><br>
<button onclick="saveTextAsFile(csv.value,'export.csv')">Download CSV</button>
