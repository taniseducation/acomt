<?PHP
// Deze is EENMALIG gebruikt voor inlezen uit bestaande Excel-files.
// voor nieuwe lege cohorten aanmaken => genereerNieuweCohorten.php
require('../../vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class MyReadFilter implements IReadFilter
{
    private $startRow = 0;
    private $endRow = 0;
    private $columns = [];
    public function __construct($startRow, $endRow, $columns)
    {
        $this->startRow = $startRow;
        $this->endRow = $endRow;
        $this->columns = $columns;
    }
    public function readCell($column, $row, $worksheetName = '')
    {
        if ($row >= $this->startRow && $row <= $this->endRow) {
            if (in_array($column, $this->columns)) {
                return true;
            }
        }
        return false;
    }
}

$filePath = 'fileExcel/';
$fileNAme = '_FAKEmastervoortest.xlsx';
$inputFileName = $filePath.$fileNAme;

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

$spreadsheet = $reader->load($inputFileName);
$loadedSheetNames = $spreadsheet->getSheetNames();

// verwijder instellingen, master en master zonder filter
array_shift($loadedSheetNames);
array_shift($loadedSheetNames);
array_shift($loadedSheetNames);

echo '<pre>';
//print_r($loadedSheetNames);
echo '</pre>';

$beginJaar=array('3M' => 2020,'4M' => 2019,'4H' => 2020,'5H' => 2019,'4A' => 2020,'5A' => 2019,'6A' => 2018);
echo '<pre>';
//print_r($beginJaar);
echo '</pre>';

/*
LET OP: de algemene omschrijving moet per leerjaar ook een plekje krijgen
Daarvoor maak ik een tabel met cohortjaren zodat ze per jaar schrijfbaar zijn
*/

foreach ($loadedSheetNames as $vakCode) {
    $spreadsheet->setActiveSheetIndexByName($vakCode);
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null,true,true,true);
    echo '<pre>';
    print_r($sheetData[1]['D']);
    echo '</pre>';
    // maak cohort aan LET OP: alleen KCKV heeft 3M maar niet langere sheet nog steeds 43
    for ($rij=2;$rij<=43;$rij++) {        
        if (($rij-2) % 7 == 0) {
            // check of cohort niet al bestaat
            $niveau = str_split($sheetData[$rij]['A']);
            $sql = "select * from cohorten where vakcode = {$sheetData[$rij]['B']} and beginJaar={$beginJaar[$sheetData[$rij]['A']]} and niveau='{$niveau[1]}'";
            $record = mysqli_query($DBverbinding, $sql);
            if (mysqli_num_rows($record) == 1) {
                $cohort = mysqli_fetch_assoc($record);
                //echo '<h3>cohort gevonden</h3>';
            }
            else {
                // bestaat nog niet dus toevoegen
                //echo '<h3>cohort toegevoegd</h3>';
                $sql = "INSERT INTO `cohorten` (`cid`, `vakcode`, `niveau`, `beginJaar`, `actief`, `edit`) VALUES (NULL, '{$sheetData[$rij]['B']}', '{$niveau[1]}', '{$beginJaar[$sheetData[$rij]['A']]}', 1, 1);";
                mysqli_query($DBverbinding, $sql);
                $sql = "select * from cohorten where vakcode = {$sheetData[$rij]['B']} and beginJaar={$beginJaar[$sheetData[$rij]['A']]} and niveau='{$niveau[1]}'";
                $record = mysqli_query($DBverbinding, $sql);
                $cohort = mysqli_fetch_assoc($record);
            }
            echo '<pre>';
            print_r($cohort);
            echo '</pre>';  
            // per cohort nu cohortjaren toevoegen
            /* gedaan dus uitgezet
            $sheetData[$rij+6]['H'] = utf8_encode($sheetData[$rij+6]['H']);
            $sql = "INSERT INTO `cohortjaar` (`cjid`, `cid`, `jaar`, `actief`, `edit`, `algemeen`) VALUES (NULL, '{$cohort['cid']}', '{$cohort['beginJaar']}', 1, 1, '{$sheetData[$rij+6]['H']}');";
            echo $sql.'<br>';
            mysqli_query($DBverbinding, $sql);
            $cohort['beginJaar']+=1;
            $sql = "INSERT INTO `cohortjaar` (`cjid`, `cid`, `jaar`, `actief`, `edit`, `algemeen`) VALUES (NULL, '{$cohort['cid']}', '{$cohort['beginJaar']}', 1, 1, 'null');";
            echo $sql.'<br>';
            mysqli_query($DBverbinding, $sql);   
            if ($cohort['niveau']=='A') {
                $cohort['beginJaar']+=1;
                $sql = "INSERT INTO `cohortjaar` (`cjid`, `cid`, `jaar`, `actief`, `edit`, `algemeen`) VALUES (NULL, '{$cohort['cid']}', '{$cohort['beginJaar']}', 1, 1, 'null');";
                echo $sql.'<br>';
                mysqli_query($DBverbinding, $sql); 
            }
            */
        }          
    }
    //die(); // eerst alleen voor Nwderlands
}
die();
// alles hieronder verwijderd. Eventueel in backup
?>