
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

		$code = random_password(6);
		createVerificationCode($username, $code);

		$email = $result['email'];
		mailUser($email, $username, 'registratie', $code);

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
