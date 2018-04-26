<?php
require('connect.php');
/*verification function*/
function verification($getUsername,$getCode)
{

	global $dbh;
  global $codeValid;
  global $submittedCode;
  global $deltaTime;
  global $results;

	$codeValid = true;//codeValid is true until proven that it's not
  $submittedCode = $getCode;
	$username = $getUsername;

	try {//checks if code exists in database
	$statement = $dbh->prepare("select * from Verificatiecode where gebruikersnaam = ? AND code = ?");
	$statement->execute(array($username,$submittedCode));
	$resultaten = $statement->fetch();
	} catch (PDOException $e) {
	$error= "Code invalid";
	$codeValid = false;
	}

	$storedUsername = $resultaten[0];
	$storedTime = $resultaten[1];
	$storedCode = $resultaten[2];

	$deltaTime = time() - $storedTime;

	if ($deltaTime > 14400) {//14400 seconds = 4 hours
	$codeValid = false;
  $error = "Time has expired";
	}

	if ($codeValid) {
	$statement = $dbh->prepare("update Gebruiker set geactiveerd = 1 where gebruikersnaam = ?");
	$statement->execute(array($storedUsername));
	$statement = $dbh->prepare("delete Verificatiecode where gebruikersnaam = ?");
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
       $error = "email or username already exists";
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
function login($username_input,$password)
{

    global $dbh;
    global $error;

		$username = $username_input;
		$email = $username_input;

    // $username=trim($username);
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
            $userdata = $dbh->prepare("select * from Gebruiker where gebruikersnaam=? AND wachtwoord=? OR email=? AND wachtwoord=?");
            $userdata->execute(array($username,$password,$email, $password));

        } catch (PDOException $e) {
            $error = $e;
        }
        if (!($result = $userdata->fetch(PDO::FETCH_ASSOC))) {
             $error = "username or password invalid";
        } else {
            $_SESSION['username'] = $result['gebruikersnaam'];
						header('Location: index.php');
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
		$userdata = $dbh->prepare("insert into Verificatiecode(gebruikersnaam, begintijd, code) Values(?, ?, ?)");
		$userdata->execute(array($username, time(), $random_password));
    } catch (PDOException $e) {
		$error=$e;
    }
}

function getAuctionTime($voorwerpnummer)
{
  global $dbh;

  global $looptijd;
  global $looptijdbegindag;
  global $looptijdeindedag;
  global $looptijdeindetijdstip;
  global $looptijdbegintijdstip;

try {
  $userdata = $dhb->prepare("select looptijd, looptijdbegindag, looptijdbegintijdstip,looptijdeindedag,looptijdeindetijdstip from Voorwerp where ?");
  $userdata->execute(array($voorwerpnummer));
  $userdata->fetch();
  $looptijd = $userdata[0];
    $looptijdbegindag = $userdata[1];
      $looptijdbegintijdstip = $userdata[2];
      $looptijdeindedag = $userdata[3];
      $looptijdeindetijdstip = $userdata[4];
}catch (PDOException $e) {
  $error=$e;
}

}

function  auctionTimer($voorwerpnummer){
  global $timer;
  getAuctionTime($voorwerpnummer);
  $remaining = ($looptijdeindedag+$looptijdeindetijdstip) - time();
  $days_remaining = floor($remaining/86400);
  $hours_remaining = floor(($remaining/86400)/ 3600);
  if($days_remaining>1){
    $timer = $days_remaining;
  }else{
    $timer = $days_remaining + $hours_remaining;
  }
}


function changePassword($new_password)
{
global $error;
global $dbh;
$username=$_SESSION['username'];
try {
	// $dbh->query("update Gebruiker set wachtwoord='$new_password' where gebruikersnaam='$username'");
	$statement=$dbh->prepare("update Gebruiker set wachtwoord = ? where gebruikersnaam=?");
	$statement->execute(array($new_password,$username));

} catch (PDOException $e) {
 	$error =  $e;
}
}

function addPicture(){
//in production
   $allowedExts = array("jpg", "jpeg", "gif", "png", "bmp");
        $extension = end(explode(".", $_FILES["file"]["name"]));
$avatarnaam = $_FILES["file"]["name"];
        echo $_FILES["file"]["size"];

        if (
            (
            ($_FILES["file"]["type"] == "image/gif")
            || ($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/png")
            || ($_FILES["file"]["type"] == "image/pjpeg")
            )
            && ($_FILES["file"]["size"] < 2000000)
            && in_array($extension, $allowedExts))
          {


         if ($_FILES["file"]["error"] > 0)
                {

                    $error= "Return Code: " . $_FILES["file"]["error"] . "<br />";

                } else {

                    $error= "Upload: " . $_FILES["file"]["name"] . "<br />";
                    $error= "Type: " . $_FILES["file"]["type"] . "<br />";
                    $error=  "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
                    $error= "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

                    if (file_exists("avatar/" . $_FILES["file"]["name"])) {
                      $error= $_FILES["file"]["name"] . " already exists. ";
$result = mysql_query("UPDATE users SET avatarnaam='$avatarnaam' WHERE name='$name'")
or die(mysql_error());
                    } else {
                      move_uploaded_file($_FILES["file"]["tmp_name"],
                      "avatar/" . $_FILES["file"]["name"]);
                      $error= "Stored in: " . "upload/" . $_FILES["file"]["name"];
					  $result = mysql_query("UPDATE users SET avatarnaam='$avatarnaam' WHERE name='$name'")
or die(mysql_error());
                    }
                }

          }    else {

            $error= $_FILES["file"]["type"]."<br />";
              $error = "Invalid file try another Image";

          }
}




?>
