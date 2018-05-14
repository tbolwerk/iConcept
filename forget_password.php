<?php
$current_page = 'login';
require_once("templates/header.php");
$txt="";
if(isset($_POST['forget_password'])){
$new_password=random_password(8);
    $to = $_POST['forget_password'];

$dbh->query("update Gebruiker set wachtwoord='$new_password' where email = '$to'");


$subject = "Reset Password EenmaalAndermaal";
$txt = "Your new generated password : ".$new_password;
$headers = "From: Admin@EenmaalAndermaal.com";

// mail($to,$subject,$txt,$headers);
// header("Location:login.php");
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
    <!-- forget password text -->
      <div class="login-form-header elegant">
        <h3>Wachtwoord vergeten?</h3>
      </div>
      <div class="green-text" style="text-align: center; font-weight: bold;">
        <?=$txt?>
      </div>

<form method="post" action="" >
  <div class="md-form">
    <i class="fa fa-envelope prefix niagara"></i>
    <input type="email" class="form-control white-text" name="forget_password">
    <label for="forget_password" class="font-weight-light" >Uw email</label>
  </div>
  <div class="text-center py-1 mt-3">
    <button class="btn elegant" type="submit" name="submit">Wachtwoord opvragen</button>
  </div>
</form>
</div>



<!-- Card body -->
</div>
<!-- Card -->
</div>
</main>
<!--Main Layout-->
<?php include("templates/footer.php"); ?>
