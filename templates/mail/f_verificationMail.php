<?php
//This function sends a mail with a verification code to a user
function verificationMail($email, $username, $code, $type) {
	$to = $email;
  //Generate the url that the user has to click
  $url = "http://iproject40.icasites.nl/iconcept/" . "verification.php?username=" . urlencode($username) . "&code=" . urlencode($code);

  switch($type) {
  case "register": //For when someone registers a new account
    $subject = "Verificatie account EenmaalAndermaal";
    $message = "Beste " . $username . ",\r\n\nKlik op deze link om uw account te activeren\r\n" . $url;
  break;
  case "mail": //For when a user wants to change his email
    $subject = "E-Mail wijziging EenmaalAndermaal";
    $message = "Beste " . $username . ",\r\n\nKlik op deze link om uw e-mail te wijzigen\r\n" . $url;
  break;
  }

  //Metadata for the mail
	$headers = "From: webmaster@iproject40.icasites.nl" . "\r\n" .
	    "Reply-To: webmaster@iproject40.icasites.nl" . "\r\n" .
	    "X-Mailer: PHP/" . phpversion();

  //Send the mail
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
