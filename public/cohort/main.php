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
require('class/bruteforceDBread.php');

// hoofdprogramma
require('class/excellezerNAARdb.php');
require('class/consistentiecheck.php');
require('class/DBnaarPDFschrijver.php');
// require('class/excelschrijver.php');
// require('class/DBoverzichtVak.php');

// ONDERSTAANDE ALLEEN GEBRUIKEN BIJ JAARLIJKSE UPDATE
// require('class/maak_items_in_db.php');
// require('class/genereerNieuweCohorten.php'); // elk jaar uitvoeren om nieuwe cohorten toe te voegen. Lees de code: niet automatisch nu
// hier kopieer cohort.
// require('class/kopieer_cohorten.php');

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
echo '<h3>MAILinglist sectievoorzitters</h3>'.$mailinglist;
?>