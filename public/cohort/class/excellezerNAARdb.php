<?PHP
require('../../vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$inFilePath = 'fileExcel/xlsxIN/';

echo '<h1>inlezen aangepaste Excel-files en wegschrijven naar DB<br>WERK TIJDELIJK IN ECHTE KOPIE DB ipv steeds terugzetten</h1>';

// haal vakken op uit database voor bestandsnamen
$sql = "SELECT * FROM vakken";
$vakken= mysqli_query($DBverbinding, $sql);
while($vak = mysqli_fetch_assoc($vakken)) {    
    if ($vak['vid'] == 29) {continue;} // BV in database maar wordt niet gebruikt
    if ($vak['vid'] != 14) {continue;} // eerst even informatica
    $inFileName = "{$vak['vakCode']} PTA en onderwijsprogramma.xlsx";
    $inputFileName = $inFilePath.$inFileName;    
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
        if ($naamTabblad != 'A 2021') {continue;}
        echo "<h3>$naamTabblad</h3>";
        $spreadsheet->setActiveSheetIndexByName($naamTabblad);
        $vid = $spreadsheet->getActiveSheet()->getCell('B5');
        $niveau = $spreadsheet->getActiveSheet()->getCell('B6');
        $positiePTA = $spreadsheet->getActiveSheet()->getCell('B13')->getCalculatedValue();
        $cid = $spreadsheet->getActiveSheet()->getCell('B8')->getCalculatedValue();
        echo "<h2>Dit is het vak $vid voor $niveau met cid = $cid</h2>";
        $cjidLijst = [$spreadsheet->getActiveSheet()->getCell('D13')->getCalculatedValue(),$spreadsheet->getActiveSheet()->getCell('D25')->getCalculatedValue()];
        if ($niveau == 'A') array_push($cjidLijst,$spreadsheet->getActiveSheet()->getCell('D37')->getCalculatedValue());
        // gewetensvraag: gaan we nu alles spiegelen met de database of alleen dat wat schrijfrecht had
        // => kan op zich relatief snel met de bruteforce import die al is gedaan, toch?
        // !! vergeet niet de algemene opmerkingen per cohortjaar

        // als er wel een leerstofomscrijving maar nog geen id is => item aanmaken
        // anders vergelijken met wat je al hebt

        for ($nr=0;$nr<count($cjidLijst);$nr++) {
            // echo "<h3>{$cjidLijst[$nr]}</h3>";
            if ($nr == 0) {$dataArray = $spreadsheet->getActiveSheet()->rangeToArray('D6:P11',NULL,TRUE,TRUE,TRUE);}
            if ($nr == 1) {$dataArray = $spreadsheet->getActiveSheet()->rangeToArray('D18:P23',NULL,TRUE,TRUE,TRUE);}
            if ($nr == 2) {$dataArray = $spreadsheet->getActiveSheet()->rangeToArray('D30:P35',NULL,TRUE,TRUE,TRUE);}
            foreach ($dataArray as $item) {
                if ($item['D'] == null) {
                    // geen itemnummer: als er wel iets is opgeschreven moet er een INSERT komen
                    if ($item['H'] != null) {
                        echo '[1] wel een item ('.$item['H'].'), nog geen itemnummer<br>';
                    }
                    else {
                        echo '[2] GEEN itemnummer<br>';
                    }
                }
                else {
                    // wel itemnummer: als er geen inhoud is moet het item DELETE en anders een UPDATE
                    if ($item['H'] == null) {
                        // geen item meer DELETE of zet actief op FALSE: wat doen we?
                        echo '[3] WEL itemnummer, maar geen inhoud meer of weggehaald<br>';
                    }
                    else {
                        // er is content: is het eigenlijk wel nodig om te chechen op identiek? DOE HET WEL voor formatcheck
                        // sowieso bestaande code gebruiken voor schrijven naar db
                        echo '[4] WEL itemnummer, en nog steeds inhoud<br>';
                        if(!${'i'.$item['D']}->dbExcelIdentiek($item)) {
                            // er is verschil geconstateerd
                        } 
                        echo '<pre>';
                        print_r(${'i'.$item['D']}->itemData);
                        echo '</pre>';                                       
                    }
                }
                continue;
                // hier moet nog check voor of er wel een itemnummer is!

                echo "<h3>content db van item: {$item['D']} (cjid {$cjidLijst[$nr]})</h3>";
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
        die('die: één tabblad');
    }
    $spreadsheet->disconnectWorksheets();
    unset($spreadsheet);
    unset($reader);
    die('die: één excelfile'); // één excelfile / één vak
}
?>