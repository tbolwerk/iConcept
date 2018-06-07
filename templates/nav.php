<?php
$server = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
require_once($server . "/iconcept/templates/rubriek/f_convertAdjacencyListToTree.php");

// $statement = $dbh->query("SELECT * FROM Rubriek WHERE rubrieknummerOuder = -1");
// $rubrieken="";
// while($row = $statement->fetch()){
// $rubrieken.='<a class="dummy-media-object" href="?rubrieknummer='.$row["rubrieknummer"].'"><img class="round" src="" alt=""/><h3>'.$row["rubrieknaam"].'</h3></a>';
// }
// if(isset($_GET['rubrieknummer'])){
// $subrubriek = $_GET['rubrieknummer'];
// $statement = $dbh->prepare("SELECT * FROM Rubriek WHERE rubrieknummerOuder = ?");
// $statement->execute(array($subrubriek));
// }else{
//   $statement = $dbh->query("SELECT * FROM Rubriek r WHERE rubrieknummerOuder!=-1 AND rubrieknummerOuder!=1");
// }
// $subrubrieken="";
// while($row = $statement->fetch()){
//   $subrubrieken.='<a class="dummy-media-object" href=""><img src="" alt=""/><h3>'.$row["rubrieknaam"].'</h3></a>';
// }
// $veilingen="";
// $statement = $dbh->query("SELECT * FROM Voorwerp");
// while($row = $statement->fetch()){
//   $veilingen.='<a class="dummy-media-object" href=""><img src="" alt=""/><h3>#'.$row['voorwerpnummer'].' '.$row["titel"].'</h3></a>';
// }



?>
<!--Navbar-->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark">
<?php if($current_page == 'rubriek') {
  echo '  <a class="flypanels-button-mobile icon-menu mobileNav" onclick="w3_open()" href="#"><i class="fas fa-tags"></i></a>';
} ?>


    <!-- Navbar brand -->
    <a id="navbar-brand" class="navbar-brand" href="index.php">
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
    				<div id="display"></div>

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
    <div class="current-category">
      <h1><a href="rubriek.php">Rubrieken</a><?php if(isset($current_column)){
        echo $current_column;
      } ?></h1>
    </div>
    <div class="category-list">
<?php echo $column; ?>
</div>
  </div>
</div>

<!-- Category Sidebar -->
<!-- <div class="w3-sidebar w3-bar-block w3-animate-left " style="display:none;z-index:1031" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large" onclick="w3_close()">Close &times;</button>
  <button class="w3-button w3-block w3-left-align" onclick="myAccFunc()">
  Accordion <i class="fa fa-caret-down"></i>
  </button>
  <div id="demoAcc" class="w3-hide w3-white w3-card">
    <a href="#" class="w3-bar-item w3-button">Link</a>
    <a href="#" class="w3-bar-item w3-button">Link</a>
  </div>
  <button class="w3-button w3-block w3-left-align" onclick="myAccFunc()">
  Accordion <i class="fa fa-caret-down"></i>
  </button>
  <div id="demoAcc" class="w3-hide w3-white w3-card">
    <a href="#" class="w3-bar-item w3-button">Link</a>
    <a href="#" class="w3-bar-item w3-button">Link</a>
  </div>
  <button class="w3-button w3-block w3-left-align" onclick="myAccFunc()">
  Accordion <i class="fa fa-caret-down"></i>
  </button>
  <div id="demoAcc" class="w3-hide w3-white w3-card">
    <a href="#" class="w3-bar-item w3-button">Link</a>
    <a href="#" class="w3-bar-item w3-button">Link</a>
  </div>
</div>
<div class="w3-overlay w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" id="myOverlay"></div> -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/iConcept/templates/rubriek/sidebar-menu-mobile.php';?>
