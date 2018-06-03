<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/iconcept/templates/connect.php');
function livesearch($post_livesearch){//livesearch function met parameter $_POST['search']
  global $dbh;
  global $rubrieken;
  global $subrubrieken;
  global $veilingen;

//Getting value of "search" variable from "script.js".
$return ="";
$rubrieken="";
$name = $post_livesearch;
  // $name = $_POST['livesearch'];
  try{
  $statement = $dbh->prepare("SELECT * FROM Rubriek WHERE rubrieknaam LIKE ? AND rubrieknummerOuder=-1");//zoekt in hoofdrubrieken
  $statement->execute(array("%".$name."%"));
}catch(PDOException $e){
  $error = $e;
}

  while($row = $statement->fetch()){
    $rubrieknaam = $row['rubrieknaam'];
    $rubrieknummer = $row['rubrieknummer'];
    $function = "fill('".$rubrieknaam."')";
    $rubrieken.="<li onclick='".$function."'><a class='dummy-media-object' href='rubriek.php?rubrieknummer=".$rubrieknummer."'><h3>".$rubrieknaam."</h3></li></a>";
  }
  //Sub-rubrieken
  $subrubrieken="";
  //zoekt in subrubrieken
  try{
    $statement = $dbh->prepare("SELECT kind.rubrieknummer,kind.rubrieknaam,kind.rubrieknummerOuder,ouder.rubrieknaam as 'ouderRubriek'
FROM Rubriek kind INNER JOIN Rubriek ouder ON kind.rubrieknummerOuder = ouder.rubrieknummer
WHERE kind.rubrieknaam LIKE ?");
    $statement->execute(array("%".$name."%"));

  }catch(PDOException $e){
    $error = $e;
  }
  while($row = $statement->fetch()){

    $rubrieknaam = $row['rubrieknaam'];
    $rubrieknaamOuder = $row['ouderRubriek'];
    $rubrieknummer = $row['rubrieknummer'];
    $function = "fill('".$rubrieknaam."')";
      if($row['rubrieknummerOuder'] !=-1){
    $subrubrieken.="<li onclick='".$function."'><a class='dummy-media-object' href='rubriek.php?rubrieknummer=".$rubrieknummer."'><h6>".$rubrieknaamOuder."</h6><h3>".$rubrieknaam."</h3></li></a>";
}
  }


  $veilingen="";
  //zoekt in veilingen
  try{
    $statement = $dbh->prepare("SELECT vw.voorwerpnummer,vw.titel,vr.rubrieknummer,r.rubrieknaam
FROM Voorwerp vw LEFT JOIN Voorwerp_in_Rubriek vr ON
vw.voorwerpnummer = vr.voorwerpnummer LEFT JOIN Rubriek r ON vr.rubrieknummer=r.rubrieknummer
WHERE titel LIKE ? AND vw.geblokkeerd = 0");
    $statement->execute(array("%".$name."%"));
  }catch(PDOException $e){
    $error = $e;
  }

  while($row = $statement->fetch()){


    $voorwerptitel = $row['titel'];
    $voorwerpnummer = $row['voorwerpnummer'];
    $rubrieknummer = $row['rubrieknummer'];
    $rubrieknaam = $row['rubrieknaam'];

    $function = "fill('".$rubrieknaam."')";

    $veilingen.="<li onclick='".$function."'><a class='dummy-media-object' href='detailpage.php?id=".$voorwerpnummer."'><h6>".$rubrieknaam."</h6><h3>".$voorwerptitel."</h3></li></a>";

  }


}
?>
