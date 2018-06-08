<?php
function displayAuctionpage($voorwerpnummer = 0,$rubrieknummer = 0)
{
  global $dbh;
  global $auctionpage;
  global $pagination;
  $tbl_name="nieuws";		//your table name
  // How many adjacent pages should be shown on each side?
  $adjacents = 3;

  /*
     First get total number of rows in data table.
     If you have a WHERE clause in your query, make sure you mirror it here.
  */

  if($rubrieknummer == 0){
    $data = $dbh->query("SELECT COUNT(*) as num FROM Voorwerp");
    $row = $data->fetch();
    $total_pages = $row['num'];
  }
  else {
    $data = $dbh->query("SELECT COUNT(*) as num FROM Voorwerp_in_Rubriek WHERE rubrieknummer = $rubrieknummer");
    $row = $data->fetch();


    $total_pages = $row['num'];
  }


  /* Setup vars for query. */
  $targetpage = "rubriek.php?rubrieknummer=" . $rubrieknummer; 	//your file name  (the name of this file)
  $limit = 12;                  	//how many items to show per page
  if (!isset($_GET['page'])){
    $page = 1;
  }
  else{$page = $_GET['page'];}
  if($page){
    $start = ($page - 1) * $limit; 			//first item to display on this page
  }
  else{
    $start = 0;								//if no page var is given, set start to 0
  }
  $end = $start + $limit;

  /* Get data. */



try{
if(($rubrieknummer !=0)){
  $data = $dbh->prepare("SELECT top $end * ,dateadd(day, looptijd, looptijdbegindag) as looptijdeindedag FROM Voorwerp vw LEFT JOIN(
SELECT DISTINCT b2.voorwerpnummer,(SELECT TOP 1 filenaam FROM Bestand b1 WHERE b1.voorwerpnummer=b2.voorwerpnummer
ORDER BY voorwerpnummer DESC) as 'filenaam' FROM Bestand b2) as b2
ON vw.voorwerpnummer=b2.voorwerpnummer
LEFT JOIN (
SELECT DISTINCT voorwerpnummer,(SELECT TOP 1 bodbedrag FROM Bod b1 where b1.voorwerpnummer=bd.voorwerpnummer
ORDER BY bodbedrag DESC ) as 'hoogsteBod' from Bod bd ) as bd
ON vw.voorwerpnummer=bd.voorwerpnummer
LEFT JOIN Voorwerp_in_Rubriek vr ON vr.voorwerpnummer=vw.voorwerpnummer
LEFT JOIN Rubriek r ON vr.rubrieknummer = r.rubrieknummer WHERE vr.rubrieknummer = ? AND vw.geblokkeerd = 0
EXCEPT
SELECT top $start * ,dateadd(day, looptijd, looptijdbegindag) as looptijdeindedag FROM Voorwerp vw LEFT JOIN(
SELECT DISTINCT b2.voorwerpnummer,(SELECT TOP 1 filenaam FROM Bestand b1 WHERE b1.voorwerpnummer=b2.voorwerpnummer
ORDER BY voorwerpnummer DESC) as 'filenaam' FROM Bestand b2) as b2
ON vw.voorwerpnummer=b2.voorwerpnummer
LEFT JOIN (
SELECT DISTINCT voorwerpnummer,(SELECT TOP 1 bodbedrag FROM Bod b1 where b1.voorwerpnummer=bd.voorwerpnummer
ORDER BY bodbedrag DESC ) as 'hoogsteBod' from Bod bd ) as bd
ON vw.voorwerpnummer=bd.voorwerpnummer
LEFT JOIN Voorwerp_in_Rubriek vr ON vr.voorwerpnummer=vw.voorwerpnummer
LEFT JOIN Rubriek r ON vr.rubrieknummer = r.rubrieknummer WHERE vr.rubrieknummer = ? AND vw.geblokkeerd = 0");
  $data->execute(array($rubrieknummer,$rubrieknummer));

}else{
  $data = $dbh->query("SELECT top $end * ,dateadd(day, looptijd, looptijdbegindag) as looptijdeindedag FROM Voorwerp vw LEFT JOIN(
SELECT DISTINCT b2.voorwerpnummer,(SELECT TOP 1 filenaam FROM Bestand b1 WHERE b1.voorwerpnummer=b2.voorwerpnummer
ORDER BY voorwerpnummer DESC) as 'filenaam' FROM Bestand b2) as b2
ON vw.voorwerpnummer=b2.voorwerpnummer
LEFT JOIN (
SELECT DISTINCT voorwerpnummer,(SELECT TOP 1 bodbedrag FROM Bod b1 where b1.voorwerpnummer=bd.voorwerpnummer
ORDER BY bodbedrag DESC ) as 'hoogsteBod' from Bod bd ) as bd
ON vw.voorwerpnummer=bd.voorwerpnummer WHERE vw.geblokkeerd = 0
except
SELECT top $start * ,dateadd(day, looptijd, looptijdbegindag) as looptijdeindedag FROM Voorwerp vw LEFT JOIN(
SELECT DISTINCT b2.voorwerpnummer,(SELECT TOP 1 filenaam FROM Bestand b1 WHERE b1.voorwerpnummer=b2.voorwerpnummer
ORDER BY voorwerpnummer DESC) as 'filenaam' FROM Bestand b2) as b2
ON vw.voorwerpnummer=b2.voorwerpnummer
LEFT JOIN (
SELECT DISTINCT voorwerpnummer,(SELECT TOP 1 bodbedrag FROM Bod b1 where b1.voorwerpnummer=bd.voorwerpnummer
ORDER BY bodbedrag DESC ) as 'hoogsteBod' from Bod bd ) as bd
ON vw.voorwerpnummer=bd.voorwerpnummer WHERE vw.geblokkeerd = 0");
}
}catch(PDOException $e){
  $error = $e;
}

  /* Setup page vars for display. */
  if ($page == 0) $page = 1;					//if no page var is given, default to 1.
  $prev = $page - 1;							//previous page is page - 1
  $next = $page + 1;							//next page is page + 1
  $lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
  $lpm1 = $lastpage - 1;						//last page minus 1

  /*
    Now we apply our rules and draw the pagination object.
    We're actually saving the code to a variable in case we want to draw it more than once.
  */
  $pagination = "";
  if($lastpage > 1)
  {
    $pagination .= "<div class=\"card-body\"><ul class=\"pagination pg-blue\">";
    //previous button
    if ($page > 1) {
      $pagination.= "<li class=\"page-item\">
      <a href=\"$targetpage&page=$prev\" class=\"page-link\" aria-label=\"Previous\">
        <span aria-hidden=\"true\">&laquo;</span>
      </a>
    </li>";
        }
    else {
      $pagination.= "<li class=\"page-item disabled\">
      <a href=\"#\" class=\"page-link\" aria-label=\"Previous\">
        <span aria-hidden=\"true\">&laquo;</span>
      </a>
    </li>";	}

    //pages
    if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
    {
      for ($counter = 1; $counter <= $lastpage; $counter++)
      {
        if ($counter == $page)
          $pagination.= "<li class=\"page-item active\"><a href=\"#\" class=\"page-link\">$counter <span class=\"sr-only\">(current)</span></a></li>";
        else
          $pagination.= "<li class=\"page-item\"><a href=\"$targetpage&page=$counter\" class=\"page-link\">$counter</a></li>";
      }
    }
    elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
    {
      //close to beginning; only hide later pages
      if($page < 1 + ($adjacents * 2))
      {
        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
        {
          if ($counter == $page)
            $pagination.= "<li class=\"page-item active\"><a href=\"#\" class=\"page-link\" >$counter<span class=\"sr-only\">(current)</span></a></li>";
          else
            $pagination.= "<li class=\"page-item\"><a href=\"$targetpage&page=$counter\" class=\"page-link\">$counter</a></li>";
        }
        $pagination.= "<li class=\"page-item\"><a class=\"page-link\">...</a></li>";
        $pagination.= "<li class=\"page-item\"><a href=\"$targetpage&page=$lpm1\" class=\"page-link\">$lpm1</a></li>";
        $pagination.= "<li class=\"page-item\"><a href=\"$targetpage&page=$lastpage\" class=\"page-link\">$lastpage</a></li>";
      }
      //in middle; hide some front and some back
      elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
      {
        $pagination.= "<li class=\"page-item\"><a href=\"$targetpage&page=1\" class=\"page-link\">1</a></li>";
        $pagination.= "<li class=\"page-item\"><a href=\"$targetpage&page=2\" class=\"page-link\">2</a></li>";
        $pagination.= "<li class=\"page-item\"><a class=\"page-link\">...</a></li>";
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
        {
          if ($counter == $page)
            $pagination.= "<li class=\"page-item active\"><a href=\"#\" class=\"page-link\">$counter <span class=\"sr-only\">(current)</span></a></li>";
          else
            $pagination.= "<li class=\"page-item\"><a href=\"$targetpage&page=$counter\" class=\"page-link\">$counter</a></li>";
        }
        $pagination.= "<li class=\"page-item\"><a class=\"page-link\">...</a></li>";
        $pagination.= "<li class=\"page-item\"><a href=\"$targetpage&page=$lpm1\" class=\"page-link\">$lpm1</a></li>";
        $pagination.= "<li class=\"page-item\"><a href=\"$targetpage&page=$lastpage\" class=\"page-link\">$lastpage</a></li>";
      }
      //close to end; only hide early pages
      else
      {
        $pagination.= "<li class=\"page-item\"><a href=\"$targetpage&page=1\" class=\"page-link\">1</a></li>";
        $pagination.= "<li class=\"page-item\"><a href=\"$targetpage&page=2\" class=\"page-link\">2</a></li>";
        $pagination.= "<li class=\"page-item\"><a class=\"page-link\">...</a></li>";
        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
        {
          if ($counter == $page)
            $pagination.= "<li class=\"page-item active\"><a href=\"#\" class=\"page-link\">$counter <span class=\"sr-only\">(current)</span></a></li>";
          else
            $pagination.= "<li class=\"page-item\"><a href=\"$targetpage&page=$counter\" class=\"page-link\">$counter</a></li>";
        }
      }
    }

    //next button
    if ($page < $counter - 1)
      $pagination.= "<li class=\"page-item\">
      <a href=\"$targetpage&page=$next\" class=\"page-link\" aria-label=\"Next\">
        <span aria-hidden=\"true\">&raquo;</span>
      </a>
    </li>";
    else
      $pagination.= "<li class=\"page-item disabled\">
      <a href=\"#\" class=\"page-link\" aria-label=\"Next\">
        <span aria-hidden=\"true\">&raquo;</span>
      </a>
    </li>";
    $pagination.= "</ul></div>\n";
  }

  $i = 0;
    while($row = $data->fetch())
    {
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
      $titel = strip_tags($row['titel']);
      $beschrijving = strip_tags($row['beschrijving'],'<br>');

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
        <h4 class="card-title">'.$titel.'</h4>
        <hr>
        <div class="card-text">
          <p>
            '.$beschrijving.'
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
    $auctionpage .= $pagination;

}
?>
