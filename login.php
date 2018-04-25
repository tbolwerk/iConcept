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
  <div class="bg"></div>
<!-- Card -->
<div class="container col-md-4">
<div class="card">
    <!-- Card body -->
    <div class="card-body">

        <!-- Material form login -->
        <form action="" method="post" autocomplete="on">
            <p class="h4 text-center py-4">Sign in</p>




            <!-- Material input username -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" id="materialFormCardNameEx" class="form-control" name="username">
                <label for="materialFormCardNameEx" class="font-weight-light">Gebruikersnaam</label>
            </div>



            <!-- Material input username -->
            <div class="md-form">
                <i class="fa fa-lock prefix grey-text"></i>
                <input type="password" id="materialFormCardPasswordEx" class="form-control" name="password">
                <label for="materialFormCardPasswordEx" class="font-weight-light">Wachtwoord</label>
            </div>

            <div class="text-center py-4 mt-3">
                <button class="btn btn-cyan" type="submit" name="submit">login</button>
            </div>
        </form>
        <!-- Material form login -->


        <?php  if(isset($error)){echo $error;}

          ?>
              <a class="red-text" href="forget_password.php">Forgot password?</a>
    </div>

    <!-- Card body -->
</div>
<!-- Card -->
</div>
</main>
<!--Main Layout-->
<?php include 'templates/footer.php'; ?>
