<?php
$current_page = 'login';
require_once("templates/header.php");

$txt="";
$secret_question_options = null;
try {

    $data = $dbh->query("select * from Vraag");

    while($question = $data->fetch()){
        $secret_question_options .= "<option value='{$question['vraagnummer']}'>{$question['vraag']}</option>";
      }

} catch (PDOException $e) {
    $error = $e;
}



if(isset($_POST['submit'])){
// print_r($secret_question_options);
if(empty($_POST['forget_password']) || empty($_POST['secretAnswer'])){
  $message = "Niet alle velden zijn ingevuld";
  $message.=$_POST['forget_password'].$_POST['secretAnswer'].$_POST['secretQuestion'];
}else{
$password = str_replace("\"", "", strip_tags($_POST['forget_password']));
$secretAnswer = str_replace("\"", "", strip_tags($_POST['secretAnswer']));
$secretQuestion = str_replace("\"", "", strip_tags($_POST['secretQuestion']));

  $user_check = $dbh->prepare("SELECT * FROM Gebruiker WHERE email = ? AND antwoordtekst=? AND vraagnummer=?");
  $user_check->execute(array($password,$secretAnswer,$secretQuestion));




if($statement = $user_check->fetch()){

$new_password=random_password(8);
    $to = $_POST['forget_password'];
try{
$update_password= $dbh->prepare("UPDATE Gebruiker SET wachtwoord=? WHERE email=?");
$hash=password_hash($new_password, PASSWORD_DEFAULT);
$update_password->execute(array($hash,$to));
}catch(PDOException $e){
  echo $e;
}

$subject = "Wachtwoord herstellen voor EenmaalAndermaal";
$txt = "Uw nieuwe wachtwoord is: ".$new_password;
$headers = "From: Admin@EenmaalAndermaal.com";

// mail($to,$subject,$txt,$headers);
  $message = "Het nieuwe wachtwoord is verzonden naar ".$to;
  $URL="login.php?redirect=".$message;
echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';

}else{
  $message = "Email of vraag en antwoord incorrect";
  $message.=$_POST['forget_password'].$_POST['secretAnswer'].$_POST['secretQuestion'];
  $message = "Er is iets fout gegaan tijdens het aanvragen van een nieuw wachtwoord. Probeer het opnieuw.";
}
}
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
        <!-- <?=$txt?> -->
      </div>
      <div class="red-text" style="text-align: center; font-weight: bold;">

      </div>



<form method="post" action="" >
  <div class="md-form">

    <i class="fa fa-at prefix niagara"></i>
    <input type="email" class="form-control white-text" name="forget_password">
    <label for="forget_password" class="font-weight-light" >Uw email</label>
  </div>

    <div class="md-form">
        <select name="secretQuestion" class="form-control black-text">
          <option value="kies" class="font-weight-light black-text disabled selected">Kies een geheime vraag...</option>
          <?=$secret_question_options?>
        </select>
    </div>
      <div class="md-form">
        <i class="fa fa-lock prefix niagara"></i>
        <input type="text" class="form-control white-text" name="secretAnswer" id="secretAnswer">
        <label for="secretAnswer" class"font-weight-light">Antwoord</label>
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
