<?php

//Including Database configuration file.
require_once($_SERVER['DOCUMENT_ROOT'] . '/iconcept/templates/functions.php');

require_once($_SERVER['DOCUMENT_ROOT'] . "/iconcept/templates/livesearch/f_livesearch.php");

$return = "";
  echo "<ul>";
  $rubrieken="";
  $subrubrieken="";
  $veilingen="";
  if(isset($_POST['search'])){
$livesearch = $_POST['search'];
        livesearch($livesearch);
}
$return.='
        <div class="dummy-column" style="">
          <h2>Rubrieken</h2>
          <div class="search-scroll">
'.$rubrieken.'
        </div>
      </div>
      <div class="dummy-column">
          <h2>Sub-rubrieken</h2>
          <div class="search-scroll">
'.$subrubrieken.'
        </div>
      </div>
      <div class="dummy-column">
          <h2>Veilingen</h2>
          <div class="search-scroll">
'.$veilingen.'
        </div>
      </div>







  ';

  echo $return;

?>
</ul>
