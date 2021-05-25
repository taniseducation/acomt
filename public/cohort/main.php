<?PHP
error_reporting(E_ALL);
ini_set("display_errors", "1");
// ini_set('memory_limit','1024M');
ini_set('memory_limit', '-1');
// set_time_limit(0);
ini_set('max_execution_time', 0); //300 s = 5 min

require('class/database.php');
require('class/settings.php');
require('class/cohort.class.php');
require('class/item.class.php');

//require('class/maak_items_in_db.php');
// require('class/genereerNieuweCohorten.php'); // elk jaar uitvoeren om nieuwe cohorten toe te voegen. Lees de code: niet automatisch nu

require('class/bruteforceDBread.php');

// hier kopieer cohort.
require('class/kopieer_cohorten.php');

echo '<pre>';
// print_r($cidLijst);
echo '<pre>';
die();

// hoofdprogramma

// eerst 1cohort gedaan met $filterCohort = selecteerCohort($filter,$DBverbinding); // in bruteforceDBread.php
$huidigJaarVoorGenererenExcel = 2021; // doe je voor de zomervakantie

// LET OP LET OP eerste item [0] wordt ook gebruikt om dat tabblad weer te verwijderen voor iedereen behalve KCKV
$tabbladen = ['M2021','M2020','M2019','H2021','H2020','H2019','A2021','A2020','A2019','A2018'];
$status = 'schrijfrecht'; // schrijfrecht leesrecht definitief
require('class/excelschrijver.php');

//$filter['niveau'] = 'A';
//$filter['beginJaar'] = '2020';
//$filter['vakCode'] = 'NA'; // IF 14 NA 15
// $filter['vid'] = 15; // selecteerCohort gebruik vid en niet vakCode, want gaat om één cohort.

echo '<pre>';
//print_r(${'c'.$filterCohort}->cohortData['niveau']);
echo '<pre>';

// met het gefilterde cohort ga je schrijven
// require('class/excelschrijver.php');

// require('class/DBoverzichtVak.php');

/*
foreach (${'c'.$filterCohort}->jaarItems as $cj) {
    echo '<pre>';
    print_r($cj);
    echo '<pre>';
}
*/


// require('class/pdfschrijver.php');
?>