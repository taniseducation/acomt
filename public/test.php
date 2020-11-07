<!DOCTYPE html>
<html>
    <head>
        <title>mentor</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body style="width: 100%; padding-left: 30%; font-size: 2em;">
        <h1>mentoroverzichten</h1>
        <h2 style='color: green;'>notities</h2>
        <p>
            !nothing here;
        </p>
        <h2 id="settings">settings</h2>
        <script>
            document.getElementById("settings").innerHTML = 'Vul hier settings aan: +';
        </script>


<?php

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$inputFileName = "2sheets.xlsx";

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

$reader->setLoadSheetsOnly(["beheer"]);
$spreadsheet = $reader->load($inputFileName);
$writer = IOFactory::createWriter($spreadsheet, 'Html');
$message = $writer->save('php://output');

$reader->setLoadSheetsOnly(["geheim"]);
$spreadsheet = $reader->load($inputFileName);
$writer = IOFactory::createWriter($spreadsheet, 'Html');
$message = $writer->save('php://output');






$inputFileName = "testnode.xlsx";


/* alternatieve methode werkt ook
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
        <h2>done</h2>
    </body>
</html>
