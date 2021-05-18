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

require('class/bruteforceDBread.php');

// hoofdprogramma

$status = 'schrijfrecht'; // schrijfrecht leesrecht definitief
$filter['niveau'] = 'A';
$filter['beginJaar'] = '2019';
$filter['vakCode'] = 'NA'; // IF 14 NA 15
$filter['vid'] = 15; // selecteerCohort gebruik vid en niet vakCode, want gaat om één cohort.
$filterCohort = selecteerCohort($filter,$DBverbinding); // in bruteforceDBread.php

// met het gefilterde cohort ga je schrijven
require('class/excelschrijver.php');

echo '<pre>';
//print_r(${'c'.$filterCohort}->cohortData['niveau']);
echo '<pre>';

// require('class/DBoverzichtVak.php');

/*
foreach (${'c'.$filterCohort}->jaarItems as $cj) {
    echo '<pre>';
    print_r($cj);
    echo '<pre>';
}
*/

//require('class/excelschrijver.php');
// require('class/pdfschrijver.php');
?>