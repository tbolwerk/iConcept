<?php
function updatePhones() {
  global $dbh;

  //Receive all phone numbers associated with this account
  $statement = $dbh->prepare("select * from Gebruikerstelefoon where gebruikersnaam = ?");
  $statement->execute(array($_SESSION['username']));
  $phones = $statement->fetchAll();

  $numbersToKeep = array();

  //Put all submitted numbers in an array and strip all duplicate numbers
  $submittedPhones = array_unique(array($_POST['phone1'], $_POST['phone2'], $_POST['phone3']));

  //Make sure all numbers are present in the database
  foreach ($submittedPhones as $submittedPhone) {
    if ($submittedPhone != "") {
      insertPhoneNumber($submittedPhone, $phones, $numbersToKeep);
    }
  }
  //Delete all phones associated with this account that shouldn't be kept
  foreach ($phones as $phone) {
    $hit = 0;

    foreach ($numbersToKeep as $number) {
      if ($phone['telefoonnummer'] == $number) {
        $hit = 1;
      }
    }
    if ($hit == 0) {
      $statement = $dbh->prepare("delete Gebruikerstelefoon where volgnummer = ?");
      $statement->execute(array($phone['volgnummer']));
    }
  }
}
?>
