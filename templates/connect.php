<?php

 $hostname = "77.174.95.152";
 $dbname = "testDB";
 $uid = "iConcept";
 $pw ="Welkom01!";

$dbh = new PDO("sqlsrv:Server=$hostname;Database=$dbname;
			ConnectionPooling=0", "$uid", "$pw");

try {
    $dbh = new PDO("sqlsrv:Server=$hostname;Database=$dbname;
			ConnectionPooling=0", "$uid", "$pw");

    $dbh->setAttribute(PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    echo "Er ging iets mis met de database.<br>";
    echo "De melding is {$e->getMessage()}<br><br>";
}



?>
