
<?php
if(isset($_POST['submit'])){
  sendVerificationCode($_POST['username']);
}

//Selects users that need verification
$statement = $dbh->prepare("SELECT G.gebruikersnaam, G.adresregel1, VV.code FROM Gebruiker G, Verkoper V, VerificatieVerkoper VV WHERE G.gebruikersnaam = V.gebruikersnaam AND G.gebruikersnaam = VV.gebruikersnaam AND VV.verzonden = 0");
$statement->execute();
$results = $statement->fetchAll();

//prints users that need verification
function printVerificationList($results){
  foreach ($results as $result) {
    echo '
    <tr>
      <td>' . $result['gebruikersnaam'] . '</td>
      <td>' . $result['adresregel1'] . '</td>
      <td>' . $result['code'] . '</td>
      <td class="text-right">
        <form method="post" action="">
          <input type="hidden" name="username" value="' . $result['gebruikersnaam'] . '"></input>
          <button style="border:none;background:none" type="submit" name="submit" data-toggle="tooltip" data-placement="top" title="Verifieër gebruiker"><i class="fas fa-check" aria-hidden="true"></i></button>
        </form>
      </td>
    </tr>
    ';
  }
}



function sendVerificationCode($username){
  global $dbh;
  try { //Set 'verzonden' in table 'VerificatieVerkoper' to true
    $statement = $dbh->prepare("UPDATE VerificatieVerkoper SET verzonden = 1 WHERE gebruikersnaam = ?");
    $statement->execute(array($username));
  } catch(PDOException $e) {
    $error = $e;
    echo $error;
  }
}
?>

<div class="col-11 verifcation-list">
  <div class="panel-information">
    <h1>Verificatielijst</h1>
    <p>In deze lijst staan alle gebruikers die zich via de post willen registeren als verkoper</p>
  </div>

    <!-- Table-->
  <table class="table verification-table-list fixed_headers">

      <!--Table head-->
      <thead>
          <tr>
              <th class="text-uppercase">Gebruikersnaam</th>
              <th class="text-uppercase">Adres</th>
              <th class="text-uppercase">Verificatiecode</th>
              <th class="text-uppercase text-center">Acties</th>
          </tr>
      </thead>
    <!--Table head-->

      <!--Table body-->
      <div class="verification-table-content">
      <tbody>
          <?=printVerificationList($results)?>
      </tbody>
    </div>
      <!--Table body-->

  </table>
  <!--Table -->
</div>
</div>
