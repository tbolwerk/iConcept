<?php
$current_page='register';
require('templates/header.php');
require_once("templates/register/f_createVerificationCode.php");
require_once("templates/mail/f_verificationMail.php");

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
		$firstname = $result['voornaam'];

		$code = random_password(6);
		createVerificationCode($username, $code, $result['email']);

		$email = $result['email'];
		verificationMail($email, $username, $code, 'register');
	}
} else {
	header("Location: index.php");
}
?>

<main class="py-5 mask rgba-black-light flex-center">
  <div class="bg bg-login"></div>

	<div class="container col-md-4">
		<div class="card login-register-card">
			<div class="card-body">
	    	<div class="login-form-header elegant">
	       	<h3>Verificatie</h3>
	      </div>
				<div class="white-text">
					<p style="margin: 10px;">Beste <?=$firstname?>,</p>
					<p>Er is een verificatie mail gestuurd naar <?=$email?>. Deze mail bevat een link. Uw account wordt geactiveerd zodra er op de link wordt geklikt</p>
				</div>
			</div>
		</div>
	</div>
</main>

<?php include("templates/footer.php"); ?>
