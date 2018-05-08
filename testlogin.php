<?php require_once 'templates/header.php'; ?>
<div class="login-logo">
    <a href="#">
        <img src="img/logo/logo.png">
        </a>
    </div>

<main class="py-5 mask rgba-black-light flex-center">
  <div class="bg bg-login blur"></div>
<!-- Card -->
<div class="container col-md-6">


                      <!--Form with header-->
                      <div class="card" style="background: #4444443b;">
                          <div class="card-body">

                              <!--Header-->
                              <div class="login-form-header elegant">
                                  <h3>
                                      <i class="fa fa-user"></i> Registreren:</h3>
                              </div>

                              <!--Body-->
                              <!-- Material input text -->
  <div class="form-row">
    <div class="md-form col-md-6">
        <i class="fa fa-user prefix grey-text"></i>
        <input type="text" id="voornaam" class="form-control">
        <label for="materialFormRegisterNameEx">Voornaam</label>
    </div>
    <div class="md-form col-md-6">
        <i class="fa fa-user prefix grey-text"></i>
        <input type="text" id="achternaam" class="form-control">
        <label for="materialFormRegisterNameEx">Achternaam</label>
    </div>
  </div>
    <div class="md-form">
        <i class="fa fa-user prefix grey-text"></i>
        <input type="text" id="materialFormRegisterNameEx" class="form-control">
        <label for="materialFormRegisterNameEx">Gebruikersnaam</label>
    </div>


    <!-- Material input email -->
    <div class="md-form">
        <i class="fa fa-envelope prefix grey-text"></i>
        <input type="email" id="materialFormRegisterEmailEx" class="form-control">
        <label for="materialFormRegisterEmailEx">E-mail</label>
    </div>

    <!-- Material input email -->
    <div class="md-form">
        <i class="fa fa-exclamation-triangle prefix grey-text"></i>
        <input type="email" id="materialFormRegisterConfirmEx" class="form-control">
        <label for="materialFormRegisterConfirmEx">Herhaal e-mail</label>
    </div>

    <!-- Material input password -->
    <div class="md-form">
        <i class="fa fa-lock prefix grey-text"></i>
        <input type="password" id="materialFormRegisterPasswordEx" class="form-control">
        <label for="materialFormRegisterPasswordEx">Wachtwoord</label>
    </div>
    <div class="md-form">
        <i class="fa fa-lock prefix grey-text"></i>
        <input type="password" id="materialFormRegisterPasswordEx" class="form-control">
        <label for="materialFormRegisterPasswordEx">Wachtwoord</label>
    </div>
    <div class="md-form">
        <i class="fa fa-lock prefix grey-text"></i>
        <input type="password" id="materialFormRegisterPasswordEx" class="form-control">
        <label for="materialFormRegisterPasswordEx">Wachtwoord</label>
    </div>
    <div class="md-form">
        <i class="fa fa-lock prefix grey-text"></i>
        <input type="password" id="materialFormRegisterPasswordEx" class="form-control">
        <label for="materialFormRegisterPasswordEx">Wachtwoord</label>
    </div>

                              <div class="text-center">
                                  <button class="btn btn-elegant waves-effect waves-light">Sign up</button>
                              </div>

                          </div>
                      </div>
                      <!--/Form with header-->


<!-- Card -->
</div>
</main>
<!--Main Layout-->
<?php include 'templates/footer.php'; ?>
