<?php
require_once("templates/mail/f_blockMail.php");

// If the auction gets blocked successfully it will write a message to the message variable
// that gets executed with toastr after a page refresh
if(isset($_POST['unblockAuction'])){
  try {
    unblockAuction($_POST['auctionId']);
    $message = "Veiling is succesvol gedeblokkeerd";
    //header('Location:rubriek.php');
  } catch (PDOException $e){
    $message = "Er is iets fout gegaan tijdens het deblokkeren van de veiling";
  }

}

function printAuctionList(){
  $message = "";
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
          <button type="submit" name="unblockAuction" id="unblockAuctionBtn" data-toggle="tooltip" data-placement="top" title="Unblock veiling"><i class="fa fa-times" aria-hidden="true"></i></button>
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
    blockMail("unblock auction", $auctionId);
  } catch(PDOException $e) {
    $error = $e;
    echo $e;
  }
}
?>

<!-- This is the panel content for the blocked auctions -->
<div class="col-11 verifcation-list">
  <!-- This is where the information about this panel is set -->
  <div class="panel-information">
    <h1>Veilingenlijst</h1>
    <p>In deze lijst staan alle veilingen die geblokkeerd zijn via de website. Hier kan je de veilingen deblokkeren</p>
  </div>

    <!-- Table-->
  <table class="table verification-table-list fixed_headers">

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
