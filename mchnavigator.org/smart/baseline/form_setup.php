<?php
// echo "form_setup included.";
// echo $uID;


  include_once(__DIR__ . "/../../../globals/filemaker_init.php");

  // check for data
  $fm = db_connect("MCH-Navigator");
  $request = $fm->newFindCommand('MCH_Smart_Baseline');
  $request->addFindCriterion('uID', "==\"" . $uID . "\"");
  $result = $request->execute();
  if (!FileMaker::isError($result)) {
    $records = $result->getRecords();
    $record = $records[0];

    $recordID = $record->getField('recordID');
    // echo $record->getField('Competency_1_1_Status');
    // echo $record->getField('Competency_1_1_Knowledge');
    // echo $record->getField('Competency_1_1_Skills');
    // echo $record->getField('recordID');
    

// print_r($record->_impl->_fields);

    echo '<script type="text/javascript">$( document ).ready(function() { ';

    foreach($record->_impl->_fields as $fieldname => $value){
      if(strpos($fieldname,"Competency_".$section."_") !== false){
          if(strpos($fieldname,"Feedback") !== false){
            // if feedback, put value
            echo '$("textarea#'.$fieldname.'").val("'.$record->getField($fieldname).'");' . PHP_EOL; 
          } else if(strpos($fieldname,"Status") === false){
            // if choice (not status) set input
            echo '$("input[name=\''.$fieldname.'\'][value=\''.$record->getField($fieldname).'\']").prop("checked", true);' . PHP_EOL; 
          }

      }
    }
    // echo '$("input[name=\'Competency_1_1_Knowledge\'][value=\''.$record->getField('Competency_1_1_Knowledge').'\']").prop("checked", true);' . PHP_EOL;

    // echo '$("input[name=\'Competency_1_1_Skills\'][value=\''.$record->getField('Competency_1_1_Skills').'\']").prop("checked", true);' . PHP_EOL;

    echo '});</script>';

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