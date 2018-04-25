<nav class="navbar fixed-top navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="index.php">
<img src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">
EenmaalAndermaal
</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-autonav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Rubrieken <!--<span class="sr-only">(current)</span>--></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#!">Over ons</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#!">FAQ</a>
            </li>
        </ul>
        <ul class="navbar-nav nav-flex-icons ml-auto mr-autonav">
<?php
if(!isset($_SESSION['username'])){
?>

          <li class="nav-item active">
              <a class="nav-link" href="login.php">Login</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="register.php">Register</a>
          </li>
<?php
}else{
?>
          <li class="nav-item active">
              <a class="nav-link" href="userpage.php?user=<?=$_SESSION['username']?>"><?=$_SESSION['username']?></a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
          </li>
<?php
}
?>
        </ul>

    </div>
</nav>
