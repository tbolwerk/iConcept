<div class="sidenav col-3">
  <!-- The website's logo -->
  <div class="admin-logo">
    <a class='nav-link waves-effect waves-light' href='index.php'>
    <img src="img/logo/logo.png" class="mt-5" height="70">
  </a>
  </div>
  <!-- The navigation for the different pages -->
  <div class="admin-list row">
    <ul class="nav admin-list md-pills pills-primary flex-column" role="tablist" id="adminTabs">
      <!-- This page displays all the users that are registered on the website and the option to block/unblock them -->
      <li class="nav-item">
        <a class="nav-link admin-list-item active" data-toggle="tab" href="#panel1" role="tab">
          <i class="ml-4 mr-5 fas fa-2x white-text fa-users" aria-hidden="true"></i> Gebruikers</a>
      </li>
      <!-- This page displays all the auctions that were blocked through the website with the option to unblock them -->
      <li class="nav-item">
        <a class="nav-link admin-list-item" data-toggle="tab" href="#panel2" role="tab">
          <i class="ml-4 mr-5 fa fa-2x white-text fa-gavel" aria-hidden="true"></i> Veilingen</a>
      </li>
      <!-- This page displays all the registered users that need to receive their activation code through post -->
      <li class="nav-item">
        <a class="nav-link admin-list-item" data-toggle="tab" href="#panel3" role="tab">
          <i class="ml-4 mr-5 fas fa-2x white-text fa-envelope-open" aria-hidden="true"></i> Verificatielijst</a>
      </li>
    </ul>
  </div>
  <!-- Information about the logged in Administrator -->
  <div class="admin-info">
    <div class="admin-user avatar">
      <img class='mr-2' style='border-radius: 50%;' src='img/avatar/<?=$_SESSION['username']?>.png' height='40' width='40' />
        <span class='navbar-text white-text' style='margin-top: 7px;'><?= $_SESSION['username'];?></span>
    </div>
    <!-- The logout button for the administrator -->
    <div class="admin-logout">
      <a href="logout.php"><i class="fas fa-2x fa-sign-out-alt mr-2 white-text" aria-hidden="true"></i><span class="white-text"> Uitloggen</span></a>
    </div>
  </div>
</div>
