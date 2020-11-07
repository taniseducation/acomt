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

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



$inputFileName = "testnode.xlsx";

/**  Identify the type of $inputFileName  **/
$inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);

/**  Create a new Reader of the type that has been identified  **/
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

/**  Load $inputFileName to a Spreadsheet Object  **/
$spreadsheet = $reader->load($inputFileName);

/**  Convert Spreadsheet Object to an Array for ease of use  **/
$schdeules = $spreadsheet->getActiveSheet()->toArray();

foreach( $schdeules as $single_schedule )
{               
    echo '<div class="row">';
    foreach( $single_schedule as $single_item )
    {
        echo '<p class="item">' . $single_item . '</p>';
    }
    echo '</div>';
}




/*
require __DIR__ . '/../Header.php';

// Create temporary file that will be read
$sampleSpreadsheet = require __DIR__ . '/../templates/sampleSpreadsheet.php';
$filename = $helper->getTemporaryFilename();
$writer = new Xlsx($sampleSpreadsheet);
$writer->save($filename);

$callStartTime = microtime(true);
$spreadsheet = IOFactory::load($filename);
$helper->logRead('Xlsx', $filename, $callStartTime);

// Save
$helper->write($spreadsheet, __FILE__);
unlink($filename);
*/
?>


<?php
/*

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Hello World !');

$writer = new Xlsx($spreadsheet);
$writer->save('hello world.xlsx');
*/
?>
        <h2>done</h2>
    </body>
</html>
