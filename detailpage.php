<?php
$current_page='detailpage';
require_once('templates/header.php');

if (isset($_GET['id'])) {
  if (isset($_POST['bid'])) {
    $statement = $dbh->prepare("insert into bod(voorwerpnummer, bodbedrag, gebruikersnaam, boddag, bodtijdstip) Values (?, ?, ?, GETDATE(), CURRENT_TIMESTAMP)");
    $statement->execute(array($_GET['id'], $_POST['bid'], $_SESSION['username']));
  }

  $statement = $dbh->prepare("select *, dateadd(day, looptijd, looptijdbegindag) as looptijdeindedag2 from Voorwerp join Voorwerp_in_Rubriek on Voorwerp.voorwerpnummer = Voorwerp_in_Rubriek.voorwerpnummer where Voorwerp.voorwerpnummer = ?");
  $statement->execute(array($_GET['id']));
  $results = $statement->fetch();

  $statement = $dbh->prepare("select * from Bod where voorwerpnummer = ?");
  $statement->execute(array($_GET['id']));
  $biddings = $statement->fetch();

  $statement = $dbh->prepare("select bodbedrag, gebruikersnaam from Bod where voorwerpnummer = ? and bodbedrag = (
  	select max(bodbedrag) from Bod where voorwerpnummer = ?
  	)");
  $statement->execute(array($_GET['id'], $_GET['id']));
  $maxbid = $statement->fetch();

  $statement = $dbh->prepare("select * from Bestand where voorwerpnummer = ?");
  $statement->execute(array($_GET['id']));
  $bestanden = $statement->fetchAll();

  $time = date_create($results['looptijdeindedag2'] . $results['looptijdtijdstip']);
  $closingtime = date_format($time, "d M Y H:i"); //for example 14 Jul 2020 14:35

  //select looptijdbegindag, looptijd, dateadd(day, looptijd, looptijdbegindag) as looptijdeindedag from Voorwerp

  $statement = $dbh->prepare("select * from Rubriek where rubrieknummer = ?");
  $statement->execute(array($results['rubrieknummer']));
  $rubriek = $statement->fetch();
  $lijst = array($rubriek);

  while ($rubriek['rubrieknummerOuder'] != -1) {
    $statement->execute(array($rubriek['rubrieknummerOuder']));
    $rubriek = $statement->fetch();
    array_push($lijst, $rubriek);
  }

  $lijst = array_reverse($lijst);

  $hoofdrubriek = $lijst[0];
}
?>

<!--
These values are for debugging purposes and are visible by inspecting the page source

<p>ontvangen post gegevens: </p>
<?php print_r($_POST); ?><br>
<br>

<p>ontvangen get gegevens: </p>
<?php print_r($_GET); ?><br>
<br>

<p>ontvangen database gegevens: </p>
<?php print_r($results); ?><br>
<br>

<p>ontvangen rubriek gegevens: </p>
<?php print_r($rubriek); ?><br>
<br>

<p>ontvangen lijst gegevens: </p>
<?php print_r($lijst); ?><br>
<br>
-->

<!-- Banner -->
<div class="view index-header">
  <img src="img/bgs/account-bg.png" class="" height="350">
  <div class="mask index-banner rgba-niagara-strong">
    <h1 class="white-text banner-text"><?=$hoofdrubriek['rubrieknaam']?></h1>
  </div>
</div>

<p>Home
<?php
foreach ($lijst as $rubriek) {
  echo " > {$rubriek['rubrieknaam']}";
}
?>
</p>

<p>Sluit op <?=$closingtime?></p>

<p>Veilingnummer <?=$results['voorwerpnummer']?></p>

<p>Hoogste bod <?=$maxbid[0]?> door <?=$maxbid[1]?></p>

<p id="timer"></p>

<form method="post" class="col-md-6">
    <input type="number" name="bid" id="bid" class="form-control">
    <button type="submit" name="submit" class="btn btn-primary">Bied</button>
</form>

<?php
foreach ($bestanden as $bestand) {
  echo "<img src=\"{$bestand['filenaam']}\"></img>";
}
?>

<script>
countdown('timer', <?php echo "'{$results['looptijdeindedag2']} {$results['looptijdtijdstip']}'"; ?>);
</script>

<?php include('templates/footer.php'); ?>
