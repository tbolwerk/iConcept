<?php
$current_page='postregister';
require('templates/header.php');

if(isset($_POST['submit'])){
	register($_POST['username'],$_POST['firstname'],$_POST['lastname'],$_POST['address1'],$_POST['address2'],$_POST['zipcode'],$_POST['city'],$_POST['country'],$_POST['birthdate'],$_POST['email'],$_POST['email_check'],$_POST['password'],$_POST['password_check'],$_POST['secretAnswer']);
	
	$random_password = random_password(6);
	createVerificationCode($_POST['username'], $random_password);
	
	$message = "http://http://iconcept.tpnb.nl/verification.php?code=" . $random_password;
	$message = wordwrap($message, 70, "\r\n");

	mail($_POST['email'], "Verificatiecode EenmaalAndermaal", $message, "From: EenmaalAndermaal@iConcepts.com");
}
?>

<html>
<body>

<br>
<br>
<br>
<p>Er is een mail gestuurd naar <?=$_POST['email']?>.</p>

</body>
</html>
