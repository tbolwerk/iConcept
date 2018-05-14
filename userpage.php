<?php
$current_page='userpage';
require_once('templates/header.php');

if(isset($_POST['tab1submit'])){
  $statement = $dbh->prepare("update Gebruiker set voornaam = ?, achternaam = ?, adresregel1 = ?, postcode = ?, plaatsnaam = ?, land = ?, geboortedatum = ?, email = ?, vraagnummer = ?, antwoordtekst = ? where gebruikersnaam = ?");
	$statement->execute(array($_POST['firstname'], $_POST['lastname'], $_POST['address1'], $_POST['postalcode'], $_POST['city'], $_POST['country'], $_POST['birthdate'], $_POST['email'], $_POST['secretQuestion'], $_POST['secretAnswer'], $_SESSION['username']));
}

if(isset($_POST['tab2submit'])){
  $statement = $dbh->prepare("select wachtwoord from Gebruiker where gebruikersnaam = ?");
  $statement->execute(array($_SESSION['username']));
  $password = $statement->fetch();

  if ($password[0] == $_POST['currentPassword']) {
    changePassword($_POST['newPassword']);
  }
}

if(isset($_POST['change_avatar'])){
  $username = $_SESSION['username'];
  $picture = $_FILES['file'];
  addPicture($picture,$username);
}

if(isset($_POST['addphone'])) {
  $statement = $dbh->prepare("insert into Gebruikerstelefoon(gebruikersnaam, telefoonnummer) Values (?, ?)");
  $statement->execute(array($_SESSION['username'], $_POST['phone']));
}

if(isset($_POST['delete'])) {
  $statement = $dbh->prepare("delete Gebruikerstelefoon where volgnummer = ?");
	$statement->execute(array((int)$_POST['delete']));
}

$username = $_SESSION['username'];

$statement = $dbh->prepare("select * from Gebruiker where gebruikersnaam = ?");
$statement->execute(array($username));
$results = $statement->fetch();

$statement = $dbh->prepare("select * from Gebruikerstelefoon where gebruikersnaam = ?");
$statement->execute(array($username));
$phones = $statement->fetchAll();

$statement = $dbh->prepare("select * from Vraag where vraagnummer = ?");
$statement->execute(array($results['vraagnummer']));
$questions = $statement->fetch();

$secret_question_options = null;
try {
    $data = $dbh->prepare("select * from Vraag");
    $data->execute();
} catch (PDOException $e) {
    $error = $e;
}
while($question = $data->fetch()){
  if ($question['vraagnummer'] == $results['vraagnummer']) {
    $secret_question_options = "<option value='{$question['vraagnummer']}'>{$question['vraag']}</option>" . $secret_question_options;
  } else {
    $secret_question_options .= "<option value='{$question['vraagnummer']}'>{$question['vraag']}</option>";
  }
}
?>

<div class="view index-header">
    <img src="https://images.unsplash.com/photo-1453060590797-2d5f419b54cb?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=f42332c3b8e749209b9ce1c2f7d212d0&auto=format&fit=crop&w=2250&q=80" class="img-fluid" height="450">
    <div class="mask index-banner pattern-5">
    <div class="mask index-banner rgba-cyan-light">
        <h1 class="white-text banner-text">Accountinstellingen</h1>
    </div>
  </div>
</div>

<img class="" src="img/avatar/<?=$_SESSION['username']?>.png" style="border-radius: 50%; width: 300px; height: 300px; position: relative; top: -100px; left: 100px; float: left;">

<!--
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
<br> -->


<div class="container-fluid" style="background-color: WhiteSmoke;">

<div class="" style="margin: auto; max-width: 700px; text-align: center; padding: 20px;">

<button type="button" class="black-text" id="tab1knop" style="padding: 0; border: none; background: none; font-size: 1.5em;" onclick="switchToTab1()">Persoonlijke instellingen</button>
<button type="button" class="grey-text" id="tab2knop" style="padding: 0; border: none; background: none; font-size: 1.5em;" onclick="switchToTab2()">Wachtwoord</button>
<button type="button" class="grey-text" id="tab3knop" style="padding: 0; border: none; background: none; font-size: 1.5em;" onclick="switchToTab3()">Placeholder</button>

<div class="" id="tab1" style="background-color: White; padding: 20px; border-radius: 20px; border-color: black; border-width: 1px; border-style: solid;">

  <form method="post" action="">
    <fieldset style="border-radius: 20px;">
      <legend>Naam</legend>
      <div class="form-row">
        <div class="col-md-6">
          <div class="md-form">
            <label for="firstname">Voornaam</label>
            <input type="text" class="form-control" name="firstname" id="firstname" value="<?=$results['voornaam']?>" required pattern="[A-z]+">
          </div>
        </div>
        <div class="col-md-6">
          <div class="md-form">
            <label for="lastname">Achternaam</label>
            <input type="text" class="form-control" name="lastname" id="lastname" value="<?=$results['achternaam']?>" required pattern="[A-z]+">
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6">
          <div class="md-form">
            <!-- <label for="birthdate">Geboortedatum</label> -->
            <input type="date" class="form-control" name="birthdate" id="birthdate" value="<?=$results['geboortedatum']?>" required> <!-- pattern="[0-9]{4,4}-[0-9]{1,2}-[0-9]{1,2}" -->
          </div>
        </div>
        <div class="col-md-6">
          <div class="md-form">
            <label for="country">Land</label>
            <input type="text" class="form-control" name="country" id="country" value="<?=$results['land']?>" required pattern="[A-z]+">
          </div>
        </div>
      </div>
    </fieldset>

    <fieldset style="border-radius: 20px;">
      <legend>Contactgegevens</legend>
      <div class="form-row">
        <div class="col-md-6">
          <div class="md-form">
            <label for="postalcode">Postcode</label>
            <input type="text" class="form-control" name="postalcode" id="postalcode" value="<?=$results['postcode']?>" required pattern="[0-9]{4,4}[A-Z]{2,2}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="md-form">
            <label for="city">Plaatsnaam</label>
            <input type="text" class="form-control" name="city" id="city" value="<?=$results['plaatsnaam']?>" required pattern="[A-z]+">
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6">
          <div class="md-form">
            <label for="address1">Adres</label>
            <input type="text" class="form-control" name="address1" id="address1" value="<?=$results['adresregel1']?>" required>
          </div>
        </div>
        <div class="col-md-6">
          <div class="md-form">
            <label for="email">E-Mail</label>
            <input type="email" class="form-control" name="email" id="email" value="<?=$results['email']?>" required>
          </div>
        </div>
      </div>
    </fieldset>

    <fieldset style="border-radius: 20px;">
      <legend>Geheime vraag</legend>
      <div class="md-form">
        <select name="secretQuestion" class="form-control">
          <?=$secret_question_options?>
        </select>
      </div>
      <div class="md-form">
        <label for="secretAnswer">Geheim antwoord</label>
        <input type="text" class="form-control" name="secretAnswer" id="secretAnswer" value="<?=$results['antwoordtekst']?>" required>
      </div>
    </fieldset>

    <button type="submit" name="tab1submit">Opslaan</button>
  </form>

  <br><hr>

  <h4>Telefoon</h4>

  <form method="post" action="" >
    <?php
    foreach ($phones as $phone) {
      echo <<<HTML
        <input type="tel" name="{$phone['volgnummer']}" value="{$phone['telefoonnummer']}">
        <button type="submit" name="delete" value="{$phone['volgnummer']};">Verwijder</button><br>
        <!--NEVER touch the following line, the page WILL break-->
HTML;
    }
    ?>
  </form>

  <form method="post" action="" >
    <input type="tel" name="phone">
    <button type="submit" name="addphone">Voeg toe</button><br>
  </form>

</div>

<div class="" id="tab2" style="background-color: White; padding: 20px; border-radius: 20px; border-color: black; border-width: 1px; border-style: solid; display: none;">

  <form method="post" action="">
    <div class="md-form">
      <label for="currentPassword">Huidig wachtwoord</label>
      <input type="password" class="form-control" name="currentPassword" id="currentPassword" value="" required>
    </div>

    <div class="md-form">
      <label for="newPassword">Nieuw wachtwoord</label>
      <input type="password" class="form-control" name="newPassword" id="newPassword" value="" required>
    </div>

    <div class="md-form">
      <label for="confirmPassword">Herhaling nieuw wachtwoord</label>
      <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" value="" required>
    </div>

    <button type="submit" name="tab2submit">Opslaan</button>
  </form>

</div>

<div class="" id="tab3" style="background-color: White; padding: 20px; border-radius: 20px; border-color: black; border-width: 1px; border-style: solid; display: none;">
  <?php
  // vul dit in
  // include(bestand.php);
  ?>
</div>

</div>

<br>

<form method="post" action="" enctype="multipart/form-data">
  <label for="file">Filename:</label>
  <input type="file" name="file" accept=".png">

  <button type="submit" name="change_avatar">Upload</button>
</form>

<script>
function switchToTab1() {
  document.getElementById("tab1").style.display = "block";
  document.getElementById("tab2").style.display = "none";
  document.getElementById("tab3").style.display = "none";
  document.getElementById("tab1knop").classList.remove("grey-text");
  document.getElementById("tab1knop").classList.add("black-text");
  document.getElementById("tab2knop").classList.remove("black-text");
  document.getElementById("tab2knop").classList.add("grey-text");
  document.getElementById("tab3knop").classList.remove("black-text");
  document.getElementById("tab3knop").classList.add("grey-text");
}

function switchToTab2() {
  document.getElementById("tab1").style.display = "none";
  document.getElementById("tab2").style.display = "block";
  document.getElementById("tab3").style.display = "none";
  document.getElementById("tab1knop").classList.remove("black-text");
  document.getElementById("tab1knop").classList.add("grey-text");
  document.getElementById("tab2knop").classList.remove("grey-text");
  document.getElementById("tab2knop").classList.add("black-text");
  document.getElementById("tab3knop").classList.remove("black-text");
  document.getElementById("tab3knop").classList.add("grey-text");
}

function switchToTab3() {
  document.getElementById("tab1").style.display = "none";
  document.getElementById("tab2").style.display = "none";
  document.getElementById("tab3").style.display = "block";
  document.getElementById("tab1knop").classList.remove("black-text");
  document.getElementById("tab1knop").classList.add("grey-text");
  document.getElementById("tab2knop").classList.remove("black-text");
  document.getElementById("tab2knop").classList.add("grey-text");
  document.getElementById("tab3knop").classList.remove("grey-text");
  document.getElementById("tab3knop").classList.add("black-text");
}

function passwordConfirmation() {
  if (document.getElementById("newPassword").value != document.getElementById("confirmPassword").value) {
    document.getElementById("confirmPassword").setCustomValidity("Wachtwoorden komen niet overeen");
  } else {
    document.getElementById("confirmPassword").setCustomValidity("");
  }
}

document.getElementById("confirmPassword").onchange = passwordConfirmation;
</script>

</div>
<?php if(isset($error)){echo $error;}?>
<?php include('templates/footer.php'); ?>
