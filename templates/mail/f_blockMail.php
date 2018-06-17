<?php
//Ik let niet meer op de netheid van de code
function blockMail($type, $id) {
  global $dbh;

  switch($type) {
  case "block user":
    $statement = $dbh->prepare("select email from gebruiker where gebruikersnaam = ?");
    $statement->execute(array($id));
    $gebruikermail = $statement->fetch()[0];

    $to = $gebruikermail;
    $subject = "Geblokkeerd EenmaalAndermaal";
    $message = "Beste " . $id . ",\r\n\nUw bent geblokkeerd";
  break;
  case "unblock user":
    $statement = $dbh->prepare("select email from gebruiker where gebruikersnaam = ?");
    $statement->execute(array($id));
    $gebruikermail = $statement->fetch()[0];

    $to = $gebruikermail;
    $subject = "Gedeblokkeerd EenmaalAndermaal";
    $message = "Beste " . $id . ",\r\n\nUw bent gedeblokkeerd";
  break;
  case "block auction":
    $statement = $dbh->prepare("select * from voorwerp where voorwerpnummer = ?");
    $statement->execute(array($id));
    $results = $statement->fetch();

    $statement = $dbh->prepare("select email from gebruiker where gebruikersnaam = ?");
    $statement->execute(array($results['verkoper']));
    $verkopermail = $statement->fetch()[0];

    $to = $verkopermail;
    $subject = "Veiling geblokkeerd EenmaalAndermaal";
    $message = "Beste " . $results['verkoper'] . ",\r\n\nUw voorwerp \"{$results['titel']}\" is geblokkeerd";
  break;
  case "unblock auction":
    $statement = $dbh->prepare("select * from voorwerp where voorwerpnummer = ?");
    $statement->execute(array($id));
    $results = $statement->fetch();

    $statement = $dbh->prepare("select email from gebruiker where gebruikersnaam = ?");
    $statement->execute(array($results['verkoper']));
    $verkopermail = $statement->fetch()[0];

    $to = $verkopermail;
    $subject = "Veiling gedeblokkeerd EenmaalAndermaal";
    $message = "Beste " . $results['verkoper'] . ",\r\n\nUw voorwerp \"{$results['titel']}\" is gedeblokkeerd";
  break;
  }

	$headers = "From: webmaster@iproject40.icasites.nl" . "\r\n" .
	    "Reply-To: webmaster@iproject40.icasites.nl" . "\r\n" .
	    "X-Mailer: PHP/" . phpversion();

	mail($to, $subject, $message, $headers);

  echo "<!--
  From: webmaster@iproject40.icasites.nl

  To: {$to}

  Subject: {$subject}

  Message: {$message}
  -->";

  $file = fopen("mails.txt", "a");
  fwrite($file, "
--------------------------------------
From: webmaster@iproject40.icasites.nl

To: {$to}

Subject: {$subject}

Message: {$message}
  ");
  fclose($file);
}
?>
