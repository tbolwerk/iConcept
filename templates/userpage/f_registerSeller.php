<?php
function registerSeller($username, $checkoption, $creditcard, $bank, $banknumber){
  global $dbh;
  global $message;
  global $errors;
  $errors = array();

  try {
    $data = $dbh->prepare("select verkoper from Gebruiker where gebruikersnaam = ?");
    $data->execute(array($username));
    $seller = $data->fetch();

  } catch (PDOException $e) {
    $error=$e;
    echo $error;
  }
  if($seller[0] == 1)//checks if user is seller
  {
    $errors['seller'] = "U bent al een verkoper.";
  }
  else {
    if(empty($checkoption))//checks if checkoption is not empty
    {
      $errors['checkoption'] = "Dit is een verplicht veld.";
    }
    if($checkoption == "creditcard" && empty($creditcard))//checks if title is not empty and if creditcardoption is selected
    {
      $errors['creditcard'] = "Dit is een verplicht veld.";
    }
    if(empty($bank) && empty($creditcard) && $checkoption != "creditcard"){
      $errors['bank'] = "Dit is een verplicht veld.";
    }
    if(empty($banknumber) && empty($creditcard) && $checkoption != "creditcard"){
      $errors['banknumber'] = "Dit is een verplicht veld.";
    }

    if(count($errors) == 0){//checks if there are errors
      if($checkoption == "creditcard"){
        $bank = null;
        $banknumber = null;
        try {
          $data = $dbh->prepare("insert into Verkoper(gebruikersnaam, controleoptienaam, creditcardnummer, banknaam, rekeningnummer) values(?, ?, ?, ?, ?)");//inserts sellerdata in database
          $data->execute(array($username, $checkoption, $creditcard,  $bank, $banknumber));
          $userdata = $dbh->prepare("update Gebruiker set verkoper = 1 where gebruikersnaam = ?;");//registers user as seller
          $userdata->execute(array($username));
          $_SESSION['seller'] = 1;
          $message = "<p class='green-text lead'>U bent succesvol registreerd als verkoper.</p>";
        }
        catch (PDOException $e) {
          $error=$e;
          echo $error;
        }
			}
      else{
        $creditcard = null;
          try {
  					$data = $dbh->prepare("insert into Verkoper(gebruikersnaam, controleoptienaam, creditcardnummer, banknaam, rekeningnummer) values(?, ?, ?, ?, ?)");//inserts sellerdata in database
  					$data->execute(array($username, $checkoption, $creditcard,  $bank, $banknumber));
  					$code = random_password(6);//generates random code
  					createVerificationCodeSeller($username, $code);
            $message = "<p class='green-text lead'>U krijgt per post een code toegestuurd waarmee U het proces om verkoper te worden kunt afronden.</p>";
  				}
  				catch (PDOException $e) {
  					$error=$e;
  					echo $error;
  				}
			  }
      }
    }
  }
?>
