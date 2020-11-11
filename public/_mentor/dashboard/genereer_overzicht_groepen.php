<?PHP
// genereer_overzicht_groepen

// $handmatigeLeerLaagLijst = ['A4']; komt uit settings
// klasnaamlijst gegenereerd door excellezer

$actieveLaag = '';
foreach ($klasNaamLijst as $klas) {
    $laag = strtoupper(substr($klas,1,2));
    if ($actieveLaag!=$laag) {
        $actieveLaag = $laag;
        echo '<h1>'.$actieveLaag.' <a href="dashboard/mentor_overzicht_per_leerling_leerlaag.php?laag='.$actieveLaag.'" target="_blank">#</a></h1>| ';
    }
    echo '<a href="dashboard/mentor_overzicht_per_leerling_stamklas.php?klas='.$klas.'&laag='.$actieveLaag.'" target="_blank">'.$klas.'</a> | ';
}
?>