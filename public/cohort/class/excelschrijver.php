<?PHP
require('../../vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

echo "<h3>Wegschrijven database naar Excel</h3>";
$NfilesXLS = 0;

$unlock = false;
$alleenLezen = false;
$inFilePath = 'fileExcel/';
$inFileName = '_sjabloon_v4.xlsx';
if ($unlock && !$alleenLezen) {$inFileName = '_sjabloon_v4_UNLOCK.xlsx';}
$outFilePath = 'fileExcel/xlsxUIT/';
$inputFileName = $inFilePath.$inFileName;
$beveiliging = true;
$systeemKolommenOnzichbaar = true;
$nietRelevanteCohortjarenOnzichtbaar = true;

if ($unlock && !$alleenLezen) {
    echo "<hr><font style='color: red; font-size: 3.5em;'><b>LET OP</b> Files worden in open format weggeschreven.</font><br>";
    $beveiliging = false;
    $systeemKolommenOnzichbaar = false;
    $nietRelevanteCohortjarenOnzichtbaar = true;
    $outFilePath = $outFilePath.'OPEN/';
}

if ($alleenLezen) {
    echo "<hr><font style='color: red; font-size: 3.5em;'><b>LET OP</b> Files worden in ALLEEN LEZEN format weggeschreven.</font><br>";
    $beveiliging = true;
    $systeemKolommenOnzichbaar = true;
    $nietRelevanteCohortjarenOnzichtbaar = true;
    $outFilePath = $outFilePath.'LEZEN/';
}

if (!$systeemKolommenOnzichbaar) {$nietRelevanteCohortjarenOnzichtbaar = false;} // want anders vallen ze weg

for ($vakID = 1;$vakID <= 31;$vakID++) {
    if ($vakID == 29) {$vakID++;} // BV in database maar wordt niet gebruikt
    // if ($vakID != 2) {continue;};
    $NfilesXLS++;
    $filter['vid'] = $vakID;
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    // $reader->setReadDataOnly(true);
    // $reader->setLoadSheetsOnly(["wensen", "instellingen"]);
    // $reader->setLoadSheetsOnly(["sjabloon"]); // inschakelen filtert ook op hidden cells
    $spreadsheet = $reader->load($inputFileName);

    $spreadsheet->getProperties()
        ->setCreator("VNR@acomt")
        ->setLastModifiedBy("René van der Veen")
        ->setTitle("xlsx-pta-generator")
        ->setSubject("acomt pta cohorten")
        ->setDescription(
            "Dit bestand is eigendom van CSG Augustinus Groningen"
        )
        ->setKeywords("acomt pta cohorten")
        ->setCategory("internal usage only");

    $loadedSheetNames = $spreadsheet->getSheetNames();
    $spreadsheet->setActiveSheetIndexByName('sjabloon');


    //die();

    foreach ($tabbladen as $tabblad) {
        $filter['niveau'] = substr($tabblad, -5, 1);
        $filter['beginJaar'] = substr($tabblad, -4, 4);
        $naamTabblad = $filter['niveau'].' '.$filter['beginJaar'];
        // echo "{$filter['niveau']} {$filter['beginJaar']} met tabbladnaam $naamTabblad<br>";
        $clonedWorksheet = clone $spreadsheet->getSheetByName('sjabloon');
        $clonedWorksheet->setTitle($naamTabblad);
        $spreadsheet->addSheet($clonedWorksheet);
        $spreadsheet->setActiveSheetIndexByName($naamTabblad);

        // BEGIN beschrijven van één cohort-tabblad
        $filterCohort = selecteerCohort($filter,$DBverbinding); // in bruteforceDBread.php
        if ( $filterCohort != null) {
            $spreadsheet->getActiveSheet()->fromArray(${'c'.$filterCohort}->getB2B8($status),NULL,'B2');
            $spreadsheet->getActiveSheet()->fromArray(${'c'.$filterCohort}->getD6P11(),NULL,'D6');
            /* GENEREERT html-versie van ingelezen spread
                    $HTMLwriter = IOFactory::createWriter($spreadsheet, 'Html');
                    foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
                        echo "<h2>".$loadedSheetName."</h2>";
                        $spreadsheet->setActiveSheetIndexByName($loadedSheetName);
                        $HTMLwriter->setSheetIndex($spreadsheet->getActiveSheetIndex());
                        $message = $HTMLwriter->save('php://output');
                    }
            */        
            $XLSXwriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

            // kolom periode omzetten naar dropdown voor lege cellen
            $validation = $spreadsheet->getActiveSheet()->getCell('G6')->getDataValidation();
            $validation->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
            $validation->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
            $validation->setAllowBlank(false);
            $validation->setShowInputMessage(true);
            $validation->setShowErrorMessage(true);
            $validation->setShowDropDown(true);
            $validation->setErrorTitle('ERROR');
            $validation->setError('ongeldige waarde');
            $validation->setFormula1('instellingen!$G$2:$G$6');

            $pLijst = ['G7','G8','G9','G10','G11'];
            if (${'c'.$filterCohort}->cohortData['niveau'] != 'M' || 0 == 0) { // LUI: bij nader inzien ook voor mavo
                $pLijst=array_merge($pLijst,['G18','G19','G20','G21','G22','G23']);
            }
            if (${'c'.$filterCohort}->cohortData['niveau'] = 'A') {
                $pLijst=array_merge($pLijst,['G30','G31','G32','G33','G34','G35']);
            }
            foreach ($pLijst as $p) {
                $spreadsheet->getActiveSheet()->getCell($p)->setDataValidation(clone $validation);
            }

            // kolom soort toets omzetten naar dropdown voor lege cellen
            $validation = $spreadsheet->getActiveSheet()->getCell('J6')->getDataValidation();
            $validation->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
            $validation->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
            $validation->setAllowBlank(false);
            $validation->setShowInputMessage(true);
            $validation->setShowErrorMessage(true);
            $validation->setShowDropDown(true);
            $validation->setErrorTitle('ERROR');
            $validation->setError('ongeldige waarde');
            $validation->setFormula1('instellingen!$H$2:$H$7');

            $tLijst = ['J7','J8','J9','J10','J11'];
            if (${'c'.$filterCohort}->cohortData['niveau'] != 'M') {
                $tLijst=array_merge($tLijst,['J18','J19','J20','J21','J22','J23']);
            }
            if (${'c'.$filterCohort}->cohortData['niveau'] = 'A') {
                $tLijst=array_merge($tLijst,['J30','J31','J32','J33','J34','J35']);
            }
            foreach ($tLijst as $p) {
                $spreadsheet->getActiveSheet()->getCell($p)->setDataValidation(clone $validation);
            }

            // kolom soort SE en herkansbaar omzetten naar dropdown voor lege cellen
            $validation = $spreadsheet->getActiveSheet()->getCell('M6')->getDataValidation();
            $validation->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
            $validation->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
            $validation->setAllowBlank(false);
            $validation->setShowInputMessage(true);
            $validation->setShowErrorMessage(true);
            $validation->setShowDropDown(true);
            $validation->setErrorTitle('ERROR');
            $validation->setError('ongeldige waarde');
            $validation->setFormula1('instellingen!$I$2:$I$4');

            $sLijst = ['M7','M8','M9','M10','M11'];
            $sLijst = array_merge($sLijst,['O6','O7','O8','O9','O10','O11']);
            if (${'c'.$filterCohort}->cohortData['niveau'] != 'M') {
                $sLijst=array_merge($sLijst,['M18','M19','M20','M21','M22','M23']);
                $sLijst=array_merge($sLijst,['O18','O19','O20','O21','O22','O23']);
            }
            if (${'c'.$filterCohort}->cohortData['niveau'] = 'A') {
                $sLijst=array_merge($sLijst,['M30','M31','M32','M33','M34','M35']);
                $sLijst=array_merge($sLijst,['O30','O31','O32','O33','O34','O35']);
            }
            foreach ($sLijst as $p) {
                $spreadsheet->getActiveSheet()->getCell($p)->setDataValidation(clone $validation);
            }
        }
        // klaar met beschrijven worksheet: nu opmaak en verbergen cellen
        // doublecheck: haal waarden uit Excel en niet uit code
        $vid = $spreadsheet->getActiveSheet()->getCell('B5');
        $niveau = $spreadsheet->getActiveSheet()->getCell('B6');
        $positiePTA = $spreadsheet->getActiveSheet()->getCell('B13')->getCalculatedValue();
        $cid = $spreadsheet->getActiveSheet()->getCell('B8')->getCalculatedValue();
      
        // locken van beschermde cellen
        // tactiek: eerst alles blokken en dan op maat weer openzetten
        if ($beveiliging) {
            for ($k = 'F'; $k <= 'Q'; $k++) {
                for ($r = 1; $r <= 38; $r++) {
                    $spreadsheet->getActiveSheet()->getStyle("$k$r")->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);
                }
            }
            if (!$alleenLezen) {
                if ($niveau == 'A' && $positiePTA == -1) {
                    for ($k = 'G'; $k <= 'P'; $k++) {
                        for ($r = 30; $r <= 38; $r++) {
                            if (!($r == 36 || $r == 37)) {
                                $spreadsheet->getActiveSheet()->getStyle("$k$r")->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                            }
                        }
                    }
                }
                if ($positiePTA == 0 && $vid != '28') {
                    for ($k = 'G'; $k <= 'P'; $k++) {
                        for ($r = 18; $r <= 26; $r++) {
                            if (!($r == 24 || $r == 25)) {
                                $spreadsheet->getActiveSheet()->getStyle("$k$r")->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                            }
                        }
                    }
                }
                if ($positiePTA == 1) {
                    for ($k = 'G'; $k <= 'P'; $k++) {
                        for ($r = 6; $r <= 14; $r++) {
                            if (!($r == 12 || $r == 13)) {
                                $spreadsheet->getActiveSheet()->getStyle("$k$r")->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                            }
                        }
                    }
                }
            }                          
        }
  
        // rijen onzichtbaar
        if ($nietRelevanteCohortjarenOnzichtbaar) {
            if ($niveau == 'M' && $vid != '28') { // 28 is KCKV die heeft als enige juist alleen in M3
                for ($r = 3; $r <= 15; $r++) {
                    $spreadsheet->getActiveSheet()->getRowDimension($r)->setVisible(false);
                }
            }            
            if ($niveau != 'A') {
                for ($r = 28; $r <= 38; $r++) {
                    $spreadsheet->getActiveSheet()->getRowDimension($r)->setVisible(false);
                }
            }         
        }

        // systeemkolommen onzichtbaar
        if ($systeemKolommenOnzichbaar) {
            for ($k = 'A'; $k <= 'E'; $k++) {
                $spreadsheet->getActiveSheet()->getColumnDimension($k)->setVisible(false);
            }
            for ($k = 'R'; $k <= 'Y'; $k++) {
                $spreadsheet->getActiveSheet()->getColumnDimension($k)->setVisible(false);
            }    
            $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setVisible(false);
            $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setVisible(false);
            $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setVisible(false);
            $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setVisible(false);
            $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setVisible(false);
            $spreadsheet->getActiveSheet()->getColumnDimension('AE')->setVisible(false);
            $spreadsheet->getActiveSheet()->getColumnDimension('AF')->setVisible(false);
        }
        $spreadsheet->getActiveSheet()->getCell('G1')->setValue('*'); // hack om cursor boven te krijgen
    } // EINDE beschrijven van één cohort-tabblad

    $spreadsheet->setActiveSheetIndex(1);
    $sheetIndex = $spreadsheet->getIndex($spreadsheet->getSheetByName('sjabloon'));
    $spreadsheet->removeSheetByIndex($sheetIndex);
    // $tabbladen = ['M2021','M2020','M2019','H2021','H2020','H2019','A2021','A2020','A2019','A2018'];
    // 1 is bewaren 0 is verwijderen
    $removeLijst = str_split(${'c'.$filterCohort}->cohortData['removeTab']);
    for ($b = 0; $b < 10; $b++) {
        if ($removeLijst[$b] == 1) {
            // echo "$b Bewaar tabblad {$tabbladen[$b]}<br>";
        }
        else {
            //echo "$b WEG MET tabblad {$tabbladen[$b]}<br>";
            $nv = substr($tabbladen[$b], -5, 1);
            $bj = substr($tabbladen[$b], -4, 4);
            $tbHelper = $nv.' '.$bj;
            $sheetIndex = $spreadsheet->getIndex($spreadsheet->getSheetByName($tbHelper));
            $spreadsheet->removeSheetByIndex($sheetIndex);            
        }
    }

    $outFileName = ${'c'.$filterCohort}->cohortData['vakCode'].' PTA en onderwijsprogramma.xlsx';
    if ($unlock && !$alleenLezen) {
        $outFileName = ${'c'.$filterCohort}->cohortData['vakCode'].'_OPEN.xlsx';
    }
    if ($alleenLezen) {
        $outFileName = 'PTA_'.${'c'.$filterCohort}->cohortData['vakCode'].'_ALLEEN_LEZEN.xlsx';
    }    
    $outputFileName = $outFilePath.$outFileName;
    echo '<a href="'.$outputFileName.'" target="_NEW">'.$outFileName.'</a><br>';
    $XLSXwriter->save($outputFileName);
    $spreadsheet->disconnectWorksheets();
    unset($spreadsheet);
    unset($reader);
    unset($XLSXwriter);
    // die('alleen 1x voor testen'); // één bestand voor testen
}
echo "Er zijn $NfilesXLS excel-bestanden weggeschreven.";
?>