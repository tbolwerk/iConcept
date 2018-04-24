<?php
/*
   $target = mktime(0, 0, 0, 9, 25, 2011) ;//set date

   $today = time () ;

   $difference =($target-$today) ;

   $month =date('m',$difference) ;
   $days =date('d',$difference) ;
   $hours =date('h',$difference) ;
   $minutes =date ( 'i', $difference) ;
   $secondes =date ( 's', $difference) ;

   print $month." month".$days." days".$hours." hours".$minutes." minutes".$secondes." secondes left";
*/
$auctionTime = mktime(0, 4, 0);
$startTime = DATE('Y-m-d H:i:s');
$endTime = $startTime + $auctionTime;

$rightNow = time();

$difference =($startTime - $rightNow);

$month = date('m', $difference);
$days = date('d', $difference);
$hours = date('h', $difference);
$minutes = date('i', $difference);
$secondes = date('s', $difference);

print $month." maanden ".$days." dagen ".$hours." uren ".$minutes." minuten ".$secondes." seconden over tot de veiling sluit.";

?>
