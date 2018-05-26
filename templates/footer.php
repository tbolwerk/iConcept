

<?php if ($current_page == 'login' || $current_page == 'register') {
  // include 'templates/logo_nav.php';
} else {
  include 'templates/footer_links.php';
}?>
<!--/.Footer-->

    <!-- SCRIPTS -->
    <!-- Including jQuery is required. -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <!-- Including our scripting file. -->
    <script type="text/javascript" src="templates/livesearch.js"></script>
    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>
    <!-- JavaScript for the sidemenu on category page -->
    <script type="text/javascript" src="js/jquery.flypanels.min.js"></script>
    <!-- Classie.js -->
    <script type="text/javascript" src="js/classie.js"></script>
    <!-- Rubrieken overlay JavaScript -->
    <script type="text/javascript" src="js/category_overlay.js"></script>
    <script type="text/javascript" src="js/search_overlay.js"></script>
    <!-- JavaScript for the sidebar on the category page to collapse items -->
    <script type="text/javascript" src="js/kitUtils.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.3/fastclick.min.js"></script>
    <script type="text/javascript" src="js/twbs-pagination.js"></script>
    <script type="text/javascript" src="js/paging.js"></script>
    <script type="text/javascript" src="js/timer.js"></script>
    <script>
    $(document).ready(function(){
      $('.flypanels-container').flyPanels({
        treeMenu: {
          init: true
        },
      });
      FastClick.attach(document.body);
    });
    </script>

    <script type="text/javascript">

    $('.carousel').carousel({
      interval: 5000
    })
    $('.carousel[data-type="multi"] .item').each(function() {
    var next = $(this).next();
    if (!next.length) {
      next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));


    if (next.next().length > 0) {
      next.next().children(':first-child').clone().appendTo($(this));
    } else {
      $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
    }
    });
    </script>

    <script type="text/javascript">
      $(document).ready(function() {
      appendMobileNav();
      appendMobileFooter();
      });

      $(window).resize(function() {
      appendMobileNav();
      appendMobileFooter();
      });

      const appendMobileNav = () => {
      if ($(window).width() < 991) {
        $('#navbar-brand').addClass('ml-auto');
        $('#navbar-brand').addClass('mr-auto');
      }
      else {
        $('#navbar-brand').removeClass('ml-auto');
        $('#navbar-brand').removeClass('mr-auto');
      }
      };

      const appendMobileFooter = () => {
      if ($(window).width() < 991) {
        $('#mobileFooter').addClass('mr-auto');
      }
      else {
        $('#mobileFooter').removeClass('mr-auto');
      }
      };
      </script>

      <script type="text/javascript" src="js/mdb.min.js">
        // SideNav Button Initialization
        $(".button-collapse").sideNav();
        // SideNav Scrollbar Initialization
        var sideNavScrollbar = document.querySelector('.custom-scrollbar');
        Ps.initialize(sideNavScrollbar);
        // SideNav Options
        $('.button-collapse').sideNav({
        edge: 'right', // Choose the horizontal origin
        closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
        });
      </script>




</body>

</html>
