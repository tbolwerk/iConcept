<?php
require_once("templates/connect.php");
require_once("templates/mail/f_verificationMail.php");
require_once("templates/mail/f_auctionClosedMail.php");

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

<?php
if (isset($_GET['subbuyer'])) {
  auctionClosedMail($_GET['email'], $_GET['username'], $_GET['id'], 'buyer');
  echo "Mail verstuurd";
}
?>

<form action="" method="get">
  <input type="text" name="email" value="janbeenham@hotmail.com">

  <input type="text" name="username" value="janbeenham">

  <input type="text" name="id" value="5">

  <button type="submit" name="subbuyer">Veiling gewonnen mail</button>
</form>

<?php
if (isset($_GET['subseller'])) {
  auctionClosedMail($_GET['email'], $_GET['username'], $_GET['id'], 'seller');
  echo "Mail verstuurd";
}
?>

<form action="" method="get">
  <input type="text" name="email" value="janbeenham@hotmail.com">

  <input type="text" name="username" value="janbeenham">

  <input type="text" name="id" value="5">

  <button type="submit" name="subseller">Voorwerp verkocht mail</button>
</form>

<?php
if (isset($_GET['subsellerfailed'])) {
  auctionClosedMail($_GET['email'], $_GET['username'], $_GET['id'], 'sellerfailed');
  echo "Mail verstuurd";
}
?>

<form action="" method="get">
  <input type="text" name="email" value="janbeenham@hotmail.com">

  <input type="text" name="username" value="janbeenham">

  <input type="text" name="id" value="5">

  <button type="submit" name="subsellerfailed">Voorwerp niet verkocht mail</button>
</form>
