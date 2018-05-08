<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-dark">

    <!-- Navbar brand -->
    <a class="navbar-brand" href="index.php">
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
          <!-- <form class="my-2 my-lg-0 ml-auto">
            <input class="form-control mr-sm-2" type="text" placeholder="Zoeken" aria-label="Zoeken">
          </form> -->
          <div id="search_overlay" class="search_overlay" style="flex:1;">
    				<form class="search_overlay-form">
    					<input class="search_overlay-input niagara" type="search" placeholder="Zoeken..."/>
    					<button class="search_overlay-submit" type="submit">Search</button>
    				</form>
    				<div class="search_overlay-content">
    					<div class="dummy-column" style="">
    						<h2>Rubrieken</h2>
    						<div class="search-scroll">
    						<a class="dummy-media-object" href="http://twitter.com/SaraSoueidan">
    							<img class="round" src="http://0.gravatar.com/avatar/81b58502541f9445253f30497e53c280?s=50&d=identicon&r=G" alt="Sara Soueidan"/>
    							<h3>Sara Soueidan</h3>
    						</a>
    						<a class="dummy-media-object" href="http://twitter.com/rachsmithtweets">
    							<img class="round" src="http://0.gravatar.com/avatar/48959f453dffdb6236f4b33eb8e9f4b7?s=50&d=identicon&r=G" alt="Rachel Smith"/>
    							<h3>Rachel Smith</h3>
    						</a>
    						<a class="dummy-media-object" href="http://www.twitter.com/peterfinlan">
    							<img class="round" src="http://0.gravatar.com/avatar/06458359cb9e370d7c15bf6329e5facb?s=50&d=identicon&r=G" alt="Peter Finlan"/>
    							<h3>Peter Finlan</h3>
    						</a>
    						<a class="dummy-media-object" href="http://www.twitter.com/pcridesagain">
    							<img class="round" src="http://1.gravatar.com/avatar/db7700c89ae12f7d98827642b30c879f?s=50&d=identicon&r=G" alt="Patrick Cox"/>
    							<h3>Patrick Cox</h3>
    						</a>
    						<a class="dummy-media-object" href="https://twitter.com/twholman">
    							<img class="round" src="http://0.gravatar.com/avatar/cb947f0ebdde8d0f973741b366a51ed6?s=50&d=identicon&r=G" alt="Tim Holman"/>
    							<h3>Tim Holman</h3>
    						</a>
    						<a class="dummy-media-object" href="https://twitter.com/shaund0na">
    							<img class="round" src="http://1.gravatar.com/avatar/9bc7250110c667cd35c0826059b81b75?s=50&d=identicon&r=G" alt="Shaun Dona"/>
    							<h3>Shaun Dona</h3>
    						</a>
    						<a class="dummy-media-object" href="https://twitter.com/shaund0na">
    							<img class="round" src="http://1.gravatar.com/avatar/9bc7250110c667cd35c0826059b81b75?s=50&d=identicon&r=G" alt="Shaun Dona"/>
    							<h3>Shaun Dona</h3>
    						</a>
    						<a class="dummy-media-object" href="https://twitter.com/shaund0na">
    							<img class="round" src="http://1.gravatar.com/avatar/9bc7250110c667cd35c0826059b81b75?s=50&d=identicon&r=G" alt="Shaun Dona"/>
    							<h3>Shaun Dona</h3>
    						</a>
    						<a class="dummy-media-object" href="https://twitter.com/shaund0na">
    							<img class="round" src="http://1.gravatar.com/avatar/9bc7250110c667cd35c0826059b81b75?s=50&d=identicon&r=G" alt="Shaun Dona"/>
    							<h3>Shaun Dona</h3>
    						</a>
    						<a class="dummy-media-object" href="https://twitter.com/shaund0na">
    							<img class="round" src="http://1.gravatar.com/avatar/9bc7250110c667cd35c0826059b81b75?s=50&d=identicon&r=G" alt="Shaun Dona"/>
    							<h3>Shaun Dona</h3>
    						</a>
    					</div>
    				</div>

    				<div class="dummy-column">
    						<h2>Sub-rubrieken</h2>
    						<div class="search-scroll">
    						<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/08/05/page-preloading-effect/">
    							<img src="img/thumbs/PagePreloadingEffect.png" alt="PagePreloadingEffect"/>
    							<h3>Page Preloading Effect</h3>
    						</a>
    						<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/05/28/arrow-navigation-styles/">
    							<img src="img/thumbs/ArrowNavigationStyles.png" alt="ArrowNavigationStyles"/>
    							<h3>Arrow Navigation Styles</h3>
    						</a>
    						<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/06/19/ideas-for-subtle-hover-effects/">
    							<img src="img/thumbs/HoverEffectsIdeasNew.png" alt="HoverEffectsIdeasNew"/>
    							<h3>Ideas for Subtle Hover Effects</h3>
    						</a>
    						<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/07/14/freebie-halcyon-days-one-page-website-template/">
    							<img src="img/thumbs/FreebieHalcyonDays.png" alt="FreebieHalcyonDays"/>
    							<h3>Halcyon Days Template</h3>
    						</a>
    						<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/05/22/inspiration-for-article-intro-effects/">
    							<img src="img/thumbs/ArticleIntroEffects.png" alt="ArticleIntroEffects"/>
    							<h3>Inspiration for Article Intro Effects</h3>
    						</a>
    						<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/06/26/draggable-dual-view-slideshow/">
    							<img src="img/thumbs/DraggableDualViewSlideshow.png" alt="DraggableDualViewSlideshow"/>
    							<h3>Draggable Dual-View Slideshow</h3>
    						</a>
    						<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/06/26/draggable-dual-view-slideshow/">
    							<img src="img/thumbs/DraggableDualViewSlideshow.png" alt="DraggableDualViewSlideshow"/>
    							<h3>Draggable Dual-View Slideshow</h3>
    						</a>
    						<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/06/26/draggable-dual-view-slideshow/">
    							<img src="img/thumbs/DraggableDualViewSlideshow.png" alt="DraggableDualViewSlideshow"/>
    							<h3>Draggable Dual-View Slideshow</h3>
    						</a>
    						<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/06/26/draggable-dual-view-slideshow/">
    							<img src="img/thumbs/DraggableDualViewSlideshow.png" alt="DraggableDualViewSlideshow"/>
    							<h3>Draggable Dual-View Slideshow</h3>
    						</a>
    					</div>
    				</div>
    				<div class="dummy-column">
    						<h2>Veilingen</h2>
    						<div class="search-scroll">
    						<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/10/07/tooltip-styles-inspiration/">
    							<img src="img/thumbs/TooltipStylesInspiration.png" alt="TooltipStylesInspiration"/>
    							<h3>Tooltip Styles Inspiration</h3>
    						</a>
    						<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/09/23/animated-background-headers/">
    							<img src="img/thumbs/AnimatedHeaderBackgrounds.png" alt="AnimatedHeaderBackgrounds"/>
    							<h3>Animated Background Headers</h3>
    						</a>
    						<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/09/16/off-canvas-menu-effects/">
    							<img src="img/thumbs/OffCanvas.png" alt="OffCanvas"/>
    							<h3>Off-Canvas Menu Effects</h3>
    						</a>
    						<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/09/02/tab-styles-inspiration/">
    							<img src="img/thumbs/TabStyles.png" alt="TabStyles"/>
    							<h3>Tab Styles Inspiration</h3>
    						</a>
    						<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/08/19/making-svgs-responsive-with-css/">
    							<img src="img/thumbs/ResponsiveSVGs.png" alt="ResponsiveSVGs"/>
    							<h3>Make SVGs Responsive with CSS</h3>
    						</a>
    						<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/07/23/notification-styles-inspiration/">
    							<img src="img/thumbs/NotificationStyles.png" alt="NotificationStyles"/>
    							<h3>Notification Styles Inspiration</h3>
    						</a>
    						<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/07/23/notification-styles-inspiration/">
    							<img src="img/thumbs/NotificationStyles.png" alt="NotificationStyles"/>
    							<h3>Notification Styles Inspiration</h3>
    						</a>
    						<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/07/23/notification-styles-inspiration/">
    							<img src="img/thumbs/NotificationStyles.png" alt="NotificationStyles"/>
    							<h3>Notification Styles Inspiration</h3>
    						</a>
    						<a class="dummy-media-object" href="http://tympanus.net/codrops/2014/07/23/notification-styles-inspiration/">
    							<img src="img/thumbs/NotificationStyles.png" alt="NotificationStyles"/>
    							<h3>Notification Styles Inspiration</h3>
    						</a>
    					</div>
    				</div>

    				</div><!-- /morphsearch-content -->
    				<span class="search_overlay-close"></span>
    			</div><!-- /morphsearch -->
    			<div class="overlay"></div>

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
                    <img style='border-radius: 50%; margin-left: 10px;' src='img/avatar/" .$_SESSION['username']. ".png' height='50' />
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
