

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
    <!-- Classie.js -->
    <script type="text/javascript" src="js/classie.js"></script>
    <!-- Rubrieken overlay JavaScript -->
    <script type="text/javascript" src="js/category_overlay.js"></script>
    <script type="text/javascript" src="js/search_overlay.js"></script>

    <script type="text/javascript">

    $('.carousel[data-type="multi"] .item').each(function() {
	var next = $(this).next();
	if (!next.length) {
		next = $(this).siblings(':first');
	}
	next.children(':first-child').clone().appendTo($(this));


  if (next.next().length>0) {
  next.next().children(':first-child').clone().appendTo($(this));
}
else {
  $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
}
});
    </script>

    <script>
     var teller = 0;
     var x = [];
         x[teller] = setInterval(function() {
         for(i = 0;i<countDownDate.length;i++) {
           teller = i;
         var now = new Date().getTime();
         var distance = countDownDate[i] - now;
         console.log(i);
         var days = Math.floor(distance / (1000 * 60 * 60 * 24));
         var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
         var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
         var seconds = Math.floor((distance % (1000 * 60)) / 1000);
         document.getElementById("timer"+i).innerHTML = "Nog: "+ days + "d " + hours + "h "
         + minutes + "m " + seconds + "s ";
         if (distance < 0) {
           clearInterval(x[i]);
           document.getElementById("timer"+i).innerHTML = "EXPIRED";
         }
        }
       },1000);



     </script>


</body>

</html>
