<?php
$current_page='index';
require_once('templates/header.php');
displayAuction();
?>

<script>
var myVar = setInterval(myTimer, 1000);

function myTimer() {
    var d = new Date();
    document.getElementById("demo").innerHTML = d.toLocaleTimeString();
}
</script>
<!--Main Navigation-->
<!-- <div class="index-header"> -->

  <!-- <div class="index-banner mask pattern-5">
    <h1>EenmaalAndermaal</h1>
    <h6>...verkocht! Zo simpel is het.</h6>
  </div> -->

<!-- </div> -->
<div class="view index-header">
    <img src="https://images.unsplash.com/photo-1453060590797-2d5f419b54cb?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=f42332c3b8e749209b9ce1c2f7d212d0&auto=format&fit=crop&w=2250&q=80" class="img-fluid" height="450">
    <div class="mask index-banner pattern-5">
    <div class="mask index-banner rgba-cyan-light">
        <h1 class="white-text banner-text">EenmaalAndermaal</h1>
        <h3 class="white-text">...verkocht! Zo simpel is het</h3>
    </div>
  </div>
</div>

 <!-- Include file for the carousel on the index page -->
<?php include "templates/carousel.php";?>




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

 <!-- <div class="container-fluid mt-3 mb-3" style="background-color: #4584A4; height: 350px;">
   <div class="">
     <h1 style="text-align: center">Hoe werkt het?</h1>
   </div>
   <div class="row">
     <div class="col-md-4">
       <img src="" alt="test">
     </div>
   </div>
 </div> -->


</main>
<!--Main Layout-->
<?php include 'templates/footer.php';?>
