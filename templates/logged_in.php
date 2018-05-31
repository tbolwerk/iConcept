<li class='nav-item'>
        <a class='nav-link waves-effect waves-light' href='logout.php'>
          <i class='fa fa-sign-out-alt'></i>
        </li>
        </a>
        <li class='nav-item'>
          <a class='nav-link waves-effect waves-light' href="admin_panel.php">
            <i class="fa fa-users" aria-hidden="true"></i>
          </a>
      </li>
      <?php if($_SESSION['seller'] == 1){?>
      <li class='nav-item'>
        <a class='nav-link waves-effect waves-light' href='new_auction.php'>
          <i class='fa fa-edit'></i>
        </a>
      </li>
    <?php }else{ ?>
      <li class='nav-item'>
        <a class='nav-link waves-effect waves-light' href='new_auction.php'>
          <i class='fa fa-heart'></i>
        </a>
      </li>
    <?php }?>
      <li class='nav-item'>
        <a class='nav-link waves-effect waves-light' href='userpage.php'>
          <i class='fa fa-cog'></i>
        </a>
      </li>
      <li class='nav-item avatar'>
        <span class='navbar-text white-text' style='margin-top: 7px;'><?= $_SESSION['username'];?></span>
        <img style='border-radius: 50%; margin-left: 10px;' src='img/avatar/<?=$_SESSION['username']?>.png' height='50' width='50' />
      </li>
