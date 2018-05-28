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
        <div class="red-text" style="text-align: center;font-weight: bold;">
        <?php
        if(isset($error)) {
          foreach ($error as $errortext) {
            echo $errortext;
          }
        }
        ?>
      </div>
        <!-- Material form login -->
        <form action="" method="post" autocomplete="on">
          <!-- Material input username -->
          <div class="md-form">
            <i class="fa fa-user prefix niagara"></i>
            <input type="text" id="username" class="form-control white-text" name="username" autofocus required>
            <label for="username" class="font-weight-light">Gebruikersnaam</label>
          </div>
          <!-- Material input username -->
          <div class="md-form">

            <i class="fa fa-lock prefix niagara"></i>
            <input type="password" id="password" class="form-control white-text" name="password" aria-describedby="passwordHelp" required>
            <label for="password" class="font-weight-light">Wachtwoord</label>

            <div class="form-row ml-auto mr-auto">
          <div class="text-center py-1 mt-3">
            <a href="forget_password.php" class="btn elegant">Wachtwoord vergeten</a>
          </div>
          <div class="text-center py-1 mt-3">
            <button class="btn elegant" type="submit" name="submit">Inloggen</button>
          </div>
        </div>
        </form>
        <!-- Material form login -->


        <!-- <?php  if(isset($error)){echo $error;}

          ?> -->

      </div>

      <!-- Card body -->
    </div>
    <!-- Card -->
  </div>
</main>
<!--Main Layout-->
<?php include 'templates/footer.php'; ?>
