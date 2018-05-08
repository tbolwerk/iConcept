<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-dark">

    <!-- Navbar brand -->
    <a class="navbar-brand" href="#">
      <img src="img/logo/logo.png" height="50" alt="EenmaalAndermaal" />
    </a>

    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="basicExampleNav">

        <!-- Links -->
        <div>
          <ul class="navbar-nav">
            <li class="nav-item">
              <span onclick="openNav()">
              <a class="nav-link" href="#">Rubrieken
                <span class="sr-only">(current)</span>
              </a>
            </span>
            </li>
          </ul>
        </div>
        <div class="nav-search" style="flex:1">
          <form class="my-2 my-lg-0 ml-auto">
            <input class="form-control mr-sm-2" type="text" placeholder="Zoeken" aria-label="Zoeken">
          </form>
        </div>

        <div class="vl d-none d-md-block"></div>


        <!-- Links -->

        <ul class="navbar-nav ml-auto nav-flex-icons">
          <?php
          if (isset($_SESSION['username'])) {
            echo "<li class='nav-item'>
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
                    <span class='navbar-text white-text' style='margin-top: 7px;'>" . $_SESSION['username'] . "</span>
                    <img style='margin-left: 10px;' src='img/avatar/" .$_SESSION['username']. ".png' height='50' />
                  </li>";
          } else {
            include 'templates/not_logged_in.php';
          }
           ?>
        </ul>



    </div>
    <!-- Collapsible content -->

</nav>
<!--/.Navbar-->



<!-- Rubrieken overlay -->
<div id="myNav" class="overlay_rubrieken">

  <!-- Button to close the overlay navigation -->
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

  <!-- Overlay content -->
  <div class="overlay-content">
        <a href="index.php">Auto's, boten en motoren</a>
        <a href="login.php">Baby</a>
        <a href="navtest.php">Muziek- en instrumenten</a>
  </div>
</div>
