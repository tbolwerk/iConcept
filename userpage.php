<?php
$current_page='userpage';
require_once('templates/header.php');

function updatePhones() {
  global $dbh;

  $statement = $dbh->prepare("select * from Gebruikerstelefoon where gebruikersnaam = ?");
  $statement->execute(array($_SESSION['username']));
  $phones = $statement->fetchAll();

  $numbersToKeep = array();

  insertNumberUnderSpecificConditions($_POST['phone1'], $phones, $numbersToKeep);
  insertNumberUnderSpecificConditions($_POST['phone2'], $phones, $numbersToKeep);
  insertNumberUnderSpecificConditions($_POST['phone3'], $phones, $numbersToKeep);

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

function insertNumberUnderSpecificConditions($number, $phones, &$numbersToKeep) {
  global $dbh;

  if ($number != "") {
    $hit = 0;
    foreach ($phones as $phone) {
      if ($number == $phone['telefoonnummer']) {
        $hit = 1;
      }
    }
    if ($hit == 0) {
      $statement = $dbh->prepare("insert into Gebruikerstelefoon(gebruikersnaam, telefoonnummer) Values (?, ?)");
      $statement->execute(array($_SESSION['username'], $number));
    }
    array_push($numbersToKeep, $number);
  }
}

//If user submits updated account data
if(isset($_POST['tab1submit'])){
  $firstname = str_replace("\"", "", strip_tags($_POST['firstname']));
  $lastname = str_replace("\"", "", strip_tags($_POST['lastname']));
  $address1 = str_replace("\"", "", strip_tags($_POST['address1']));
  $postalcode = str_replace("\"", "", strip_tags($_POST['postalcode']));
  $city = str_replace("\"", "", strip_tags($_POST['city']));
  $country = str_replace("\"", "", strip_tags($_POST['country']));
  $birthdate = str_replace("\"", "", strip_tags($_POST['birthdate']));
  $email = str_replace("\"", "", strip_tags($_POST['email']));
  $secretQuestion = str_replace("\"", "", strip_tags($_POST['secretQuestion']));
  $secretAnswer = str_replace("\"", "", strip_tags($_POST['secretAnswer']));
  $statement = $dbh->prepare("update Gebruiker set voornaam = ?, achternaam = ?, adresregel1 = ?, postcode = ?, plaatsnaam = ?, land = ?, geboortedatum = ?, email = ?, vraagnummer = ?, antwoordtekst = ? where gebruikersnaam = ?");
	$statement->execute(array($firstname, $lastname, $address1, $postalcode, $city, $country, $birthdate, $email, $secretQuestion, $secretAnswer, $_SESSION['username']));
  updatePhones();
}

//If user tries to change password...
if (isset($_POST['tab2submit'])) {
    $statement = $dbh->prepare("select wachtwoord from Gebruiker where gebruikersnaam = ?");
    $statement->execute(array($_SESSION['username']));
    $password = $statement->fetch();
    //...and provides his current password
    if ($password[0] == $_POST['currentPassword']) {
        //changePassword() can be found in functions.php
        changePassword($_POST['newPassword']);
    }
}

//If user submits a profile picture, upload it to the server
if (isset($_POST['change_avatar'])) {
    $username = $_SESSION['username'];
    $picture = $_FILES['file'];
    //addAvatar() can be found in functions.php
    addAvatar($picture, $username);
}

$username = $_SESSION['username'];

//Receive account data from database
$statement = $dbh->prepare("select * from Gebruiker where gebruikersnaam = ?");
$statement->execute(array($username));
$results = $statement->fetch();

//Receive phone numbers for this user from database
$statement = $dbh->prepare("select * from Gebruikerstelefoon where gebruikersnaam = ? order by volgnummer");
$statement->execute(array($username));
$phones = $statement->fetchAll();

//Receive secret question from database
$statement = $dbh->prepare("select * from Vraag where vraagnummer = ?");
$statement->execute(array($results['vraagnummer']));
$questions = $statement->fetch();

//Construct a list with <option> tags for the secret question dropdown menu
$secret_question_options = null;
//Receive all secret questions from database
try {
    $data = $dbh->prepare("select * from Vraag");
    $data->execute();
} catch (PDOException $e) {
    $error = $e;
}
//Construct the list by iterating over each received secret question
while ($question = $data->fetch()) {
    //The current secret question is put at the top of the list, all others are appended
    if ($question['vraagnummer'] == $results['vraagnummer']) {
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
      <h1 class="white-text userpage-header">Accountinstellingen</h1>
    </div>
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
          <button type="submit" name="change_avatar">Upload</button>
        </div>
      </form>
    </div>
  </div>

  <!--
These values are for debugging purposes and are visible by inspecting the page source

<p>ontvangen bestanden: </p>
<?php print_r($_FILES); ?><br>
<br>

<p>ontvangen post gegevens: </p>
<?php print_r($_POST); ?><br>
<br>

<p>ontvangen database gegevens: </p>
<?php print_r($results); ?><br>
<br>

<p>ontvangen telefoon gegevens: </p>
<?php print_r($phones); ?><br>
<br>

<p>ontvangen vraag gegevens: </p>
<?php print_r($questions); ?><br>
<br>
-->



<div class="container-fluid usersettings-page" id="wrapper">

<div class="col-md-6 ml-auto mr-5 usersettings-content">

<ul class="nav nav-tabs">
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

<div class="tab-pane fade in show active" id="tab1" role="tabpanel">
  <form method="post" action="">
    <div class="userpage-form-header">
      <h1>Naam</h1>
    </div>
    <div class="form-row">
      <div class="col-md-6">
        <div class="md-form form-group">
          <input type="text" class="form-control" name="firstname" id="firstname" value="<?=$results['voornaam']?>" required pattern="[A-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-\'’‘]+" placeholder="Vul hier uw voornaam in">
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
          <input type="text" class="form-control" name="lastname" id="lastname" value="<?=$results['achternaam']?>" required pattern="[A-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-\'’‘]+" placeholder="Vul hier uw achternaam in">
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
          <input type="date" class="form-control" name="birthdate" id="birthdate" value="<?=$results['geboortedatum']?>" required placeholder="Geboortedatum">
        </div>
      </div>
      <div class="col-md-6">
        <div class="md-form form-group">
          <input type="text" class="form-control" name="country" id="country" value="<?=$results['land']?>" required pattern="[A-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-\'’‘ ]+" placeholder="Selecteer uw land">
          <div class="form-requirements">
            <ul>
              <li>Minimaal 2 tekens</li>
              <li>Maximaal 48 tekens</li>
              <li>De meeste tekens uit het latijns alfabet worden toegestaan</li>
              <li>Wordt nog vervangen met dropdown list</li>
            </ul>
          </div>
          <label style="black-text" for="country">Land</label>
        </div>
      </div>
    </div>
    <div class="userpage-form-header">
      <h1>Contactgegevens</h1>
    </div>
    <div class="form-row">
      <div class="col-md-6">
        <div class="md-form form-group">
          <input type="text" class="form-control" name="postalcode" id="postalcode" value="<?=$results['postcode']?>" onkeydown="upperCaseF(this)" required pattern="[0-9]{4,4}[A-Z]{2,2}" placeholder="Vul uw postcode in">
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
          <input type="text" class="form-control" name="city" id="city" value="<?=$results['plaatsnaam']?>" required pattern="[A-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-\'’‘ ]+" placeholder="Vul uw plaatsnaam in">
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
    <div class="row">
      <div class="col-md-12" >
        <div class="md-form form-group">
          <input type="text" class="form-control" name="address1" id="address1" value="<?=$results['adresregel1']?>" placeholder="Vul hier uw adres in" required pattern="[A-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-\'’‘ ]+ [0-9]+[A-z]{0,1}">
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
    </div>
    <div class="form-row">
      <div class="col-md-6">
        <div class="md-form form-group">
          <input type="email" class="form-control" name="email" id="email" value="<?=$results['email']?>" onchange="confirmation('email', 'emailcheck')" onkeyup="confirmation('email', 'emailcheck')" required placeholder="Vul uw emailadres in">
          <div class="form-requirements">
            <ul>
              <li>Placeholder</li>
              <li>Bijvoorbeeld: hermanreinhart@hotmail.com</li>
              <li>Maximaal 100 tekens</li>
              <li>De meeste speciale tekens worden niet toegestaan</li>
            </ul>
          </div>
          <label style="black-text" for="email">E-Mail</label>
        </div>
      </div>
      <div class="col-md-6">
        <div class="md-form form-group">
          <input type="email" class="form-control" id="emailcheck" onchange="confirmation('email', 'emailcheck')" onkeyup="confirmation('email', 'emailcheck')" required placeholder="Herhaal uw emailadres">
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
          <input type="tel" class="form-control" name="phone1" id="phone1" value="<?php if(isset($phones[0]['telefoonnummer'])) {echo $phones[0]['telefoonnummer'];} ?>" placeholder="Vul hier uw telefoonnummer in" required pattern="[0-9]{2}-[0-9]{8}">
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
          <input type="tel" class="form-control" name="phone2" id="phone2" value="<?php if(isset($phones[1]['telefoonnummer'])) {echo $phones[1]['telefoonnummer'];} ?>" placeholder="Optioneel telefoonnummer" pattern="[0-9]{2}-[0-9]{8}">
          <label style="black-text" for="phone2">Telefoonnummer #2</label>
        </div>
      </div>
      <div class="col-md-4">
        <div class="md-form">
          <input type="tel" class="form-control" name="phone3" id="phone3" value="<?php if(isset($phones[2]['telefoonnummer'])) {echo $phones[2]['telefoonnummer'];} ?>" placeholder="Optioneel telefoonnummer" pattern="[0-9]{2}-[0-9]{8}">
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
          <input type="text" class="form-control" name="secretAnswer" id="secretAnswer" value="<?=$results['antwoordtekst']?>" required pattern="[A-z0-9\- ]+">
        </div>
      </div>
    </div>
    <div class="mt-3 py-1 text-center">
      <button class="btn elegant" type="submit" name="tab1submit">Opslaan</button>
    </div>
  </form>
</div>
        <!-- Settings to change current password -->
        <div class="tab-pane fade" id="tab2" role="tabpanel" <form method="post" action="">
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
            <button class="btn elegant" type="submit" name="tab2submit">Opslaan</button>
          </div>
          </form>

        </div>
        <!-- Settings to register as a seller -->
        <div class="tab-pane fade" id="tab3" role="tabpanel">
          <?php
  global $username;
  $username = $_SESSION['username'];
  try {//checks if user needs verification
      $statement = $dbh->prepare("select gebruikersnaam from VerificatieVerkoper where gebruikersnaam = ?");
      $statement->execute(array($username));
      $results = $statement->fetch();
  } catch (PDOException $e) {
      $error=$e;
      echo $error;
  }

  if ($_SESSION['seller']) {
      echo "U bent al verkoper.";
  } elseif (empty($results[0])) {
      include('register_seller.php');
  } else {
      include('verification_seller.php');
  }
  ?>
        </div>

      </div>
    </div>

    <script src="js/functions.js"></script>

  </div>
  <?php include('templates/footer.php'); ?>
