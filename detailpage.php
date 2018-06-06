<?php
$current_page='detailpage';
require_once('templates/header.php');

if(isset($_POST['block'])){
  $statement = $dbh->prepare("UPDATE Voorwerp SET geblokkeerd = 1 WHERE voorwerpnummer = ?");
  $statement->execute(array($_GET['id']));
}

if (isset($_GET['id'])) {
  if(!isset($_SESSION['username'])){
    $error = "U moet ingelogt zijn om te bieden klik <br><a href='login.php'>hier om in te loggen</a>";
  }else{
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
        $error = $e->getMessage();
        echo "<!--|-~----~-|Database error|-~----~-|-->";
        echo "<!--{$error}-->";
        $error = "Ongeldig bod";
      }
    }
  }
}
try{
  $statement = $dbh->prepare("select *, dateadd(day, looptijd, looptijdbegindag) as looptijdeindedag2 from Voorwerp join Voorwerp_in_Rubriek on Voorwerp.voorwerpnummer = Voorwerp_in_Rubriek.voorwerpnummer where Voorwerp.voorwerpnummer = ?");
  $statement->execute(array($_GET['id']));
  $results = $statement->fetch();
  $time = date_create($results['looptijdeindedag2'] . $results['looptijdtijdstip']);
  $closingtime = date_format($time, "d M Y H:i"); //for example 14 Jul 2020 14:35
  $titel = strip_tags($results["titel"]);
  $beschrijving = strip_tags($results["beschrijving"],'<br>');
  $betalingswijze = strip_tags($results['betalingswijze']);
  $betalingsinstructie = strip_tags($results['betalingsinstructie']);
  $verzendkosten = strip_tags($results['verzendkosten']);
  $verzendinstructies = strip_tags($results['verzendinstructies']);
}catch(PDOException $e){

}
try{
  $statement = $dbh->prepare("select * from Bod where voorwerpnummer = ?");
  $statement->execute(array($_GET['id']));
  $biddings = $statement->fetch();

  $statement = $dbh->prepare("select bodbedrag, gebruikersnaam from Bod where voorwerpnummer = ? and bodbedrag = (
  	select max(bodbedrag) from Bod where voorwerpnummer = ?)");
  $statement->execute(array($_GET['id'], $_GET['id']));
  $maxbid = $statement->fetch();
}catch(PDOException $e){

}
try{
  $statement = $dbh->prepare("select * from Bestand where voorwerpnummer = ?");
  $statement->execute(array($_GET['id']));
  $images = $statement->fetchAll();
}catch(PDOException $e){

}


try{
  $statement = $dbh->prepare("select * from Rubriek where rubrieknummer = ?");
  $statement->execute(array($results['rubrieknummer']));
  $category = $statement->fetch();
  $categorychain = array($category);

  while ($category['rubrieknummerOuder'] != -1) {
    $statement->execute(array($category['rubrieknummerOuder']));
    $category = $statement->fetch();
    array_push($categorychain, $category);
  }

  $categorychain = array_reverse($categorychain);

  $maincategory = $categorychain[0];
}catch(PDOException $e){

}

  if (isset($_SESSION['username']) && $_SESSION['username'] == $results['verkoper']) {
    $input = "disabled";
  }
}
?>

<!-- Banner -->
<div class="view index-header">
  <img src="img/bgs/account-bg.png" class="" height="350">
  <div class="mask index-banner rgba-niagara-strong">
    <h1 class="white-text banner-text"><?=$maincategory['rubrieknaam']?></h1>
  </div>
</div>
<?php if($results['geblokkeerd'] == 1){
  echo "De veiling is gesloten";
}else{
  ?>

<div class="container">
  <!-- breadcrumb to see the path the user took to get to this page. Clicking one of the categories will bring you back to that category -->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="grey-text" href="index.php">Home</a></li>
      <?php
      foreach ($categorychain as $category) {
        echo "<li class='breadcrumb-item'><i class='grey-text fa fa-angle-right mx-2' aria-hidden='true'></i><a class='niagara' href=\"rubriek.php?rubrieknummer={$category['rubrieknummer']}\">{$category['rubrieknaam']}</a></li>";
      }
      ?>
    </ol>

  <div class="row p-3">
    <div class="col-md-7 vertical-line">
      <!-- This includes the necessary code to display the pictures correctly -->
      <?php include('detailpage_pictures.php'); ?>
      <div>
      <div id="active-picture" style="width: 80%; float: left;">
        <div class='pictureFrame'>
          <img height="100%" src="<?=$pictures[0]['filenaam']?>"></img>
        </div>
      </div>
      <div style="width: 20%; float: right;">
        <?=generatePictureSelector($pictures)?>
      </div>
      </div>
      <div style="clear: both;"></div>



    </div>

    <div class="col-md-5 product-info">

    <h2 class="product-title"><?=$titel?></h2>

      <hr>

      <div class="row text-center">
        <!-- Displays the highest bid on the current auction -->
        <div class="col">
          <p class="grey-text small">Hoogste bod</p>
          <p class="highest-bid" id="maxbid">€<?=$maxbid[0]?></p>
        </div>
        <div class="col">
          <p class="grey-text small">Resterende tijd</p>
          <p class="auction-timer" id="timer"></p>
        </div>
      </div>

      <hr>

      <form method="post">
        <div class="row">
            <div class="ml-5 col-12 col-md-7 mt-2">
              <input type="number" name="bid" class="form-control" step="0.01" <?php if(isset($input)){echo $input;}?>>
            </div>
            <div class="">
              <button type="submit" name="submit" class="btn elegant" <?php if(isset($input)){echo $input;}?>>Bied</button>
              <?php if(isset($_SESSION['admin']) == 1){?><button name="block" class="btn btn-danger px-3"><i class="fas fa-ban"></i></button><?php } ?>
            </div>
        </div>
      </form>

      <p class="red-text text-center font-weight-bold"><?=$error?></p>

      <hr>
      <ul class="product-info-data">
        <li><i class="fas fa-lg fa-tags" aria-hidden="true"></i> Startprijs: €<?=$results['startprijs']?></li>
        <li><i class="far fa-lg fa-compass" aria-hidden="true"></i> <?=$results['plaatsnaam']?>, <?=$results['land']?></li>
        <li><i class="far fa-lg fa-calendar-times" aria-hidden="true"></i> Sluit op: <?=$closingtime?></li>
        <li><i class="fas fa-lg fa-barcode" aria-hidden="true"></i> Veilingnummer: <?=$results['voorwerpnummer']?></li>
        <li><i class="far fa-lg fa-user" aria-hidden="true"></i> Verkoper: <?=$results['verkoper']?></li>
      </div>

    </div>

  <ul class="nav nav-tabs product-description">
    <li class="nav-item active">
      <a class="nav-link active panel-name" data-toggle="tab" href="#tab1" role="tab">Productomschrijving</a>
    </li>
    <li class="nav-item">
      <a class="nav-link panel-name" data-toggle="tab" href="#tab2" role="tab">Betaalinformatie</a>
    </li>
    <li class="nav-item">
      <a class="nav-link panel-name" data-toggle="tab" href="#tab3" role="tab">Verzendinformatie</a>
    </li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane fade in show active" id="tab1" role="tabpanel">
      <p><?=$beschrijving?></p>
    </div>
    <div class="tab-pane fade" id="tab2" role="tabpanel">
      <p class="font-weight-bold niagara">Betaalwijze</p>
      <p><?=$betalingswijze?></p>
      <br>
      <p class="font-weight-bold niagara">Betaalinstructie</p>
      <p><?=$betalingsinstructie?></p>
    </div>
    <div class="tab-pane fade" id="tab3" role="tabpanel">
      <p class="font-weight-bold niagara">Verzendkosten</p>
      <p>€<?=$verzendkosten?></p>
      <br>
      <p class="font-weight-bold niagara">Verzendinstructies</p>
      <p><?=$verzendinstructies?></p>
    </div>
  </div>
</div>

<script>
countdown('timer', <?php echo "'{$closingtime}'"; ?>);

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
<?php } ?>
<?php include('templates/footer.php'); ?>
