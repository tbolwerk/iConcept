<?php
require('connect.php');
/*Register function*/
function register($username,$firstname,$lastname,$address1,$address2,$zipcode,$city,$country,$birthdate,$email,$email_check,$password,$password_check,$secretAnswer)
{
  global $dbh;
  global $error;


if(empty($username))
{
  $error = "username empty";
}else
if(empty($password))
{
  $error = "password empty";
}else
if(empty($email))
{
 $error = "email empty";
}else
if($email != $email_check)
{
  $error = "email do not match";
}else
if($password != $password_check)
{
  $error = "password do not match";
}else{
  try {
      $userdata = $dbh->prepare("select * from Gebruiker where email=? AND gebruikersnaam=?");
      $userdata->execute(array($email, $username));
  } catch (PDOException $e) {
      $error = $e;
  }
  if (($result = $userdata->fetch(PDO::FETCH_ASSOC))) {
       $error = "username or password already exists";
  }else{
    try {
      $userdata = $dbh->prepare("insert into Gebruiker(gebruikersnaam, voornaam, achternaam, adresregel1, adresregel2, postcode, plaatsnaam, land, geboortedatum, email, wachtwoord, vraagnummer, antwoordtekst, verkoper)
Values(?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?,?, ?,?)");
      $userdata->execute(array($username, $firstname, $lastname, $address1,$address2, $zipcode, $city, $country, $birthdate, $email, $password,"", $secretAnswer,""));
      $error = "account succesfully made";
    } catch (PDOException $e) {
      $error=$e;
    }

  }
}
}



/*login function */
function login($username,$password)
{


    global $dbh;
    global $error;
  $error = "";
    $username=trim($username);
    $password=trim($password);

    if(strlen($username)>=50){
         $error = "username has more than 50 characters";
    }else
    if(strlen($password)>=20){
         $error = "password has more than 20 characters";
    }else
    if(empty($username)){
         $error = "username is empty";
    }else
    if(empty($password)){
         $error = "password is empty";
    }else {

        try {
            $userdata = $dbh->prepare("select * from Gebruiker where email=? AND wachtwoord=?");
            $userdata->execute(array($username, $password));
        } catch (PDOException $e) {
            $error = $e;
        }
        if (!($result = $userdata->fetch(PDO::FETCH_ASSOC))) {
             $error = "username or password invalid";
        } else {
            $_SESSION['username'] = $username;
            header("location: index.php");
        }
    }
}



function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}

?>
