<!DOCTYPE html>

<?php
$current_page='verification';
require('templates/header.php');

if(isset($_GET['code'])){
	$submittedCode = $_GET['code'];
	$codeValid = true;
    try {
		$statement = $dbh->prepare("select * from Verificatiecode where code = ?");
		$statement->execute(array($submittedCode));
		
		$resultaten = $statement->fetch();
    } catch (PDOException $e) {
		$error=$e;
		$codeValid = false;
    }
	$storedUsername = $resultaten[0];
	$storedTime = $resultaten[1];
	$storedCode = $resultaten[2];
	$deltaTime = time() - $storedTime;
	if ($deltaTime > 14400) {
		$codeValid = false;
	}
	if ($codeValid) {
		$statement = $dbh->prepare("update Gebruiker set geactiveerd = 1 where gebruikersnaam = ?");
		$statement->execute(array($storedUsername));
	}
} else {
	header("Location: index.php");
	die();
}
?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>
	<p>Code Geldig: <?=$codeValid?></p>
	<p>Opgegeven Code: <?=$submittedCode?></p>
	<p>Verstreken tijd: <?=$deltaTime?></p>
	<p><?php print_r($resultaten);?></p>
</body>

</html>