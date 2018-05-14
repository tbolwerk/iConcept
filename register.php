<?php
$current_page='register';
require_once('templates/header.php');

$secret_question_options = null;
try {
    $data = $dbh->prepare("select * from Vraag");
    $data->execute();
} catch (PDOException $e) {
    $error = $e;
}
while($question = $data->fetch()){
  $secret_question_options .= "<option value='{$question['vraagnummer']}'>{$question['vraag']}</option>";
}




if(isset($_POST['submit'])){
  $address2=NULL;
  if($_POST['address2']!=""){
    $address2=$_POST['address2'];
  }
  	register($_POST['username'],$_POST['firstname'],$_POST['lastname'],$_POST['address1'],$address2,$_POST['zipcode'],$_POST['city'],$_POST['country'],$_POST['birthdate'],$_POST['email'],$_POST['email_check'],$_POST['password'],$_POST['password_check'],$_POST['secretAnswer'],$_POST['secretQuestion']);
}
?>
<!--Main Layout-->
<main class="py-5 mask rgba-black-light">
  <div class="bg bg-login"></div>
<!-- Card -->
<div class="container col-md-6">
<!-- Card -->
<div class="card login-register-card">
    <!-- Card body -->
    <div class="card-body">
      <!-- Register header -->
      <div class="login-form-header elegant">
        <h3>Registreren</h3>
      </div>
        <!-- Material form register -->
        <form action="" method="post" autocomplete="on">
            <!-- Material input text -->
            <div class="d-flex flex-row">
            <div class="md-form ml-5 mr-3">
                <i class="fa fa-user prefix niagara"></i>
                <input type="text" class="form-control white-text" name="firstname">
                <label class="font-weight-light white-text">Voornaam</label>
            </div>

            <!-- Material input text -->
            <div class="md-form mr-5 ml-3">
                <i class="fa fa-user prefix niagara"></i>
                <input type="text" class="form-control white-text" name="lastname">
                <label class="font-weight-light white-text">Achternaam</label>
            </div>
          </div>

            <!-- Material input text -->
            <div class="d-flex flex-row">
            <div class="md-form ml-5 mr-5">
                <i class="fa fa-user prefix niagara"></i>
                <input type="text" class="form-control white-text" name="username">
                <label class="font-weight-light white-text">Gebruikersnaam</label>
            </div>
          </div>

          <div class="d-flex flex-row">
            <div class="md-form ml-5 mr-3">
                <i class="fa fa-user prefix niagara"></i>
                <input type="text"  class="form-control white-text" name="birthday">
                <label class="font-weight-light white-text">Geboortedag</label>
            </div>
            <div class="md-form ml-3 mr-3">
                <i class="fa fa-user prefix niagara"></i>
                <input type="text"  class="form-control white-text" name="birthmonth">
                <label class="font-weight-light white-text">Geboortemaand</label>
            </div>
            <div class="md-form ml-3 mr-5">
                <i class="fa fa-user prefix niagara"></i>
                <input type="text"  class="form-control white-text" name="birthyear">
                <label for="materialFormCardNameEx" class="font-weight-light white-text">Geboortejaar</label>
            </div>
          </div>

          <div class="d-flex flex-row">
            <!-- Material input text -->
            <div class="md-form ml-5 mr-3">
                <i class="fa fa-user prefix niagara"></i>
                <input type="password" class="form-control white-text" name="password">
                <label class="font-weight-light white-text">Wachtwoord</label>
            </div>

            <!-- Material input text -->
            <div class="md-form mr-5 ml-3">
                <i class="fa fa-user prefix niagara"></i>
                <input type="password" class="form-control white-text" name="password_check">
                <label class="font-weight-light white-text">Herhaal wachtwoord</label>
            </div>
          </div>

          <div class="d-flex flex-row">
            <!-- Material input email -->
            <div class="md-form ml-5 mr-3">
                <i class="fa fa-envelope prefix niagara"></i>
                <input type="email" class="form-control white-text" name="email">
                <label class="font-weight-light white-text">Emailadres</label>
            </div>

            <!-- Material input email -->
            <div class="md-form mr-5 ml-3">
                <i class="fa fa-exclamation-triangle prefix niagara"></i>
                <input type="email" class="form-control white-text" name="email_check">
                <label class="font-weight-light white-text">Bevestig emailadres</label>
            </div>
          </div>

          <div class="d-flex flex-row">
            <!-- Material input password -->
            <div class="md-form ml-5 mr-5">
                <i class="fa fa-home prefix niagara"></i>
                <input type="text" class="form-control white-text" name="address1">
                <label class="font-weight-light white-text">Adres</label>
            </div>
          </div>

          <div class="d-flex flex-row">
            <div class="md-form ml-5 mr-5">
                <i class="fa fa-home prefix niagara"></i>
                <input type="text" class="form-control white-text" name="address2">
                <label class="font-weight-light white-text">Adres (optioneel)</label>
            </div>
          </div>

          <div class="d-flex flex-row">
            <!-- Material input text -->
            <div class="md-form ml-5 mr-3">
                <i class="fa fa-user prefix niagara"></i>
                <input type="text" class="form-control white-text" name="zipcode">
                <label class="font-weight-light white-text">Postcode</label>
            </div>

            <!-- Material input text -->
            <div class="md-form mr-5 ml-3">
                <i class="fa fa-user prefix niagara"></i>
                <input type="text" class="form-control white-text" name="city">
                <label class="font-weight-light white-text">Stad</label>
            </div>
          </div>

          <div class="d-flex flex-row">
            <!-- Material input text -->
            <div class="md-form ml-5 mr-5">
                <i class="fa fa-user prefix niagara"></i>
                <input type="text" class="form-control white-text" name="country">
                <label class="font-weight-light white-text">Land</label>
            </div>
          </div>

            <!-- Material input text -->
            <div class="d-flex flex-row">
            <div class="md-form ml-5 mr-5 register-select">
                <i class="fa fa-user prefix niagara"></i>
                <select name="secretQuestion" class="">
                  <option value="kies" class="font-weight-light white-text disabled selected">Kies een geheime vraag...</option>
                  <?=$secret_question_options?>
                </select>


            </div>
          </div>



            <!-- Material input password -->

            <!-- Material input text -->
            <div class="d-flex flex-row">
            <div class="md-form ml-5 mr-5">
                <i class="fa fa-user prefix niagara"></i>
                <input type="text" class="form-control white-text" name="secretAnswer">
                <label class="font-weight-light white-text">Antwoord op de geheime vraag</label>
            </div>
          </div>


            <div class="text-center py-4 mt-4 ml-5 mr-5">
                <button class="btn elegant" type="submit" name="submit">Registreren</button>
            </div>
        </form>
        <!-- Material form register -->
<?php
if(isset($errors)){
print_r($errors);

}
if(isset($error)){
  echo $error;
}

?>

    </div>
    <!-- Card body -->

</div>
<!-- Card -->
</div>
<!-- Card -->

</main>
<!--Main Layout-->
<!-- Material form register -->
<?php include 'templates/footer.php'; ?>
