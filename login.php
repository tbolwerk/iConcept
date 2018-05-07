<?php
$current_page='login';
require_once('templates/header.php');

//login SCRIPTS
if(isset($_POST['submit'])){//if submit pressed
  login($_POST['username'], $_POST['password']);//login function
}

?>





<!--Main Layout-->
<main class="py-5 mask rgba-black-light flex-center">
  <div class="bg bg-login"></div>
  <!-- Card -->
  <div class="container col-md-4">
    <div class="card login-register-card">
      <!-- Card body -->
      <div class="card-body">
        <!-- Login header text -->
        <div class="login-form-header elegant">
          <h3>Inloggen</h3>
        </div>
        <!-- Material form login -->
        <form action="" method="post" autocomplete="on">
          <!-- Material input username -->
          <div class="md-form">
            <i class="fa fa-user prefix niagara"></i>
            <input type="text" id="materialFormCardNameEx" class="form-control white-text" name="username">
            <label for="materialFormCardNameEx" class="font-weight-light">Gebruikersnaam</label>
          </div>
          <!-- Material input username -->
          <div class="md-form">
            <i class="fa fa-lock prefix niagara"></i>
            <input type="password" id="materialFormCardPasswordEx" class="form-control white-text" name="password" aria-describedby="passwordHelp">
            <label for="materialFormCardPasswordEx" class="font-weight-light">Wachtwoord</label>
            <small id="passwordHelp" class="form-text text-muted red-text" href="forget_password.php"><a href="forget_password.php">Wachtwoord vergeten?</a></small>
          </div>

          <div class="text-center py-1 mt-3">
            <button class="btn elegant" type="submit" name="submit">Inloggen</button>
          </div>
        </form>
        <!-- Material form login -->


        <?php  if(isset($error)){echo $error;}

          ?>

      </div>

      <!-- Card body -->
    </div>
    <!-- Card -->
  </div>
</main>
<!--Main Layout-->
<?php include 'templates/footer.php'; ?>
