<?php
$current_page='register_verification';
require_once('templates/header.php');
require_once('templates/connect.php');
$username = $_SESSION['username'];

function verificationSeller($username,$code)
{
	global $dbh;
	global $errors;
	$errors = array();

	$codeValid = true;//codeValid is true until proven that it's not

	try {//checks if code exists in database
	$statement = $dbh->prepare("select * from VerificatieVerkoper where gebruikersnaam = ? AND code = ?");
	$statement->execute(array($username,$code));
	$results = $statement->fetch();
	} catch (PDOException $e) {
	$error= "Code invalid";
	$codeValid = false;
	}

	if ($codeValid) {
	$statement = $dbh->prepare("update Gebruiker set verkoper = 1 where gebruikersnaam = ?");
	$statement->execute(array($username));
	$statement = $dbh->prepare("delete VerificatieVerkoper where gebruikersnaam = ?");
	$statement->execute(array($username));
	}
}

if(isset($_POST['verify'])){
  verificationSeller($username, $_POST['code']);
}

?>

<form action="" method="post">
  <label>Verificatiecode</label>
	<input type="text" name="code"><br>
	<button type="submit" name="verify">Verifieer</button>
</form>
