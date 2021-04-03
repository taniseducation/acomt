<?PHP
error_reporting(E_ALL);
ini_set("display_errors", "1");
// ini_set('memory_limit','1024M');
ini_set('memory_limit', '-1');
// set_time_limit(0);
ini_set('max_execution_time', 0); //300 s = 5 min

require('class/database.php');
require('class/settings.php');
require('class/cohort.class');
require('class/item.class');

// require('class/bruteforceDBread.php');
require('class/excelschrijver.php');

// hoofdprogramma

// require('class/pdfschrijver.php');
?>