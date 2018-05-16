<li class='nav-item'>
        <a class='nav-link waves-effect waves-light' href='logout.php'>
          <i class='fa fa-sign-out-alt'></i>
        </a>
      </li>
      <li class='nav-item'>
        <a class='nav-link waves-effect waves-light'>
          <i class='fa fa-heart'></i>
        </a>
      </li>
      <li class='nav-item'>
        <a class='nav-link waves-effect waves-light' href='userpage.php'>
          <i class='fa fa-cog'></i>
        </a>
      </li>
      <li class='nav-item avatar'>
        <span class='navbar-text white-text' style='margin-top: 7px;'><?= $_SESSION['username'];?></span>
        <img style='border-radius: 50%; margin-left: 10px;' src='img/avatar/<?=$_SESSION['username']?>.png' height='50' width='50' />
      </li>
