<?PHP
// mentor_overzicht_per_leerling_Stamklas
// toont alle ingevulde gegevens per leerling-record voor een hele stamklas

$laag = null; 
if( isset($_GET['laag'])) {
    $laag = $_GET['laag']; 
    $klas = $_GET['klas'];
    require('standaloneheader.php');
    $handmatigeLeerLaagLijst = [$laag];
    require('standaloneexcellezer.php');
    $klasNaamLijst = [$klas];
}

foreach ($klasNaamLijst as $klas) {
    $lijst=${$klas}->get_llLijst();
    foreach ($lijst as $leerling) {
        $beoordelingen = ${$leerling->get_laag().$leerling->get_laagVolgNummer()}->get_beoordeling();
        echo '<h3>'.${$leerling->get_laag().$leerling->get_laagVolgNummer()}->get_naam().' ('.$klas.')</h3>';
        // tabel met sterren e.d.
        echo '<table>';
        echo '<tr><th>vak</th><th>inzet</th><th>concentratie</th><th>inzicht</th><th>huiswerk</th><th>op niveau?</th><th>corona</th><th>plaatsing</th></tr>';
        while ($beoordeling = current($beoordelingen)) {
            echo '<tr><td class="vak">'.key($beoordelingen).'</td><td class="ster">'.$beoordeling['D'].'</td><td class="ster">'.$beoordeling['E'].'</td><td class="ster">'.$beoordeling['F'].'</td><td class="ster">'.$beoordeling['G'].'</td><td>'.$beoordeling['M'].'</td><td>'.$beoordeling['N'].'</td><td>'.$beoordeling['O'].'</td></tr>';
            next($beoordelingen);
        }
        echo '</table>';
        // tabel met opmerkingen
        // echo '<h1>opmerkingen collega\'s</h1>';
        echo '<table>';
        echo '<tr><th>vak</th><th>opmerkingen gedrag en inzet</th><th>vakinhoudelijke opmerkingen</th><th>actie leerling</th></tr>';
        $beoordelingen = ${$leerling->get_laag().$leerling->get_laagVolgNummer()}->get_beoordeling();
        while ($beoordeling = current($beoordelingen)) {
            echo '<tr><td class="vak">'.key($beoordelingen).'</td><td class="tekst">'.$beoordeling['H'].'</td><td class="tekst">'.$beoordeling['P'].'</td><td class="tekst">'.$beoordeling['Q'].'</td></tr>';
            next($beoordelingen);
        }
        echo '</table>';
        
        echo '<div class="pagebreak"></div>';
    }
}

if( isset( $_GET['laag'])) {
    echo '</div></body></html>';
}
?>