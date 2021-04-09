<?PHP
require('../../vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$inFilePath = 'fileExcel/';
$inFileName = '_sjabloon_v1.xlsx';
$outFilePath = 'fileExcel/xlsxUIT/';
$outFileName = 'writer.xlsx';

$inputFileName = $inFilePath.$inFileName;
$outputFileName = $outFilePath.$outFileName;

echo '<h2>WRITER van '.$inputFileName.' naar '.$outputFileName.'</h2>';

/*  PLAN
    Laat de instanties zelf een array genereren die door Excel wordt weggeschreven
    Sterker nog: kun je een cohort zijn eigen pagina laten opbouwen?
*/

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
// $reader->setReadDataOnly(true);
// $reader->setLoadSheetsOnly(["wensen", "instellingen"]);
// $reader->setLoadSheetsOnly(["sjabloon"]); // inschakelen filtert ook op hidden cells
$spreadsheet = $reader->load($inputFileName);
$loadedSheetNames = $spreadsheet->getSheetNames();
$spreadsheet->setActiveSheetIndexByName('sjabloon');
// $spreadsheet->getActiveSheet()->setCellValue('D4',1);
// $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

$cohortBkolom = [$status,NULL,${'c'.$filterCohort}->cohortData['vakCode'],${'c'.$filterCohort}->cohortData['vid'],${'c'.$filterCohort}->cohortData['niveau'],${'c'.$filterCohort}->cohortData['beginJaar'],${'c'.$filterCohort}->cohortData['cid']];
$spreadsheet->getActiveSheet()->fromArray(array_chunk($cohortBkolom,1),NULL,'B2');

echo '<pre>';
//print_r($sheetData);
echo '<pre>'; 

/*
foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
    echo "<h3>".$loadedSheetName."</h3>";
    $spreadsheet->setActiveSheetIndexByName($loadedSheetName);
    // $spreadsheet->getActiveSheet()->setCellValue('A1', 'schadenberg');
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
}

$HTMLwriter = IOFactory::createWriter($spreadsheet, 'Html');
foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
    echo "<h2>".$loadedSheetName."</h2>";
    $spreadsheet->setActiveSheetIndexByName($loadedSheetName);
    $HTMLwriter->setSheetIndex($spreadsheet->getActiveSheetIndex());
    $message = $HTMLwriter->save('php://output');
}
*/

$XLSXwriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$XLSXwriter->save($outputFileName);
$spreadsheet->disconnectWorksheets();
unset($spreadsheet);
?>
