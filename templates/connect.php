<?php

 $hostname = "ip";
 $dbname = "";
 $uid = "";
 $pw ="";

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
