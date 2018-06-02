<?php
//Inserts a verification code into the database
function createVerificationCode($username, $random_password) {
	global $dbh;
	global $error;

    try {
  		$userdata = $dbh->prepare("insert into Verificatiecode(gebruikersnaam, begintijd, code) Values(?, ?, ?)");
  		$userdata->execute(array($username, time(), $random_password));
    } catch (PDOException $e) {
  		$error=$e;
    }
}
?>
