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
    <img src="img/bgs/home-bg.png" class="" height="350">
    <div class="mask index-banner rgba-niagara-strong">
        <h1 class="white-text banner-text">EenmaalAndermaal</h1>
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
 <div class="container-fluid mt-3 mb-3" style="background-color: #4584A4;">
   <div class="pt-3 white-text">
     <h1 style="text-align: center; font-weight: bold;">Hoe werkt het?</h1>
   </div>
   <div class="row ml-3 mr-3 pb-3">
     <div class="col-md-4">
       <img src="https://images.unsplash.com/photo-1516116216624-53e697fedbea?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=0f388c03c3f15daa78a7afd93b2ff3e3&auto=format&fit=crop&w=2300&q=80" width="500" height="350" alt="test" style="border-radius: 5px">
       <div class="mt-2">
       <h4 class="white-text" style="text-align: center;">Registreer jezelf via de website</h4>
     </div>
     </div>
     <div class="col-md-4">
       <img src="https://images.unsplash.com/photo-1484100356142-db6ab6244067?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=287b89ab963953c2301037e788c2eb99&auto=format&fit=crop&w=1924&q=80" width="500" height="350" alt="test" style="border-radius: 5px">
       <div class="mt-2">
       <h4 class="white-text" style="text-align: center;">Activeer je account</h4>
     </div>
     </div>
     <div class="col-md-4">
       <img src="https://images.unsplash.com/photo-1491974162517-a7541284efe7?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=e0c4664b504f632d31f49fb757f9335f&auto=format&fit=crop&w=3310&q=80" width="500" height="350" alt="test" style="border-radius: 5px">
       <div class="mt-2">
       <h4 class="white-text" style="text-align: center;">Bieden maar!</h4>
     </div>
     </div>
   </div>
 </div>


</main>
<!--Main Layout-->
<?php include 'templates/footer.php'; ?>
