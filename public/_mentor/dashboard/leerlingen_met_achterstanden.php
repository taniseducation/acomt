<?PHP
// leerlingen_met_achterstanden
// toont beoordelingen van leerlingen die niet op niveau zitten kolom M

foreach ($klasNaamLijst as $klas) {
    echo "<h1>klas $klas</h1>";
    $lijst=${$klas}->get_llLijst();
    foreach ($lijst as $leerling) {
        $beoordelingen = ${$leerling->get_laag().$leerling->get_laagVolgNummer()}->get_beoordeling();
        $lijstNietOpNiveau = [];
        while ($beoordeling = current($beoordelingen)) {
            if ($beoordeling['M'] == 'NEE') {
                $lijstNietOpNiveau[key($beoordelingen)] = $beoordeling;
            }
            next($beoordelingen);
        }
        if (!empty($lijstNietOpNiveau)) {
            echo '<b style="margin-top: 0px; color: dodgerblue;">'.${$leerling->get_laag().$leerling->get_laagVolgNummer()}->get_naam().'</b><br>';
            while ($beoordeling = current($lijstNietOpNiveau)) {
                $kleur = 'green';
                if ($beoordeling['N'] == 'JA') {
                    $kleur = 'indianred';
                }
                echo key($lijstNietOpNiveau).' | op niveau?: '.$beoordeling['M'].' | door CORONA?:<b style="color: '.$kleur.';"> '.$beoordeling['N'].'</b> | plaatsing juist?: '.$beoordeling['O'].'<br>';
                next($lijstNietOpNiveau);
            }
        }
    }
}
?>