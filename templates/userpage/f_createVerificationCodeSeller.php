<?php
function createVerificationCodeSeller($username, $random_password) {
	global $dbh;
	global $error;

    try {
		$userdata = $dbh->prepare("insert into VerificatieVerkoper(gebruikersnaam, code) Values(?, ?)");//inserts verificationcode into database
		$userdata->execute(array($username, $random_password));
    } catch (PDOException $e) {
		$error=$e;
    }
}
?>
