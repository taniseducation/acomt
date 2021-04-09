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

$inputFileName = $outputFileName;

echo '<h1>VIEWER '.$inputFileName.'</h1>';
echo 'load <a href="'.$inputFileName.'">file</a>';

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
// $reader->setReadDataOnly(true); // geeft problemen bij wegschrijven
// $reader->setLoadSheetsOnly(["wensen", "instellingen"]);
// $reader->setLoadSheetsOnly(["sjabloon"]); // inschakelen filtert ook op hidden cells
$spreadsheet = $reader->load($inputFileName);
$loadedSheetNames = $spreadsheet->getSheetNames();
$HTMLwriter = IOFactory::createWriter($spreadsheet, 'Html');

foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
    echo "<h2>".$loadedSheetName."</h2>";
    $spreadsheet->setActiveSheetIndexByName($loadedSheetName);
    if ($loadedSheetName == 'sjabloon') {
        echo '<div style="background: green;"';
    }
    else {
        echo '<div style="display: none;"';
    }
    $HTMLwriter->setSheetIndex($spreadsheet->getActiveSheetIndex());
    $message = $HTMLwriter->save('php://output');
    echo '</div>';
}


$message = $HTMLwriter->save('php://output');
$spreadsheet->disconnectWorksheets();
unset($spreadsheet);
?>