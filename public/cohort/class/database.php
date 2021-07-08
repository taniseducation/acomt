<?php
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$servernaam = "localhost";
$gebruikersnaam = "username";
$wachtwoord = "password";
$database = "cohorten";
//$database = "cohortTESTdb";
$DBverbinding = mysqli_connect($servernaam, $gebruikersnaam, $wachtwoord, $database);

if (!$DBverbinding) {
    die("connectie database mislukt: " . mysqli_connect_error());
}
else {
    if ($database == 'cohortTESTdb') {
        echo "<hr><font style='color: indianred; font-size: 4em;'><b>LET OP</b> $database actief.</font><br>";
    }
}
?>