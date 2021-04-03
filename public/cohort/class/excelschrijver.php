<?PHP
require('../../vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

echo '<h1>beginfile</h1>';
$filePath = 'class/';
$fileName = '2sheets.xlsx';
$inputFileName = $filePath.$fileName;
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load($inputFileName);

$loadedSheetNames = $spreadsheet->getSheetNames();
foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
    echo $loadedSheetName."<br>";
}
$spreadsheet->setActiveSheetIndexByName("beheer");
$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
$HTMLwriter = IOFactory::createWriter($spreadsheet, 'Html');
$message = $HTMLwriter->save('php://output');

echo '<h3>manipuleren</h3>';
// https://phpspreadsheet.readthedocs.io/en/latest/topics/accessing-cells/
$spreadsheet->getActiveSheet()->setCellValue('A1', 'schadenberg');


$styleArray = [
    'borders' => [
        'outline' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['argb' => '00BBFF00'],
        ],
    ],
];

$spreadsheet->getActiveSheet()->getStyle('B2:G8')->applyFromArray($styleArray);

echo '<h3>einde manipuleren</h3>';

$XLSXwriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$XLSXwriter->save("writeExcel/weggeschreve.xlsx");
$spreadsheet->disconnectWorksheets();
unset($spreadsheet);

// andere file openen
echo '<h1>eindresultaat</h1>';
$filePath = 'writeExcel/';
$fileName = 'weggeschreve.xlsx';
$inputFileName = $filePath.$fileName;
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load($inputFileName);

$loadedSheetNames = $spreadsheet->getSheetNames();
foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
    echo $loadedSheetName."<br>";
}

$spreadsheet->setActiveSheetIndexByName("beheer");
//$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
$HTMLwriter = IOFactory::createWriter($spreadsheet, 'Html');
$message = $HTMLwriter->save('php://output');
$spreadsheet->disconnectWorksheets();
unset($spreadsheet);


die();

/* alternatieve methode werkt ook
$fileName = "testnode.xlsx";
$inputFileName = $filePath.$fileName;
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
*/
?>
