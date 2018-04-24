<?php
$current_page = 'login';
require_once("templates/header.php");
$txt="";
if(isset($_POST['forget_password'])){
$new_password=random_password(8);
    $to = $_POST['forget_password'];

$dbh->query("update Gebruiker set password='$new_password' where email = '$to'");


$subject = "Reset Password EenmaalAndermaal";
$txt = "Your new generated password : ".$new_password;
$headers = "From: Admin@EenmaalAndermaal.com";

mail($to,$subject,$txt,$headers);
header("Location:login.php");
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

<form method="post" action="" >
    <label for="forget_password">Send E-mail with new Generated password</label>
    <input type="email" name="forget_password">
    <?=$txt?>
</form>
</div>

</div>

<!-- Card body -->
</div>
<!-- Card -->
</div>
</main>
<!--Main Layout-->
<?php include("templates/footer.php"); ?>
