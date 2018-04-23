<?php
require('connect.php');
/*Register function*/
function register($username,$firstname,$lastname,$address1,$address2,$zipcode,$city,$country,$birthdate,$email,$password,$questionNumber,$replyText,$seller)
{
  global $dbh;
  global $error;

  if(strlen($username)>=50){
    return $error = "username has more than 50 characters";
  }else
  if(strlen($password)>=20){
    return $error = "password has more than 20 characters";
  }else
  if(empty($username)){
      return $error = "username is empty";
  }else
  if(empty($password)){
      return $error = "password is empty";
  }else {
    try {
      $userdata = $dbh->prepare("insert into Gebruiker(gebruikersnaam, voornaam, achternaam, adresregel1, adresregel2, postcode, plaatsnaam, land, geboortedatum, email, wachtwoord, vraagnummer, antwoordtekst, verkoper)
Values(?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?,?, ?,?)");
      $userdata->execute(array($username, $firstname, $lastname, $address1,$address2, $zipcode, $city, $country, $birthdate, $email, $password,$questionNumber, $replyText,$seller));
    } catch (PDOException $e) {
      $error=$e;
    }

  }
}



/*login function */
function login($username,$password)
{
    global $dbh;
    global $error;

    $username=trim($username);
    $password=trim($password);

    if(strlen($username)>=50){
        return $error = "username has more than 50 characters";
    }else
    if(strlen($password)>=20){
        return $error = "password has more than 20 characters";
    }else
    if(empty($username)){
        return $error = "username is empty";
    }else
    if(empty($password)){
        return $error = "password is empty";
    }else {

        try {
            $userdata = $dbh->prepare("select * from Gebruiker where email=? AND wachtwoord=?");
            $userdata->execute(array($username, $password));
        } catch (PDOException $e) {
            $error = $e;
        }
        if (!($result = $userdata->fetch(PDO::FETCH_ASSOC))) {
            return $error = "username or password invalid";
        } else {
            $_SESSION['username'] = $username;
            header("location: index.php");
        }
    }
}
?>
