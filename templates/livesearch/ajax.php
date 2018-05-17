<?php

//Including Database configuration file.
require_once($_SERVER['DOCUMENT_ROOT'] . '/iconcept/templates/connect.php');

//Getting value of "search" variable from "script.js".
$return ="";
$rubrieken="";
if (isset($_POST['livesearch'])) {
  $name = $_POST['livesearch'];
  try{
  $statement = $dbh->prepare("SELECT * FROM Rubriek WHERE rubrieknaam LIKE ? AND rubrieknummerOuder=-1");
  $statement->execute(array("%".$name."%"));
}catch(PDOException $e){
  $error = $e;
}

  while($row = $statement->fetch()){
    $rubrieknaam = $row['rubrieknaam'];
    $function = "fill('".$rubrieknaam."')";
    $rubrieken.="<li onclick='".$function."'><a href='#'>".$rubrieknaam."</li></a>";
  }
  //Sub-rubrieken
  $subrubrieken="";
  try{
    $statement = $dbh->prepare("SELECT * FROM Rubriek WHERE rubrieknaam LIKE ? AND rubrieknummerOuder!=-1 AND rubrieknummerOuder!=1");
    $statement->execute(array("%".$name."%"));
  }catch(PDOException $e){
    $error = $e;
  }

  while($row = $statement->fetch()){
    $rubrieknaam = $row['rubrieknaam'];
    $function = "fill('".$rubrieknaam."')";
    $subrubrieken.="<li onclick='".$function."'><a href='#'>".$rubrieknaam."</li></a>";
  }

  $veilingen="";
  try{
    $statement = $dbh->prepare("SELECT * FROM Voorwerp where titel LIKE ?");
    $statement->execute(array("%".$name."%"));
  }catch(PDOException $e){
    $error = $e;
  }

  while($row = $statement->fetch()){
    $voorwerptitel = $row['titel'];
    $function = "fill('".$rubrieknaam."')";
    $veilingen.="<li onclick='".$function."'><a href='#'>".$voorwerptitel."</li></a>";
  }

}
  echo "<ul>";
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
