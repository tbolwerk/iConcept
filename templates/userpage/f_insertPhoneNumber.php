<?php
//Insert a number into the database if the number can't be found in the $phones array, which should contain
// all numbers in the database associated with this account
function insertPhoneNumber($number, $phones, &$numbersToKeep) {
  global $dbh;

  $hit = 0;
  foreach ($phones as $phone) {
    if ($number == $phone['telefoonnummer']) {
      $hit = 1;
    }
  }
  //If the phone can't be found in the database
  if ($hit == 0) {
    //Insert it
    $statement = $dbh->prepare("insert into Gebruikerstelefoon(gebruikersnaam, telefoonnummer) Values (?, ?)");
    $statement->execute(array($_SESSION['username'], $number));
  }
  //This number should not be deleted
  array_push($numbersToKeep, $number);
}
?>
