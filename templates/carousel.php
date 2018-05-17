<?php require_once("functions.php");
function displayCarousel()
{


	global $dbh;
	global $carousel;
	$carousel = "";

	try{
		$data = $dbh->query("select * from Voorwerp");
    $counter = 0;
		while ($row = $data->fetch()) {


			$carousel.='          <!--First slide-->
              <div class="carousel-item active">

                <div class="col-md-3">
                    <div class="card auction-card mb-4">
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
                </div>';
		}
	}catch(PDOException $e){
		$error = $e;
	}

}
displayCarousel();
?>
<!--Carousel Wrapper-->
<div id="multi-item-example" class="carousel slide carousel-multi-item mt-5" data-ride="carousel">

    <!--Slides-->
    <div class="carousel-inner" role="listbox">
<?=$carousel?>

    <div class="col-md-3">
      <div class="card auction-card mb-4">
        <div class="view overlay">
          <img class="card-img-top" src="https://picsum.photos/388/258/?image=2" alt="Test Card" />
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

  </div>
  <!--/.Third slide-->

</div>
<!--/.Slides-->

</div>
<!--/.Carousel Wrapper-->
