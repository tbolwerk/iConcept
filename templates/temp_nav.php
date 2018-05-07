<?php if(isset($_GET['zoeken'])){search(Voorwerp,titel,$_GET['zoeken']);}?>

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
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Rubrieken
                    <span class="sr-only">(current)</span>
                </a>
            </li>
            <div class="nav-search">
            <form method="get" action="" class="form-inline my-2 my-lg-0 ml-auto">
              <input class="form-control mr-sm-2" type="text" placeholder="Zoeken" aria-label="Zoeken">
            </form>
          </div>
        </ul>
        <!-- Links -->


        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Registreren</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Inloggen</a>
            </li>
        </ul>

    </div>
    <!-- Collapsible content -->

</nav>
<!--/.Navbar-->
