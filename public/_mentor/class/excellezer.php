<?PHP
require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

$filePath = 'fileExcel/';
$excelVak = $vakCodeLijst[0];
$fileNAmeEnd = ' inventarisatie leerlingen.xlsx';
$inputFileName = $filePath.$excelVak.$fileNAmeEnd;

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

$spreadsheet = $reader->load($inputFileName);
$loadedSheetNames = $spreadsheet->getSheetNames();

if (empty($worksheetLijst)) {
    // genereer de lijst van leerlagen die moeten worden afgehandeld
    // en maak voor elke laag een instantie met de naam $laagA4
    // vul elke laaginstantie met een array met leerlingen

    // verwijder beheer en klassen
    array_splice($loadedSheetNames,count($loadedSheetNames)-2);
    $leerLaagLijst = $loadedSheetNames;
    // ** tijdelijk voor minder data
    $leerLaagLijst = ['A4','A5'];
    foreach ($leerLaagLijst as $laag) {
        ${$laag} = new Leerlaag($laag);
        $spreadsheet->setActiveSheetIndexByName($laag);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null,true,true,true);
        $index = $indexEersteLeerling;
        while ($sheetData[$index]['B'] != null) {
            $nr = $index - 4;
            $laagVariabele = $laag.$nr;
            // check of de klas al in de lijst staat; zo niet: toevoegen om volgnummer te kunnen genereren
            if (!in_array($sheetData[$index]['C'],$klasNaamLijst)) {
                array_push($klasNaamLijst,$sheetData[$index]['C']);
                // maak een lege array voor een nieuwe klas
                ${$sheetData[$index]['C']} = new Leerlaag($sheetData[$index]['C']);
                $klasAantalLijst[$sheetData[$index]['C']] = 0;
            }
            $klasVariabele = $sheetData[$index]['C'].$klasAantalLijst[$sheetData[$index]['C']];
            ${$laag.$nr} = new Leerling($sheetData[$index]['B'],$laag,$laagVariabele,$nr,$sheetData[$index]['C'],$klasVariabele,$klasAantalLijst[$sheetData[$index]['C']]);
            ${$laag}->voegLeerlingToe(${$laag.$nr});
            ${$sheetData[$index]['C']}->voegLeerlingToe(${$laag.$nr});
            $klasAantalLijst[$sheetData[$index]['C']]++;
            $index++;
        }
        $laagAantalLijst[$laag] = $nr + 1;
    }
}

// nu de lagen, klassen en leerlingen zijn gegenereerd gaan we beoordelingen verzamelen
foreach ($vakCodeLijst as $excelVak) {
    $fileNAmeEnd = ' inventarisatie leerlingen.xlsx';
    $inputFileName = $filePath.$excelVak.$fileNAmeEnd;
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $spreadsheet = $reader->load($inputFileName);
    foreach ($leerLaagLijst as $laag) {
        $spreadsheet->setActiveSheetIndexByName($laag);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null,true,true,true);
        $aantalLeerLaag = count(${$laag}->llLijst);
        for ($l = 0; $l < $aantalLeerLaag; $l++) {
            // check of er een beoordeling voor deze leerling bestaat
            if ($sheetData[$l+$indexEersteLeerling]['D'] != 'kies...') {
                ${$laag.$l}->voegBeoordelingToe($excelVak,$sheetData[$l+$indexEersteLeerling]);
            }
        }
    }
}

echo '<h1>break</h1>';
echo '<PRE>';
print_r($A50);
echo '</PRE>';

/*
// leerling
echo '<PRE>';
print_r($A50);
echo '</PRE>';

// klas
echo '<PRE>';
print_r($aa5a);
echo '</PRE>';

// leerlaag
echo '<PRE>';
print_r($A5);
echo '</PRE>';

*/
?>