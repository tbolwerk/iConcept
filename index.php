<?php
$current_page='index';
require_once('templates/header.php');
displayAuction();
?>


<!--Main Navigation-->
<!-- <div class="index-header"> -->

  <!-- <div class="index-banner mask pattern-5">
    <h1>EenmaalAndermaal</h1>
    <h6>...verkocht! Zo simpel is het.</h6>
  </div> -->

<!-- </div> -->
<div class="view index-header">
    <img src="img/bgs/home-bg.png" class="" height="350">
    <div class="mask index-banner rgba-niagara-strong">
        <h1 class="white-text index-text banner-text">EenmaalAndermaal</h1>
        <h3 class="white-text">...verkocht! Zo simpel is het</h3>
    </div>
  </div>
</div>

 <!-- Include file for the carousel on the index page -->
<?php include 'templates/carousel.php'; ?>




<!--Main Navigation-->

<!--Main Layout-->
<main class="py-5">
<div class="container">
  <?php if(isset($error)){echo $error;}

  if(isset($searchResults)){
    echo $searchResults;
}
  ?>
  <h1><i class="fa fa-clock fa-lg"></i> Sluitende veilingen</h1><hr />
  <div class="row">


    <?php
    for ($i=1; $i < 2; $i++) {
      echo $auction;
    }

      ?>
      </div>
    </div>




    <!-- "Hoe werkt het?" section -->
 <div class="container-fluid mt-3 mb-5 how-does-it-work">
   <div class="pt-3 mb-3 white-text text-center">
     <h1>Hoe werkt het?</h1>
   </div>
   <div class="row ml-3 mr-3 pb-3 text-center">
     <div class="col-md-12 col-lg-4">
       <img src="img/register.png" alt="test">
       <div class="mt-2">
       <h4 class="white-text">Registreer jezelf via de website</h4>
     </div>
     </div>
     <div class="col-md-12 col-lg-4">
       <img src="img/activate.png" alt="test">
       <div class="mt-2">
       <h4 class="white-text">Activeer je account</h4>
     </div>
     </div>
     <div class="col-md-12 col-lg-4">
       <img src="img/bid.png" alt="test">
       <div class="mt-2">
       <h4 class="white-text">Bieden maar!</h4>
     </div>
     </div>
   </div>
 </div>

 <!-- Question opportunities -->
 <div class="container-fluid mt-3 mb-3 contact">
   <div class="pt-3 black-text text-center mb-5">
     <h1 class="mb-3">Heeft u vragen?</h1>
     <p>Neem dan contact met ons op via een van de onderstaande kanalen, dan hopen wij u zo snel mogelijk van dienst te kunnen zijn.</p>
   </div>
   <div class="row ml-3 mr-3 pb-3">
     <div class="col-md-12 col-lg-4" style=" text-align: center;">
       <a href="#">
         <i class="fab fa-10x fa-facebook-square"></i>
       </a>
     </div>
     <div class="col-md-12 col-lg-4" style=" text-align: center;">
       <a href="#">
         <i class="fab fa-10x fa-google-plus-square"></i>
       </a>
     </div>
     <div class="col-md-12 col-lg-4" style=" text-align: center;">
       <a href="#">
         <i class="fab fa-10x fa-twitter-square"></i>
       </a>
     </div>
   </div>
 </div>


</main>
<!--Main Layout-->
<?php include 'templates/footer.php'; ?>
