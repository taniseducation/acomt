<?php
// Include the main TCPDF library (search for installation path).
// https://tcpdf.org
// https://rimas-kudelis.github.io/tcpdf/classes/TCPDF.html

require_once('TCPDF/tcpdf.php');
require_once('ptapdf.class.php');

$filter['cohortJaar'] = '2021'; // jaar waarvoor het PTA geprint moet worden
$examenjaar = $filter['cohortJaar'] + 1;
$schooljaar = $filter['cohortJaar'].'-'.$examenjaar;
$filter['klasJaar'] = 6;
$filter['niveau'] = 'A'; // MHA
if (($filter['niveau'] == 'M' && $filter['klasJaar'] == 3) || ($filter['niveau'] != 'M' && $filter['klasJaar'] == 4)) {$filter['beginJaar'] = $filter['cohortJaar'];}
if (($filter['niveau'] == 'M' && $filter['klasJaar'] == 4) || ($filter['niveau'] != 'M' && $filter['klasJaar'] == 5)) {$filter['beginJaar'] = $filter['cohortJaar'] - 1;}
if ($filter['klasJaar'] == 6) {$filter['beginJaar'] = $filter['cohortJaar'] - 2;}

$relatief = '/cohort/filePDFout/'.$filter['klasJaar'].$filter['niveau'].'_PTA_'.$schooljaar.'.pdf';
$sFilePath = $_SERVER['DOCUMENT_ROOT'].$relatief ;

$pdf = new PTAPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator('VNR@acomt');
$pdf->SetAuthor('VNR@acomt');
$pdf->SetTitle('PTB-PTA-CSG');
$pdf->SetSubject('Programma van Toetsing en Afsluiting');
$pdf->SetKeywords('PTO,PTA,CSG,Augustinus,Groningen');
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->laag = $filter['klasJaar'].$filter['niveau'];

$sql = "SELECT cohorten.cid FROM vakken,cohorten WHERE vakken.vid = cohorten.vid AND cohorten.beginjaar={$filter['beginJaar']} AND niveau='{$filter['niveau']}' AND NOT vakken.vid = 29 ORDER BY vakken.vid ASC";
$cohorten = mysqli_query($DBverbinding, $sql);
while($c = mysqli_fetch_assoc($cohorten)) {
    //echo "<h2>{${'c'.$c['cid']}->cohortData['cid']} {${'c'.$c['cid']}->cohortData['vid']} {${'c'.$c['cid']}->cohortData['vakNaam']} {${'c'.$c['cid']}->cohortData['niveau']} {${'c'.$c['cid']}->cohortData['beginJaar']}</h2>";
    $data = [];
    $sql = "SELECT items.id,items.hulp,cohortjaar.algemeen FROM cohortjaar,items WHERE cohortjaar.cjid=items.cjid AND cohortjaar.jaar=2021 AND cohortjaar.cid = {${'c'.$c['cid']}->cohortData['cid']} ORDER BY items.periode ASC,items.volgnr ASC";
    $items = mysqli_query($DBverbinding, $sql);
    while($i = mysqli_fetch_assoc($items)) {
        $algemeen = $i['algemeen'];
        //echo "<h5>{$i['id']} | {${'i'.$i['id']}->itemData['periode']} | {${'i'.$i['id']}->itemData['hulp']}</h5>";
        array_push($data,[${'i'.$i['id']}->itemData['periode'],${'i'.$i['id']}->itemData['SOMcode'],${'i'.$i['id']}->itemData['wegingSE'],${'i'.$i['id']}->itemData['herkansbaar'],${'i'.$i['id']}->itemData['duur'],${'i'.$i['id']}->itemData['leerstofomschrijving'],${'i'.$i['id']}->itemData['domeinen'],$i['hulp']]);
    }
    if (mysqli_num_rows($items)) {$pdf->ptaJaarVak(${'c'.$c['cid']}->cohortData['vakNaam'],$data,$algemeen);}
}

$pdf->lastPage();
$pdf->Output( $sFilePath , 'F');

echo "<h3>$sFilePath path<br>";
echo 'dus klik op <a href="'.$relatief.'" target="_NEW">link</a></h3>';
