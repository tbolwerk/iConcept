<?php require_once("functions.php"); ?>
<?php

$statement = $dbh->query("SELECT * FROM Rubriek WHERE rubrieknummerOuder = -1");
$rubrieken="";
while($row = $statement->fetch()){
$rubrieken.='<a class="dummy-media-object" href="?rubrieknummer='.$row["rubrieknummer"].'"><img class="round" src="" alt=""/><h3>'.$row["rubrieknaam"].'</h3></a>';
}
if(isset($_GET['rubrieknummer'])){
$subrubriek = $_GET['rubrieknummer'];
$statement = $dbh->prepare("SELECT * FROM Rubriek WHERE rubrieknummerOuder = ?");
$statement->execute(array($subrubriek));
}else{
  $statement = $dbh->query("SELECT * FROM Rubriek r WHERE rubrieknummerOuder!=-1 AND rubrieknummerOuder!=1");
}
$subrubrieken="";
while($row = $statement->fetch()){
  $subrubrieken.='<a class="dummy-media-object" href=""><img src="" alt=""/><h3>'.$row["rubrieknaam"].'</h3></a>';
}
$veilingen="";
$statement = $dbh->query("SELECT * FROM Voorwerp");
while($row = $statement->fetch()){
  $veilingen.='<a class="dummy-media-object" href=""><img src="" alt=""/><h3>#'.$row['voorwerpnummer'].' '.$row["titel"].'</h3></a>';
}



?>
<!--Navbar-->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark">

    <!-- Navbar brand -->
    <a class="navbar-brand" href="index.php">
      <img src="img/logo/logo.png" height="50" alt="EenmaalAndermaal" />
    </a>

    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="basicExampleNav">
        <!-- Links -->
        <div>
          <ul class="navbar-nav">
            <li class="nav-item">
              <span onclick="openNav()">
              <a class="nav-link" href="#">Rubrieken
                <span class="sr-only">(current)</span>
              </a>
            </span>
            </li>
          </ul>
        </div>
        <div class="nav-search" style="flex:1">
          <!-- <form class="my-2 my-lg-0 ml-auto">
            <input class="form-control mr-sm-2" type="text" placeholder="Zoeken" aria-label="Zoeken">
          </form> -->
          <div id="search_overlay" class="search_overlay" style="flex:1;">
    				<form class="search_overlay-form">
    					<input class="search_overlay-input niagara" id="search" type="search" placeholder="Zoeken..."/>
    					<button class="search_overlay-submit" type="submit">Search</button>
    				</form>
    				<div class="search_overlay-content">
    					<div class="dummy-column" style="">
    						<h2>Rubrieken</h2>
    						<div class="search-scroll">
<?=$rubrieken?>
    					</div>
    				</div>

    				<div class="dummy-column">
    						<h2>Sub-rubrieken</h2>
    						<div class="search-scroll">
<?=$subrubrieken?>
    					</div>
    				</div>
    				<div class="dummy-column">
    						<h2>Veilingen</h2>
    						<div class="search-scroll">
<?=$veilingen?>
    					</div>
    				</div>

    				</div><!-- /morphsearch-content -->
    				<span class="search_overlay-close"></span>
    			</div><!-- /morphsearch -->
    			<div class="overlay"></div>

        </div>

        <div class="vl d-none d-md-block"></div>


        <!-- Links -->

        <ul class="navbar-nav ml-auto nav-flex-icons">
          <?php
          if (isset($_SESSION['username'])) {
            include 'templates/logged_in.php';
          } else {
            include 'templates/not_logged_in.php';
          }
           ?>
        </ul>



    </div>
    <!-- Collapsible content -->

</nav>
<!--/.Navbar-->



<!-- Rubrieken overlay -->
<div id="myNav" class="overlay_rubrieken">

  <!-- Button to close the overlay navigation -->
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

  <!-- Overlay content -->
  <div class="overlay-content">
<?php echo $column; ?>
  </div>
</div>
