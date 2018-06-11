<?php
//This function sends a mail to a user notifying him that someone else placed a higher bid
function bidMail($userdata) {
	$to = $userdata[1];

  $subject = "EenmaalAndermaal overboden";
  $message = "Beste " . $userdata[0] . ",\nU bent overboden";

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
}
?>
