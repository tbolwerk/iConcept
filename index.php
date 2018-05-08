<?php
$current_page='index';
require_once('templates/header.php');
displayAuction();
?>
<!--Main Navigation-->
<header>
  <div class="view view-main-header intro-2">
      <div class="full-bg-img">
          <div class="mask rgba-black-light flex-center">
              <div class="container text-center white-text">
                  <div class="white-text text-center wow fadeInUp">
                      <h2>This Navbar is fixed</h2>
                      <h5>It will always stay visible on the top, even when you scroll down</h5>
                      <br>
                      <p>Full page intro with background image will be always displayed in full screen mode, regardless of device </p>
                  </div>
              </div>
          </div>
      </div>
  </div>

</header>
<!--Main Navigation-->

<!--Main Layout-->
<main class="py-5">
<div class="container">
  <?php if(isset($error)){echo $error;}

  if(isset($searchResults)){echo $searchResults;
}
  ?>
  <h1><i class="fa fa-fire fa-lg"></i> Populaire veilingen op dit moment</h1><hr />
  <div class="row">


    <?php
      echo $auction;
      ?>
      </div>
    </div>
</main>
<!--Main Layout-->
<?php include 'templates/footer.php'; ?>
