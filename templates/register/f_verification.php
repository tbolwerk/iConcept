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

	$storedUsername = $results[0];
	$storedTime = $results[1];
	$storedCode = $results[2];

	$deltaTime = time() - $storedTime;

	if ($deltaTime > 14400) {//14400 seconds = 4 hours
  	$codeValid = false;
    $error = "Time has expired";
	}

	if ($codeValid && $results['email'] == 0) {
  	$statement = $dbh->prepare("update Gebruiker set geactiveerd = 1 where gebruikersnaam = ?");//set activatie bit to 1
  	$statement->execute(array($storedUsername));
  	$statement = $dbh->prepare("delete Verificatiecode where gebruikersnaam = ?");//clean database
  	$statement->execute(array($storedUsername));
	}else if($codeValid && $results['email'] != 0){
		$statement = $dbh->prepare("update Gebruiker set geactiveerd = 1 AND email=? where gebruikersnaam = ?");//set activatie bit to 1
		$statement->execute(array($results['email'],$storedUsername));
		$statement = $dbh->prepare("delete Verificatiecode where gebruikersnaam = ?");//clean database
		$statement->execute(array($storedUsername));
	}
}
?>
