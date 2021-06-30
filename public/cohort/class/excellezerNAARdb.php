<?PHP
require('../../vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$inFilePath = 'fileExcel/xlsxIN/';
$outFilePath = 'fileExcel/xlsxIN/afgehandeld/';
$queriesUitvoeren = true;
$Nfouten = 0;
if ($queriesUitvoeren) {
    echo "<hr><font style='color: darkgreen; font-size: 3.5em;'><b>LET OP</b> update-queries worden WEL uitgevoerd.</font><br>";
}
else {
    echo "<hr><font style='color: red; font-size: 3.5em;'><b>LET OP</b> update-queries worden NIET uitgevoerd.</font><br>";
}

echo "<h3>Inlezen Excel naar database</h3>";
$Nfiles = 0;

// haal vakken op uit database voor bestandsnamen
$sql = "SELECT * FROM vakken";
$vakken= mysqli_query($DBverbinding, $sql);
while($vak = mysqli_fetch_assoc($vakken)) {    
    if ($vak['vid'] == 29) {continue;} // BV in database maar wordt niet gebruikt
    //if ($vak['vid'] != 14) {continue;} // eerst even informatica
    $inFileName = "{$vak['vakCode']} PTA en onderwijsprogramma.xlsx";
    $inputFileName = $inFilePath.$inFileName;
    if (!file_exists($inputFileName)) {continue;} else {$Nfiles++;}
    $outputFileName = $outFilePath.$inFileName.' ('.date_timestamp_get($timestamp).')';
    echo "<h2>{$vak['vid']} {$vak['vakNaam']} => $inputFileName</h2>";
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $reader->setReadDataOnly(true);
    $spreadsheet = $reader->load($inputFileName);
    $loadedSheetNames = $spreadsheet->getSheetNames();
    array_shift($loadedSheetNames); // gooi settings ...
    array_shift($loadedSheetNames); // en instructie weg
    foreach ($tabbladen as $tabblad) {
        $naamTabblad = substr($tabblad,0,-4).' '.substr($tabblad,1,4);
        // check of het tabblad voor dit vak bestaat
        if (!in_array($naamTabblad,$loadedSheetNames)) {continue;}
        // if ($naamTabblad != 'A 2021') {continue;}
        echo "<h3>$naamTabblad</h3>";
        $spreadsheet->setActiveSheetIndexByName($naamTabblad);
        $vid = $spreadsheet->getActiveSheet()->getCell('B5');
        $niveau = $spreadsheet->getActiveSheet()->getCell('B6');
        $positiePTA = $spreadsheet->getActiveSheet()->getCell('B13')->getCalculatedValue();
        $cid = $spreadsheet->getActiveSheet()->getCell('B8')->getCalculatedValue();
        echo "<h2>Dit is het vak $vid voor $niveau met cid = $cid</h2>";
        $cjidLijst = [$spreadsheet->getActiveSheet()->getCell('D13')->getCalculatedValue(),$spreadsheet->getActiveSheet()->getCell('D25')->getCalculatedValue()];
        // $opmLijst = [utf8_encode(addslashes($spreadsheet->getActiveSheet()->getCell('G14')->getCalculatedValue())),utf8_encode(addslashes($spreadsheet->getActiveSheet()->getCell('G26')->getCalculatedValue()))];
        $opmLijst = [mysqli_real_escape_string($DBverbinding,$spreadsheet->getActiveSheet()->getCell('G14')->getCalculatedValue()),mysqli_real_escape_string($DBverbinding,$spreadsheet->getActiveSheet()->getCell('G26')->getCalculatedValue())];
        if ($niveau == 'A') {
            array_push($cjidLijst,$spreadsheet->getActiveSheet()->getCell('D37')->getCalculatedValue());
            array_push($opmLijst,mysqli_real_escape_string($DBverbinding,$spreadsheet->getActiveSheet()->getCell('G38')->getCalculatedValue()));
        }
        // !! vergeet niet de algemene opmerkingen per cohortjaar
        
        for ($nr=0;$nr<count($cjidLijst);$nr++) {
            if ($nr == 0) {$dataArray = $spreadsheet->getActiveSheet()->rangeToArray('D6:P11',NULL,TRUE,TRUE,TRUE);}
            if ($nr == 1) {$dataArray = $spreadsheet->getActiveSheet()->rangeToArray('D18:P23',NULL,TRUE,TRUE,TRUE);}
            if ($nr == 2) {$dataArray = $spreadsheet->getActiveSheet()->rangeToArray('D30:P35',NULL,TRUE,TRUE,TRUE);}
            $sql = "UPDATE `cohortjaar` SET `algemeen` = '{$opmLijst[$nr]}' WHERE `cohortjaar`.`cjid` = {$cjidLijst[$nr]};";
            echo "<h1>$sql</h1>";
            if (!mysqli_query($DBverbinding,$sql)) {
                $Nfouten++;
                echo("FATALE FOUT <b>$Nfouten </b>: " . mysqli_error($DBverbinding));
                echo "<h5>{$sql}</h5>algemene opmerking $volgnummer<br>";
                die('[0]');
            }

            $volgnummer = 7; // voor nieuwe items; dan geen voorgegenereerd volgnummer 
            foreach ($dataArray as $item) {
                // SOWIESO ALLES OMZETTEN, of je het gebruikt of niet
                    $item['H'] = mysqli_real_escape_string($DBverbinding,$item['H']);
                    $item['K'] = mysqli_real_escape_string($DBverbinding,$item['K']);
                    $item['P'] = mysqli_real_escape_string($DBverbinding,$item['P']);
                    if ($item['I'] == 0) {$item['I'] = 'NULL';} // wegingVD
                    if ($item['K'] == '0') {$item['K'] = null;}
                    if ($item['L'] == 0) {$item['L'] = 'NULL';} // duur
                    if ($item['M'] == '0') {$item['M'] = 'NULL';}
                    if ($item['N'] == 0 || $item['N']== null) {$item['N'] = 'NULL';} // wegingSE
                    if ($item['P'] == '0') {$item['P'] = null;}
                    if ($item['M'] == 'ja') {$item['M'] = 1;}
                    if ($item['M'] == 'nee') {$item['M'] = 0; $item['O'] = 'NULL';}
                    // if ($item['O'] == 'kies...') {$item['O'] = 'NULL';}
                    if ($item['O'] == 'ja') {$item['O'] = '1';}
                    if ($item['O'] == 'nee') {$item['O'] = '0';} // herkansbaarheid                   
                    if ($item['J'] == 'tt' && $item['M'] == 1) {$inTW = 1;} else {$inTW = 0;}
                // / SOWIESO ALLES OMZETTEN, of je het gebruikt of niet
                
                if ($item['D'] == null) {
                    // geen itemnummer: als er wel iets is opgeschreven moet er een INSERT komen
                    if ($item['H'] != null) {
                        echo '[1] <b>XXXX</b> wel een item ('.$item['H'].'), nog geen itemnummer<br>';
                        $volgnummer++;
                        $sql = "INSERT INTO `items` (`id`, `cid`, `cjid`, `volgnr`, `periode`, `SOMcode`, `leerstofomschrijving`, `wegingVD`, `afname`, `hulp`, `duur`, `SE`, `wegingSE`, `herkansbaar`, `domeinen`, `datumAfname`, `opmerkingAfname`, `inTW`, `internRooster`, `intern`) 
                        VALUES (NULL, $cid, {$cjidLijst[$nr]}, {$volgnummer}, {$item['G']}, NULL, '{$item['H']}', {$item['I']}, '{$item['J']}', '{$item['K']}', {$item['L']}, {$item['M']}, {$item['N']}, {$item['O']}, '{$item['P']}', NULL, NULL, NULL, NULL, NULL);";
                        // echo "<h1>$sql</h1>";
                        if (!$queriesUitvoeren) {continue;}
                        if (!mysqli_query($DBverbinding,$sql)) {
                            $Nfouten++;
                            echo("FATALE FOUT <b>$Nfouten </b>: " . mysqli_error($DBverbinding));
                            echo "<h5>{$sql}</h5>Nieuw item met volgnummer $volgnummer<br>";
                            die('[1]');
                        }
                    }
                    else {
                        echo '[2] GEEN itemnummer, maar ook geen item<br>';
                    }
                }
                else {
                    // wel itemnummer: als er geen inhoud is moet het item DELETE en anders een UPDATE
                    if ($item['H'] == null) {
                        // geen item meer DELETE of zet actief op FALSE: wat doen we?
                        echo '[3] WEL itemnummer ('.$item['D'].'), maar geen inhoud meer of weggehaald<br>';
                        $sql = "DELETE FROM `items` WHERE `items`.`id` = {$item['D']}";
                        echo "<hr><font style='color: indianred; font-size: 4em;'>[3] {$item['D']} verwijderd</font><br>";
                        if (!$queriesUitvoeren) {continue;}
                        if (!mysqli_query($DBverbinding,$sql)) {
                            $Nfouten++;
                            echo("FATALE FOUT <b>$Nfouten </b>: " . mysqli_error($DBverbinding));
                            echo "<h5>{$sql}</h5>";
                            die('[3]');
                        }
                    }
                    else {
                        // er is content: is het eigenlijk wel nodig om te chechen op identiek? DOE HET WEL voor formatcheck
                        // sowieso bestaande code gebruiken voor schrijven naar db
                        echo '[4] WEL itemnummer ('.$item['D'].'), en nog steeds inhoud<br>';
                        if(!${'i'.$item['D']}->dbExcelIdentiek($item)) {
                            // er is verschil geconstateerd
                            $sql = "DELETE FROM `items` WHERE `id`= {$item['D']};";
                            echo "<hr><font style='color: red; font-size: 4em;'>[4A] {$item['D']} verwijderd</font><br>";
                            if (!mysqli_query($DBverbinding,$sql)) {
                                $Nfouten++;
                                echo("FATALE FOUT <b>$Nfouten </b>: " . mysqli_error($DBverbinding));
                                echo "<h5>{$sql}</h5>";
                                die('[4A]');
                            }                            
                            $sql = "INSERT INTO `items` (`id`, `cid`, `cjid`, `volgnr`, `periode`, `SOMcode`, `leerstofomschrijving`, `wegingVD`, `afname`, `hulp`, `duur`, `SE`, `wegingSE`, `herkansbaar`, `domeinen`, `datumAfname`, `opmerkingAfname`, `inTW`, `internRooster`, `intern`) 
                        VALUES ({$item['D']}, $cid, {$cjidLijst[$nr]}, {$volgnummer}, {$item['G']}, NULL, '{$item['H']}', {$item['I']}, '{$item['J']}', '{$item['K']}', {$item['L']}, {$item['M']}, {$item['N']}, {$item['O']}, '{$item['P']}', NULL, NULL, NULL, NULL, NULL);";
                            // echo "$sql <br>";
                            if (!$queriesUitvoeren) {continue;}
                            // echo "<hr><font style='color: indianred; font-size: 4em;'>AAN HET POMPEN.</font><br>";
                            if (!mysqli_query($DBverbinding,$sql)) {
                                $Nfouten++;
                                echo("FATALE FOUT <b>$Nfouten </b>: " . mysqli_error($DBverbinding));
                                echo "<h5>{$sql}</h5>";
                                die('[4B]');
                            }
                        }
                        else {
                            echo '[5] maar GEEN VERSCHIL dus geen actie nodig<br>';
                        }
                        /*
                        echo '<pre>';
                        print_r(${'i'.$item['D']}->itemData);
                        echo '</pre>';                                       
                        */
                    }
                }
                continue;
                /*
                echo '<pre>';
                print_r(${'i'.$item['D']}->itemData);
                echo '</pre>';        
                echo "<h1>content <b>EXCEL</b> van item: {$item['D']} (cjid {$cjidLijst[$nr]})</h3>";
                echo '<pre>';
                print_r($item);
                echo '</pre>';       
                */                   
                // die('die: eerst één item');
            }
            echo '<pre>';
            //print_r($dataArray);
            echo '</pre>';
            // die('die: eerst één cohortjaar');
        }
        // die('die: één tabblad');
    }
    $spreadsheet->disconnectWorksheets();
    unset($spreadsheet);
    unset($reader);
    rename($inputFileName,$outputFileName);
    // die('die: één excelfile'); // één excelfile / één vak
}
echo "Er zijn $Nfiles excel-bestanden ingelezen.";
?>