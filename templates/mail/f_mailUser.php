<?php
function mailUser($email, $username, $type) {

  global $dbh;

	$to = $email;

	switch($type) {
	case 'registratie':
    $statement = $dbh->prepare("select voornaam, achternaam, code from Gebruiker G join Verificatiecode V on G.gebruikersnaam = V.gebruikersnaam where G.gebruikersnaam = ?");
    $statement->execute(array($username));
    $results = $statement->fetch();
		$subject = 'Verificatie account EenmaalAndermaal';
		$message = 'Beste '.$results['voornaam'].' '.$results['achternaam'].', http://iconcept.tpnb.nl/iconcept/'.'verification.php?username='.urlencode($username)."&code=".urlencode($results['code']);
	break;

	case 'veilingaanmaken':
		$subject = 'Veiling aangemaakt!';
		$message = 'Beste '. $username .', Uw veiling is aangemaakt!';
	break;

	case 'overboden':
		$subject = 'U bent overboden!';
		$message = 'Beste '. $username .', U bent overboden!';
	break;

	case 'veilinggewonnen':
		$veilinggew = $dbh->prepare("select titel from Voorwerp where koper=?");
		$veilinggew->execute(array($username));

		$to = $email_address;
		$subject = 'U heeft de veiling gewonnen!';
		$message = 'Beste '. $username .', U heeft veiling'. $veilinggew.'gewonnen!';
	break;

	case 'wachtwoordvergeten':

	break;
	case 'emailwijzigen':
	    $statement = $dbh->prepare("select voornaam, achternaam, code from Gebruiker G join Verificatiecode V on G.gebruikersnaam = V.gebruikersnaam where G.gebruikersnaam = ?");
    $statement->execute(array($username));
    $results = $statement->fetch();
		$subject = 'E-Mail wijziging';
		$message = 'Beste '. $results["voornaam"] .' ' .$results["achternaam"]. ' , Klik op de onderstaande link om Uw E-Mail te wijzigen: http://iconcept.tpnb.nl/iconcept/verification.php?username='.urlencode($username).'&code='.urlencode($results["code"]);
	break;

}

	$headers = 'From: webmaster@iproject40.icasites.nl' . "\r\n" .
	    'Reply-To: webmaster@iproject40.icasites.nl' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);
}
?>
