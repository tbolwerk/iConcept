<?php

require("templates/connect.php");

$statement = $dbh->prepare("select top(1) startprijs, (select max(bodbedrag) from Bod where voorwerpnummer = ?) as maxbod from Voorwerp left outer join Bod on Bod.voorwerpnummer = Voorwerp.voorwerpnummer where Voorwerp.voorwerpnummer = ?");
$statement->execute(array($_GET['id'], $_GET['id']));
$result = $statement->fetch(PDO::FETCH_NUM);
$maxbid = "€" . $result[1];

if ($maxbid == "€") {
  $maxbid .= $result[0];
}

echo $maxbid;

?>
