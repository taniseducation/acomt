<?PHP
require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

$filePath = 'fileExcel/';
$excelVak = $vakCodeLijst[0];
$fileNAmeEnd = ' inventarisatie leerlingen.xlsx';
$inputFileName = $filePath.$excelVak.$fileNAmeEnd;

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

// hier moet nog een for-each vakkenlijst
// hier moet nog een for-each vakkenlijst
// hier moet nog een for-each vakkenlijst

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
        ${'laag'.$laag} = new Leerlaag($laag);
        // echo ${'laag'.$laag}->get_naam().'toegevoegd<br>';

        echo "<h5>huidige laag: $laag</h5>";
        $spreadsheet->setActiveSheetIndexByName($laag);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null,true,true,true);
        $index = 4;
        while ($sheetData[$index]['B'] != null) {
            //echo $sheetData[$index]['B'].'<br>';
            ${'laag'.$laag}->voegLeerlingToe($sheetData[$index]['B'],$sheetData[$index]['C']);
            $index++;
        }
    }
}

/* eerst object leerling aanmaken
foreach ($leerLaagLijst as $laag) {
    // de lagen en leerlingen bestaan: nu beoordelingen registreren
    // aanduiding was ${'laag'.$laag} = new Leerlaag($laag);
    $spreadsheet->setActiveSheetIndexByName($laag);
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null,true,true,true);
    $index = 4;
    while ($sheetData[$index]['B'] != null) {
        //echo $sheetData[$index]['B'].'<br>';
        ${'laag'.$laag}->voegLeerlingToe($sheetData[$index]['B']);
        $index++;
    }
}
*/
// ALS HET GOED IS KUN JE LARS BIEK NU OM ZIJN NAAM VRAGEN

echo '<PRE>';
// print_r($laagA5->get_llLijst());
// $lijst = $laagA5->get_llLijst();
//echo $lijst[0]->get_naam().'<br>'; // toont eerste leerling van de klas
print_r($aa4a0);
print_r($laagA5);
// print_r($leerLaagLijst);
echo '</PRE>';


// hier moet nog een for-each vakkenlijst
// hier moet nog een for-each vakkenlijst
// hier moet nog een for-each vakkenlijst

// var_dump($sheetData);
// $message = $writer->save('php://output');

// $reader->setLoadSheetsOnly(["geheim"]);
// $spreadsheet = $reader->load($inputFileName);
// $writer = IOFactory::createWriter($spreadsheet, 'Html');

// XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
// XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
