<?PHP
require('../../vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

$filePath = 'fileExcel/';
$fileNAme = '_FAKEmastervoortest.xlsx';
$inputFileName = $filePath.$fileNAme;

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

$spreadsheet = $reader->load($inputFileName);
$loadedSheetNames = $spreadsheet->getSheetNames();

echo '<pre>';
//print_r($loadedSheetNames);
echo '</pre>';

foreach ($loadedSheetNames as $vakCode) {
    $spreadsheet->setActiveSheetIndexByName($vakCode);
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null,true,true,true);

}
?>