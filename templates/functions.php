<?php
require('connect.php');
/*verification function*/
function verification($submittedCode)
{

	global $dbh;
  global $codeValid;
  global $submittedCode;
  global $deltaTime;
  global $resultaten;

	$codeValid = false;

	try {//checks if code exists in database
	$statement = $dbh->prepare("select * from Verificatiecode where code = ?");
	$statement->execute(array($submittedCode));
	$resultaten = $statement->fetch();
  $codeValid = true;
	} catch (PDOException $e) {
	$error= "Code invalid";
	$codeValid = false;
	}

	$storedUsername = $resultaten[0];
	$storedTime = $resultaten[1];
	$storedCode = $resultaten[2];

	$deltaTime = time() - $storedTime;

	if ($deltaTime > 14400) {
	$codeValid = false;
  $error = "Time has expired";
	}

	if ($codeValid) {
	$statement = $dbh->prepare("update Gebruiker set geactiveerd = 1 where gebruikersnaam = ?");
	$statement->execute(array($storedUsername));
	}

}


/*Register function*/
function register($username,$firstname,$lastname,$address1,$address2,$zipcode,$city,$country,$birthdate,$email,$email_check,$password,$password_check,$secretAnswer)
{
  global $dbh;
  global $error;


if(empty($username))//checks if username is not empty
{
  $error = "username empty";
}else
if(empty($password) || empty($password_check))//checks if password is not empty
{
  $error = "password empty";
}else
if(empty($email) || empty($email_check))//checks if email is not empty
{
 $error = "email empty";
}else
if($email != $email_check)//checks if email equils email_check
{
  $error = "email do not match";
}else
if($password != $password_check)//checks if password equils password_check
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
      $userdata = $dbh->prepare("insert into Gebruiker(gebruikersnaam, voornaam, achternaam, adresregel1, adresregel2, postcode, plaatsnaam, land, geboortedatum, email, wachtwoord, vraagnummer, antwoordtekst, verkoper,geactiveerd)
Values(?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?,?, ?,?,?)");
      $userdata->execute(array($username, $firstname, $lastname, $address1,$address2, $zipcode, $city, $country, $birthdate, $email, $password,0, $secretAnswer,0,0));
      $error = "email vertification send";
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
             $error = "username or password invalid <a href='forget_password.php'>Forgot password</a>";
        } else {
            $_SESSION['username'] = $username;
            header("location: index.php");
        }
    }
}

function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}

function createVerificationCode($username, $random_password) {
	global $dbh;
	global $error;

    try {
		$userdata = $dbh->prepare("insert into Verificatiecode(gebruikersnaam, tijd, code) Values(?, ?, ?)");
		$userdata->execute(array($username, time(), $random_password));
    } catch (PDOException $e) {
		$error=$e;
    }
}
?>
