<?PHP
error_reporting(E_ALL);
ini_set("display_errors", "1");
// ini_set('memory_limit','1024M');
ini_set('memory_limit', '-1');
// set_time_limit(0);
ini_set('max_execution_time', 0); //300 s = 5 min

require('class/settings.php');
require('class/leerling.class');
require('class/leerlaag.class');

// hoofdprogramma
require('class/excellezer.php');
 require('dashboard/genereer_overzicht_groepen.php');

// require('class/pdfschrijver.php');

// require('dashboard/beoordelingen_klasniveau_per_leerling.php');
// require('dashboard/leerlingen_met_achterstanden.php');
// require('dashboard/mentor_overzicht_per_leerling_leerlaag.php');
// require('dashboard/mentor_overzicht_per_leerling_stamklas.php');
?>