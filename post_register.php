
<?php
$current_page='register';
require('templates/header.php');

if(isset($_GET['username'])){
	$username = $_GET['username'];
	try {
			$userdata = $dbh->prepare("select * from Gebruiker where gebruikersnaam=? and geactiveerd=0");
			$userdata->execute(array($username));
	} catch (PDOException $e) {
			$error = $e;
			echo $error;
	}
	if (($result = $userdata->fetch(PDO::FETCH_ASSOC))) {
		$email = $result['email'];
		mailUser($email,'registratie');

			$code = random_password(6);
			$url = "verification.php?username=" . urlencode($username) . "&code=" . urlencode($code);
			createVerificationCode($username, $code);

			$message = "http://http://iconcept.tpnb.nl/".$url;
		 	$message = wordwrap($message, 70, "\r\n");

?>
<br>
<br>
<br>
<p>Er is een mail gestuurd naar <?=$email?>.</p>
<p><a class="black-text" href="<?=$url?>">verification code</a>


<?php
}
	// mail($_POST['email'], "Verificatiecode EenmaalAndermaal", $message, "From: EenmaalAndermaal@iConcepts.com");
}
?>
