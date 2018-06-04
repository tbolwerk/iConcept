<?php
/*verification function*/
function verification($getUsername, $getCode) {
	global $dbh;
  global $codeValid;
  global $submittedCode;
  global $deltaTime;
  global $results;

	$codeValid = true;//codeValid is true until proven that it's not
  $submittedCode = $getCode;
	$username = $getUsername;

	try {//checks if code exists in database
  	$statement = $dbh->prepare("SELECT * FROM Verificatiecode WHERE gebruikersnaam = ? AND code = ?");
  	$statement->execute(array($username, $submittedCode));
  	$results = $statement->fetch();
	} catch (PDOException $e) {
  	$error = "Code invalid";
  	$codeValid = false;
	}

	$storedUsername = $results['gebruikersnaam'];
	$storedTime = $results['begintijd'];
	$storedCode = $results['code'];
	$storedEmail = $results['email'];

	$deltaTime = time() - $storedTime;

	if ($deltaTime > 14400) {//14400 seconds = 4 hours
  	$codeValid = false;
    $error = "Time has expired";
	}

	if ($codeValid) {
  	$statement = $dbh->prepare("update Gebruiker set geactiveerd = 1, email=? where gebruikersnaam = ?");//set activatie bit to 1
  	$statement->execute(array($storedEmail,$storedUsername));
  	$statement = $dbh->prepare("delete Verificatiecode where gebruikersnaam = ?");//clean database
  	$statement->execute(array($storedUsername));
	}
}
?>
