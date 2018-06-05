<?php
//generates and returns options for the main categoryselector
function generateCategoryOptions($results){
  $options = "<option value=''>Kies rubriek...</option>";
  for ($i = 0; $i < count($results); $i++) {
    if($results[$i]['rubrieknummerOuder'] == -1){
      $options .= "<option value='" . $results[$i]['rubrieknummer'] . "'>" . $results[$i]['rubrieknaam'] . "</option>";
    }
  }
  return $options;
}
?>
