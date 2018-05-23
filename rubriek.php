<?php
  $current_page='rubriek';
  require_once ('templates/header.php');
?>
<div class="view index-header">
  <img src="img/rubriek/car-boats-motorcycles.png" class="" height="350">
  <div class="mask index-banner rgba-niagara-strong">
    <h1 class="white-text banner-text">Auto's, boten en motoren</h1>
  </div>
</div>
<div class="flex-parent">
  <div class="category-sidebar col-sm-12 col-md-3 flex-1">
    <div class="flypanels-container">
  		<?php include ('templates/rubriek/sidebar-menu.php'); ?>
  	</div>
  </div>

<div class="container-fluid category-page flex-1" id="wrapper">
  <div class="col-sm-12 col-md-9 category-content">
    <div class="row">
      <div class="card auction-card mb-4 col-md-4">
        <div class="view overlay">
          <img class="card-img-top" src="https://picsum.photos/388/258/?image=4" alt="Test Card" />
        </div>
        <div class="card-body">
          <span class="small-font">20345322</span>
          <h4 class="card-title">'.$row["titel"].'</h4>
          <hr>
          <div class="card-text">
            <p>
              '.$row["beschrijving"].'
            </p>
          </div>
          <hr />
          <ul class="list-unstyled list-inline d-flex" style="text-align:center">
            <li class="list-inline-item pr-2 flex-1 ml-5"><i class="fa fa-lg fa-gavel pr-2"></i>&euro;40,50</li>
            <div class="card-line"></div>
            <li class="list-inline-item pr-2 flex-1 mr-5"><i class="fa fa-lg fa-clock pr-2"></i>02:01:21</li>
          </ul>
        </div>
      </div>
      <div class="card auction-card mb-4 col-md-4">
        <div class="view overlay">
          <img class="card-img-top" src="https://picsum.photos/388/258/?image=4" alt="Test Card" />
        </div>
        <div class="card-body">
          <span class="small-font">20345322</span>
          <h4 class="card-title">'.$row["titel"].'</h4>
          <hr>
          <div class="card-text">
            <p>
              '.$row["beschrijving"].'
            </p>
          </div>
          <hr />
          <ul class="list-unstyled list-inline d-flex" style="text-align:center">
            <li class="list-inline-item pr-2 flex-1 ml-5"><i class="fa fa-lg fa-gavel pr-2"></i>&euro;40,50</li>
            <div class="card-line"></div>
            <li class="list-inline-item pr-2 flex-1 mr-5"><i class="fa fa-lg fa-clock pr-2"></i>02:01:21</li>
          </ul>
        </div>
      </div>
      <div class="card auction-card mb-4 col-md-4">
        <div class="view overlay">
          <img class="card-img-top" src="https://picsum.photos/388/258/?image=4" alt="Test Card" />
        </div>
        <div class="card-body">
          <span class="small-font">20345322</span>
          <h4 class="card-title">'.$row["titel"].'</h4>
          <hr>
          <div class="card-text">
            <p>
              '.$row["beschrijving"].'
            </p>
          </div>
          <hr />
          <ul class="list-unstyled list-inline d-flex" style="text-align:center">
            <li class="list-inline-item pr-2 flex-1 ml-5"><i class="fa fa-lg fa-gavel pr-2"></i>&euro;40,50</li>
            <div class="card-line"></div>
            <li class="list-inline-item pr-2 flex-1 mr-5"><i class="fa fa-lg fa-clock pr-2"></i>02:01:21</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
</div>



<?php include('templates/footer.php') ?>
