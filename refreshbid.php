<?php

require_once('templates/functions.php');

$statement = $dbh->prepare("select bodbedrag, gebruikersnaam from Bod where voorwerpnummer = ? and bodbedrag = (
  select max(bodbedrag) from Bod where voorwerpnummer = ?
  )");
$statement->execute(array($_GET['id'], $_GET['id']));
$maxbid = $statement->fetch(PDO::FETCH_NUM);

echo "Hoogste bod {$maxbid[0]} door {$maxbid[1]}";

?>
