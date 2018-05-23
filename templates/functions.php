<?php
require('connect.php');
function livesearch($post_livesearch){//livesearch function met parameter $_POST['search']
  global $dbh;
  global $rubrieken;
  global $subrubrieken;
  global $veilingen;

//Getting value of "search" variable from "script.js".
$return ="";
$rubrieken="";
$name = $post_livesearch;
  // $name = $_POST['livesearch'];
  try{
  $statement = $dbh->prepare("SELECT * FROM Rubriek WHERE rubrieknaam LIKE ? AND rubrieknummerOuder=-1");//zoekt in hoofdrubrieken
  $statement->execute(array("%".$name."%"));
}catch(PDOException $e){
  $error = $e;
}

  while($row = $statement->fetch()){
    $rubrieknaam = $row['rubrieknaam'];
    $rubrieknummer = $row['rubrieknummer'];
    $function = "fill('".$rubrieknaam."')";
    $rubrieken.="<li onclick='".$function."'><a class='dummy-media-object' href='?rubrieknummer=".$rubrieknummer."'><h3>".$rubrieknaam."</h3></li></a>";
  }
  //Sub-rubrieken
  $subrubrieken="";
  //zoekt in subrubrieken
  try{
    $statement = $dbh->prepare("SELECT kind.rubrieknummer,kind.rubrieknaam,kind.rubrieknummerOuder,ouder.rubrieknaam as 'ouderRubriek'
FROM Rubriek kind INNER JOIN Rubriek ouder ON kind.rubrieknummerOuder = ouder.rubrieknummer
WHERE kind.rubrieknaam LIKE ?");
    $statement->execute(array("%".$name."%"));

  }catch(PDOException $e){
    $error = $e;
  }
  while($row = $statement->fetch()){

    $rubrieknaam = $row['rubrieknaam'];
    $rubrieknaamOuder = $row['ouderRubriek'];
    $rubrieknummer = $row['rubrieknummer'];
    $function = "fill('".$rubrieknaam."')";
      if($row['rubrieknummerOuder'] !=-1){
    $subrubrieken.="<li onclick='".$function."'><a class='dummy-media-object' href='?rubrieknummer=".$rubrieknummer."'><h6>".$rubrieknaamOuder."</h6><h3>".$rubrieknaam."</h3></li></a>";
}
  }


  $veilingen="";
  //zoekt in veilingen
  try{
    $statement = $dbh->prepare("SELECT vw.voorwerpnummer,vw.titel,vr.rubrieknummer,r.rubrieknaam
FROM Rubriek r,Voorwerp vw INNER JOIN Voorwerp_in_Rubriek vr ON
vw.voorwerpnummer = vr.voorwerpnummer
WHERE  r.rubrieknummer = vr.rubrieknummer
AND titel LIKE ?");
    $statement->execute(array("%".$name."%"));
  }catch(PDOException $e){
    $error = $e;
  }

  while($row = $statement->fetch()){


    $voorwerptitel = $row['titel'];
    $voorwerpnummer = $row['voorwerpnummer'];
    $rubrieknummer = $row['rubrieknummer'];
    $rubrieknaam = $row['rubrieknaam'];

    $function = "fill('".$rubrieknaam."')";

    $veilingen.="<li onclick='".$function."'><a class='dummy-media-object' href='?voorwerpnummer=".$voorwerpnummer."'><h6>".$rubrieknaam."</h6><h3>".$voorwerptitel."</h3></li></a>";

  }


}

function displayColumn(){

	global $dbh;
	global $column;
  $column = "";
  try{
    $data = $dbh->query("SELECT * FROM Rubriek");
    while($row = $data->fetch()){
			if($row['rubrieknummerOuder'] == -1){//als rubrieknummerOuder == -1 geeft hoofdrubrieken
      $column.="<a href='?rubrieknummer=".$row['rubrieknummer']."'>".$row['rubrieknaam']."</a>";
		}else if(isset($_GET['rubrieknummer'])){//als er een get request is , zoekt bij behorende rubrieknummerOuder
			if($row['rubrieknummerOuder'] == $_GET['rubrieknummer']){
				$column.="<a href='?rubrieknummer=".$row['rubrieknummer']."'>".$row['rubrieknaam']."</a>";
			}
		}
    }
    }catch(PDOException $e){
      $column = $e;
  }
}


/*display auction*/
function displayAuction()
{


	global $dbh;
	global $auction;
	$auction = "<script>
        var countDownDate = [];
        </script>";

	try{
		$data = $dbh->query("SELECT * FROM Voorwerp vw INNER JOIN Bestand b ON vw.voorwerpnummer=b.voorwerpnummer");

		while ($row = $data->fetch()) {
      $i++;
      $timer="timer".$i;
      $looptijd = $row['looptijd'];
      $looptijdbegindag =strtotime($row['looptijdbegindag']);
      $looptijdbegintijdstip = strtotime($row['looptijdtijdstip']);
      $countdown_date = date("Y-m-d",$looptijdbegindag);
      $countdown_time = date("h:i:s",$looptijdbegintijdstip);
      $countdown = $countdown_date . " " . $countdown_time;



			$auction.="  <div class='col-sm-12 col-md-6 col-lg-4'>
          <div class='card auction-card'>
            <div class='view overlay'>
              <img class='card-img-top' src='".$row['filenaam']."' alt='".$row['titel']."' />
            </div>
            <div class='card-body'>
              <span class='small-font'>".$row['voorwerpnummer']."</span>
              <h4 class='card-title'>".$row['titel']." #".$row['voorwerpnummer']."</h4>
              <hr>
              <div class='card-text'>
                <p>
                ".$row['beschrijving']."
                </p>
              </div>
              <hr />
              <ul class='list-unstyled list-inline d-flex'>
                <li class='list-inline-item flex-1 ml-5'><i class='fa fa-lg fa-gavel pr-2'></i>&euro;".$row['startprijs']."</li>
								<div class='card-line'></div>
                <li class='list-inline-item flex-1 mr-5'><i class='fa fa-lg fa-clock pr-2'></i><div id=".$timer."></div></li>
              </ul>
            </div>

            <div class='view overlay mdb-blue'>
              <a href='auction.php?voorwerpnummer=".$row['voorwerpnummer']."' class='veiling-bieden'><div class='mask flex-center rgba-white-slight waves-effect waves-light'></div>
                  <p style='text-align:center'>Bieden</p>
                </div>
              </a>
            </div>
          </div>
          <script>
                countDownDate.push(new Date('".$countdown."').getTime());
          </script>

          ";
		}
	}catch(PDOException $e){
		$error = $e;
	}

}

 /*display auctionpage*/
 function displayAuctionpage()
 {
 
 
   global $dbh;
   global $auctionpage;
   $auction = "<script>
         var countDownDate = [];
         </script>";
 
   try{
     $data = $dbh->query("SELECT * FROM Voorwerp vw INNER JOIN Bestand b ON vw.voorwerpnummer=b.voorwerpnummer");
 
     while ($row = $data->fetch()) {
  
       $looptijd = $row['looptijd'];
       $looptijdbegindag =strtotime($row['looptijdbegindag']);
       $looptijdbegintijdstip = strtotime($row['looptijdtijdstip']);
       $countdown_date = date("Y-m-d",$looptijdbegindag);
       $countdown_time = date("h:i:s",$looptijdbegintijdstip);
       $countdown = $countdown_date . " " . $countdown_time;
 
 
 
       $auctionpage.='  <div class="card auction-card mb-4 col-md-4">
       <div class="view overlay">
         <img class="card-img-top" src="https://picsum.photos/388/258/?image=4" alt="Test Card" />
       </div>
       <div class="card-body">
         <span class="small-font">20345322</span>
         <h4 class="card-title">'.$row["titel"].'</h4>
         <hr>
         <div class="card-text">
           <p>
             '.$row["beschrijving"].'
           </p>
         </div>
         <hr />
         <ul class="list-unstyled list-inline d-flex" style="text-align:center">
           <li class="list-inline-item pr-2 flex-1 ml-5"><i class="fa fa-lg fa-gavel pr-2"></i>&euro;40,50</li>
           <div class="card-line"></div>
           <li class="list-inline-item pr-2 flex-1 mr-5"><i class="fa fa-lg fa-clock pr-2"></i>02:01:21</li>
         </ul>
       </div>
     </div>
 
           ';
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
	$statement = $dbh->prepare("SELECT * FROM Verificatiecode WHERE gebruikersnaam = ? AND code = ?");
	$statement->execute(array($username,$submittedCode));
	$results = $statement->fetch();
	} catch (PDOException $e) {
	$error= "Code invalid";
	$codeValid = false;
	}

	$storedUsername = $results[0];
	$storedTime = $results[1];
	$storedCode = $results[2];

	$deltaTime = time() - $storedTime;

	if ($deltaTime > 14400) {//14400 seconds = 4 hours
	$codeValid = false;
  $error = "Time has expired";
	}

	if ($codeValid) {
	$statement = $dbh->prepare("update Gebruiker set geactiveerd = 1 where gebruikersnaam = ?");//set activatie bit to 1
	$statement->execute(array($storedUsername));
	$statement = $dbh->prepare("delete Verificatiecode where gebruikersnaam = ?");//clean database
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
function login($username_input, $password)
{
  global $dbh;
  global $error;

	$username = $username_input;
	$email = $username_input;

  // $username=trim($username);
  $password = trim($password);

  $error = array();

  if (strlen($username) >= 25){
    $error['username'] = "Username has more than 25 characters";
  } else
  if (strlen($password) >= 50){
    $error['password'] = "Password has more than 50 characters";
  } else
  if (empty($username)){
    $error['username'] = "Username is empty";
  } else
  if (empty($password)){
    $error['password'] = "Password is empty";
  } else {
    try {
    	$password_check = $dbh->prepare("SELECT * FROM Gebruiker WHERE gebruikersnaam=? AND wachtwoord=? OR email=? AND wachtwoord=?");
    	$password_check->execute(array($username, $password, $email, $password));
    } catch(PDOException $e){
    	$error = $e;
    }
    if (!($password_result = $password_check->fetch(PDO::FETCH_ASSOC))) {
    	$error['password'] = "Wachtwoord klopt niet";
    } else {
      //Has the user activated his account yet?
      $activation_check = $dbh->prepare("SELECT geactiveerd FROM Gebruiker WHERE gebruikersnaam=?");
      $activation_check->execute(array($password_result['gebruikersnaam']));

      if (!($activation_result = $activation_check->fetch(PDO::FETCH_NUM)[0])) {
        $error['verification'] = "Account is nog niet geactiveerd";
      } else {
        try {//checks if user needs verification
        	$statement = $dbh->prepare("select verkoper from Gebruiker where gebruikersnaam = ?");
        	$statement->execute(array($password_result['gebruikersnaam']));
        	$results = $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
      		$error=$e;
      		echo $error;
        }
        $_SESSION['seller'] = $results['gebruikersnaam'];
        $_SESSION['username'] = $password_result['gebruikersnaam'];
        $_SESSION['email'] = $password_result['email'];

        header('Location: index.php');
      }
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

//Takes an image and stores it as {username}.png in /img/avatar
function addAvatar($file, $username){
	global $error;
	global $dbh; //database object

	$error="";

	//If the file is a supported image
	if ((
			 ($file["type"] == "image/jpeg")
		|| ($file["type"] == "image/png")
		|| ($file["type"] == "image/pjpeg")
	) && ($file["size"] < 4000000)) {
		if ($file["error"] > 0) {
			$error.= "Return Code: " . $file["error"] . "<br />";
		} else {
			$error.= "Upload: " . $file["name"] . "<br />";
			$error.= "Type: " . $file["type"] . "<br />";
			$error.=  "Size: " . ($file["size"] / 1024) . " Kb<br />";
			$error.= "Temp file: " . $file["tmp_name"] . "<br />";

			//Move and rename uploaded image
			$filename = "img/avatar/" . $username . ".png";
			move_uploaded_file($file["tmp_name"], $filename);

			$error.= "Stored in: " . $filename;
		}
	} else {
		$error.= $file["type"]."<br />";
		$error.= "Verkeerd bestand, selecteer een nieuwe";
	}
}

function mailUser($username, $soort){
	//
	// global $dbh;
	//
	// $email_address = $dbh->prepare("select * from Gebruiker where gebruikersnaam=?");
	// $fetch_email = $email_addres->execute(array($username));
	// $fetch_email->fetch();


	$to = 'twanbolwerk@gmail.com';

	switch($soort){
	case 'registratie':
		$subject = 'Registratie gelukt!';
		$message = 'Uw registratie is gelukt'. $username .' !';
	break;

	case 'veilingaanmaken':
		$subject = 'Veiling aangemaakt!';
		$message = 'Beste '. $username .', Uw veiling is aangemaakt!';
	break;

	case 'overboden':
		$subject = 'U bent overboden!';
		$message = 'Beste '. $username .', U bent overboden!';
	break;

	case 'veilinggewonnen':
		$veilinggew = $dbh->prepare("select titel from Voorwerp where koper=?");
		$veilinggew->execute(array($username));

		$to = $email_address;
		$subject = 'U heeft de veiling gewonnen!';
		$message = 'Beste '. $username .', U heeft veiling'. $veilinggew.'gewonnen!';
	break;

	case 'wachtwoordvergeten':

	break;


}

	$headers = 'From: webmaster@iproject40.icasites.nl' . "\r\n" .
	    'Reply-To: webmaster@iproject40.icasites.nl' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);



}



?>
