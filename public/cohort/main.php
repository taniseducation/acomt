<?PHP
error_reporting(E_ALL);
ini_set("display_errors", "1");
// ini_set('memory_limit','1024M');
ini_set('memory_limit', '-1');
// set_time_limit(0);
ini_set('max_execution_time', 0); //300 s = 5 min
$timestamp = date_create();

require('class/database.php');
require('class/settings.php');
require('class/cohort.class.php');
require('class/item.class.php');

// maillinglist sectievoorzitters
$sql = "SELECT DISTINCT voorzitter FROM vakken";
$voorzitters = mysqli_query($DBverbinding, $sql);
$mailinglist = '';
while($voorzitter = mysqli_fetch_assoc($voorzitters)) {
    if ($voorzitter['voorzitter'] == null ) {
        //echo 'Hier mist iets<br>';
    }
    else {
        $mailinglist.=$voorzitter['voorzitter'].',';
    }
}
$mailinglist = substr($mailinglist,0,-1); // laatste , eraf halen
//echo '<h2>MAILinglist sectievoorzitters</h2>'.$mailinglist.'<br>';

//require('class/maak_items_in_db.php');
// require('class/genereerNieuweCohorten.php'); // elk jaar uitvoeren om nieuwe cohorten toe te voegen. Lees de code: niet automatisch nu
// hier kopieer cohort.
//require('class/kopieer_cohorten.php');

// hoofdprogramma

// eerst 1cohort gedaan met $filterCohort = selecteerCohort($filter,$DBverbinding); // in bruteforceDBread.php
$huidigJaarVoorGenererenExcel = 2021; // doe je voor de zomervakantie
// LET OP LET OP eerste item [0] wordt ook gebruikt om dat tabblad weer te verwijderen voor iedereen behalve KCKV
$tabbladen = ['M2021','M2020','M2019','H2021','H2020','H2019','A2021','A2020','A2019','A2018'];
$status = 'schrijfrecht'; // schrijfrecht leesrecht definitief
require('class/bruteforceDBread.php');

require('class/DBnaarPDFschrijver.php');
die();

//require('class/consistentiecheck.php');
//require('class/excellezerNAARdb.php');
//require('class/excelschrijver.php');

echo '<pre>';
//print_r(${'c'.$filterCohort}->cohortData['niveau']);
echo '</pre>';

require('class/DBoverzichtVak.php');
?>