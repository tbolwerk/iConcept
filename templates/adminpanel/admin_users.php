<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/iConcept/templates/functions.php';
$message = "";
if(isset($_GET['ban'])){
  $statement = $dbh->prepare("UPDATE Gebruiker SET geblokkeerd = 1 WHERE gebruikersnaam = ?");
  $statement->execute(array($_GET['ban']));
  $message = "<p class='danger-text'>Account van <b>".$_GET['ban']."</b> is succesvol geblokkeerd</p>";
}
if(isset($_GET['unban'])){
  $statement = $dbh->prepare("UPDATE Gebruiker SET geblokkeerd = 0 WHERE gebruikersnaam = ?");
  $statement->execute(array($_GET['unban']));
  $message = "<p class='success-text'>Account van <b>".$_GET['unban']."</b> is succesvol gedeblokkeerd</p>";
}
$out = "";
$status = "";
$statement = $dbh->prepare("SELECT * FROM Gebruiker");
$statement->execute();
while($row = $statement->fetch()){
  if($row['geblokkeerd'] == 0){
    $status = '<span class="user-active"></span>Actief';
    $statusBtn= '<a href="?ban='.$row["gebruikersnaam"].'"><i class="fas fa-ban" aria-hidden="true"></i></a>';
  }else{
    $status = '<span class="user-blocked"></span>Geblokkeerd';
    $statusBtn= '<a href="?unban='.$row["gebruikersnaam"].'"><i class="fas fa-check aria-hidden="true"></i></a>';
  }
  $out.='<tr>
    <td>'.$row["gebruikersnaam"].'</td>
    <td>'.$row["email"].'</td>
    <td class="text-center">'.$status.'</td>
    <td class="text-center">'.$statusBtn.'</td>
  </tr>';
}


?>

<div class="col-11 verifcation-list">
  <div class="panel-information">
    <h1>Gebruikerslijst</h1>
    <p>In deze lijst staan alle gebruikers die geregistreert zijn op de website. Hier kan je de gebruikers blokkeren of deblokkeren</p>
  </div>
  <!-- Display notification box -->
  <div class="mb-5 ml-auto mr-auto text-center">
    <div id="adminAlertBox" class="alert alert-success" data-alert="alert">Dit werkt!</div>
    <!-- <?=$message?> -->
  </div>

    <!-- Table-->
  <table id="status" class="table verification-table-list fixed_headers">

      <!--Table head-->
      <thead>
          <tr>
              <th class="text-uppercase">Gebruikersnaam</th>
              <th class="text-uppercase">E-mailadres</th>
              <th class="text-uppercase text-center">Status</th>
              <th class="text-uppercase text-center">Acties</th>
          </tr>
      </thead>
    <!--Table head-->

      <!--Table body-->
      <div class="verification-table-content">
      <tbody>
          <?php echo $out; ?>
      </tbody>
    </div>
      <!--Table body-->

  </table>
  <!--Table -->
</div>
