<?php
function registerVerificationMail($email, $username, $code) {
	$to = $email;
	$subject = "Verificatie account EenmaalAndermaal";
  $url = "http://iconcept.tpnb.nl/iconcept/" . "verification.php?username=" . urlencode($username) . "&code=" . urlencode($code);
	$message = "Beste " . $username . ", \r\n\nKlik op deze link om uw account te activeren\r\n" . $url;
	$headers = "From: webmaster@iproject40.icasites.nl" . "\r\n" .
	    "Reply-To: webmaster@iproject40.icasites.nl" . "\r\n" .
	    "X-Mailer: PHP/" . phpversion();

	mail($to, $subject, $message, $headers);
}
?>
