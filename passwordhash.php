<?php
if (isset($_GET['submit'])) {
  $hash = password_hash($_GET['password'], PASSWORD_DEFAULT);
  echo $hash;
}
?>

<form action="" method="get">
  <input type="text" name="password" placeholder="password">

  <button type="submit" name="submit">Test</button>
</form>
