<style>
.success-text {
  color: #00C851; }

  .danger-text {
  color: #ff3547; }
</style>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/iConcept/templates/functions.php';
$message = "";
if(isset($_GET['ban'])){
  $statement = $dbh->prepare("UPDATE Gebruiker SET geblokkeerd = 1 WHERE gebruikersnaam = ?");
  $statement->execute(array($_GET['ban']));
  $message = "<p class='danger-text'>Account van <b>".$_GET['ban']."</b> is Succesvol geblokkeerd</p>";
}
if(isset($_GET['unban'])){
  $statement = $dbh->prepare("UPDATE Gebruiker SET geblokkeerd = 0 WHERE gebruikersnaam = ?");
  $statement->execute(array($_GET['unban']));
  $message = "<p class='success-text'>Account van <b>".$_GET['unban']."</b> is Succesvol gedeblokkeerd</p>";
}
$out = "";
$status = "";
$statement = $dbh->prepare("SELECT * FROM Gebruiker");
$statement->execute();
while($row = $statement->fetch()){
  if($row['geblokkeerd'] == 0){
    $status = '<span class="user-active"></span>Actief';
    $statusBtn= '<a href="?ban='.$row["gebruikersnaam"].'"><i class="fas fa-ban" aria-hidden></i></a>';
  }else{
    $status = '<span class="user-blocked"></span>Geblokkeerd';
    $statusBtn= '<a href="?unban='.$row["gebruikersnaam"].'"><i class="fas fa-thumbs-up aria-hidden"></i></a>';
  }
  $out.='<tr>
    <td>'.$row["gebruikersnaam"].'</td>
    <td>'.$row["email"].'</td>
    <td>'.$status.'</td>
    <td class="text-center">'.$statusBtn.'</td>
  </tr>';
}


?>

<div class="col-11 verifcation-list">
  <div class="panel-information">
    <h1>Gebruikerslijst</h1>
    <p>In deze lijst staan alle gebruikers die geregistreert zijn op de website. Hier kan je de gebruikers blokkeren of deblokkeren</p>
    <?=$message?>
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
          <tr>
            <td>Gangsterboymark</td>
            <td>Mark@zucc.erberg</td>
            <td><span class="user-active"></span>Actief</td>
            <td class="text-center"><a href="#"><i class="fa fa-times" aria-hidden="true"></i></a></td>
          </tr>
          <tr>
            <td>Gangsterboymark</td>
            <td>Mark@zucc.erberg</td>
            <td><span class="user-blocked"></span>Geblokkeerd</td>
            <td class="text-center"><a href="#"><i class="fa fa-times" aria-hidden="true"></i></a></td>
          </tr>
          <tr>
            <td>Gangsterboymark</td>
            <td>Mark@zucc.erberg</td>
            <td><span class="user-active"></span>Actief</td>
            <td class="text-center"><a href="#"><i class="fa fa-times" aria-hidden="true"></i></a></td>
          </tr>
          <tr>
            <td>Gangsterboymark</td>
            <td>Mark@zucc.erberg</td>
            <td><span class="user-blocked"></span>Geblokkeerd</td>
            <td class="text-center"><a href="#"><i class="fa fa-times" aria-hidden="true"></i></a></td>
          </tr>
          <tr>
            <td>Gangsterboymark</td>
            <td>Mark@zucc.erberg</td>
            <td><span class="user-active"></span>Actief</td>
            <td class="text-center"><a href="#"><i class="fa fa-times" aria-hidden="true"></i></a></td>
          </tr>
          <tr>
            <td>Gangsterboymark</td>
            <td>Mark@zucc.erberg</td>
            <td><span class="user-blocked"></span>Geblokkeerd</td>
            <td class="text-center"><a href="#" disabled><i class="fas fa-check" aria-hidden="true"></i></a><a href="#"><i class="ml-2 fas fa-ban" aria-hidden="true"></i></a></td>
          </tr>
          <tr>
            <td>Gangsterboymark</td>
            <td>Mark@zucc.erberg</td>
            <td><span class="user-active"></span>Actief</td>
            <td class="text-center"><a href="#"><i class="fa fa-times" aria-hidden="true"></i></a></td>
          </tr>
          <tr>
            <td>Gangsterboymark</td>
            <td>Mark@zucc.erberg</td>
            <td><span class="user-active"></span>Actief</td>
            <td class="text-center"><a href="#"><i class="fa fa-times" aria-hidden="true"></i></a></td>
          </tr>

      </tbody>
    </div>
      <!--Table body-->

  </table>
  <!--Table -->
</div>
