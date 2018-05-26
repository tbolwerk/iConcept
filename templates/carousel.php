<?php require_once("functions.php");
global $dbh;
try{
$statement = $dbh->query("SELECT * FROM Voorwerp vw LEFT JOIN Bestand b ON vw.voorwerpnummer=b.voorwerpnummer");

$carousel= array();
$i=0;
while($row = $statement->fetch()){
	$i--;
	$timer="timer".$i;
	$looptijd = $row['looptijd'];
	$looptijdbegindag =strtotime($row['looptijdbegindag']);
	$looptijdbegintijdstip = strtotime($row['looptijdtijdstip']);
	$countdown_date = date("Y-m-d",$looptijdbegindag);
	$countdown_time = date("h:i:s",$looptijdbegintijdstip);
	$countdown = $countdown_date . " " . $countdown_time;
	$out = '';

$carousel[]=	'			<div class="col-md-3">
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
				</div><script>
						 countdown("'.$timer.'","'.$countdown.'");
						 </script>';
}
for($i = 0; $i<count($carousel);$i++){
if($i>11){
	break;
}
	if($i==0){
$out.='<div class="carousel-item active">';

}else
	if($i==4){
$out.='</div>';
$out.='<div class="carousel-item">';

}else
	if($i==8){
		$out.='</div>';
$out.='<div class="carousel-item">';

	}
	$out.=$carousel[$i];


}
}catch(PDOException $e){
	$out = '';

}


?>
<!--Carousel Wrapper-->
<div id="multi-item-example" class="carousel slide carousel-multi-item mt-5" data-ride="carousel">

    <!--Slides-->
    <div class="carousel-inner" role="listbox">
<?=$out?>

  <!--/.Third slide-->

</div>
<!--/.Slides-->

</div>
<!--/.Carousel Wrapper-->
