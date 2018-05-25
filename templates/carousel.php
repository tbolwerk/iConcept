<?php require_once("functions.php");
global $dbh;
$statement = $dbh->query("SELECT TOP 4 * FROM Voorwerp vw INNER JOIN Bestand b ON vw.voorwerpnummer=b.voorwerpnummer");
$carousel="";
while($row = $statement->fetch()){
	$i++;
	$timer="timer".$i;
	$looptijd = $row['looptijd'];
	$looptijdbegindag =strtotime($row['looptijdbegindag']);
	$looptijdbegintijdstip = strtotime($row['looptijdtijdstip']);
	$countdown_date = date("Y-m-d",$looptijdbegindag);
	$countdown_time = date("h:i:s",$looptijdbegintijdstip);
	$countdown = $countdown_date . " " . $countdown_time;
$carousel.=	'			<div class="col-md-3">
					<div class="card auction-card mb-4">
						<div class="view overlay">
							<img class="card-img-top" src="'.$row["filenaam"].'" alt="'.$row["titel"].'" />
						</div>
						<div class="card-body">
							<span class="small-font">'.$row["voorwerpnummer"].'</span>
							<h4 class="card-title">'.$row["titel"].'</h4>
							<hr>
							<div class="card-text">
								<p>
									'.$row["beschrijving"].'
								</p>
							</div>
							<hr />
							<ul class="list-unstyled list-inline d-flex" style="text-align:center">
								<li class="list-inline-item pr-2 flex-1 ml-5"><i class="fa fa-lg fa-gavel pr-2"></i>&euro;'.$row["startprijs"].'</li>
								<div class="card-line"></div>
								<li class="list-inline-item pr-2 flex-1 mr-5"><i class="fa fa-lg fa-clock pr-2"></i><div id='.$timer.'></div></li>
							</ul>
						</div>
					</div>
				</div>     <script>
				     countdown("'.$timer.'","'.$countdown.'");
				     </script>';
}


?>
<!--Carousel Wrapper-->
<div id="multi-item-example" class="carousel slide carousel-multi-item mt-5" data-ride="carousel">

    <!--Slides-->
    <div class="carousel-inner" role="listbox">
			<div class="carousel-item active">
<?=$carousel?>
</div>
			<!-- Second slide -->
			<div class="carousel-item">
<?=$carousel?>
			</div>
				<!-- Third slide -->
				<div class="carousel-item">
<?=$carousel?>
				</div>

  <!--/.Third slide-->

</div>
<!--/.Slides-->

</div>
<!--/.Carousel Wrapper-->
