

<?php if ($current_page == 'login' || $current_page == 'register' || $current_page == 'adminpanel') {
  // do nothing actually
} else {
  include 'templates/footer_links.php';
}?>
<!--/.Footer-->

    <!-- SCRIPTS -->
    <!-- Including jQuery is required. -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <!-- Including our scripting file. -->
    <script type="text/javascript" src="templates/livesearch/livesearch.js"></script>
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
    <!-- JS Toastr for alerts CDN -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- Script for the sidenav on category page -->
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

    <!-- Script for the carousel on the mainpage -->
    <script type="text/javascript">
    // The time before the carousel slides to the other 4 items
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

    <!-- Toasrt JS script for notifications -->
    <script>
    // https://github.com/CodeSeven/toastr
    var message = '<?php echo $message; ?>';

    $(document).ready(function() {
        // Shows an alert based on a certain message that belongs to the action being executed
        if (message.indexOf("Account") >= 0 && message.indexOf("gedeblokkeerd") >= 0) {
          toastr["success"](message)
        } else if (message.indexOf("Account") >= 0 && message.indexOf("geblokkeerd") >= 0) {
          toastr["error"](message)
        } else if (message.indexOf("Veiling") >= 0 && message.indexOf("geblokkeerd") >= 0) {
          toastr["error"] (message)
        } else if (message.indexOf("Veiling") >= 0 && message.indexOf("gedeblokkeerd") >= 0) {
          toastr["success"] (message)
        } else if (message.indexOf("geen bestand") >= 0) {
          toastr["error"] (message)
        } else if (message.indexOf("profielfoto") >= 0 && message.indexOf("succesvol") >= 0) {
          toastr["success"] (message)
        } else if (message.indexOf("Persoonlijke informatie") >= 0 && message.indexOf("succesvol") >= 0) {
          toastr["success"] (message)
        } else if (message.indexOf("iets mis") >= 0 && message.indexOf("persoonlijke informatie") >= 0) {
          toastr["error"] (message)
        } else if (message.indexOf("wachtwoord") >= 0 && message.indexOf("succesvol") >= 0) {
          toastr["success"] (message)
        } else if (message.indexOf("wachtwoord") >= 0 && message.indexOf("onjuist") >= 0) {
          toastr["error"] (message)
        } else if (message.indexOf("nieuwe wachtwoord") >= 0 && message.indexOf("verzonden") >= 0) {
          toastr["info"] (message)
        } else if (message.indexOf("Iets fout gegaan") >= 0 && message.indexOf("nieuw wachtwoord") >= 0) {
          toastr["error"] (message)
        } else if (message.indexOf("Account") >= 0 && message.indexOf("succesvol aangemaakt") >= 0) {
          toastr["error"] (message)
        } else if (message.indexOf("Volgende") >= 0 && message.indexOf("foutmeldingen") >= 0) {
          toastr["error"] (message)
        } else if (message.indexOf("Logingegevens") >= 0 && message.indexOf("onjuist") >= 0) {
          toastr["error"] (message)
        }

      });
      // The options for the toastr alerts
      toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "8000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "body-output-type": "trustedHtml"
      }

    </script>

    <script type="text/javascript">
    // Tooltips Initialization
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
    </script>

    <script type="text/javascript">
    // Align logo to the center of the navbar when using mobile devices or anything smaller than 991px
      $(document).ready(function() {
      appendMobileNav();
      appendMobileFooter();
      });

      $(window).resize(function() {
      appendMobileNav();
      appendMobileFooter();
      });

      // Removes classes and adds classes depending on the width of the screen
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

      <!-- This script is under development for the mobile version  -->
      <!-- <script>
        function w3_open() {
            document.getElementById("mySidebar").style.display = "block";
            document.getElementById("myOverlay").style.display = "block";
        }
        function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
            document.getElementById("myOverlay").style.display = "none";
        }
    </script> -->


    <script type="text/javascript">
    //https://stackoverflow.com/questions/18999501/bootstrap-3-keep-selected-tab-on-page-refresh
    // This script prevents the tabs to return to 1 after a page refresh
    $('#adminTabs a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
        });

        // store the currently selected tab in the hash value
        $("ul.admin-list > li > a").on("shown.bs.tab", function(e) {
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
        });

        // on load of the page: switch to the currently selected tab
        var hash = window.location.hash;
        $('#adminTabs a[href="' + hash + '"]').tab('show');
    </script>

</body>

</html>
