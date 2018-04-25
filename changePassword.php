<?php
$current_page= 'account';
require_once('templates/header.php');


if(isset($_POST['password_change_button'])){
changePassword($_POST['password']);
}
 ?>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<form method="post" action="">

  <input type='password' name='password' placeholder="password">
  <button name='password_change_button' id='password_change'>Change Password</button>

</form>
<?php if(isset($error)){echo $error;} ?>
<?php
include('templates/footer.php');
?>
