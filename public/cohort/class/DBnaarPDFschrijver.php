<?php
// Include the main TCPDF library (search for installation path).
// https://tcpdf.org
// https://rimas-kudelis.github.io/tcpdf/classes/TCPDF.html
require_once('TCPDF/tcpdf.php');
require_once('ptapdf.class.php');
$relatief = '/cohort/filePDFout/first.pdf';
$sFilePath = $_SERVER['DOCUMENT_ROOT'].$relatief ;

$pdf = new PTAPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator('VNR@acomt');
$pdf->SetAuthor('VNR@acomt');
$pdf->SetTitle('PTB-PTA-CSG');
$pdf->SetSubject('Programma van Toetsing en Afsluiting');
$pdf->SetKeywords('PTO,PTA,CSG,Augustinus,Groningen');
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$data = [
    [1,'4po1',3,'nee',100,'Opdracht bij 3 moderne werken, periode 1940 tot heden. Opdracht bij 3 moderne werken, periode 1940 tot heden.','E','Woordenboek en gelezen werken niet toegestaan'],
    [1,'4po1',3,'nee',100,'Opdracht bij 3 moderne werken, periode 1940 tot heden. Opdracht bij 3 moderne werken, periode 1940 tot heden. Opdracht bij 3 moderne werken, periode 1940 tot heden.','E','Woordenboek en gelezen werken niet toegestaan'],
    [1,'4po1',3,'nee',100,'Opdracht bij 3 moderne werken, periode 1940 tot heden','E','Woordenboek en gelezen werken niet toegestaan'],
    [1,'4po1',3,'nee',100,'Opdracht bij 3 moderne werken, periode 1940 tot heden','E','Woordenboek en gelezen werken niet toegestaan'],
    [1,'4po1',3,'nee',100,'Opdracht bij 3 moderne werken, periode 1940 tot heden','E','Woordenboek en gelezen werken niet toegestaan'],
    [1,'4po1',3,'nee',100,'Opdracht bij 3 moderne werken, periode 1940 tot heden','E','Woordenboek en gelezen werken niet toegestaan'],

];
$pdf->laag = '4M';
$vak='Duitse taal en cultuur';
$pdf->ptaJaarVak($vak,$data);
$vak='informatica';
$pdf->ptaJaarVak($vak,$data);

$pdf->lastPage();
$pdf->Output( $sFilePath , 'F');


echo "<h3>$sFilePath path<br>";
echo 'dus klik op <a href="'.$relatief.'" target="_NEW">link</a></h3>';
