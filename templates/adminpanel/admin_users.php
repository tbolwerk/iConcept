<?php
$message = "";
if(isset($_GET['ban'])){
  $statement = $dbh->prepare("UPDATE Gebruiker SET geblokkeerd = 1 WHERE gebruikersnaam = ?");
  $statement->execute(array($_GET['ban']));
  $message = "Account van ".$_GET['ban']." is succesvol geblokkeerd";
}
if(isset($_GET['unban'])){
  $statement = $dbh->prepare("UPDATE Gebruiker SET geblokkeerd = 0 WHERE gebruikersnaam = ?");
  $statement->execute(array($_GET['unban']));
  $message = "Account van ".$_GET['unban']." is succesvol gedeblokkeerd";
}
$out = "";
$status = "";
//SQL statement to get all users form the database
$statement = $dbh->prepare("SELECT * FROM Gebruiker");
$statement->execute();
//Iterate over all received users
while( $row = $statement->fetch()){
  if ($row['geblokkeerd'] == 0){ //When not blocked show user as active
    $status = '<span class="user-active"></span>Actief';
    $statusBtn= '<a id="status" href="?ban='.$row["gebruikersnaam"].'"><i class="fas fa-ban" aria-hidden="true"></i></a>';
  } else { //Else show as blocked
    $status = '<span class="user-blocked"></span>Geblokkeerd';
    $statusBtn= '<a id="status" href="?unban='.$row["gebruikersnaam"].'"><i class="fas fa-check aria-hidden="true"></i></a>';
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
    <!-- Table-->
  <table id="status" class="table verification-table-list fixed_headers">
      <!--Table head that show's what information about the users is displayed -->
      <thead>
          <tr>
              <th class="text-uppercase">Gebruikersnaam</th>
              <th class="text-uppercase">E-mailadres</th>
              <th class="text-uppercase text-center">Status</th>
              <th class="text-uppercase text-center">Acties</th>
          </tr>
      </thead>
      <!--Table body-->
      <div class="verification-table-content">
      <tbody>
        <!-- Displays all the users through PHP code -->
          <?=$out?>
      </tbody>
    </div>
  </table>
</div>
