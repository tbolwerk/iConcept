<div id="search_overlay" class="search_overlay">
  <form class="search_overlay-form">
    <input class="search_overlay-input" type="search" placeholder="Search..."/>

  </form>
  <div class="search_overlay-content">
    <div class="dummy-column">
      <h2>People</h2>
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
    </div>
    <div class="dummy-column">
      <h2>Popular</h2>
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
    </div>
    <div class="dummy-column">
      <h2>Recent</h2>
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
    </div>
  </div><!-- /morphsearch-content -->
  <span class="search_overlay-close"></span>
</div><!-- /morphsearch -->

<script>
  (function() {
    var overlaySearch = document.getElementById( 'search_overlay' ),
      input = overlaySearch.querySelector( 'input.search_overlay-input' ),
      ctrlClose = overlaySearch.querySelector( 'span.search_overlay-close' ),
      isOpen = isAnimating = false,
      // show/hide search area
      toggleSearch = function(evt) {
        // return if open and the input gets focused
        if( evt.type.toLowerCase() === 'focus' && isOpen ) return false;

        var offsets = overlaySearch.getBoundingClientRect();
        if( isOpen ) {
          classie.remove( overlaySearch, 'open' );

          // trick to hide input text once the search overlay closes
          // todo: hardcoded times, should be done after transition ends
          if( input.value !== '' ) {
            setTimeout(function() {
              classie.add( overlaySearch, 'hideInput' );
              setTimeout(function() {
                classie.remove( overlaySearch, 'hideInput' );
                input.value = '';
              }, 300 );
            }, 500);
          }

          input.blur();
        }
        else {
          classie.add( overlaySearch, 'open' );
        }
        isOpen = !isOpen;
      };

    // events
    input.addEventListener( 'focus', toggleSearch );
    ctrlClose.addEventListener( 'click', toggleSearch );
    // esc key closes search overlay
    // keyboard navigation events
    document.addEventListener( 'keydown', function( ev ) {
      var keyCode = ev.keyCode || ev.which;
      if( keyCode === 27 && isOpen ) {
        toggleSearch(ev);
      }
    } );


    /***** for demo purposes only: don't allow to submit the form *****/
    overlaySearch.querySelector( 'button[type="submit"]' ).addEventListener( 'click', function(ev) { ev.preventDefault(); } );
  })();
</script>
