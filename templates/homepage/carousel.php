<?php
global $dbh;
try{
$statement = $dbh->query("SELECT TOP(12) * ,dateadd(day, looptijd, looptijdbegindag) as looptijdeindedag FROM Voorwerp vw LEFT JOIN(
SELECT DISTINCT b2.voorwerpnummer,(SELECT TOP 1 filenaam FROM Bestand b1 WHERE b1.voorwerpnummer=b2.voorwerpnummer
ORDER BY voorwerpnummer DESC) as 'filenaam' FROM Bestand b2) as b2
ON vw.voorwerpnummer=b2.voorwerpnummer
LEFT JOIN (
 SELECT DISTINCT voorwerpnummer,(SELECT TOP 1 bodbedrag FROM Bod b1 where b1.voorwerpnummer=bd.voorwerpnummer
 ORDER BY bodbedrag DESC ) as 'hoogsteBod' from Bod bd ) as bd
 ON vw.voorwerpnummer=bd.voorwerpnummer WHERE vw.geblokkeerd = 0");

$carousel= array();
$i=0;
while($row = $statement->fetch()){
	$id = $row[0];
	$i--;
  $timer = "timer{$i}";
  $maxbid = "maxbid{$i}";

  $countdown = "{$row['looptijdeindedag']} {$row['looptijdtijdstip']}";

  $title = strip_tags($row['titel']);
  $description = strip_tags($row['beschrijving'],'<br>');

	$out = "";

  $carousel[] = <<<HTML
    <div class="col-md-3">
  		<div class="card auction-card mb-4">
  			<div class="view overlay">
  			<a href="detailpage.php?id={$id}"><div class="mask flex-center rgba-white-slight waves-effect waves-light"></div>
  				<img class="card-img-top" src="{$row['filenaam']}" alt="{$title}" />
  			</a>
  			</div>
  			<div class="card-body">
  				<span class="small-font">{$id}</span>
  				<h4 class="card-title">{$title}</h4>
  				<hr>
  				<div class="card-text">
  					<p>{$description}</p>
  				</div>
  				<hr />
  				<ul class="list-unstyled list-inline d-flex" style="text-align:center">
  					<li class="list-inline-item pr-2 flex-1 ml-5"><i class="fa fa-lg fa-gavel pr-2"></i><div style="display:inline;" id="{$maxbid}"></div></li>
  					<div class="card-line"></div>
  					<li class="list-inline-item pr-2 flex-1 mr-5"><i class=""></i><div id="{$timer}"></div></li>
  				</ul>
  			</div>
  		</div>
  	</div>
    <script>
    countdown("{$timer}", "{$countdown}");

    var x = setInterval(function() {
     var xhttp;
     xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
       if (this.readyState == 4 && this.status == 200) {
       document.getElementById("{$maxbid}").innerHTML = this.responseText;
       }
     };
     xhttp.open("GET", "refreshbid.php?id={$id}", true);
     xhttp.send();
   }, 2000);

    </script>
HTML;
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


    <!--Indicators-->
    <ol class="carousel-indicators">
        <li data-target="#multi-item-example" data-slide-to="0" class="active"></li>
        <li data-target="#multi-item-example" data-slide-to="1"></li>
        <li data-target="#multi-item-example" data-slide-to="2"></li>
    </ol>
    <!--/.Indicators-->

<?php if(isset($out)){
  echo $out;
}?>

  <!--/.Third slide-->

</div>
<!--/.Slides-->
<!--Controls-->

<!--/.Controls-->
</div>
<div class="controls-top">
  <a class="btn btn-primary" href="#multi-item-example" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
  <a class="btn btn-primary" href="#multi-item-example" data-slide="next"><i class="fa fa-chevron-right"></i></a>
</div>
<!--/.Carousel Wrapper-->
</div>
