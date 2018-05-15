

<html>



<head>

   <title>Live Search using AJAX</title>

   <!-- Including jQuery is required. -->

   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

   <!-- Including our scripting file. -->

   <script type="text/javascript" src="livesearch.js"></script>

   <!-- Including CSS file. -->

   <link rel="stylesheet" type="text/css" href="style.css">



</head>



<body>



  <div class="nav-search" style="flex:1">

    <div id="search_overlay" class="search_overlay" style="flex:1;">
      <form class="search_overlay-form">
        <input class="search_overlay-input niagara" id="search" type="search" placeholder="Zoeken..."/>
        <button class="search_overlay-submit" type="submit">Search</button>
      </form>
      <div class="search_overlay-content">
        <div class="dummy-column" style="">
          <h2>Rubrieken</h2>
          <div class="search-scroll">
<div id="display"></div>
        </div>
      </div>

      <div class="dummy-column">
          <h2>Sub-rubrieken</h2>
          <div class="search-scroll">

        </div>
      </div>
      <div class="dummy-column">
          <h2>Veilingen</h2>
          <div class="search-scroll">

        </div>
      </div>

      </div><!-- /morphsearch-content -->
      <span class="search_overlay-close"></span>
    </div><!-- /morphsearch -->
    <div class="overlay"></div>

  </div>













<!-- Search box. -->

   <input type="text" id="search" placeholder="Search" />

   <br>

   <b>Ex: </b><i>David, Ricky, Ronaldo, Messi, Watson, Robot</i>

   <br />

   <!-- Suggestions will be displayed in below div. -->

   <div id="display"></div>



</body>



</html>
