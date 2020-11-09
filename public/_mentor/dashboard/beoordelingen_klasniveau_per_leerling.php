<?PHP
// beoordelingen_klasniveau_per_leerling
// genereert een overzicht van sterbeoordelingen per klas per leerling per vak

foreach ($klasNaamLijst as $klas) {
    echo "<h1>klas $klas</h1>";
    $lijst=${$klas}->get_llLijst();
    foreach ($lijst as $leerling) {
        echo '<h3 style="margin-top: 10px;">'.${$leerling->get_laag().$leerling->get_laagVolgNummer()}->get_naam().'</h3><br>';
        ${$leerling->get_laag().$leerling->get_laagVolgNummer()}->toon_beoordelingen();
    }
}
?>