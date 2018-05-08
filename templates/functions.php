<?php
require('connect.php');




/*search function database table database column and search item EXAMPLE: search(bank); will give $searchResults is an array else $error*/
function search($searchKey,$searchType)
{
	global $dbh;
	global $error;
	global $searchResults;
	$searchResults="";
	try {
		if($searchType == 'voorwerp'){
		$data = $dbh->prepare("SELECT * FROM Voorwerp WHERE titel LIKE ?");
		$data->execute(array('%'.$searchKey.'%'));
    while ($row = $data->fetch()) {
		$searchResults.="Titel: ".$row['titel']." Beschrijving: ".$row['beschrijving'];
	}
}else if($searchType == 'rubriek'){
	$data = $dbh->prepare("SELECT * FROM Voorwerp_in_Rubriek vr RIGHT JOIN Voorwerp v ON v.voorwerpnummer=vr.voorwerpnummer WHERE vr.rubrieknummer = ?");
	$data->execute(array($searchKey));
	while($row = $data->fetch()){
	$searchResults.="Titel: ".$row['titel']." Beschrijving: ".$row['beschrijving'];
	}

}
	}catch(PDOException $e){
		$error = $e;
	}
}


/*display auction*/
function displayAuction()
{


	global $dbh;
	global $auction;
	$auction = "";

	try{
		$data = $dbh->query("select * from Voorwerp");
		while ($row = $data->fetch()) {

			$auction.="  <div class='col-md-4'>
          <div class='card auction-card'>
            <div class='view overlay'>
              <img class='card-img-top' src='https://mdbootstrap.com/img/Mockups/Lightbox/Thumbnail/img%20(67).jpg' alt='Test Card' />
            </div>
            <div class='card-body'>
              <span class='small-font'>20345322</span>
              <h4 class='card-title'>".$row['titel']." #".$row['voorwerpnummer']."</h4>
              <hr>
              <div class='card-text'>
                <p>
                ".$row['beschrijving']."
                </p>
              </div>
              <hr />
              <ul class='list-unstyled list-inline'>
                <li class='list-inline-item pr-2'><i class='fa fa-lg fa-gavel pr-2'></i>&euro;".$row['startprijs']."</li>
                <li class='list-inline-item pr-2'><i class='fa fa-lg fa-clock pr-2'></i></li>
              </ul>
            </div>
            <div class='view overlay mdb-blue'>
              <a href='auction.php/?key=".$row['voorwerpnummer']."' class='veiling-bieden'>
                <li class='list-inline-item pr-2'><i class='fa fa-lg fa-clock pr-2'></i></p></li>
              </ul>
            </div>
            <div class='view overlay mdb-blue'>
              <a href='auction.php?voorwerpnummer=".$row['voorwerpnummer']."' class='veiling-bieden'><div class='mask flex-center rgba-white-slight waves-effect waves-light'></div>
                  <p style='text-align:center'>Bieden</p>
                </div>
              </a>
            </div>
          </div>";
		}
	}catch(PDOException $e){
		$error = $e;
	}

}

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
	$results = $statement->fetch();
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
function register($username,$firstname,$lastname,$address1,$address2,$zipcode,$city,$country,$birthdate,$email,$email_check,$password,$password_check,$secretAnswer,$secretQuestion)
{
  global $dbh;
  global $error;
	global $errors;
	$errors = array();


if(empty($username))//checks if username is not empty
{
  $errors['username'] = "Dit is een verplicht veld.";
}
else{
	try {
			$userdata = $dbh->prepare("select * from Gebruiker where gebruikersnaam=?");
			$userdata->execute(array($username));
	} catch (PDOException $e) {
			$error = $e;
	}
	if (($result = $userdata->fetch(PDO::FETCH_ASSOC))) {
			 $errors['username'] = "Deze gebruikersnaam bestaat al.";
	}
}
if(empty($password) || empty($password_check))//checks if password is not empty
{
  $errors['password'] = "Dit is een verplicht veld.";
}else
if($password != $password_check)//checks if password equils password_check
{
  $errors['password'] = "Het wachtwoord komt niet overeen.";
}
if(empty($email) || empty($email_check))//checks if email is not empty
{
 $errors['email'] = "Dit is een verplicht veld.";
}else
if($email != $email_check)//checks if email equils email_check
{
  $errors['email'] = "Het email-adres komt niet overeen.";
}
else{
	try {
			$userdata = $dbh->prepare("select * from Gebruiker where email=?");
			$userdata->execute(array($email));
	} catch (PDOException $e) {
			$error = $e;
	}
	if (($result = $userdata->fetch(PDO::FETCH_ASSOC))) {
			 $errors['email'] = "Dit email-adres is al in gebruik.";
	}
}
if($secretQuestion == "kies")//checks if username is not empty
{
  $errors['secretQuestion'] = "Dit is een verplicht veld.";
}
if(empty($secretAnswer))//checks if username is not empty
{
  $errors['secretAnswer'] = "Dit is een verplicht veld.";
}
if(empty($firstname))//checks if username is not empty
{
  $errors['firstname'] = "Dit is een verplicht veld.";
}
if(empty($lastname))//checks if username is not empty
{
  $errors['lastname'] = "Dit is een verplicht veld.";
}
if(empty($zipcode))//checks if username is not empty
{
  $errors['zipcode'] = "Dit is een verplicht veld.";
}
if(empty($address1))//checks if username is not empty
{
  $errors['address1'] = "Dit is een verplicht veld.";
}
if(empty($city))//checks if username is not empty
{
  $errors['city'] = "Dit is een verplicht veld.";
}
if(empty($country))//checks if username is not empty
{
  $errors['country'] = "Dit is een verplicht veld.";
}
if(empty($birthdate))//checks if username is not empty
{
  $errors['birthdate'] = "Dit is een verplicht veld.";
}

if(count($errors) == 0){//checks if there are errors
    try {
      $userdata = $dbh->prepare("insert into Gebruiker(gebruikersnaam, voornaam, achternaam, adresregel1, adresregel2, postcode, plaatsnaam, land, geboortedatum, email, wachtwoord, vraagnummer, antwoordtekst, verkoper,geactiveerd)
Values(?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?,?, ?,?,?)");
      $userdata->execute(array($username, $firstname, $lastname, $address1,$address2, $zipcode, $city, $country, $birthdate, $email, $password, $secretQuestion, $secretAnswer,0,0));
			copy("img/avatar/avatar.png","img/avatar/".$username.".png");
			header("Location: post_register.php?username={$username}");

    } catch (PDOException $e) {
      $error=$e;
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

		$error = array();

    if(strlen($username)>=50){
         $error['username'] = "username has more than 50 characters";
    }else
    if(strlen($password)>=20){
         $error['password'] = "password has more than 20 characters";
    }else
    if(empty($username)){
         $error['username'] = "username is empty";
    }else
    if(empty($password)){
         $error['password'] = "password is empty";
    }else {
        try {
            $username_check = $dbh->prepare("select * from Gebruiker where gebruikersnaam=? OR email=?");
            $username_check->execute(array($username,$email));

        } catch (PDOException $e) {
            $error = $e;
        }
        if (!($username_result = $username_check->fetch(PDO::FETCH_ASSOC))) {
             $error['username'] = "gebruikersnaam klopt niet";
        }

				try{
					$password_check = $dbh->prepare("SELECT * FROM Gebruiker WHERE gebruikersnaam=? AND wachtwoord=? OR email=? AND wachtwoord=?");
					$password_check->execute(array($username,$password,$email,$password));
				}catch(PDOException $e){
					$error = $e;
				}
				if(!($password_result = $password_check->fetch(PDO::FETCH_ASSOC))) {
					$error['password'] = "wachtwoord klopt niet";
				}
				if($password_result && $username_result) {
            $_SESSION['username'] = $username_result['gebruikersnaam'];
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



function  auctionTimer($voorwerpnummer){
global $dbh;
global $error;
$timer = "3 uur";
	try {
	  $userdata = $dbh->prepare("select * from Voorwerp where ?");
	  $voorwerpdata = $userdata->execute(array($voorwerpnummer));
	  $voorwerpdata->fetch();
	  $looptijd = $voorwerpdata['looptijd'];
	    $looptijdbegindag = $voorwerpdata['looptijdbegindag'];
	      $looptijdbegintijdstip = $voorwerpdata['looptijdbegintijdstip'];
	      $looptijdeindedag = $voorwerpdata['looptijdeindedag'];
	      $looptijdeindetijdstip = $voorwerpdata['looptijdeindetijdstip'];
				$remaining = ($looptijdeindedag+$looptijdeindetijdstip) - time();
				$days_remaining = floor($remaining/86400);
				$hours_remaining = floor(($remaining/86400)/ 3600);
				if($days_remaining>1){
					$timer = $days_remaining;
				}else{
					$timer = $days_remaining + $hours_remaining;
				}
	}catch (PDOException $e) {
	  $error=$e;
	}

	return $timer;
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

function addPicture($picture,$file_name){
	// $file = array();
	// foreach ($picture as $key1 => $value1) {
	// 	foreach ($value1 as $key2 => $value2) {
	// 	$file[$key2][$key1] = $value2;
	// }
	// }
global $error;
global $dbh;

$error="";
//in production
$file = $picture;
$error="";
//in production
	 $allowedExts = array("png");
				$tmp_extension = explode(".", $file["name"]);
				$extension = end($tmp_extension);
				if (
						(
							 ($file["type"] == "image/gif")
						|| ($file["type"] == "image/jpeg")
						|| ($file["type"] == "image/png")
						|| ($file["type"] == "image/pjpeg")
						)
						&& ($file["size"] < 2000000)
						&& in_array($extension, $allowedExts))
					{
				 if ($file["error"] > 0)
								{
										$error.= "Return Code: " . $file["error"] . "<br />";
								} else {
										$error.= "Upload: " . $file["name"] . "<br />";
										$error.= "Type: " . $file["type"] . "<br />";
										$error.=  "Size: " . ($file["size"] / 1024) . " Kb<br />";
										$error.= "Temp file: " . $file["tmp_name"] . "<br />";
										move_uploaded_file($file["tmp_name"],
										"img/avatar/" . $_SESSION["username"] . "." . $extension);
										$error.= "Stored in: " . "img/avatar/" . $file_name . "." . $extension;
								}
					}    else {

						$error.= $file["type"]."<br />";
							$error.= "Invalid file try another Image";
					}
}
?>
