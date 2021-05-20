<?PHP
require('../../vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

$filePath = 'fileExcel/';
$fileNAme = '_FAKEmastervoortest.xlsx';
$fileNAme = '_master PTAB.xlsx';
$inputFileName = $filePath.$fileNAme;

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

$spreadsheet = $reader->load($inputFileName);
$loadedSheetNames = $spreadsheet->getSheetNames();

// verwijder instellingen, master en master zonder filter
array_shift($loadedSheetNames);
array_shift($loadedSheetNames);
array_shift($loadedSheetNames);

$beginJaar=array('3M' => 2020,'4M' => 2019,'4H' => 2020,'5H' => 2019,'4A' => 2020,'5A' => 2019,'6A' => 2018);

function getVolgorde($DBverbinding) {
    $sql = "SELECT vid,volgorde FROM vakken";
    $records = mysqli_query($DBverbinding, $sql);
    $lijst = [];
    if (mysqli_num_rows($records) > 0) {
        while($vak = mysqli_fetch_assoc($records)) {
            $lijst[$vak['volgorde']]=$vak['vid'];
        }
    }
    return $lijst;
}

$volgordeLijst = getVolgorde($DBverbinding);
echo '<pre>';
// print_r($volgordeLijst);
echo '</pre>';
$Nfouten = 0;
foreach ($loadedSheetNames as $vakCode) {
    $spreadsheet->setActiveSheetIndexByName($vakCode);
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null,true,true,true);
    for ($rij=2;$rij<=43;$rij++) {        
        if (($rij-2) % 7 == 0) {
            $niveau = str_split($sheetData[$rij]['A']);
            $test = "{$volgordeLijst[$sheetData[$rij]['B']]}";
            //echo "<h2>$test</h2>";
            $sql = "select * from cohorten where vid = {$volgordeLijst[$sheetData[$rij]['B']]} and beginJaar={$beginJaar[$sheetData[$rij]['A']]} and niveau='{$niveau[1]}'";
            $record = mysqli_query($DBverbinding, $sql);
            if (mysqli_num_rows($record) == 1) {
                $cohort = mysqli_fetch_assoc($record);
            }
            else {
                echo '<h3>'.$sql.'<br>Fatale fout. '.$sheetData[$rij]['B'].' '.$sheetData[$rij]['C'].'</h3>';
                die();
            }
            $sql = "SELECT * FROM `cohortjaar` WHERE cid={$cohort['cid']} and jaar = 2020";
            $record = mysqli_query($DBverbinding, $sql);
            $cohortJaar = mysqli_fetch_assoc($record);
            // echo "<h3>$sql</h3>";
            for ($n=$rij; $n<$rij+6;$n++) {
                // deze werkt $sql = "INSERT INTO `items` (`id`, `cid`, `cjid`, `volgnr`, `periode`, `SOMcode`, `leerstofomschrijving`, `wegingVD`, `afname`, `hulp`, `duur`, `SE`, `wegingSE`, `herkansbaar`, `domeinen`, `datumAfname`, `opmerkingAfname`, `inTW`, `internRooster`, `intern`) VALUES (NULL, {$cohort['cid']}, {$cohortJaar['cjid']}, {$sheetData[$n]['E']}, {$sheetData[$n]['F']}, '{$sheetData[$n]['G']}', '{$sheetData[$n]['H']}', {$sheetData[$n]['I']}, '{$sheetData[$n]['J']}', '{$sheetData[$n]['K']}', {$sheetData[$n]['L']}, 1, {$sheetData[$n]['N']}, 0, '{$sheetData[$n]['P']}', NULL, '{$sheetData[$n]['R']}', 1, NULL, NULL);";
                /* nog aanpakken
                    v SOMcode => Keuze om te updaten bij Genereren Excel.
                    v alles UTF_encode HKPR
                    > https://www.toptal.com/php/a-utf-8-primer-for-php-and-mysql
                    boolean-velden Ja Nee naar 1 0 MO
                    logisch in TW defaultwaarde als SE tt
                */

                // check of het item wel gevuld is:
                if ($sheetData[$n]['H'] != '0') {
                    $sheetData[$n]['H'] = utf8_encode(addslashes($sheetData[$n]['H']));
                    $sheetData[$n]['K'] = utf8_encode(addslashes($sheetData[$n]['K']));
                    $sheetData[$n]['P'] = utf8_encode(addslashes($sheetData[$n]['P']));
                    $sheetData[$n]['R'] = utf8_encode(addslashes($sheetData[$n]['R']));
                    echo 'vooraf '.$sheetData[$n]['M'].' | ';
                    if ($sheetData[$n]['I'] == 0) {$sheetData[$n]['I'] = 'NULL';} // wegingVD
                    if ($sheetData[$n]['K'] == 0) {$sheetData[$n]['K'] = null;}
                    if ($sheetData[$n]['L'] == 0) {$sheetData[$n]['L'] = 'NULL';} // duur
                    if ($sheetData[$n]['M'] == '0') {$sheetData[$n]['M'] = null;}
                    echo 'tussendoor *'.$sheetData[$n]['M'].'* ';
                    if ($sheetData[$n]['N'] == 0) {$sheetData[$n]['N'] = 'NULL';} // wegingSE
                    if ($sheetData[$n]['O'] == 0) {$sheetData[$n]['O'] = null;}
                    if ($sheetData[$n]['P'] == 0) {$sheetData[$n]['P'] = null;}
                    
                    if ($sheetData[$n]['M'] == 'Ja') {$sheetData[$n]['M'] = 1;}
                    if ($sheetData[$n]['M'] == 'Nee') {$sheetData[$n]['M'] = 0;}
                    if ($sheetData[$n]['O'] == 'Ja') {$sheetData[$n]['O'] = 1;}
                    if ($sheetData[$n]['O'] == 'Nee') {$sheetData[$n]['O'] = 0;}
                    echo 'achteraf '.$sheetData[$n]['M'].'<br>';
                    if ($sheetData[$n]['J'] == 'tt' && $sheetData[$n]['M'] == 1) {$inTW = 1;} else {$inTW = 0;}
                    $sql = "INSERT INTO `items` (`id`, `cid`, `cjid`, `volgnr`, `periode`, `SOMcode`, `leerstofomschrijving`, `wegingVD`, `afname`, `hulp`, `duur`, `SE`, `wegingSE`, `herkansbaar`, `domeinen`, `datumAfname`, `opmerkingAfname`, `inTW`, `internRooster`, `intern`) VALUES (NULL, {$cohort['cid']}, {$cohortJaar['cjid']}, {$sheetData[$n]['E']}, {$sheetData[$n]['F']}, NULL, '{$sheetData[$n]['H']}', {$sheetData[$n]['I']}, '{$sheetData[$n]['J']}', '{$sheetData[$n]['K']}', {$sheetData[$n]['L']}, 1, {$sheetData[$n]['N']}, 0, '{$sheetData[$n]['P']}', NULL, '{$sheetData[$n]['R']}', $inTW, NULL, NULL);";
                    // echo "<h4>{$sheetData[$n]['H']}</h4>";
                    
                    // UIT voor dubbelingen mysqli_query($DBverbinding, $sql);
                    // onderstaande if voert de query al uit
                    if (!mysqli_query($DBverbinding,$sql)) {
                        $Nfouten++;
                        echo("FATALE FOUT <b>$Nfouten </b>: " . mysqli_error($DBverbinding));
                        echo "<h5>{$sql}</h5>";
                        //die();
                    }
                }
                else {
                    // echo "Geen item voor {$cohort['cid']} met {$cohortJaar['cjid']}<br>";
                }
            }
        } 
    }
    // die(); // eerst alleen voor Nederlands
}

?>