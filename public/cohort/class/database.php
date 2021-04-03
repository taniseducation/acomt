<?php
$servernaam = "localhost";
$gebruikersnaam = "username";
$wachtwoord = "password";
$database = "cohorten";
$DBverbinding = mysqli_connect($servernaam, $gebruikersnaam, $wachtwoord, $database);

if (!$DBverbinding) {
    die("connectie database mislukt: " . mysqli_connect_error());
}
else {
    echo 'connectie database gelukt.<br>';
}
?>