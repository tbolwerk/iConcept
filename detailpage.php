<?php
$current_page='detailpage';
require_once('templates/header.php');

if (isset($_GET['id'])) { //Dit hele ding is nog een WIP
  $error = "";
  if (isset($_POST['bid'])) {
    $bid = str_replace("\"", "", strip_tags($_POST['bid']));
    if ($bid <= 0) {
      $error = "Bod is te laag";
    }
    if ($error == "") {
      try {
        $statement = $dbh->prepare("insert into bod(voorwerpnummer, bodbedrag, gebruikersnaam, boddag, bodtijdstip) Values (?, ?, ?, GETDATE(), CURRENT_TIMESTAMP)");
        $statement->execute(array($_GET['id'], $bid, $_SESSION['username']));
      } catch(PDOException $e){
        $error = $e->getCode();
        if ($error == 23000) {
          $error = "Primary key conflict";
        }
      }
    }
  }

  $statement = $dbh->prepare("select *, dateadd(day, looptijd, looptijdbegindag) as looptijdeindedag2 from Voorwerp join Voorwerp_in_Rubriek on Voorwerp.voorwerpnummer = Voorwerp_in_Rubriek.voorwerpnummer where Voorwerp.voorwerpnummer = ?");
  $statement->execute(array($_GET['id']));
  $results = $statement->fetch();

  $statement = $dbh->prepare("select * from Bod where voorwerpnummer = ?");
  $statement->execute(array($_GET['id']));
  $biddings = $statement->fetch();

  $statement = $dbh->prepare("select bodbedrag, gebruikersnaam from Bod where voorwerpnummer = ? and bodbedrag = (
  	select max(bodbedrag) from Bod where voorwerpnummer = ?)");
  $statement->execute(array($_GET['id'], $_GET['id']));
  $maxbid = $statement->fetch();

  $statement = $dbh->prepare("select * from Bestand where voorwerpnummer = ?");
  $statement->execute(array($_GET['id']));
  $bestanden = $statement->fetchAll();

  $time = date_create($results['looptijdeindedag2'] . $results['looptijdtijdstip']);
  $closingtime = date_format($time, "d M Y H:i"); //for example 14 Jul 2020 14:35

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

  $minIncrease = 1;
  $minBidAmount = $maxbid[0] + $minIncrease;
}
?>

<!-- Banner -->
<div class="view index-header">
  <img src="img/bgs/account-bg.png" class="" height="350">
  <div class="mask index-banner rgba-niagara-strong">
    <h1 class="white-text banner-text"><?=$hoofdrubriek['rubrieknaam']?></h1>
  </div>
</div>

<p>Sluit op <?=$closingtime?></p>

<p id="maxbid">Hoogste bod <?=$maxbid[0]?> door <?=$maxbid[1]?></p>

<div class="container-fluid">
  <h5><strong>
    <a class="black-text" href="index.php">Home</a>
    <?php
    foreach ($lijst as $rubriek) {
      echo " > <a class='black-text' href=\"rubriek.php?rubrieknummer={$rubriek['rubrieknummer']}\">{$rubriek['rubrieknaam']}</a>";
    }
    ?>
  </strong></h5>

  <div class="row">
    <div class="col-md-7">

      <?php //Display images
      foreach ($bestanden as $bestand) {
        echo "<img src=\"{$bestand['filenaam']}\"></img>";
      }
      ?>

      <p><?=$results['betalingswijze']?></p>

    </div>

    <div class="col-md-5">

      <h2><strong><?=$results['titel']?></strong></h2>

      <hr>

      <div class="row text-center">
        <div class="col">
          <p><?=$maxbid[0]?> door <?=$maxbid[1]?></p>
        </div>
        <div class="col">
          <p id="timer">Dit moet nog opgelost worden</p>
        </div>
      </div>

      <hr>

      <form method="post" class="row">
          <div class="col"></div>
          <input type="number" name="bid" class="form-control col-md-5" required min="<?=$minBidAmount?>">
          <button type="submit" name="submit" class="btn btn-primary col-md-3">Bied</button>
          <div class="col"></div>
      </form>

      <p class="red-text text-center"><strong><?=$error?></strong></p>

      <hr>

      <p>Startprijs: <?=$results['startprijs']?></p>
      <p><?=$results['plaatsnaam']?>, <?=$results['land']?></p>
      <p>Sluit op: <?=$closingtime?></p>
      <p><?=$results['betalingsinstructie']?></p>
      <p>Veilingnummer: <?=$results['voorwerpnummer']?></p>

    </div>
  </div>

  <h4>Productomschrijving</h4>

  <hr>
  <!-- <p><?=$results['beschrijving']?></p> -->
  <p>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris quam justo, ultricies eget enim a, viverra rutrum massa.
    Praesent semper faucibus luctus. Donec condimentum interdum augue, eget scelerisque justo tempor a. Suspendisse orci dolor, lobortis quis lacus quis,
    aliquam mollis enim. Integer finibus venenatis arcu id viverra. Cras nec enim sed dolor laoreet efficitur quis sed arcu. Fusce ligula sapien, tincidunt
    eget quam ac, hendrerit tristique erat. Aliquam ullamcorper nibh ac ipsum volutpat tincidunt. Etiam et felis orci.
  </p>
  <p>
    Ut tellus nisl, ultricies vehicula iaculis sed, scelerisque at orci. Aliquam id vulputate ex. Nunc dolor erat, mollis eget rutrum ut, laoreet ac sapien. Sed imperdiet diam at arcu hendrerit, non convallis risus aliquet. Fusce quis lobortis purus. Maecenas feugiat rhoncus lacus sagittis ornare. Mauris ac placerat orci. Interdum et malesuada fames ac ante ipsum primis in faucibus.
  </p>
  <p>
    Integer dapibus metus risus, tempor ultricies tortor tincidunt sed. Suspendisse vitae ligula nec dolor finibus efficitur at a metus. Aenean ullamcorper urna metus. Vestibulum mollis consequat placerat. Duis imperdiet tellus imperdiet scelerisque molestie. Vestibulum eget urna id purus mollis malesuada sit amet vitae mi. Quisque non porttitor augue. Nulla felis odio, malesuada finibus tincidunt id, porttitor elementum justo. Proin eu mi eu nisl malesuada ultricies. Integer sed ligula dignissim nulla sodales egestas. Aliquam vel ligula venenatis, vulputate augue quis, dignissim quam. Proin ex diam, sodales a aliquam vel, accumsan eu lacus. Etiam posuere efficitur urna. Maecenas molestie faucibus felis, in pellentesque nisi sagittis ut. Suspendisse eget est ut purus ultricies blandit. Maecenas vel pellentesque sem.
  </p>
  <p>
    Nulla aliquam ipsum odio, et egestas dolor lacinia vitae. Duis non laoreet erat, sit amet volutpat elit. Sed efficitur arcu vitae neque auctor, a scelerisque ipsum commodo. Sed cursus velit in ex facilisis lobortis. Nam pretium odio nibh, et blandit nulla vehicula a. Quisque euismod, metus eget convallis facilisis, nibh odio ultrices tellus, vel ultricies metus nulla quis massa. Nunc vulputate neque quis mauris tempus, et congue velit rhoncus. Pellentesque dignissim mollis nisl sit amet efficitur. Quisque venenatis volutpat tellus, molestie ullamcorper sapien rhoncus sit amet.
  </p>
  <p>
    Pellentesque congue vehicula neque ut vestibulum. Aenean leo urna, tempor in venenatis et, aliquam elementum felis. Aliquam condimentum felis facilisis tempus commodo. Duis semper mi vel nulla tincidunt, nec viverra libero pharetra. Sed at feugiat sem. Donec euismod sem non ligula scelerisque vestibulum. Duis eget iaculis tortor, sed viverra lacus. Mauris ultricies sed nulla a eleifend. Cras consectetur porta risus, sit amet vestibulum arcu molestie sit amet. Sed dapibus dolor id lectus semper, vitae euismod leo sodales. Quisque vel vehicula dui. Integer aliquet odio arcu, vitae efficitur odio consequat vitae. Pellentesque augue erat, ornare id laoreet ut, rutrum ac arcu. Maecenas consectetur est risus, et lobortis quam interdum vitae. Quisque lorem lectus, suscipit a est nec, iaculis bibendum neque.
  </p>
</div>

<script>
countdown('timer', <?php echo "'{$results['looptijdeindedag2']} {$results['looptijdtijdstip']}'"; ?>);

  var x = setInterval(function() {
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
      document.getElementById("maxbid").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "refreshbid.php?id=<?=$_GET['id']?>", true);
    xhttp.send();
}, 1000);
</script>

<?php include('templates/footer.php'); ?>
