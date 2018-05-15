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

	try {//checks if code exists in database
		$statement = $dbh->prepare("SELECT code FROM VerificatieVerkoper WHERE gebruikersnaam = ?");
		$statement->execute(array($username));
		$results = $statement->fetch();
	} catch (PDOException $e) {
		$error = $e;
		echo $error;
	}
	// print_r($results['gebruikersnaam']);
	if($results[0] == $code){
		try {
			$statement = $dbh->prepare("update Gebruiker set verkoper = 1 where gebruikersnaam = ?");
			$statement->execute(array($username));
			$statement = $dbh->prepare("delete VerificatieVerkoper where gebruikersnaam = ?");
			$statement->execute(array($username));
		} catch (PDOException $e) {
			$error = $e;
			echo $error;
		}
	}
}

if(isset($_POST['verify'])){
  verificationSeller($username, $_POST['code']);
}

?>

<!-- <form action="" method="post">
  <label>Verificatiecode</label>
	<input type="text" name="code"><br>
	<button type="submit" name="verify">Verifieer</button>
</form> -->

<form method="post" action="">

	<div class="md-form">
		<label for="code">Verificatiecode</label>
		<input type="text" class="form-control" name="code" id="code" value="" required>
	</div>

	<button type="submit" name="verify">Word verkoper</button>
</form>
