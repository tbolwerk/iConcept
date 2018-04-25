<?php
$current_page='userpage';
require('templates/header.php');

//Janno is hiermee bezig.
//Afblijven graag.

if(isset($_POST['submit'])){

  $statement = $dbh->prepare("update Gebruiker set voornaam = ?, achternaam = ?, adresregel1 = ?, postcode = ?, email = ? where gebruikersnaam = ?");
	$statement->execute(array($_POST['firstname'], $_POST['lastname'], $_POST['address1'], $_POST['postalcode'],$_POST['email'], $_SESSION['username']));
  changePassword($_POST['password']);
}

$username = $_SESSION['username'];

$statement = $dbh->prepare("select * from Gebruiker where gebruikersnaam = ?");
$statement->execute(array($username));
$results = $statement->fetch();
?>


<br><br><br>
<?php print_r($results) ?><br>

<form method="post" action="" >
  <label for="firstname">Voornaam</label>
  <input type="text" name="firstname" value="<?=$results['voornaam']?>"><br>
  <label for="lastname">Achternaam</label>
  <input type="text" name="lastname" value="<?=$results['achternaam']?>"><br>
  <label for="address1">Adres</label>
  <input type="text" name="address1" value="<?=$results['adresregel1']?>"><br>
  <label for="postalcode">Postcode</label>
  <input type="text" name="postalcode" value="<?=$results['postcode']?>"><br>
  <label for="city">Plaatsnaam</label>
  <input type="text" name="city" value="<?=$results['plaatsnaam']?>"><br>
  <label for="country">Land</label>
  <input type="text" name="country" value="<?=$results['land']?>"><br>
  <label for="birthdate">Geboortedatum</label>
  <input type="text" name="birthdate" value="<?=$results['geboortedatum']?>"><br>
  <label for="mail">E-Mail</label>
  <input type="email" name="email" value="<?=$results['email']?>"><br>
  <label for="password">Wachtwoord</label>
  <input type="text" name="password" value="<?=$results['wachtwoord']?>"><br>

  <button type="submit" name="submit">Pas aan</button>
</form>


<?php include('templates/footer.php'); ?>
