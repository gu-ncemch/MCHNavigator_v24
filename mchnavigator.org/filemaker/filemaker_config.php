<?php

// Define the API, database, and layout.
define('FILEMAKER_PATH', 'https://filemaker.ncemch.org/');

// Testing purposes only, uncomment out and publish changes to cam.php to test changes to endpoint on live server
// define('FILEMAKER_PATH', 'https://filemaker.ncemch.org/cam.php');

// Get specific fields from Filemaker
function getField(string $name, ?array $rec = null) {
    // Uses $current_record if no record explicitly passed.
    // Avoids null issue
    if ($rec === null) {
        if (!isset($GLOBALS['current_record'])) return '';
        $rec = $GLOBALS['current_record'];
    }
    // FileMaker Data API structure: ['fieldData'][<FieldName>]
    return $rec['fieldData'][$name] ?? '';
}

// Request data from FileMaker.
function do_filemaker_request($filemaker_request, $format = 'array')
{
    // Send a request to the API and get the response.
    $curl = curl_init(FILEMAKER_PATH);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $filemaker_request);
    curl_setopt($curl, CURLOPT_REFERER, $_SERVER['SERVER_NAME']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    // Send it back to the web app.
    if ('array' === $format) {
        // Transform it to an associative array.
        return json_decode($response, true);
    } elseif ('json' === $format) {
        // Transform it to a JSON object.
        return json_decode($response);
    } else {
        // Return nothing, something is wrong.
        return;
    }
}