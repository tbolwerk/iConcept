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
 ON vw.voorwerpnummer=bd.voorwerpnummer WHERE vw.geblokkeerd = 0 AND vw.veilinggesloten = 0 ORDER BY looptijdeindedag, looptijdtijdstip ASC");
    $i = 0;
		while ($row = $data->fetch()) {
      $id = $row[0];
      $i++;
      $timer = "timer{$i}";
			$maxbid = "maxbid{$i}";

			$countdown = "{$row['looptijdeindedag']} {$row['looptijdtijdstip']}";

			$title = strip_tags($row['titel']);
			$description = strip_tags($row['beschrijving'],'<br>');

			$auction .= <<<HTML
				<div class='col-12 col-md-6 col-lg-4'>
          <div class='card auction-card'>
            <div class='view overlay'>
              <img class='card-img-top' src='{$row['filenaam']}' alt='{$title}' />
            </div>
            <div class='card-body'>
              <span class='small-font'>{$id}</span>
              <h4 class='card-title'>{$title}</h4>
              <hr>
              <div class='card-text'>
              	<p>{$description}</p>
	            </div>
	            <hr />
	            <ul class='list-unstyled list-inline d-flex'>
	              <li class='list-inline-item flex-1 ml-5'><i class='fa fa-lg fa-gavel pr-2'></i><div style='display:inline;' id='{$maxbid}'></div></li>
								<div class='card-line'></div>
	              <li class='list-inline-item flex-1 mr-5'><i class=''></i><div id={$timer}></div></li>
	            </ul>
	          </div>

            <div class='view overlay mdb-blue'>
              <a href='detailpage.php?id={$id}' class='veiling-bieden'><div class='mask flex-center rgba-white-slight waves-effect waves-light'></div>
                  <p style='text-align:center'>Bieden</p>
                </div>
              </a>
            </div>
          </div>
          <script>
          countdown('{$timer}','{$countdown}');

					var x = setInterval(function() {
					  var xhttp;
					  xhttp = new XMLHttpRequest();
					  xhttp.onreadystatechange = function() {
					    if (this.readyState == 4 && this.status == 200) {
					    document.getElementById('{$maxbid}').innerHTML = this.responseText;
					    }
					  };
					  xhttp.open('GET', 'refreshbid.php?id={$id}', true);
					  xhttp.send();
					}, 2000);

          </script>
HTML;
		}
	} catch(PDOException $e) {
		$error = $e;
	}

}
?>
