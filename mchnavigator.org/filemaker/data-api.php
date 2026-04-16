<?php
/**
 * DO NOT EDIT THIS! Use config.php and functions.php to extend your app.
 * Version: 2025.10.21
 */

if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}

// Provide the login info in the config file, not here!
require_once __DIR__ . '/config.php';
include_once __DIR__ . '/functions.php';
include_once __DIR__ . '/utilities.php';

define( "FM_URL", 'https://a812617.fmphost.com/fmi/data/v2/' ); // FM19 @todo make this htaccess...

/**
 * Generate the authorization header for the API. This is good for 15 minutes after the last use, so we will store that info in the SESSION, otherwise we connect and get new credentials.
 *
 * @param string $database The database to connect to.
 *
 * @return string Properly formatted authorization header.
 */
function get_filemaker_auth( $database ) {
	if( !$database){
		return null;
	}

	// Provide the login info here. You can use logic here to vary per database if needed.
	$userpass = set_filemaker_auth( $database );
	if (null === $userpass) {
		die( '{"data":"invalid credentials"}' );
	}


	// There is no token or the last request was more than 15 minutes ago and the access token has expired.
	// https://help.claris.com/en/data-api-guide/content/log-in-database-session.html
	// https://help.claris.com/en/data-api-guide/content/log-out-database-session.html
	if (!isset($_SESSION['FM_'.$database.'_TOKEN']) || !isset($_SESSION['FM_'.$database.'_TIMESTAMP']) || (time() - $_SESSION['FM_'.$database.'_TIMESTAMP'] > 890)) {

		unset($_SESSION['FM_'.$database.'_TOKEN'], $_SESSION['FM_'.$database.'_TIMESTAMP']);

		$endpoint           = FM_URL . 'databases/' . $database . '/sessions';
		$auth_basic        = "Authorization: Basic " . $userpass;
		$filemaker_response = get_filemaker_data( $endpoint, CURLOPT_POST, $auth_basic );
		$json               = json_decode( $filemaker_response, true );

		if ( $json['messages'][0]['message'] === 'OK' ) {
			$_SESSION['FM_'.$database.'_TOKEN'] = $json['response']['token'];
			$_SESSION['FM_'.$database.'_TIMESTAMP'] = time(); // Update last activity time stamp.
		} else {
			die( '{"data":"unauthorized"}' );
		}
	}

	// If the code made it this far, we have an access token.
	$_SESSION['FM_'.$database.'_TIMESTAMP'] = time(); // Update last activity time stamp.
	return 'Authorization: Bearer ' . $_SESSION['FM_'.$database.'_TOKEN'];
}

/**
 * Once we have a fully formed API request, this function will do a CURL to get the data.
 *
 * @param string $endpoint The URL to request.
 * @param string $method The CURL method to use.
 * @param string $auth_header The API authorization header.
 * @param ?? $parameters
 *
 * @return JSON The API response, either a set of results or an error message.
 */
function get_filemaker_data( $endpoint, $method, $auth_header, $parameters = '' ) {
	if( !$endpoint || !$method || !$auth_header){
		return null;
	}

	$curl = curl_init( $endpoint );
	curl_setopt( $curl, CURLOPT_URL, $endpoint );
	if ( $method === 'DELETE' ) {
		curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'DELETE' );
	} elseif ( $method === 'PATCH' ) {
		curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'PATCH' );
	} else {
		curl_setopt( $curl, $method, true );
	}
	if ( $parameters ) {
		curl_setopt( $curl, CURLOPT_POSTFIELDS, $parameters );
	}
	curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );

	$headers = array(
		$auth_header,
		'Content-Type: application/json',
	);
	curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, false );
	curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );

	$filemaker_response = curl_exec( $curl );
	curl_close( $curl );

	return $filemaker_response;
}

/**
 * Generates the API URL from a PHP array.
 *
 * @param array $query_data Filemaker requestion variables.
 * @param string $format If the data should be returned as a PHP array or a JSON object.
 *
 * @return array|JSON The API response.
 */
function do_filemaker_request( $query_data, $format = 'array' ) {
	if( !$query_data){
		return null;
	}

	// DATA PREP
	// fmphost: https://my.fmphost.com/clientarea.php?action=productdetails&id=14980
	// errors: https://help.claris.com/en/pro-help/content/error-codes.html

	$database = isset( $query_data['database'] ) ? rawurlencode(strip_tags(htmlspecialchars($query_data['database']))) : null;
	$layout   = isset( $query_data['layout'] ) ? rawurlencode(strip_tags(htmlspecialchars($query_data['layout']))) : null;
	$record   = isset( $query_data['record'] ) ? intval($query_data['record']) : null;
	$queryString    = isset( $query_data['queryString'] ) ? $query_data['queryString'] : null;
	// echo $queryString;
	// $range    = isset( $query_data['range'] ) ? strip_tags(htmlspecialchars($query_data['range'])) : null;
	// $range    = isset( $query_data['range'] ) ? ($query_data['range']) : null;
	$action   = isset( $query_data['action'] ) ? strip_tags(htmlspecialchars($query_data['action'])) : null;
	$parameters = isset( $query_data['parameters'] ) ? $query_data['parameters'] : null;
	// Parameters needs to be a string, so if it is an array, change it
	if ( 'array' === gettype($parameters) ) {
		$parameters = json_encode( $parameters );
	}
	$script = isset( $query_data['script'] ) ? 'script='.strip_tags(htmlspecialchars($query_data['script'])) : null;

	// If we're missing data, just stop.
	if ( ! $database ) {
		die( '{"data":"invalid database"}' );
	}
	if ( ! $layout ) {
		die( '{"data":"invalid layout"}' );
	}

	$auth_token = get_filemaker_auth($database);

	// READ ONLY ACTIONS
	// @todo figure out how to cache these
	if ( $action === 'single' ) {
		// header("Cache-Control: max-age=2592000");
		// @link https://help.claris.com/en/data-api-guide/content/get-single-record.html
		$endpoint           = FM_URL . 'databases/' . $database . '/layouts/' . $layout . '/records/' . $record . $script;
		$filemaker_response = get_filemaker_data( $endpoint, CURLOPT_HTTPGET, $auth_token );
	} elseif ( $action === 'range' ) {
		// @link https://help.claris.com/en/data-api-guide/content/get-range-of-records.html
		if($queryString && $script){
			$script = '&'.$script;
		} else if (!$queryString && $script){
			$script = '?'.$script;
		}
		$endpoint           = FM_URL . 'databases/' . $database . '/layouts/' . $layout . '/records' . $queryString . $script;
			// die( '{"data":"' . $endpoint . ' endpoint"}' );
			// echo $endpoint;
		$filemaker_response = get_filemaker_data( $endpoint, CURLOPT_HTTPGET, $auth_token );
	} elseif ( $action === 'find' ) {
		// @link https://help.claris.com/en/data-api-guide/content/perform-find-request.html
		$endpoint           = FM_URL . 'databases/' . $database . '/layouts/' . $layout . '/_find' . $script;
		$filemaker_response = get_filemaker_data( $endpoint, CURLOPT_POST, $auth_token, $parameters );
	} else if ( 'create' === $action || 'edit' === $action || 'delete' === $action || 'script' === $action ) {

		// WRITE ACTIONS; WHITELIST; if create, edit, delete, or script
		// @todo better request detection
		// if ( ! in_array( $origin, $allowed_http_origins ) ) {
		// 	die( '{"data":"' . $origin . ' not in whitelist"}' );
		// }

		if ( $action === 'create' ) {
			// @link https://help.claris.com/en/data-api-guide/content/create-record.html
			$endpoint           = FM_URL . 'databases/' . $database . '/layouts/' . $layout . '/records/' . $script;
			$filemaker_response = get_filemaker_data( $endpoint, CURLOPT_POST, $auth_token, $parameters );
		} elseif ( $action === 'script' ) {
			// @link https://help.claris.com/en/data-api-guide/content/run-a-script.html
			// Do the script.
			$endpoint           = FM_URL . 'databases/' . $database . '/layouts/' . $layout . '/script/' . $script;
			$filemaker_response = get_filemaker_data( $endpoint, CURLOPT_HTTPGET, $auth_token );
			// Then get the resulting records.
			// $endpoint           = FM_URL . 'databases/' . $database . '/layouts/' . $layout . '/records';
			// $filemaker_response = get_filemaker_data( $endpoint, CURLOPT_HTTPGET, $auth_token );
		}

		// If edit or delete, let's make add an extra layer of security.
		if ( 'edit' === $action || 'delete' === $action ) {

			// The request must supply a field name and the expected value for the record in question.
			$challenge_field = isset( $query_data['challenge_field'] ) ? $query_data['challenge_field'] : null;
			$challenge_value = isset( $query_data['challenge_value'] ) ? $query_data['challenge_value'] : null;
			if ( ! $challenge_field || ! $challenge_value ) {
				die( '{"data":"invalid challenge"}' );
			}

			// if these are both null; fail - otherwise see if they match
			$endpoint           = FM_URL . 'databases/' . $database . '/layouts/' . $layout . '/records/' . $record . $script;
			$challenge_response = get_filemaker_data( $endpoint, CURLOPT_HTTPGET, $auth_token );
			$challenge_response = json_decode($challenge_response, true);

			//
			if ( $challenge_value !== $challenge_response['response']['data'][0]['fieldData'][$challenge_field] ) {
				die( '{"data":"challenge failed"}' );
			}

			// Perform the edit or delete request.
			if ( $action === 'edit' ) {
				// @link https://help.claris.com/en/data-api-guide/content/edit-record.html
				$endpoint           = FM_URL . 'databases/' . $database . '/layouts/' . $layout . '/records/' . $record . $script;
				$filemaker_response = get_filemaker_data( $endpoint, 'PATCH', $auth_token, $parameters );
			} elseif ( $action === 'delete' ) {
				// @link https://help.claris.com/en/data-api-guide/content/delete-record.html
				$endpoint           = FM_URL . 'databases/' . $database . '/layouts/' . $layout . '/records/' . $record . $script;
				$filemaker_response = get_filemaker_data( $endpoint, 'DELETE', $auth_token );
			}
		}
	} else {
		die( '{"data":"invalid action"}' );
	}


	// Send it back to the web app.
	if ( 'array' === $format ) {
		// Transform it to an associative array.
		return json_decode($filemaker_response, true);
	} elseif ( 'json' === $format ) {
		// Transform it to a JSON object.
		return json_decode($filemaker_response);
	} else {
		// Return nothing, something is wrong.
		return;
	}
}
