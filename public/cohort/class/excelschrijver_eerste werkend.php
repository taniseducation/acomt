<?PHP
require('../../vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$filePath = 'class/';
$fileName = '2sheets.xlsx';
$inputFileName = $filePath.$fileName;

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load($inputFileName);
// $writer = IOFactory::createWriter($spreadsheet, 'Html');

$loadedSheetNames = $spreadsheet->getSheetNames();
foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
    echo $loadedSheetName."<br>";
}
$spreadsheet->setActiveSheetIndexByName("beheer");
$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
echo '<PRE>';
print_r($sheetData);
echo '</PRE>';
// var_dump($sheetData);

echo "<h2>{$sheetData[1]['A']}</h2>";
$sheetData[1]['A'] = 'VNR';

$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$writer->save("writeExcel/weggeschreve.xlsx");
$spreadsheet->disconnectWorksheets();
unset($spreadsheet);



die();


$fileName = "testnode.xlsx";
$inputFileName = $filePath.$fileName;

// alternatieve methode werkt ook
$spreadsheet = IOFactory::load($inputFileName);
$writer = IOFactory::createWriter($spreadsheet, 'Html');
$message = $writer->save('php://output');

$schedules = $spreadsheet->getActiveSheet()->toArray();
echo '<PRE>';
print_r($schedules);
echo '</PRE>';
foreach( $schedules as $single_schedule )
{               
    echo '<div class="row">';
    foreach( $single_schedule as $single_item )
    {
        echo '<p class="item">' . $single_item . '</p>';
    }
    echo '</div>';
}


?>
