<?php
require_once("templates/mail/f_verificationMail.php");

if (isset($_GET['subregister'])) {
  verificationMail($_GET['email'], $_GET['username'], $_GET['code'], 'register');
  echo "Mail verstuurd";
}
?>

<form action="" method="get">
  <input type="text" name="email" value="janbeenham@hotmail.com">

  <input type="text" name="username" value="janbeenham">

  <input type="text" name="code" value="2k48d2">

  <button type="submit" name="subregister">Registerverificatie mail</button>
</form>

<?php
if (isset($_GET['submail'])) {
  verificationMail($_GET['email'], $_GET['username'], $_GET['code'], 'mail');
  echo "Mail verstuurd";
}
?>

<form action="" method="get">
  <input type="text" name="email" value="janbeenham@hotmail.com">

  <input type="text" name="username" value="janbeenham">

  <input type="text" name="code" value="2k48d2">

  <button type="submit" name="submail">Mailverificatie mail</button>
</form>
