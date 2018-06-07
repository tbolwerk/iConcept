<?php
require_once("templates/connect.php");
require_once("templates/mail/f_auctionClosedMail.php");
try {
  $statement = $dbh->query("SELECT (select gebruikersnaam from Bod where Bod.voorwerpnummer = vw.voorwerpnummer and Bod.bodbedrag =
	(select max(bodbedrag) from Bod where voorwerpnummer = vw.voorwerpnummer)) AS koper,
	vw.verkoper, vw.voorwerpnummer, vw.titel, vw.veilinggesloten, bodbedrag, verkoper.email AS verkopermail, koper.email AS kopermail, dateadd(day, looptijd, looptijdbegindag) AS looptijdeindedag, looptijdtijdstip
FROM Voorwerp vw JOIN Gebruiker verkoper ON vw.verkoper = verkoper.gebruikersnaam left outer join Bod on Bod.voorwerpnummer = vw.voorwerpnummer left outer join Gebruiker koper on koper.gebruikersnaam = Bod.gebruikersnaam
WHERE CAST(dateadd(day, looptijd, looptijdbegindag) AS DATETIME) + CAST(looptijdtijdstip AS DATETIME) < GETDATE() AND veilinggesloten = 0
AND (bodbedrag = (select max(bodbedrag) from Bod where voorwerpnummer = vw.voorwerpnummer) OR bodbedrag is null)");

  while ($row = $statement->fetch()) {
    if ($row['koper'] == "") {
      auctionClosedMail($row['verkopermail'], $row['verkoper'], $row['voorwerpnummer'], 'sellerfailed');
    } else {
      auctionClosedMail($row['verkopermail'], $row['verkoper'], $row['voorwerpnummer'], 'seller');
      auctionClosedMail($row['kopermail'], $row['koper'], $row['voorwerpnummer'], 'buyer');
    }
    $closeAuction = $dbh->prepare("UPDATE Voorwerp SET veilinggesloten = 1 WHERE voorwerpnummer=?");
    $closeAuction->execute(array($row['voorwerpnummer']));
  }
} catch (PDOException $e) {
  echo $e;
}

?>
