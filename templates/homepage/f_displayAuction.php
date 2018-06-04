<?php
/*display auction*/
function displayAuction()
{


	global $dbh;
	global $auction;
	$auction = "";

	try{
		$data = $dbh->query("SELECT TOP(9) * ,dateadd(day, looptijd, looptijdbegindag) as looptijdeindedag FROM Voorwerp vw LEFT JOIN(
SELECT DISTINCT b2.voorwerpnummer,(SELECT TOP 1 filenaam FROM Bestand b1 WHERE b1.voorwerpnummer=b2.voorwerpnummer
ORDER BY voorwerpnummer DESC) as 'filenaam' FROM Bestand b2) as b2
ON vw.voorwerpnummer=b2.voorwerpnummer
LEFT JOIN (
 SELECT DISTINCT voorwerpnummer,(SELECT TOP 1 bodbedrag FROM Bod b1 where b1.voorwerpnummer=bd.voorwerpnummer
 ORDER BY bodbedrag DESC ) as 'hoogsteBod' from Bod bd ) as bd
 ON vw.voorwerpnummer=bd.voorwerpnummer WHERE vw.geblokkeerd = 0");
    $i=0;
		while ($row = $data->fetch()) {
      $voorwerpnummer = $row[0];
      $i++;
      $timer="timer".$i;
      $looptijd = $row['looptijd'];
      $looptijdbegindag =strtotime($row['looptijdbegindag']);
      $looptijdbegintijdstip = strtotime($row['looptijdtijdstip']);

             $time = date_create($row['looptijdeindedag'] . $row['looptijdtijdstip']);
             $closingtime = date_format($time, "d M Y H:i"); //for example 14 Jul 2020 14:35

						 $titel = strip_tags($row['beschrijving']);
			       $beschrijving = strip_tags($row['beschrijving'],'<br>');

             $countdown = $closingtime;

             if(isset($row['hoogsteBod'])){
             		$huidige_bod = number_format($row['hoogsteBod'], 2, ',', '.');
             	}else{
             	  $huidige_bod=$row['startprijs'];
             	}

			$auction.="  <div class='col-12 col-md-6 col-lg-4'>
          <div class='card auction-card'>
            <div class='view overlay'>
              <img class='card-img-top' src='".$row['filenaam']."' alt='".$titel."' />
            </div>
            <div class='card-body'>
              <span class='small-font'>".$voorwerpnummer."</span>
              <h4 class='card-title'>".$titel." #".$voorwerpnummer."</h4>
              <hr>
              <div class='card-text'>
                <p>
                ".$beschrijving."
                </p>
              </div>
              <hr />
              <ul class='list-unstyled list-inline d-flex'>
                <li class='list-inline-item flex-1 ml-5'><i class='fa fa-lg fa-gavel pr-2'></i>&euro;".$huidige_bod."</li>
								<div class='card-line'></div>
                <li class='list-inline-item flex-1 mr-5'><i class=''></i><div id=".$timer."></div></li>
              </ul>
            </div>

            <div class='view overlay mdb-blue'>
              <a href='detailpage.php?id=".$voorwerpnummer."' class='veiling-bieden'><div class='mask flex-center rgba-white-slight waves-effect waves-light'></div>
                  <p style='text-align:center'>Bieden</p>
                </div>
              </a>
            </div>
          </div>
          <script>
          countdown('".$timer."','".$countdown."');
          </script>

          ";
		}
	}catch(PDOException $e){
		$error = $e;
	}

}
?>
