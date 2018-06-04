<?php
require_once("templates/mail/f_registerVerificationMail.php");

if (isset($_GET['subregister'])) {
  registerVerificationMail($_GET['email'], $_GET['username'], $_GET['code']);
  echo "Mail verstuurd";
}
?>

<form action="" method="get">
  <input type="text" name="email" value="janbeenham@hotmail.com">

  <input type="text" name="username" value="janbeenham">

  <input type="text" name="code" value="2k48d2">

  <button type="submit" name="subregister">Registerverificatie mail</button>
</form>
