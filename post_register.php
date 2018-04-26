<?php
$current_page='register';
require('templates/header.php');

if(isset($_POST['submit'])){
	register($_POST['username'],$_POST['firstname'],$_POST['lastname'],$_POST['address1'],$_POST['address2'],$_POST['zipcode'],$_POST['city'],$_POST['country'],$_POST['birthdate'],$_POST['email'],$_POST['email_check'],$_POST['password'],$_POST['password_check'],$_POST['secretAnswer']);
	$username = $_POST['username'];
	$code = random_password(6);
	$url = "verification.php?username=" . urlencode($username) . "&code=" . urlencode($code);
	createVerificationCode($_POST['username'], $code);

	$message = "http://http://iconcept.tpnb.nl/".$url;
	$message = wordwrap($message, 70, "\r\n");


	// mail($_POST['email'], "Verificatiecode EenmaalAndermaal", $message, "From: EenmaalAndermaal@iConcepts.com");
}
?>




<br>
<br>
<br>
<p>Er is een mail gestuurd naar <?=$_POST['email']?>.</p>
<p><a class="black-text" href="<?=$url?>">verification code</a>
