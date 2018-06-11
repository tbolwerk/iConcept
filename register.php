<?php
$current_page='register';
require_once('templates/header.php');
require_once("templates/register/f_register.php");

$secret_question_options = null;
try {
    $data = $dbh->prepare("select * from Vraag");
    $data->execute();
} catch (PDOException $e) {
    $error = $e;
}
while($question = $data->fetch()){
  $secret_question_options .= "<option class='black-text' value='{$question['vraagnummer']}'>{$question['vraag']}</option>";
}

$land_options = null;
try {
    $data2 = $dbh->prepare("select landnaam from Landen");
    $data2->execute();
} catch (PDOException $e) {
    $error = $e;
}
while($country = $data2->fetch()){
  $land_options .= "<option class='black-text' value='{$country['landnaam']}'>{$country['landnaam']}</option>";
}




if(isset($_POST['submit'])){
  $address2=NULL;
  if($_POST['address2']!=""){
    $address2=$_POST['address2'];
  }
  	register($_POST['username'],$_POST['firstname'],$_POST['lastname'],$_POST['address1'],$address2,$_POST['zipcode'],$_POST['city'],$_POST['country'],$_POST['birthday'],$_POST['email'],$_POST['email_check'],$_POST['password'],$_POST['password_check'],$_POST['secretAnswer'],$_POST['secretQuestion']);
}

$message = "";

if(isset($errors) || isset($error)){
  foreach ($errors as $error) {
    $message.= "De volgende foutmeldingen zijn opgetreden: ".$error;
  }

}else if(isset($_POST['submit'])){
$message = "Account succesvol aanngemaakt, klik op de verificatie link in de ontvangen mail om het account te activeren";
}
?>
<!--Main Layout-->
<main class="py-5 mask rgba-black-light">
  <div class="bg bg-login"></div>
<!-- Card -->
<div class="container col-md-6">
<!-- Card -->
<div class="card login-register-card registerMobile">
    <!-- Card body -->
    <div class="card-body">
      <!-- Register header -->
      <div class="login-form-header elegant">
        <h3>Registreren</h3>
      </div>
      <!-- <?=$message?> -->
        <!-- Material form register -->
        <form action="" method="post" autocomplete="on">
            <!-- Material input text -->
            <div class="d-flex flex-row">
            <div class="md-form ml-5 mr-3">
                <i id="registerIcon" class="fa fa-user prefix niagara"></i>
                <input type="text" class="form-control white-text" name="firstname" id=firstname maxlength="35"  required pattern="[A-z]+">
                <div class="form-requirements white-text">
                  <ul>
                    <li>Mag maximaal 35 karakters bevatten</li>
                  </ul>
                </div>
                <label class="font-weight-light white-text" for="firstname">Voornaam</label>
            </div>

            <!-- Material input text -->
            <div class="md-form mr-5 ml-3">
                <!-- <i class="fa fa-user prefix niagara"></i> -->
                <input type="text" class="form-control white-text" name="lastname" id="lastname" required pattern="[A-z]+">
                <div class="form-requirements white-text">
                  <ul>
                    <li>Mag maximaal 35 karakters bevatten</li>
                  </ul>
                </div>
                <label class="font-weight-light white-text" for="lastname">Achternaam</label>
            </div>
          </div>

            <!-- Material input text -->
            <div class="d-flex flex-row">
            <div class="md-form ml-5 mr-5">
                <i id="registerIcon" class="fas fa-user prefix niagara"></i>
                <input type="text" class="form-control white-text" name="username" id="username" required >
                <div class="form-requirements white-text">
                  <ul>
                    <li>Mag maximaal 25 karakters bevatten</li>
                  </ul>
                </div>
                <label class="font-weight-light white-text" for="username">Gebruikersnaam</label>
            </div>
          </div>

          <div class="d-flex flex-row mb-5">
            <div class="md-form ml-5 mr-3">
                <i id="registerIcon" class="fas fa-birthday-cake prefix niagara"></i>
                <input type="date"  class="form-control white-text" name="birthday" id="birthday" required>
                <label class="font-weight-light white-text" for="birthday"></label>
            </div>

          </div>

          <div class="d-flex flex-row">
            <!-- Material input text -->
            <div class="md-form ml-5 mr-3">
                <i id="registerIcon" class="fas fa-lock prefix niagara"></i>
                <input type="password" class="form-control white-text" name="password" id="password" onchange="confirmation('password', 'password_check')" onkeyup="confirmation('password', 'password_check')" required>
                <div class="form-requirements white-text">
                  <ul>
                    <li>Mag uit maximaal 50 tekens bestaan</li>
                  </ul>
                </div>
                <label class="font-weight-light white-text" for="password">Wachtwoord</label>
            </div>

            <!-- Material input text -->
            <div class="md-form mr-5 ml-3">
                <input type="password" class="form-control white-text" name="password_check" id="password_check" onchange="confirmation('password', 'password_check')" onkeyup="confirmation('password', 'password_check')" required>
                <div class="form-requirements white-text">
                  <ul>
                    <li>Wachtwoord dient overeen te komen</li>
                  </ul>
                </div>
                <label class="font-weight-light white-text" for="password_check">Herhaal wachtwoord</label>
            </div>
          </div>

          <div class="d-flex flex-row mb-5">
            <!-- Material input email -->
            <div class="md-form ml-5 mr-3">
                <i id="registerIcon" class="fa fa-at prefix niagara"></i>
                <input type="email" class="form-control white-text" name="email" id="email" onchange="confirmation('email', 'email_check')" onkeyup="confirmation('email', 'email_check')" required>
                <label class="font-weight-light white-text" for="email">Emailadres</label>
            </div>

            <!-- Material input email -->
            <div class="md-form mr-5 ml-3">
                <input type="email" class="form-control white-text" name="email_check" id="email_check" onchange="confirmation('email', 'email_check')" onkeyup="confirmation('email', 'email_check')" required>
                <div class="form-requirements white-text">
                  <ul>
                    <li>E-Mail dient overeen te komen</li>
                  </ul>
                </div>
                <label class="font-weight-light white-text" for="email_check">Bevestig emailadres</label>
            </div>
          </div>

          <div class="d-flex flex-row">
            <!-- Material input password -->
            <div class="md-form ml-5 mr-5">
                <i id="registerIcon" class="far fa-building prefix niagara"></i>
                <input type="text" class="form-control white-text" name="address1" id="address1" required>
                <div class="form-requirements white-text">
                  <ul>
                    <li>Verplicht veld</li>
                  </ul>
                </div>
                <label class="font-weight-light white-text" for="address1">Adres</label>
            </div>
          </div>

          <div class="d-flex flex-row">
            <div class="md-form ml-5 mr-5">
                <i id="registerIcon" class="far fa-building prefix niagara"></i>
                <input type="text" class="form-control white-text" name="address2" id="address2">
                <div class="form-requirements white-text">
                  <ul>
                    <li>Optioneel veld</li>
                  </ul>
                </div>
                <label class="font-weight-light white-text" for="address2">Adres (optioneel)</label>
            </div>
          </div>

          <div class="d-flex flex-row">

            <!-- Material input text -->
            <div class="md-form ml-5 mr-3 mb-5">
              <i id="registerIcon" class="far fa-building prefix niagara"></i>
                <input type="text" class="form-control white-text" name="city" id="city" required pattern="[A-z]+">
                <label class="font-weight-light white-text" for="city">Stad</label>
            </div>
            <!-- Material input text -->
            <div class="md-form mr-5 ml-3">
                <input type="text" class="form-control white-text" name="zipcode" id="zipcode" onkeydown="upperCaseF(this)" required pattern="[0-9]{4,4}[A-Z]{2,2}">
                <div class="form-requirements white-text">
                  <ul>
                    <li>Moet bestaan uit 4 cijfers</li>
                    <li>Moet eindigen met 2 letters</li>
                  </ul>
                </div>
                <label class="font-weight-light white-text" for="zipcode">Postcode</label>
            </div>


          </div>

          <div class="d-flex flex-row">
            <!-- Material input text -->
            <div class="md-form ml-5 mr-5 mb-3 register-select">
                <select name="country" id="country" class="register-select-form black-text" required>
                  <option class="black-text" value="" class="font-weight-light disabled selected">Kies een land...</option>
                  <!-- <option class="black-text" value='Nederland'>Nederland</option>
                  <option class="black-text" value='Duitsland'>Duitsland</option>
                  <option class="black-text" value='Frankrijk'>Frankrijk</option>
                  <option class="black-text" value='België'>België</option>
                </select> -->
                  <?=$land_options?>
                </select>
            </div>
          </div>

            <!-- Material input text -->
            <div class="d-flex flex-row">
            <div class="md-form ml-5 mr-5 mb-3 register-select">
                <select name="secretQuestion" id="secretQuestion" class="register-select-form black-text" required>
                  <option class="black-text" value="" class="font-weight-light disabled selected">Kies een geheime vraag...</option>
                  <?=$secret_question_options?>
                </select>


            </div>
          </div>



            <!-- Material input password -->

            <!-- Material input text -->
            <div class="d-flex flex-row">
            <div class="md-form ml-5 mr-5">
                <input type="text" class="form-control white-text" name="secretAnswer" id="secretAnswer" required>
                <div class="form-requirements white-text">
                  <ul>
                    <li>Maximaal 25 karakters</li>
                  </ul>
                </div>
                <label class="font-weight-light white-text" for="secretAnswer">Antwoord op de geheime vraag</label>
            </div>
          </div>


            <div class="text-center py-4 mt-4 ml-5 mr-5">
                <button class="btn elegant" type="submit" name="submit">Registreren</button>
            </div>
        </form>
        <!-- Material form register -->


    </div>
    <!-- Card body -->

</div>
<!-- Card -->
</div>
<!-- Card -->

</main>
<!--Main Layout-->
<!-- Material form register -->

<script src="js/functions.js"></script>
<?php include 'templates/footer.php'; ?>
