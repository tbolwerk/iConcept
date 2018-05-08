<?php
$current_page = "index";
require('templates/header.php');
if(isset($_GET['key'])){
$voorwerpnummer = $_GET['key'];
try{
$statement = $dbh->prepare("SELECT * FROM Voorwerp WHERE ?");
$data = $statement->execute(array($voorwerpnummer));
$data->FETCH_ASSOC();
if($data['voorwerpnummer']==$voorwerpnummer){
  echo "werkt";
}else{
  echo "werkt niet";
}
}catch(PDOException $e){
  $error = $e;
}
}else{
  header("Location: index.php");
}
include("templates/footer.php");
?>
