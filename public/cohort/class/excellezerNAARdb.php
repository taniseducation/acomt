<?PHP
require('../../vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$inFilePath = 'fileExcel/xlsxIN/';

echo '<h2>inlezen aangepaste Excel-files en wegschrijven naar DB</h2>';

// haal vakken op uit database voor bestandsnamen
$sql = "SELECT * FROM vakken";
$vakken= mysqli_query($DBverbinding, $sql);
while($vak = mysqli_fetch_assoc($vakken)) {    
    if ($vak['vid'] == 29) {continue;} // BV in database maar wordt niet gebruikt
    $inFileName = "{$vak['vakCode']} PTA en onderwijsprogramma.xlsx";
    $inputFileName = $inFilePath.$inFileName;    
    echo "<h3>{$vak['vid']} {$vak['vakNaam']} => $inputFileName</h3>";
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $reader->setReadDataOnly(true);
    $spreadsheet = $reader->load($inputFileName);
    $loadedSheetNames = $spreadsheet->getSheetNames();
    array_shift($loadedSheetNames); // gooi settings ...
    array_shift($loadedSheetNames); // en instructie weg
    echo '<pre>';
    print_r($loadedSheetNames);
    echo '<pre>';
    foreach ($tabbladen as $tabblad) {
        //$spreadsheet->setActiveSheetIndexByName($tabblad);
        echo "<h5>$tabblad</h5>";

        /*
        $naamTabblad = $filter['niveau'].' '.$filter['beginJaar'];
        $vid = $spreadsheet->getActiveSheet()->getCell('B5');
        $niveau = $spreadsheet->getActiveSheet()->getCell('B6');
        $positiePTA = $spreadsheet->getActiveSheet()->getCell('B13')->getCalculatedValue();
        $cid = $spreadsheet->getActiveSheet()->getCell('B8')->getCalculatedValue();
        die('die: één tabblad'); // één tabblad voor testen
        */
    }
    $spreadsheet->disconnectWorksheets();
    unset($spreadsheet);
    unset($reader);
    die('die: één excelfile'); // één excelfile / één vak
}
?>