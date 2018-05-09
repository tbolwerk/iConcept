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
