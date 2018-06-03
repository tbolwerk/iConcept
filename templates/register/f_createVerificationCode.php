<?php
//Inserts a verification code into the database
function createVerificationCode($username, $random_password, $email = 0) {
	global $dbh;
	global $error;

    try {
  		$userdata = $dbh->prepare("insert into Verificatiecode(gebruikersnaam, begintijd, code,email) Values(?, ?, ?,?)");
  		$userdata->execute(array($username, time(), $random_password,$email));
    } catch (PDOException $e) {
  		$error=$e;
    }
	}


?>
