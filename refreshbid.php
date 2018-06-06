<?php
//Connect to the database
require("templates/connect.php");

//Select the starting price and highest bid
$statement = $dbh->prepare("select top(1) startprijs, (select max(bodbedrag) from Bod where voorwerpnummer = ?) as maxbod from Voorwerp left outer join Bod on Bod.voorwerpnummer = Voorwerp.voorwerpnummer where Voorwerp.voorwerpnummer = ?");
$statement->execute(array($_GET['id'], $_GET['id']));
$result = $statement->fetch(PDO::FETCH_NUM);

//Attempt to get the max bid
$maxbid = "€" . $result[1];

//If there haven't been any bids then $maxbid will be mostly empty
if ($maxbid == "€") {
  //Set $maxbid to the starting price instead
  $maxbid .= $result[0];
}

//Return the highest bid (or starting price)
echo $maxbid;

?>
