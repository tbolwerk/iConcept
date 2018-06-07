<?php
//This function sends a mail to a user notifying him about a closed auction
function auctionClosedMail($email, $username, $id, $type) {
  global $dbh;

	$to = $email;

  switch($type) {
  case "buyer": //For when someone wins an auction
    $subject = "Veiling gewonnen EenmaalAndermaal";
    $message = "Beste " . $username . ",\r\n\nGefeliciteerd, U heeft de veiling id:{$id} gewonnen";
  break;
  case "seller": //For when a seller succeeds to sell an item
    $statement = $dbh->prepare("SELECT TOP 1 (SELECT MAX(bodbedrag) FROM Bod WHERE voorwerpnummer = b.voorwerpnummer) AS maxbid, gebruikersnaam FROM Bod b WHERE b.voorwerpnummer = ?");
    $statement->execute(array($id));
    $results = $statement->fetch();

    $subject = "Voorwerp verkocht EenmaalAndermaal";
    $message = "Beste " . $username . ",\r\n\nUw voorwerp id:{$id} is verkocht voor €{$results['maxbid']} door {$results['gebruikersnaam']}";
  break;
  case "sellerfailed": //For when a seller fails to sell an item
    $subject = "Voorwerp niet verkocht EenmaalAndermaal";
    $message = "Beste " . $username . ",\r\n\nUw voorwerp id:{$id} is helaas niet verkocht";
  break;
  }

  //Metadata for the mail
	$headers = "From: webmaster@iproject40.icasites.nl" . "\r\n" .
	    "Reply-To: webmaster@iproject40.icasites.nl" . "\r\n" .
	    "X-Mailer: PHP/" . phpversion();

  //Send the mail
	mail($to, $subject, $message, $headers);
}
?>
