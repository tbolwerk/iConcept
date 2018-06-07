<style>
.buttonEmpty{
  padding: 0;
border: none;
background: none;
}
</style>
<?php
$message = "";
if(isset($_POST['ban'])){
  $statement = $dbh->prepare("UPDATE Gebruiker SET geblokkeerd = 1 WHERE gebruikersnaam = ?");
  $statement->execute(array($_POST['gebruikersnaam']));
  $message = "Account van ".$_POST['gebruikersnaam']." is succesvol geblokkeerd";
}
if(isset($_POST['unban'])){
  $statement = $dbh->prepare("UPDATE Gebruiker SET geblokkeerd = 0 WHERE gebruikersnaam = ?");
  $statement->execute(array($_POST['gebruikersnaam']));
  $message = "Account van ".$_POST['gebruikersnaam']." is succesvol gedeblokkeerd";
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
    $statusBtn='
        <input type="hidden" name="gebruikersnaam" value="' . $row['gebruikersnaam'] . '"></input>
        <button type="submit" name="ban" id="unbanBtn" class="buttonEmpty" data-toggle="tooltip" data-placement="top" title="Ban gebruiker"><i class="fas fa-ban" aria-hidden="true"></i></button>';


  } else { //Else show as blocked
    $status = '<span class="user-blocked"></span>Geblokkeerd';
    $statusBtn='
        <input type="hidden" name="gebruikersnaam" value="' . $row['gebruikersnaam'] . '"></input>
        <button type="submit" name="unban" id="banBtn" class="buttonEmpty" data-toggle="tooltip" data-placement="top" title="Unban gebruiker"><i class="fas fa-check" aria-hidden="true"></i></button>';
  }
  $out.='<tr>
    <td>'.$row["gebruikersnaam"].'</td>
    <td>'.$row["email"].'</td>
    <td class="text-center">'.$status.'</td>
    <td class="text-center"><form method="post" action="">'.$statusBtn.'</form></td>
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
