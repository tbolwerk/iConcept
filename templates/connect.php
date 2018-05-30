<?php

 $hostname = "mssql2.iproject.icasites.nl";
 $dbname = "iproject40";
 $uid = "iproject40";
 $pw ="y7wYe9q6JP";

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
