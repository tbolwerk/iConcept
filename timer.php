<?php require_once("templates/connect.php"); ?>
<?php
$statement = $dbh->prepare("SELECT * FROM Voorwerp where voorwerpnummer = ?");
$statement->execute(array($_GET['voorwerpnummer']));
$timer = $statement->fetch();
$looptijd = $timer['looptijd'];
$looptijdbegindag =strtotime($timer['looptijdbegindag']);
$looptijdbegintijdstip = strtotime($timer['looptijdtijdstip']);
$countdown_date = date("Y-m-d",$looptijdbegindag);
$countdown_time = date("h:i:s",$looptijdbegintijdstip);
$countdown = $countdown_date . " " . $countdown_time;
echo $countdown;
?>
<!-- Display the countdown timer in an element -->
<p id="timer"></p>

<script>
// Set the date we're counting down to
var countDownDate = new Date("<?=$countdown?>").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();

  // Find the distance between now an the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="timer"
  document.getElementById("timer").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("timer").innerHTML = "EXPIRED";
  }
}, 1000);
</script>
