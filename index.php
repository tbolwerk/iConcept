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


<!--Carousel Wrapper-->
<div id="multi-item-example" class="carousel slide carousel-multi-item mt-5" data-ride="carousel">

    <!--Slides-->
    <div class="carousel-inner" role="listbox">

        <!--First slide-->
        <div class="carousel-item active">

          <div class="col-md-4">
              <div class="card auction-card mb-2">
                <div class="view overlay">
                  <img class="card-img-top" src="https://mdbootstrap.com/img/Mockups/Lightbox/Thumbnail/img%20(67).jpg" alt="Test Card" />
                </div>
                <div class="card-body">
                  <span class="small-font">20345322</span>
                  <h4 class="card-title">Veiling voorbeeld</h4>
                  <hr>
                  <div class="card-text">
                    <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                  </div>
                  <hr />
                  <ul class="list-unstyled list-inline">
                    <li class="list-inline-item pr-2"><i class="fa fa-lg fa-gavel pr-2"></i>&euro;40,50</li>
                    <li class="list-inline-item pr-2"><i class="fa fa-lg fa-clock pr-2"></i>02:01:21</li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="col-md-4 clearfix d-none d-md-block">
                <div class="card auction-card mb-2">
                  <div class="view overlay">
                    <img class="card-img-top" src="https://mdbootstrap.com/img/Mockups/Lightbox/Thumbnail/img%20(67).jpg" alt="Test Card" />
                  </div>
                  <div class="card-body">
                    <span class="small-font">20345322</span>
                    <h4 class="card-title">Veiling voorbeeld</h4>
                    <hr>
                    <div class="card-text">
                      <p>
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                      </p>
                    </div>
                    <hr />
                    <ul class="list-unstyled list-inline">
                      <li class="list-inline-item pr-2"><i class="fa fa-lg fa-gavel pr-2"></i>&euro;40,50</li>
                      <li class="list-inline-item pr-2"><i class="fa fa-lg fa-clock pr-2"></i>02:01:21</li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class='col-md-4 clearfix d-none d-md-block'>
                  <div class='card auction-card mb-2'>
                    <div class='view overlay'>
                      <img class='card-img-top' src='https://mdbootstrap.com/img/Mockups/Lightbox/Thumbnail/img%20(67).jpg' alt='Test Card' />
                    </div>
                    <div class='card-body'>
                      <span class='small-font'>20345322</span>
                      <h4 class='card-title'>Veiling voorbeeld</h4>
                      <hr>
                      <div class='card-text'>
                        <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                      </div>
                      <hr />
                      <ul class='list-unstyled list-inline'>
                        <li class='list-inline-item pr-2'><i class='fa fa-lg fa-gavel pr-2'></i>&euro;40,50</li>
                        <li class='list-inline-item pr-2'><i class='fa fa-lg fa-clock pr-2'></i>02:01:21</li>
                      </ul>
                    </div>
                  </div>
                </div>
        </div>
        <!--/.First slide-->

        <!--Second slide-->
        <div class="carousel-item">

            <div class="col-md-4">
                <div class="card mb-2">
                    <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/City/4-col/img%20(60).jpg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title">Card title</h4>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a class="btn btn-primary">Button</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 clearfix d-none d-md-block">
                <div class="card mb-2">
                    <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/City/4-col/img%20(47).jpg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title">Card title</h4>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a class="btn btn-primary">Button</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 clearfix d-none d-md-block">
                <div class="card mb-2">
                    <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/City/4-col/img%20(48).jpg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title">Card title</h4>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a class="btn btn-primary">Button</a>
                    </div>
                </div>
            </div>

        </div>
        <!--/.Second slide-->

        <!--Third slide-->
        <div class="carousel-item">

            <div class="col-md-4">
                <div class="card mb-2">
                    <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/Food/4-col/img%20(53).jpg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title">Card title</h4>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a class="btn btn-primary">Button</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 clearfix d-none d-md-block">
                <div class="card mb-2">
                    <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/Food/4-col/img%20(45).jpg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title">Card title</h4>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a class="btn btn-primary">Button</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 clearfix d-none d-md-block">
                <div class="card mb-2">
                    <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/Food/4-col/img%20(51).jpg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title">Card title</h4>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a class="btn btn-primary">Button</a>
                    </div>
                </div>
            </div>

        </div>
        <!--/.Third slide-->

    </div>
    <!--/.Slides-->

</div>
<!--/.Carousel Wrapper-->




<!--Main Navigation-->

<!--Main Layout-->
<main class="py-5">
<div class="container">
  <?php if(isset($error)){echo $error;}

  if(isset($searchResults)){
    echo $searchResults;
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
