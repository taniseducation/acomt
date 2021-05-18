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

echo '<h2>WRITER van '.$inputFileName.' naar <a href="'.$outputFileName.'" target="_NEW">'.$outFileName.'</a></h2>';

/*  PLAN
    Laat de instanties zelf een array genereren die door Excel wordt weggeschreven
    Sterker nog: kun je een cohort zijn eigen pagina laten opbouwen?
*/

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
// $reader->setReadDataOnly(true);
// $reader->setLoadSheetsOnly(["wensen", "instellingen"]);
// $reader->setLoadSheetsOnly(["sjabloon"]); // inschakelen filtert ook op hidden cells
$spreadsheet = $reader->load($inputFileName);

$spreadsheet->getProperties()
    ->setCreator("VNR@acomt")
    ->setLastModifiedBy("René van der Veen")
    ->setTitle("xlsx-pta-generator")
    ->setSubject("acomt pta cohorten")
    ->setDescription(
        "Dit bestand is eigendom van CSG Augustinus Groningen"
    )
    ->setKeywords("acomt pta cohorten")
    ->setCategory("internal usage only");

$loadedSheetNames = $spreadsheet->getSheetNames();
$spreadsheet->setActiveSheetIndexByName('sjabloon');
// $spreadsheet->getActiveSheet()->setCellValue('H6',1);
// $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

// $cohortBkolom = [$status,NULL,${'c'.$filterCohort}->cohortData['vakCode'],${'c'.$filterCohort}->cohortData['vid'],${'c'.$filterCohort}->cohortData['niveau'],${'c'.$filterCohort}->cohortData['beginJaar'],${'c'.$filterCohort}->cohortData['cid']];
$spreadsheet->getActiveSheet()->fromArray(${'c'.$filterCohort}->getB2B8($status),NULL,'B2');
$spreadsheet->getActiveSheet()->fromArray(${'c'.$filterCohort}->getG6P11(),NULL,'G6');




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

// kolom periode omzetten naar dropdown voor lege cellen
$validation = $spreadsheet->getActiveSheet()->getCell('G6')->getDataValidation();
$validation->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
$validation->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
$validation->setAllowBlank(false);
$validation->setShowInputMessage(true);
$validation->setShowErrorMessage(true);
$validation->setShowDropDown(true);
$validation->setErrorTitle('ERROR');
$validation->setError('ongeldige waarde');
$validation->setFormula1('instellingen!$G$2:$G$6');

$pLijst = ['G7','G8','G9','G10','G11'];
if (${'c'.$filterCohort}->cohortData['niveau'] != 'M') {
    $pLijst=array_merge($pLijst,['G18','G19','G20','G21','G22','G23']);
}
if (${'c'.$filterCohort}->cohortData['niveau'] = 'A') {
    $pLijst=array_merge($pLijst,['G30','G31','G32','G33','G34','G35']);
}
foreach ($pLijst as $p) {
    $spreadsheet->getActiveSheet()->getCell($p)->setDataValidation(clone $validation);
}

// kolom soort toets omzetten naar dropdown voor lege cellen
$validation2 = $spreadsheet->getActiveSheet()->getCell('J6')->getDataValidation();
$validation2->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
$validation2->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
$validation2->setAllowBlank(false);
$validation2->setShowInputMessage(true);
$validation2->setShowErrorMessage(true);
$validation2->setShowDropDown(true);
$validation2->setErrorTitle('ERROR');
$validation2->setError('ongeldige waarde');
$validation2->setFormula1('instellingen!$H$2:$G$7');

$tLijst = ['J7','J8','J9','J10','J11'];
if (${'c'.$filterCohort}->cohortData['niveau'] != 'M') {
    $tLijst=array_merge($pLijst,['J18','J19','J20','J21','J22','J23']);
}
if (${'c'.$filterCohort}->cohortData['niveau'] = 'A') {
    $tLijst=array_merge($pLijst,['J30','J31','J32','J33','J34','J35']);
}
foreach ($tLijst as $p) {
    $spreadsheet->getActiveSheet()->getCell($p)->setDataValidation(clone $validation2);
}



$XLSXwriter->save($outputFileName);
$spreadsheet->disconnectWorksheets();
unset($spreadsheet);
?>
