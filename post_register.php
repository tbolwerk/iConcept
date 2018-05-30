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
<<<<<<< HEAD
		$email = $result['email'];
		mailUser($email,'registratie');
=======
		$firstname = $result['voornaam'];
>>>>>>> 941a07fcd65ac43d4a06675c024a75d9872e0a18

			$code = random_password(6);
			$url = "verification.php?username=" . urlencode($username) . "&code=" . urlencode($code);
			createVerificationCode($username, $code);

<<<<<<< HEAD
			$message = "http://http://iconcept.tpnb.nl/".$url;
		 	$message = wordwrap($message, 70, "\r\n");

=======
		$email = $result['email'];
		mailUser($email, $username, 'registratie', $code);
	}
} else { //Dit blok is om de pagina te kunnen testen zonder daadwerkelijk een gebruiker te hoeven registreren
	$email = "janbeenham@hotmail.com";
	$code = "2k48d2cp";
	$username = "janbeenham";
	$firstname = "Jan";
}
>>>>>>> 941a07fcd65ac43d4a06675c024a75d9872e0a18
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
					<?php $url = 'verification.php?username=' . urlencode($username) . "&code=" . urlencode($code); ?>
					<p><a href="<?=$url?>">Verificatie link om het systeem te testen</a></p>
				</div>
			</div>
		</div>
	</div>
</main>

<?php include("templates/footer.php"); ?>
