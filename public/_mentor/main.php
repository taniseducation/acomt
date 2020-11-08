<?PHP
error_reporting(E_ALL);

ini_set("display_errors", "1");
// ini_set('memory_limit','1024M');
ini_set('memory_limit', '-1');

// set_time_limit(60);
// set_time_limit(0);
ini_set('max_execution_time', 0); //300 seconds = 5 minutes bij 0 zet je hem op onbeperkt

require('class/settings.php');
require('class/leerling.class');
require('class/leerlaag.class');

// hoofdprogramma
echo '<p>MAIN loaded</p>';
require('class/excellezer.php');

foreach ($klasNaamLijst as $klas) {
    echo "<h1>klas $klas</h1>";
    $lijst=${$klas}->get_llLijst();
    foreach ($lijst as $leerling) {
        echo '<h3 style="margin-top: 10px;">'.${$leerling->get_laag().$leerling->get_laagVolgNummer()}->get_naam().'</h3><br>';
        ${$leerling->get_laag().$leerling->get_laagVolgNummer()}->toon_beoordelingen();
    }
}
?>