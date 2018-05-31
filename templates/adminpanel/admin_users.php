<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/iConcept/templates/functions.php';
$out = "";
$status = "";
$statement = $dbh->prepare("SELECT * FROM Gebruiker");
$statement->execute();
while($row = $statement->fetch()){
  if($row['geblokkeerd'] == 0){
    $status = '<span class="user-active"></span>Actief';
  }else{
    $status = '<span class="user-blocked"></span>Geblokkeerd';
  }
  $out.='<tr>
    <td>'.$row["gebruikersnaam"].'</td>
    <td>'.$row["email"].'</td>
    <td>'.$status.'</td>
    <td class="text-center"><a href="#"><i class="fa fa-times" aria-hidden="true"></i></a></td>
  </tr>';
}


?>

<div class="col-11 verifcation-list">
  <div class="panel-information">
    <h1>Gebruikerslijst</h1>
    <p>In deze lijst staan alle gebruikers die geregistreert zijn op de website. Hier kan je de gebruikers blokkeren of deblokkeren</p>
  </div>

    <!-- Table-->
  <table class="table verification-table-list">

      <!--Table head-->
      <thead>
          <tr>
              <th class="text-uppercase">Gebruikersnaam</th>
              <th class="text-uppercase">E-mailadres</th>
              <th class="text-uppercase">Status</th>
              <th class="text-uppercase text-center">Acties</th>
          </tr>
      </thead>
    <!--Table head-->

      <!--Table body-->
      <div class="verification-table-content">
      <tbody>
        <?=$out?>

      </tbody>
    </div>
      <!--Table body-->

  </table>
  <!--Table -->
</div>
