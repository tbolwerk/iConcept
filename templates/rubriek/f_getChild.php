<?php
function getChild($rubrieknummer){
  global $dbh;
$out;
  try{
    $data = $dbh->prepare("SELECT * FROM Rubriek WHERE rubrieknummerOuder=?");
    $data->execute(array($rubrieknummer));
    $out = $data->fetch();

  }catch(PDOException $e){
    $error = $e;
  }
  return $out;
}
?>
