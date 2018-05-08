<?php
$current_page='index';
require_once('templates/header.php');
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
      for ($i=0; $i < 3; $i++) {
        echo "
        <div class='col-md-4'>
          <div class='card auction-card'>
            <div class='view overlay'>
              <img class='card-img-top' src='https://mdbootstrap.com/img/Mockups/Lightbox/Thumbnail/img%20(67).jpg' alt='Test Card' />
            </div>
            <div class='card-body'>
              <span class='small-font'>20345322</span>
              <h4 class='card-title'>Veiling #1</h4>
              <hr>
              <div class='card-text'>
                <p>
                  Hier komt een kleine omschrijving van max 250 letters te staan waarin dit product snel omschreven wordt.
                </p>
              </div>
              <hr />
              <ul class='list-unstyled list-inline'>
                <li class='list-inline-item pr-2'><i class='fa fa-lg fa-gavel pr-2'></i>&euro;12,99</li>
                <li class='list-inline-item pr-2'><i class='fa fa-lg fa-clock pr-2'></i>02:12:43:14</li>
              </ul>
            </div>
            <div class='view overlay mdb-blue'>
              <a href='#veiling' class='veiling-bieden'>
                <div class='mask flex-center rgba-white-slight waves-effect waves-light'></div>
                  <p style='text-align:center'>Bieden</p>
                </div>
              </a>
            </div>
          </div>";
      };
      ?>
      </div>
    </div>
</main>
<!--Main Layout-->
<?php include 'templates/footer.php'; ?>
