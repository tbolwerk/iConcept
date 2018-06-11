<?php
$current_page='userpage';
require_once('templates/header.php');
require_once("templates/userpage/f_addAvatar.php");
require_once("templates/userpage/f_changePassword.php");
require_once("templates/userpage/f_createVerificationCodeSeller.php");
require_once("templates/userpage/f_registerSeller.php");
require_once("templates/userpage/f_verificationSeller.php");
require_once("templates/userpage/f_insertPhoneNumber.php");
require_once("templates/userpage/f_updatePhones.php");
require_once("templates/register/f_createVerificationCode.php");
require_once("templates/mail/f_verificationMail.php");
$message = "";

//If user tries to register as seller
if(isset($_POST['registerseller'])){
  registerSeller($_SESSION['username'], $_POST['checkoption'],$_POST['creditcard'],$_POST['bank'],$_POST['banknumber']);
}

//If users sumbit verificationcode to become seller
if(isset($_POST['verify'])){
  verificationSeller($_SESSION['username'], $_POST['code']);
}

//If user tries to change password
if (isset($_POST['tab2submit'])) {
    //Receive the password for this user from the database
    $statement = $dbh->prepare("select wachtwoord from Gebruiker where gebruikersnaam = ?");
    $statement->execute(array($_SESSION['username']));
    $password = $statement->fetch();


    if (password_verify($_POST['currentPassword'],$password[0])) { //Has the user submitted his current password?
        //changePassword() can be found in functions.php
        changePassword($_POST['newPassword']);
        $message = "Uw wachtwoord is succesvol gewijzigd";
    }else{
       $message = "Opgegeven wachtwoord is onjuist";
    }
}

//If user submits a profile picture, upload it to the server
if (isset($_POST['change_avatar'])) {
  $username = $_SESSION['username'];
  $picture = $_FILES['file'];
  addAvatar($picture, $username);
}

$username = $_SESSION['username'];

//If user submits updated account data
if(isset($_POST['tab1submit'])) {
	$statement = $dbh->prepare("SELECT email FROM Gebruiker WHERE gebruikersnaam = ?");
	$statement->execute(array($username));
	$currentmail = $statement->fetch()[0];

  //Remove any doublequotes and html tags
  $firstname = str_replace("\"", "", strip_tags($_POST['firstname']));
  $lastname = str_replace("\"", "", strip_tags($_POST['lastname']));
  $address1 = str_replace("\"", "", strip_tags($_POST['address1']));
  $address2 = str_replace("\"", "", strip_tags($_POST['address2']));
  $postalcode = str_replace("\"", "", strip_tags($_POST['postalcode']));
  $city = str_replace("\"", "", strip_tags($_POST['city']));
  $country = str_replace("\"", "", strip_tags($_POST['country']));
  $birthdate = str_replace("\"", "", strip_tags($_POST['birthdate']));
  $secretQuestion = str_replace("\"", "", strip_tags($_POST['secretQuestion']));
  $secretAnswer = str_replace("\"", "", strip_tags($_POST['secretAnswer']));
  $activation = 1;
  $email = str_replace("\"", "", strip_tags($_POST['email']));
  $statement = $dbh->query("SELECT email FROM Gebruiker");
	$email_exists = false;
  while($row = $statement->fetch()){
	  if($email == $row['email'] && $currentmail != $email){
	    $message = "<p class='red-text lead'>Er is al een account met dit E-mail adres</p>";
	    $email_exists = true;
	    break;
	  }
	}
	//If the submitted mail is not equal to the mail in the database and noone else is using the submitted mail
	if($currentmail != $email && $email_exists == false){
	  $username = $_SESSION['username'];

	  //Generate verification code
	  $code = random_password(6);
	  createVerificationCode($username, $code, $email);

	  //Deactivate the account until the user clicks the link
	  $activation = 0;

	  //Display message on webpage
	  $message.="<p class='green-text lead'>Er is een verificatie mail verzonden naar ".$email." Klik op de activatie <a href='verification.php?username=".$username."&code=".$code."&email=".$email."'>link</a> om de wijziging door te voeren</p>";

	  //Send mail with verification code
	  verificationMail($email, $username, $code, 'mail');
	}

  try { //Update the record for this user with the submitted data
    $statement = $dbh->prepare("update Gebruiker set voornaam = ?, achternaam = ?, adresregel1 = ?,adresregel2=?, postcode = ?, plaatsnaam = ?, land = ?, geboortedatum = ?,geactiveerd =?, vraagnummer = ?, antwoordtekst = ? where gebruikersnaam = ?");
    $statement->execute(array($firstname, $lastname, $address1,$address2, $postalcode, $city, $country, $birthdate,$activation, $secretQuestion, $secretAnswer, $_SESSION['username']));
    updatePhones(); //Phones are updated seperately
    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $lastname;
    $message.="Persoonlijke informatie succesvol gewijzigd";
  } catch (PDOException $e) {
    $error = $e;

    $message = "Er ging iets mis tijdens het wijzigen van uw persoonlijke informatie";
  }
}

//Receive account data from database
$statement = $dbh->prepare("SELECT * FROM Gebruiker g LEFT JOIN Gebruikerstelefoon gt ON g.gebruikersnaam=gt.gebruikersnaam LEFT JOIN Vraag v ON g.vraagnummer = v.vraagnummer LEFT JOIN VerificatieVerkoper vv ON g.gebruikersnaam=vv.gebruikersnaam WHERE g.gebruikersnaam = ?");
$statement->execute(array($username));
$results = $statement->fetchAll();

// //Receive phone numbers for this user from database
// $statement = $dbh->prepare("select * from Gebruikerstelefoon where gebruikersnaam = ? order by volgnummer");
// $statement->execute(array($username));
// $phones = $statement->fetchAll();
//
// //Receive secret question from database
// $statement = $dbh->prepare("select * from Vraag where vraagnummer = ?");
// $statement->execute(array($results['vraagnummer']));
// $questions = $statement->fetch();

//Construct a list with <option> tags for the secret question dropdown menu
$secret_question_options = null;
//Receive all secret questions from database
try {
  $data = $dbh->prepare("select * from Vraag");
  $data->execute();
} catch (PDOException $e) {
  $error = $e;
}
//Construct the list by iterating over each received secret questions
while ($question = $data->fetch()) {
  //The current secret question is put at the top of the list, all others are appended
  if ($question['vraagnummer'] == $results[0]['vraagnummer']) {
    $secret_question_options = "<option value='{$question['vraagnummer']}'>{$question['vraag']}</option>" . $secret_question_options;
  } else {
    $secret_question_options .= "<option value='{$question['vraagnummer']}'>{$question['vraag']}</option>";
  }
}
?>
  <!-- Banner -->
  <div class="view index-header">
    <img src="img/bgs/account-bg.png" class="" height="350">
    <div class="mask index-banner rgba-niagara-strong">
      <h1 class="white-text banner-text">Accountinstellingen</h1>
    </div>
  </div>
  <!-- Profile picture -->
  <div id="wrapper">
    <div class="left col-lg-4">
      <div class="profile-picture-settings">
        <label for="profile-picture">
      <img class="photo" src="img/avatar/<?=$_SESSION['username']?>.png"/>
      <div class="profile-picture-overlay">
        <div class="pf-icon">
          <i class="fa fa-lg fa-plus"></i>
        </div>
      </div>
      </label>
      </div>

      <form method="post" action="" enctype="multipart/form-data">
        <input type="file" name="file" id="profile-picture" accept="image/png, image/jpeg">
        <div class="profile-picture-upload">
          <button class="btn elegant" type="submit" name="change_avatar" data-toggle="tooltip" data-placement="bottom" title="Upload afbeelding"><i class="fas fa-upload"></i></button>
        </div>
      </form>
    </div>
  </div>



<div class="container-fluid usersettings-page" id="wrapper">

<div class="col-md-8 ml-auto mr-5 usersettings-content">




<!-- Tabs to navigate trough account setting -->
<ul class="nav nav-tabs" role="tablist" id="adminTabs">
  <li class="nav-item">
    <a class="nav-link active panel-name" data-toggle="tab" href="#tab1" role="tab">Persoonlijke Instellingen</a>
  </li>
  <li class="nav-item">
    <a class="nav-link panel-name" data-toggle="tab" href="#tab2" role="tab">Wachtwoord veranderen</a>
  </li>
  <li class="nav-item">
    <a class="nav-link panel-name" data-toggle="tab" href="#tab3" role="tab">Verkoper worden</a>
  </li>
</ul>
<div class="tab-content">


<!-- Form to update profile -->
<div class="tab-pane fade in show active" id="tab1" role="tabpanel">
  <form method="post" action="">
    <div class="userpage-form-header">
      <h1>Naam</h1>
    </div>
    <div class="form-row">
      <div class="col-md-6">
        <div class="md-form form-group">
          <input type="text" class="form-control" name="firstname" id="firstname" value="<?=$results[0]['voornaam']?>" required maxlength="35" pattern="[A-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-'’‘]{2,35}" placeholder="Vul hier uw voornaam in">
          <div class="form-requirements">
            <ul>
              <li>Minimaal 2 tekens</li>
              <li>Maximaal 35 tekens</li>
              <li>De meeste tekens uit het latijns alfabet worden toegestaan</li>
            </ul>
          </div>
          <label class="black-text" for="firstname">Voornaam</label>
        </div>
      </div>
      <div class="col-md-6">
        <div class="md-form form-group">
          <input type="text" class="form-control" name="lastname" id="lastname" value="<?=$results[0]['achternaam']?>" required maxlength="35" pattern="[A-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-'’‘]{2,35}" placeholder="Vul hier uw achternaam in">
          <div class="form-requirements">
            <ul>
              <li>Minimaal 2 tekens</li>
              <li>Maximaal 35 tekens</li>
              <li>De meeste tekens uit het latijns alfabet worden toegestaan</li>
            </ul>
          </div>
          <label class="black-text" for="lastname">Achternaam</label>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-md-6">
        <div class="md-form form-group">
          <input type="date" class="form-control" name="birthdate" id="birthdate" value="<?=$results[0]['geboortedatum']?>" required placeholder="Geboortedatum">
        </div>
      </div>
      <div class="col-md-6">
        <div class="md-form form-group">
          <select class="black-text form-control" name="country" id="country" class="register-select-form form-control" required>
            <option class="black-text" value="<?=$results[0]['land']?>" class="font-weight-light black-text disabled selected"><?=$results[0]['land']?></option>
            <option class="black-text" value='Nederland'>Nederland</option>
            <option class="black-text" value='Duitsland'>Duitsland</option>
            <option class="black-text" value='Frankrijk'>Frankrijk</option>
            <option class="black-text" value='België'>België</option>
          </select>
          <div class="form-requirements">
            <ul>
              <li>Minimaal 2 tekens</li>
              <li>Maximaal 48 tekens</li>
              <li>De meeste tekens uit het latijns alfabet worden toegestaan</li>
              <li>Wordt nog vervangen met dropdown list</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="userpage-form-header">
      <h1>Contactgegevens</h1>
    </div>
    <div class="form-row">
      <div class="col-md-6">
        <div class="md-form form-group">
          <input type="text" class="form-control" name="postalcode" id="postalcode" value="<?=$results[0]['postcode']?>" onkeydown="upperCaseF(this)" required maxlength="6" pattern="[0-9]{4,4}[A-Z]{2,2}" placeholder="Vul uw postcode in">
          <div class="form-requirements">
            <ul>
              <li>Vier cijfers gevolgd door twee hoofdletters</li>
            </ul>
          </div>
          <label style="black-text" for="postalcode">Postcode</label>
        </div>
      </div>
      <div class="col-md-6">
        <div class="md-form form-group">
          <input type="text" class="form-control" name="city" id="city" value="<?=$results[0]['plaatsnaam']?>" required maxlength="85" pattern="[A-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-'’‘ ]{2,85}" placeholder="Vul uw plaatsnaam in">
          <div class="form-requirements">
            <ul>
              <li>Minimaal 2 tekens</li>
              <li>Maximaal 85 tekens</li>
              <li>De meeste tekens uit het latijns alfabet worden toegestaan</li>
            </ul>
          </div>
          <label style="black-text" for="city">Plaatsnaam</label>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-md-6" >
        <div class="md-form form-group">
          <input type="text" class="form-control" name="address1" id="address1" value="<?=$results[0]['adresregel1']?>" placeholder="Vul hier uw adres in" required maxlength="35" pattern="[A-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-'’‘ ]+ [0-9]+[A-z]{0,1}">
          <div class="form-requirements">
            <ul>
              <li>Straatnaam gevolgd door huisnummer</li>
              <li>Bijvoorbeeld: De goudenstraat 25B</li>
              <li>Maximaal 35 tekens</li>
              <li>De meeste tekens uit het latijns alfabet worden toegestaan</li>
            </ul>
          </div>
          <label style="black-text" for="address1">Adres</label>
        </div>
      </div>


      <div class="col-md-6" >
        <div class="md-form form-group">
          <input type="text" class="form-control" name="address2" id="address2" value="<?=$results[0]['adresregel2']?>" placeholder="Vul hier uw adres in" maxlength="35" pattern="[A-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-'’‘ ]+ [0-9]+[A-z]{0,1}">
          <div class="form-requirements">
            <ul>
              <li>*Optioneel</li>
              <li>Straatnaam gevolgd door huisnummer</li>
              <li>Bijvoorbeeld: De goudenstraat 25B</li>
              <li>Maximaal 35 tekens</li>
              <li>De meeste tekens uit het latijns alfabet worden toegestaan</li>
            </ul>
          </div>
          <label style="black-text" for="address1">Adres 2</label>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-md-6">
        <div class="md-form form-group">
          <input type="email" class="form-control" name="email" id="email" value="<?=$results[0]['email']?>" onchange="confirmation('email', 'emailcheck')" onkeyup="confirmation('email', 'emailcheck')" required maxlength="100" placeholder="Vul uw emailadres in">
          <div class="form-requirements">
            <ul>
              <li>Placeholder</li>
              <li>Bijvoorbeeld: janbeenham@hotmail.com</li>
              <li>Maximaal 100 tekens</li>
              <li>De meeste speciale tekens worden niet toegestaan</li>
            </ul>
          </div>
          <label style="black-text" for="email">E-Mail</label>
        </div>
      </div>
      <div class="col-md-6">
        <div class="md-form form-group">
          <input type="email" class="form-control" id="emailcheck" onchange="confirmation('email', 'emailcheck')" onkeyup="confirmation('email', 'emailcheck')" required maxlength="100" placeholder="Herhaal uw emailadres">
          <div class="form-requirements">
            <ul>
              <li>Moet gelijk zijn aan het andere email veld</li>
            </ul>
          </div>
          <label style="black-text" for="emailcheck">E-Mail herhalen</label>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-md-4">
        <div class="md-form">
          <input type="tel" class="form-control" name="phone1" id="phone1" value="<?php if(isset($results[0]['telefoonnummer'])) {echo $results[0]['telefoonnummer'];} ?>" placeholder="Vul hier uw telefoonnummer in" required pattern="[0-9]{2}-[0-9]{8}">
          <div class="form-requirements">
            <ul>
              <li>XX-XXXXXXXX</li>
            </ul>
          </div>
          <label style="black-text" for="phone1">Telefoonnummer #1</label>
        </div>
      </div>
      <div class="col-md-4">
        <div class="md-form">
          <input type="tel" class="form-control" name="phone2" id="phone2" value="<?php if(isset($results[1]['telefoonnummer'])) {echo $results[1]['telefoonnummer'];} ?>" placeholder="Optioneel telefoonnummer" pattern="[0-9]{2}-[0-9]{8}">
          <label style="black-text" for="phone2">Telefoonnummer #2</label>
        </div>
      </div>
      <div class="col-md-4">
        <div class="md-form">
          <input type="tel" class="form-control" name="phone3" id="phone3" value="<?php if(isset($results[2]['telefoonnummer'])) {echo $results[2]['telefoonnummer'];} ?>" placeholder="Optioneel telefoonnummer" pattern="[0-9]{2}-[0-9]{8}">
          <label style="black-text" for="phone3">Telefoonnummer #3</label>
        </div>
      </div>
    </div>
    <div class="userpage-form-header">
      <h1>Geheime vraag</h1>
    </div>
    <div class="form-row">
      <div class="col-md-12">
        <div class="md-form">
          <select name="secretQuestion" class="form-control">
            <?=$secret_question_options?>
          </select>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-md-12">
        <div class="md-form">
          <label for="secretAnswer">Geheim antwoord</label>
          <input type="text" class="form-control" name="secretAnswer" id="secretAnswer" maxlength="25" value="<?=$results[0]['antwoordtekst']?>" required pattern="[A-z0-9\- ]+">
          <div class="form-requirements">
            <ul>
              <li>Maximaal 25 tekens</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-3 py-1 text-center">
      <button class="btn elegant" type="submit" name="tab1submit" data-toggle="tooltip" title="Gewijzigde gegevens opslaan">Opslaan</button>
    </div>
  </form>
</div>
        <!-- Settings to change current password -->
        <div class="tab-pane fade" id="tab2" role="tabpanel">
          <form method="post" action="">

          <div class="userpage-form-header">
            <h1>Wachtwoord wijzigen</h1>
          </div>
          <div class="md-form">
            <label for="currentPassword">Huidig wachtwoord</label>
            <input type="password" class="form-control" name="currentPassword" id="currentPassword" value="" required>
          </div>

          <div class="md-form">
            <label for="newPassword">Nieuw wachtwoord</label>
            <input type="password" class="form-control" name="newPassword" id="newPassword" onchange="confirmation('newPassword', 'confirmPassword')" onkeyup="confirmation('newPassword', 'confirmPassword')" value="" required>
          </div>

          <div class="md-form">
            <label for="confirmPassword">Herhaling nieuw wachtwoord</label>
            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" onchange="confirmation('newPassword', 'confirmPassword')" onkeyup="confirmation('newPassword', 'confirmPassword')" value="" required>
          </div>

          <div class="mt-3 py-1 text-center">
            <button class="btn elegant" type="submit" name="tab2submit" data-toggle="tooltip" title="Gewijzigde gegevens opslaan">Opslaan</button>
          </div>
          </form>

        </div>
        <!-- Settings to register as a seller -->
        <div class="tab-pane fade" id="tab3" role="tabpanel">
          <?php
if(!empty($results[0]['code'])){//shows verificationform if user is registerd as seller but not yet verified
    ?>
    <!-- Form to verify -->
    <form method="post" action="">

    	<div class="md-form">
    		<label for="code">Verificatiecode</label>
    		<input type="text" class="form-control" name="code" id="code" value="" maxlength="6" required pattern="[a-zA-Z0-9-]{6}">
        <div class="form-requirements">
          <ul>
            <li>Een code bestaat uit 6 tekens</li>
            <li>Alleen hoofdletters en kleine letters zijn toegestaan</li>
          </ul>
        </div>
            	<button class="btn-elegant" type="submit" name="verify" data-toggle="tooltip" data-placement="top" title="Verifieër code"><i class="fas fa-check"></i></button>
    	</div>


    </form>
    <?php
}else if($results[0]['verkoper'] == 1 && empty($results[0]['code'])){//checks if user is seller and no verification code *double check
  echo "U bent al verkoper.";
}else{//else option to register as seller
      ?>
      <!-- Form to register as seller -->
      <form method="post" action="">
      	<div class="userpage-form-header">
      		<h1>Verkoper worden</h1>
      	</div>

      	<div class="md-form">
      		<select name="checkoption" id="checkoption" class="form-control" required>
      			<option value="">Kies controleoptie...</option>
      			<option value="post">Code via post</option>
      			<option value="creditcard">Creditcard</option>
      		</select>
      	</div>

      	<div class="md-form" id="creditcardDiv" style="display: none;">
      		<label for="creditcard">Creditcardnummer</label>
      		<input type="text" class="form-control" name="creditcard" id="creditcard" value="">
      		<div class="form-requirements black-text">
      			<ul>
      				<li>Enkel getallen</li>
      				<li>Maximaal 19 getallen</li>
      			</ul>
      		</div>
      	</div>

      	<div class="md-form" id="bankDiv" style="display: none;">
      		<label for="bank">Banknaam</label>
      		<input type="text" class="form-control" name="bank" id="bank" value="">
      		<div class="form-requirements black-text">
      			<ul>
      				<li>Banknaam maximaal 75 karakters</li>
      			</ul>
      		</div>
      	</div>

      	<div class="md-form" id="banknumberDiv" style="display: none;">
      		<label for="banknumber">Rekeningnummer</label>
      		<input type="text" class="form-control" name="banknumber" id="banknumber" value="">
      		<div class="form-requirements black-text">
      			<ul>
      				<li>Mag maximaal 34 karakters bevatten</li>
      			</ul>
      		</div>
      	</div>

      	<div class="py-1 mt-3 text-center">
        <button class="btn elegant" type="submit" name="registerseller" data-toggle="tooltip" title="Aanvraag verkoper">Word verkoper</button>
      </div>
      </form>
      <?php
}

  ?>
        </div>

      </div>
    </div>

    <script src="js/functions.js"></script>
    <script>
    function updateForm() {//function to show right fields for chosen option
      if (document.getElementById("checkoption").value == "post") {
        document.getElementById("bankDiv").style.display = "block";
    		document.getElementById("banknumberDiv").style.display = "block";
    		document.getElementById("bank").required = true;
    		document.getElementById("banknumber").required = true;
      } else {
    		document.getElementById("bankDiv").style.display = "none";
    		document.getElementById("banknumberDiv").style.display = "none";
    		document.getElementById("bank").required = false;
    		document.getElementById("banknumber").required = false;
    	}
    	if (document.getElementById("checkoption").value == "creditcard") {
        document.getElementById("creditcardDiv").style.display = "block";
    		document.getElementById("creditcard").required = true;
      } else {
    		document.getElementById("creditcardDiv").style.display = "none";
    		document.getElementById("creditcard").required = false;
    	}
    }

    document.getElementById("checkoption").onchange = updateForm;//updates from if users changes verify option
    </script>

  </div>
  <?php include('templates/footer.php'); ?>
