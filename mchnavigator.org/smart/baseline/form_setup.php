<?php
require_once __DIR__ . '/../../filemaker/data-api.php';

$request = array(
	'database' => 'MCH-Navigator',
	'layout' => 'MCH_Smart_Baseline',
	'action' => 'find',
	'parameters' => array(
		'query' => array(
			array(
				'uID' => '=="' . (string) $uID . '"',
			),
		),
		'limit' => 1,
	),
);

$result = do_filemaker_request($request, 'array');
if ((int) ($result['messages'][0]['code'] ?? 500) === 0 && !empty($result['response']['data'][0])) {
	$record = $result['response']['data'][0];
	$fieldData = $record['fieldData'] ?? array();
	$recordID = $fieldData['recordID'] ?? '';
	$scripts = array();

	foreach ($fieldData as $fieldname => $value) {
		if (strpos($fieldname, 'Competency_' . $section . '_') !== 0) {
			continue;
		}

		if (strpos($fieldname, 'Feedback') !== false) {
			$scripts[] = '$("textarea#' . addslashes($fieldname) . '").val(' . json_encode((string) $value) . ');';
		} else if (strpos($fieldname, 'Status') === false) {
			$scripts[] = '$("input[name=' . json_encode($fieldname) . '][value=' . json_encode((string) $value) . ']").prop("checked", true);';
		}
	}

	if (!empty($scripts)) {
		echo '<script type="text/javascript">$(document).ready(function() {' . PHP_EOL;
		echo implode(PHP_EOL, $scripts) . PHP_EOL;
		echo '});</script>';
	}
}
?>

<?php function choices_level($t){
	global $section;
	$f = $section.'_'.$t; ?>
      <ul>
        <li>
          <label for="Competency_<?php echo $f; ?>_0">
            <input id="Competency_<?php echo $f; ?>_0" name="Competency_<?php echo $f; ?>" value="None" type="radio">
            None</label>
        </li>
        <li>
          <label for="Competency_<?php echo $f; ?>_1">
            <input id="Competency_<?php echo $f; ?>_1" name="Competency_<?php echo $f; ?>" value="Low" type="radio">
            Low</label>
        </li>
        <li>
          <label for="Competency_<?php echo $f; ?>_2">
            <input id="Competency_<?php echo $f; ?>_2" name="Competency_<?php echo $f; ?>" value="Medium" type="radio">
            Medium</label>
        </li>
        <li>
          <label for="Competency_<?php echo $f; ?>_3">
            <input id="Competency_<?php echo $f; ?>_3" name="Competency_<?php echo $f; ?>" value="High" type="radio">
            High</label>
        </li>
      </ul>
<?php } ?>
