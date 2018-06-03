<?php
//Updates the record for this user with the new password
function changePassword($new_password) {
  global $error;
  global $dbh;

$hash=password_hash($new_password, PASSWORD_DEFAULT);
  $username = $_SESSION['username'];
  try {
    // $dbh->query("update Gebruiker set wachtwoord='$new_password' where gebruikersnaam='$username'");
    $statement=$dbh->prepare("update Gebruiker set wachtwoord = ? where gebruikersnaam=?");
    $statement->execute(array($hash,$username));
  } catch (PDOException $e) {
  	$error =  $e;
  }
}
?>
