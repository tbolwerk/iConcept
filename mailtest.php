<?php
require_once("templates/functions.php");

if (isset($_GET['submit'])) {
  mailUser($_GET['email'], $_GET['username'], $_GET['type']);
  echo "Mail verstuurd";
}
?>

<form action="" method="get">
  <input type="text" name="email" placeholder="email">

  <input type="text" name="username" placeholder="gebruikersnaam">

  <input type="text" name="type" placeholder="soort">

  <button type="submit" name="submit">Stuur mail</button>
</form>
