<?php
$current_page='auction';
require_once('templates/header.php');
?>

<?php

if(empty($_GET['voorwerpnummer'])){
  header("Location: index.php");
}else{
  $auctionInfo = "";
  $voorwerpnummer = $_GET['voorwerpnummer'];
  $data = $dbh->prepare("SELECT * FROM Voorwerp WHERE voorwerpnummer = ?");
  $data->execute(array($voorwerpnummer));
  while($row = $data->fetch()){
    $auctionInfo.="Titel: ".$row['titel'];
    $auctionInfo.="<br>";
    $auctionInfo.="Beschrijving: ".$row['beschrijving'];
  }
}
?>

<?php
echo $auctionInfo;
?>




<?php
include("templates/footer.php");
?>
