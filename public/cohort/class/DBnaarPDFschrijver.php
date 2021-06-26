<?php
// Include the main TCPDF library (search for installation path).
// https://tcpdf.org
// https://rimas-kudelis.github.io/tcpdf/classes/TCPDF.html
require_once('TCPDF/tcpdf.php');
require_once('ptapdf.class.php');
$relatief = '/cohort/filePDFout/first.pdf';
$sFilePath = $_SERVER['DOCUMENT_ROOT'].$relatief ;

// PDF_UNIT can be one of [pt=point, mm=millimeter, cm=centimeter, in=inch]
$pdf = new PTAPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator('VNR@acomt');
$pdf->SetAuthor('VNR@acomt');
$pdf->SetTitle('PTB-PTA-CSG');
$pdf->SetSubject('Programma van Toetsing en Afsluiting');
$pdf->SetKeywords('PTO,PTA,CSG,Augustinus,Groningen');

//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// font-size issue? https://stackoverflow.com/questions/29795896/tcpdf-how-to-set-font-size-in-right-way
// $pdf->SetFont('dejavusans', '', 10);
// $pdf->SetFont('times', '', 10);
// $pdf->SetFont('helvetica', '', 10);

$pdf->AddPage();
$pdf->Cell(0, 0, 'breedte: '.$pdf->paginaBreedte, 0, false, 'L', 0, '', 0, false, 'M', 'M');

$pdf->Ln(40);

$data = [
    [1,'4po1',3,'nee',100,'Opdracht bij 3 moderne werken, periode 1940 tot heden. Opdracht bij 3 moderne werken, periode 1940 tot heden.','E','Woordenboek en gelezen werken niet toegestaan'],
    [1,'4po1',3,'nee',100,'Opdracht bij 3 moderne werken, periode 1940 tot heden. Opdracht bij 3 moderne werken, periode 1940 tot heden. Opdracht bij 3 moderne werken, periode 1940 tot heden.','E','Woordenboek en gelezen werken niet toegestaan'],
    [1,'4po1',3,'nee',100,'Opdracht bij 3 moderne werken, periode 1940 tot heden','E','Woordenboek en gelezen werken niet toegestaan'],
    [1,'4po1',3,'nee',100,'Opdracht bij 3 moderne werken, periode 1940 tot heden','E','Woordenboek en gelezen werken niet toegestaan'],
    [1,'4po1',3,'nee',100,'Opdracht bij 3 moderne werken, periode 1940 tot heden','E','Woordenboek en gelezen werken niet toegestaan'],
    [1,'4po1',3,'nee',100,'Opdracht bij 3 moderne werken, periode 1940 tot heden','E','Woordenboek en gelezen werken niet toegestaan'],

];
$pdf->ptaJaarVak($data);
$pdf->AddPage();
$pdf->ptaJaarVak($data);

$pdf->lastPage();

// MultiCell(  $w,   $h,   $txt,   $border,   $align = 'J',   $fill = false,   $ln = 1,   $x = '',   $y = '',
//             $reseth = true,   $stretch,   $ishtml = false,   $autopadding = true,   $maxh,   $valign = 'T',   $fitcell = false) : integer
/*
$txt = "Deze tekst is vast te lang, \n hoewel \n de cel nog niet heel groot is. Mijn verwachtingen zijn daarentegen wel groot.";
$pdf->MultiCell(55, 60, $txt, 1, 'J', 1, 1, 125, 145, true, 0, false, true, 60, 'M', true);
$pdf->MultiCell(155, 30, $txt, 0, 'C', 1, 2, null, null, true, 0, false, true, 60, 'M', true);
*/
echo "<h3>$sFilePath path</h3>";
echo 'dus klik op <a href="'.$relatief.'" target="_NEW">link</a>';
$pdf->Output( $sFilePath , 'F');