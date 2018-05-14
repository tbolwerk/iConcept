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
  	register($_POST['username'],$_POST['firstname'],$_POST['lastname'],$_POST['address1'],$address2,$_POST['zipcode'],$_POST['city'],$_POST['country'],$_POST['birthday'],$_POST['email'],$_POST['email_check'],$_POST['password'],$_POST['password_check'],$_POST['secretAnswer'],$_POST['secretQuestion']);
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
                <input type="text" class="form-control white-text" name="firstname" id=firstname required pattern="[A-z]+">
                <label class="font-weight-light white-text" for="firstname">Voornaam</label>
            </div>

            <!-- Material input text -->
            <div class="md-form mr-5 ml-3">
                <i class="fa fa-user prefix niagara"></i>
                <input type="text" class="form-control white-text" name="lastname" id="lastname" required pattern="[A-z]+">
                <label class="font-weight-light white-text" for="lastname">Achternaam</label>
            </div>
          </div>

            <!-- Material input text -->
            <div class="d-flex flex-row">
            <div class="md-form ml-5 mr-5">
                <i class="fa fa-user prefix niagara"></i>
                <input type="text" class="form-control white-text" name="username" id="username" required >
                <label class="font-weight-light white-text" for="username">Gebruikersnaam</label>
            </div>
          </div>

          <div class="d-flex flex-row">
            <div class="md-form ml-5 mr-3">
                <i class="fa fa-user prefix niagara"></i>
                <input type="date"  class="form-control white-text" name="birthday" id="birthday" required>
                <label class="font-weight-light white-text" for="birthday"></label>
            </div>

          </div>

          <div class="d-flex flex-row">
            <!-- Material input text -->
            <div class="md-form ml-5 mr-3">
                <i class="fa fa-user prefix niagara"></i>
                <input type="password" class="form-control white-text" name="password" id="password" required>
                <label class="font-weight-light white-text" for="password">Wachtwoord</label>
            </div>

            <!-- Material input text -->
            <div class="md-form mr-5 ml-3">
                <i class="fa fa-user prefix niagara"></i>
                <input type="password" class="form-control white-text" name="password_check" id="password_check" required>
                <label class="font-weight-light white-text" for="password_check">Herhaal wachtwoord</label>
            </div>
          </div>

          <div class="d-flex flex-row">
            <!-- Material input email -->
            <div class="md-form ml-5 mr-3">
                <i class="fa fa-envelope prefix niagara"></i>
                <input type="email" class="form-control white-text" name="email" id="email" required>
                <label class="font-weight-light white-text" for="email">Emailadres</label>
            </div>

            <!-- Material input email -->
            <div class="md-form mr-5 ml-3">
                <i class="fa fa-exclamation-triangle prefix niagara"></i>
                <input type="email" class="form-control white-text" name="email_check" id="email_check" required>
                <label class="font-weight-light white-text" for="email_check">Bevestig emailadres</label>
            </div>
          </div>

          <div class="d-flex flex-row">
            <!-- Material input password -->
            <div class="md-form ml-5 mr-5">
                <i class="fa fa-home prefix niagara"></i>
                <input type="text" class="form-control white-text" name="address1" id="address1" required>
                <label class="font-weight-light white-text" for="address1">Adres</label>
            </div>
          </div>

          <div class="d-flex flex-row">
            <div class="md-form ml-5 mr-5">
                <i class="fa fa-home prefix niagara"></i>
                <input type="text" class="form-control white-text" name="address2" id="address2">
                <label class="font-weight-light white-text" for="address2">Adres (optioneel)</label>
            </div>
          </div>

          <div class="d-flex flex-row">
            <!-- Material input text -->
            <div class="md-form ml-5 mr-3">
                <i class="fa fa-user prefix niagara"></i>
                <input type="text" class="form-control white-text" name="zipcode" id="zipcode" required pattern="[0-9]{4,4}[A-Z]{2,2}">
                <label class="font-weight-light white-text" for="zipcode">Postcode</label>
            </div>

            <!-- Material input text -->
            <div class="md-form mr-5 ml-3">
                <i class="fa fa-user prefix niagara"></i>
                <input type="text" class="form-control white-text" name="city" id="city" required pattern="[A-z]+">
                <label class="font-weight-light white-text" for="city">Stad</label>
            </div>
          </div>

          <div class="d-flex flex-row">
            <!-- Material input text -->
            <div class="md-form ml-5 mr-5">
                <i class="fa fa-user prefix niagara"></i>
                <input type="text" class="form-control white-text" name="country" id="country" required pattern="[A-z]+">
                <label class="font-weight-light white-text" for="country">Land</label>
            </div>
          </div>

            <!-- Material input text -->
            <div class="d-flex flex-row">
            <div class="md-form ml-5 mr-5 register-select">
                <i class="fa fa-user prefix niagara"></i>
                <select name="secretQuestion" id="secretQuestion" class="register-select-form" required>
                  <option value="" class="font-weight-light black-text disabled selected">Kies een geheime vraag...</option>
                  <?=$secret_question_options?>
                </select>


            </div>
          </div>



            <!-- Material input password -->

            <!-- Material input text -->
            <div class="d-flex flex-row">
            <div class="md-form ml-5 mr-5">
                <i class="fa fa-user prefix niagara"></i>
                <input type="text" class="form-control white-text" name="secretAnswer" id="secretAnswer" required>
                <label class="font-weight-light white-text" for="secretAnswer">Antwoord op de geheime vraag</label>
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
<script>
function passwordConfirmation() {
  if (document.getElementById("password").value != document.getElementById("password_check").value) {
    document.getElementById("password_check").setCustomValidity("Wachtwoorden komen niet overeen");
  } else {
    document.getElementById("password_check").setCustomValidity("");
  }
}

function emailConfirmation() {
  if (document.getElementById("email").value != document.getElementById("email_check").value) {
    document.getElementById("email_check").setCustomValidity("Emailadressen komen niet overeen");
  } else {
    document.getElementById("email_check").setCustomValidity("");
  }
}


document.getElementById("password_check").onchange = passwordConfirmation;
document.getElementById("password").onchange = passwordConfirmation;
document.getElementById("email_check").onchange = emailConfirmation;
document.getElementById("email").onchange = emailConfirmation;
</script>
<?php include 'templates/footer.php'; ?>
