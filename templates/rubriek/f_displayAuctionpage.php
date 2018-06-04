<?php
/*display auctionpage*/
function displayAuctionpage($voorwerpnummer = 0,$rubrieknummer = 0)
{


  global $dbh;
  global $auctionpage;

  $auction = "";


  try{
if(($rubrieknummer !=0)){
    $data = $dbh->prepare("SELECT * ,dateadd(day, looptijd, looptijdbegindag) as looptijdeindedag FROM Voorwerp vw LEFT JOIN(
SELECT DISTINCT b2.voorwerpnummer,(SELECT TOP 1 filenaam FROM Bestand b1 WHERE b1.voorwerpnummer=b2.voorwerpnummer
ORDER BY voorwerpnummer DESC) as 'filenaam' FROM Bestand b2) as b2
ON vw.voorwerpnummer=b2.voorwerpnummer
LEFT JOIN (
SELECT DISTINCT voorwerpnummer,(SELECT TOP 1 bodbedrag FROM Bod b1 where b1.voorwerpnummer=bd.voorwerpnummer
ORDER BY bodbedrag DESC ) as 'hoogsteBod' from Bod bd ) as bd
ON vw.voorwerpnummer=bd.voorwerpnummer
LEFT JOIN Voorwerp_in_Rubriek vr ON vr.voorwerpnummer=vw.voorwerpnummer
LEFT JOIN Rubriek r ON vr.rubrieknummer = r.rubrieknummer WHERE vr.rubrieknummer = ? AND vw.geblokkeerd = 0 OR r.rubrieknummerOuder = ? AND vw.geblokkeerd = 0");
    $data->execute(array($rubrieknummer,getChild($rubrieknummer)["rubrieknummerOuder"]));

  }else{
    $data = $dbh->query("SELECT * ,dateadd(day, looptijd, looptijdbegindag) as looptijdeindedag FROM Voorwerp vw LEFT JOIN(
SELECT DISTINCT b2.voorwerpnummer,(SELECT TOP 1 filenaam FROM Bestand b1 WHERE b1.voorwerpnummer=b2.voorwerpnummer
ORDER BY voorwerpnummer DESC) as 'filenaam' FROM Bestand b2) as b2
ON vw.voorwerpnummer=b2.voorwerpnummer
LEFT JOIN (
SELECT DISTINCT voorwerpnummer,(SELECT TOP 1 bodbedrag FROM Bod b1 where b1.voorwerpnummer=bd.voorwerpnummer
ORDER BY bodbedrag DESC ) as 'hoogsteBod' from Bod bd ) as bd
ON vw.voorwerpnummer=bd.voorwerpnummer WHERE vw.geblokkeerd = 0");
  }
   $i=0;
    while ($row = $data->fetch()) {
      $voorwerpnummer = $row[0];
      $i++;
      $timer="timer".$i;
      $looptijd = $row['looptijd'];
      $looptijdbegindag =strtotime($row['looptijdbegindag']);

      $looptijdbegintijdstip = strtotime($row['looptijdtijdstip']);
      // $countdown_date = date("Y-m-d",$looptijdbegindag);
      // $countdown_time = date("h:i:s",$looptijdbegintijdstip);
      if(isset($row['hoogsteBod'])){
         $huidige_bod = number_format($row['hoogsteBod'], 2, ',', '.');
       }else{
         $huidige_bod=$row['startprijs'];
       }

      $time = date_create($row['looptijdeindedag'] . $row['looptijdtijdstip']);
      $closingtime = date_format($time, "d M Y H:i"); //for example 14 Jul 2020 14:35


      $countdown = $closingtime;



      $auctionpage.='

      <div class="col-md-4">
      <div class="card auction-card mb-4">
      <div class="view overlay">
      <a href="detailpage.php?id='.$voorwerpnummer.'">
        <img class="card-img-top" src="'.$row["filenaam"].'" />
      </a>
      </div>
      <div class="card-body">
        <span class="small-font">'.$voorwerpnummer.'</span>
        <h4 class="card-title">'.$row["titel"].'</h4>
        <hr>
        <div class="card-text">
          <p>
            '.$row["beschrijving"].'
          </p>
        </div>
        <hr />
        <ul class="list-unstyled list-inline d-flex" style="text-align:center">
          <li class="list-inline-item pr-2 flex-1 ml-5"><i class="fa fa-lg fa-gavel pr-2"></i>&euro;'.$huidige_bod.'</li>
          <div class="card-line"></div>
          <li class="list-inline-item pr-2 flex-1 mr-5"><i class=""></i><div id='.$timer.'></div></li>
        </ul>
      </div>
    </div>
    </div>
    <script>
    countdown("'.$timer.'","'.$countdown.'");
    </script>
          ';
    }
  }catch(PDOException $e){
    $error = $e;
  }
}
?>
