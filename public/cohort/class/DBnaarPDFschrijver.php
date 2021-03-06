<?php
// Include the main TCPDF library (search for installation path).
// https://tcpdf.org
// https://rimas-kudelis.github.io/tcpdf/classes/TCPDF.html

require_once('TCPDF/tcpdf.php');
require_once('ptapdf.class.php');
echo "<h3>PDF generator voor <b>$outputType</b></h3>";

foreach ($lagen as $laag) {
    //if ($laag=='M3') {continue;};
    $filter['cohortJaar'] = $printJaar; // jaar waarvoor het PTA geprint moet worden
    $examenjaar = $filter['cohortJaar'] + 1;
    $schooljaar = $filter['cohortJaar'].'-'.$examenjaar;
    $filter['niveau'] = $laag[0]; // MHA
    $filter['klasJaar'] = $laag[1];
    if (($filter['niveau'] == 'M' && $filter['klasJaar'] == 3) || ($filter['niveau'] != 'M' && $filter['klasJaar'] == 4)) {$filter['beginJaar'] = $filter['cohortJaar'];}
    if (($filter['niveau'] == 'M' && $filter['klasJaar'] == 4) || ($filter['niveau'] != 'M' && $filter['klasJaar'] == 5)) {$filter['beginJaar'] = $filter['cohortJaar'] - 1;}
    if ($filter['klasJaar'] == 6) {$filter['beginJaar'] = $filter['cohortJaar'] - 2;}
    if ($outputPTA) {
        $relatief = '/cohort/filePDFout/'.$filter['klasJaar'].$filter['niveau'].'_PTA_'.$schooljaar.'.pdf';
    }
    else {
        $relatief = '/cohort/filePDFout/'.$filter['klasJaar'].$filter['niveau'].'_PTB_'.$schooljaar.'.pdf';
    }    
    $sFilePath = $_SERVER['DOCUMENT_ROOT'].$relatief ;

    $pdf = new PTAPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
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
        if ($outputPTA) {
            $sql = "SELECT items.id,items.hulp,cohortjaar.algemeen FROM cohortjaar,items WHERE cohortjaar.cjid=items.cjid AND cohortjaar.jaar=2021 AND cohortjaar.cid = {${'c'.$c['cid']}->cohortData['cid']} AND items.SE = 1 ORDER BY items.periode ASC,items.volgnr ASC";
        }
        else {
            $sql = "SELECT items.id,items.hulp,cohortjaar.algemeen FROM cohortjaar,items WHERE cohortjaar.cjid=items.cjid AND cohortjaar.jaar=2021 AND cohortjaar.cid = {${'c'.$c['cid']}->cohortData['cid']} ORDER BY items.periode ASC,items.volgnr ASC";
        }
        
        $items = mysqli_query($DBverbinding, $sql);
        $toetsTypeLijst = ['tt'=>0,'mt'=>0,'lt'=>0,'hd'=>0,'po'=>0];
        while($i = mysqli_fetch_assoc($items)) {
            $algemeen = $i['algemeen'];
            //echo "<h5>{$i['id']} | {${'i'.$i['id']}->itemData['periode']} | {${'i'.$i['id']}->itemData['hulp']}</h5>";
            //MET domeimen array_push($data,[${'i'.$i['id']}->itemData['periode'],${'i'.$i['id']}->itemData['SOMcode'],${'i'.$i['id']}->itemData['wegingSE'],${'i'.$i['id']}->itemData['herkansbaar'],${'i'.$i['id']}->itemData['duur'],${'i'.$i['id']}->itemData['leerstofomschrijving'],${'i'.$i['id']}->itemData['domeinen'],$i['hulp']]);
            
            // tijdelijk voor testen
            // ${'i'.$i['id']}->itemData['SOMcode'] = ${'i'.$i['id']}->itemData['id'];
            if ($outputPTA) {
                // $this->tabelcelHeaders = array('per','SOM','weging','her','duur','stofomschrijving','hulpmiddelen');
                $toetsTypeLijst[${'i'.$i['id']}->itemData['afname']]++;
                $SOMcode = $filter['klasJaar'].${'i'.$i['id']}->itemData['afname'].$toetsTypeLijst[${'i'.$i['id']}->itemData['afname']];
                array_push($data,[${'i'.$i['id']}->itemData['periode'],${'i'.$i['id']}->itemData['afname'],$SOMcode,${'i'.$i['id']}->itemData['wegingSE'],${'i'.$i['id']}->itemData['herkansbaar'],${'i'.$i['id']}->itemData['duur'],${'i'.$i['id']}->itemData['leerstofomschrijving'],$i['hulp']]);
            }
            else {
                // $this->tabelcelHeaders = array('per','weging','her','duur','stofomschrijving','domeinen examen','hulpmiddelen');
                if ($laag=='M3' || $laag=='M4' || $laag=='H5' || $laag=='A6') {
                    $weging = ${'i'.$i['id']}->itemData['wegingSE'];
                }
                else {
                    $weging = ${'i'.$i['id']}->itemData['wegingVD'];
                }
                if (${'i'.$i['id']}->itemData['herkansbaar'] == 'kies...') {${'i'.$i['id']}->itemData['herkansbaar'] = null;}
                array_push($data,[${'i'.$i['id']}->itemData['periode'],${'i'.$i['id']}->itemData['afname'],$weging,${'i'.$i['id']}->itemData['herkansbaar'],${'i'.$i['id']}->itemData['duur'],${'i'.$i['id']}->itemData['leerstofomschrijving'],${'i'.$i['id']}->itemData['domeinen'],$i['hulp']]);
            }
        }
        if (mysqli_num_rows($items)) {$pdf->ptaJaarVak(${'c'.$c['cid']}->cohortData['vakNaam'],$data,$algemeen,$toonWatermerk,$outputPTA);}
    }

    $pdf->lastPage();
    $pdf->Output( $sFilePath , 'F');
   
    echo '<a href="'.$relatief.'" target="new">'.$filter['niveau'].$filter['klasJaar'].'</a> ';
}
?>