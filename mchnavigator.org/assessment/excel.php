<?php
if (!isset($_POST['emails'])) {
	header("Location: export.php");
	exit;
}

require_once __DIR__ . '/../filemaker/data-api.php';

define('ASSESSMENT_EXPORT_MAX_REPEATS', 31);

function assessment_repeat_value($row, $field, $index) {
	$fieldData = $row['fieldData'] ?? array();
	$value = $fieldData[$field] ?? '';
	if (is_array($value)) {
		return $value[$index] ?? '';
	}

	$repeatKey = $field . '(' . ($index + 1) . ')';
	if (array_key_exists($repeatKey, $fieldData)) {
		return $fieldData[$repeatKey];
	}

	return $index === 0 ? $value : '';
}

function assessment_exact_text($value) {
	return '=="' . str_replace('"', '\"', trim((string) $value)) . '"';
}

function assessment_fetch_records_by_email($email, $layout) {
	$request = array(
		'database' => 'MCH-Navigator',
		'layout' => $layout,
		'action' => 'find',
		'parameters' => array(
			'query' => array(
				array(
					'SA_Users::email' => assessment_exact_text($email),
				),
			),
			'sort' => array(
				array(
					'fieldName' => 'date',
					'sortOrder' => 'ascend',
				),
				array(
					'fieldName' => 'section',
					'sortOrder' => 'ascend',
				),
			),
			'limit' => 500,
		),
	);

	$result = do_filemaker_request($request, 'array');
	if ((int) ($result['messages'][0]['code'] ?? 500) !== 0 || empty($result['response']['data'])) {
		return array();
	}

	return $result['response']['data'];
}

$email_array = preg_split('/\R+/', trim((string) $_POST['emails']));
$email_array = array_values(array_filter(array_map('trim', $email_array)));

$numberToWord = array("None", "Low", "Medium", "High");
$layouts = array(
	'SA_Responses_v45' => '4.5',
	'SA_Responses_v4' => '4.0',
);

$header = array(
	'user_id',
	'email',
	'version',
	'date',
	'section',
	'importance',
	'response_summary_knowledge',
	'response_summary_skills',
	'response_summary_KI',
	'response_summary_KK',
	'response_summary_SI',
	'response_summary_SS',
);

for ($i = 1; $i <= ASSESSMENT_EXPORT_MAX_REPEATS; $i++) {
	$header[] = 'response_' . $i . '_id';
	$header[] = 'response_' . $i . '_type';
	$header[] = 'response_' . $i . '_value';
	$header[] = 'response_' . $i . '_label';
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=mch-nav-assessment-' . time() . '.csv');

$output = fopen('php://output', 'w');
fputcsv($output, $header, ',', '"', '\\');

foreach ($email_array as $email) {
	foreach ($layouts as $layout => $version) {
		$records = assessment_fetch_records_by_email($email, $layout);
		foreach ($records as $record) {
			$fieldData = $record['fieldData'] ?? array();
			$row = array(
				$fieldData['uID'] ?? '',
				$fieldData['SA_Users::email'] ?? $email,
				$version,
				$fieldData['date'] ?? '',
				$fieldData['section'] ?? '',
				assessment_repeat_value($record, 'response', 0),
				$fieldData['response_summary_knowledge'] ?? '',
				$fieldData['response_summary_skills'] ?? '',
				$fieldData['response_summary_KI'] ?? '',
				$fieldData['response_summary_KK'] ?? '',
				$fieldData['response_summary_SI'] ?? '',
				$fieldData['response_summary_SS'] ?? '',
			);

			for ($i = 0; $i < ASSESSMENT_EXPORT_MAX_REPEATS; $i++) {
				$responseId = assessment_repeat_value($record, 'responseID', $i);
				$responseType = assessment_repeat_value($record, 'responseType', $i);
				$responseValue = assessment_repeat_value($record, 'response', $i);
				$responseLabel = '';

				if ($responseValue !== '' && is_numeric((string) $responseValue)) {
					$responseIndex = (int) $responseValue;
					$responseLabel = $numberToWord[$responseIndex] ?? '';
				}

				$row[] = $responseId;
				$row[] = $responseType;
				$row[] = $responseValue;
				$row[] = $responseLabel;
			}

			fputcsv($output, $row, ',', '"', '\\');
		}
	}
}

fclose($output);
?>
