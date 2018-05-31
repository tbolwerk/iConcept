<?php
$current_page='admin_panel';

if(isset($_POST['unblockAuction'])){
  unblockAuction($_POST['auctionId']);
}



function printAuctionList(){
  global $dbh;
  $statement = $dbh->prepare("SELECT * FROM Voorwerp WHERE geblokkeerd = 1");
  $statement->execute();
  $results = $statement->fetchAll();
  foreach ($results as $result) {
    echo '
    <tr>
      <td>' . $result['voorwerpnummer'] . '</td>
      <td>' . $result['titel'] . '</td>
      <td>' . $result['verkoper'] . '</td>
      <td class="text-center">
        <form method="post" action="">
          <input type="hidden" name="auctionId" value="' . $result['voorwerpnummer'] . '"></input>
          <button type="submit" name="unblockAuction"><i class="fa fa-times" aria-hidden="true"></i></button>
        </form>
      </td>
    </tr>
    ';
  }
}



function unblockAuction($auctionId){
  global $dbh;
  try { //Set 'geblokkeerd' in table 'Voorwerp' to false
    $statement = $dbh->prepare("UPDATE Voorwerp SET geblokkeerd = 0 WHERE voorwerpnummer = ?");
    $statement->execute(array($auctionId));
  } catch(PDOException $e) {
    $error = $e;
    echo $error;
  }
}
?>

<div class="col-11 verifcation-list">
  <div class="panel-information">
    <h1>Veilingenlijst</h1>
    <p>In deze lijst staan alle veilingen die op de geblokkeert zijn via de website Hier kan je de veilingen deblokkeren</p>
  </div>

    <!-- Table-->
  <table class="table verification-table-list">

      <!--Table head-->
      <thead>
          <tr>
              <th class="text-uppercase">#</th>
              <th class="text-uppercase">Titel</th>
              <th class="text-uppercase">Verkoper</th>
              <th class="text-uppercase text-center">Acties</th>
          </tr>
      </thead>
    <!--Table head-->

      <!--Table body-->
      <div class="verification-table-content">
      <tbody>
        <?=printAuctionList()?>
      </tbody>
    </div>
      <!--Table body-->

  </table>
  <!--Table -->
</div>
