<?php
require_once("templates/connect.php");
try{
$statement = $dbh->query("SELECT voorwerpnummer,titel,veilinggesloten ,dateadd(day, looptijd, looptijdbegindag) as looptijdeindedag,looptijdtijdstip FROM Voorwerp vw WHERE dateadd(day, looptijd, looptijdbegindag) < GETDATE()");
// $out = $statement->fetchAll();
// print_r($out);

while($row = $statement->fetch()){

  $closeAuction = $dbh->prepare("UPDATE Voorwerp SET veilinggesloten = 1 WHERE voorwerpnummer=?");
  $closeAuction->execute(array($row['voorwerpnummer']));

}

}catch(PDOException $e){
echo $e;
}

?>
