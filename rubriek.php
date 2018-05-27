<?php
  $current_page='rubriek';
  require_once ('templates/header.php');
  $rubrieknaam = "Rubrieken";
  if(isset($_GET['rubrieknummer'])){
  $statement = $dbh->prepare("SELECT * FROM Rubriek WHERE rubrieknummer=?");
  $statement->execute(array($_GET['rubrieknummer']));
  while($row = $statement->fetch()){
    $rubrieknaam = $row['rubrieknaam'];
  }
}
  if(isset($_GET['voorwerpnummer'])){
  displayAuctionpage($_GET['voorwerpnummer']);
}else if(isset($_GET['rubrieknummer'])){
  displayAuctionpage($_GET['rubrieknummer']);
}else{
  displayAuctionpage();
}
?>
<div class="view index-header">
  <img src="img/rubriek/car-boats-motorcycles.png" class="" height="350">
  <div class="mask index-banner rgba-niagara-strong">
    <h1 class="white-text banner-text"><?=$rubrieknaam?></h1>
  </div>
</div>
<div class="container-fluid">
  <div class="row">
  <div class="category-sidebar col-md-12 col-lg-3">
    <div class="flypanels-container">
  		<?php include ('templates/rubriek/sidebar-menu.php'); ?>
  	</div>
  </div>


<div class="container-fluid category-page col-lg-9">
  <div class="col-md-12 col-lg-9 category-content">
    <div class="row">

      <?=$auctionpage?>
    </div>




  </div>
</div>
</div>
</div>



<?php include('templates/footer.php') ?>
