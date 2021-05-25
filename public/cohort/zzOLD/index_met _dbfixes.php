<!DOCTYPE html>
<html>
    <head>
        <title>cohort</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="css/stijl.css">
    </head>
    <body>
        <div id="PHPoutput">

<?PHP
require('main.php');

// require('class/maak_items_in_db.php');

// require('class/excellezer.php');
// require('class/excelschrijver.php');

/* fiks verkeerde vakcodes per cohort
$sql = "SELECT * FROM vakken";
$records = mysqli_query($DBverbinding, $sql);
while($vak = mysqli_fetch_assoc($records)) {
    $sql = "UPDATE `cohorten` SET `vid` = '{$vak['vid']}' WHERE `cohorten`.`vid` = {$vak['volgorde']};";
    mysqli_query($DBverbinding, $sql);
}
echo '<pre>';
print_r($sql);
echo '<pre>';
*/


/* fiks algemene opmerking bij verkeerd cohortjaar
$sql = "SELECT * FROM vakken";
$records = mysqli_query($DBverbinding, $sql);
while($vak = mysqli_fetch_assoc($records)) {
    $sql = "SELECT * FROM cohorten WHERE vid='{$vak['vid']}' AND niveau = 'M' AND beginJaar < 2020 ORDER BY beginJaar DESC";
    //echo $sql.'<br>';
    $cohorten = mysqli_query($DBverbinding, $sql);
    while($cohort = mysqli_fetch_assoc($cohorten)) {
        $algTekst = [];
        $sql = "SELECT * FROM cohortjaar WHERE cid='{$cohort['cid']}' ORDER BY jaar ASC";
        $jaren = mysqli_query($DBverbinding, $sql);
        $registreren = true;
        $deljaar = null;
        while($jaar = mysqli_fetch_assoc($jaren)) {
            if ($registreren) {
                $tekst = $jaar['algemeen'];
                $registreren = false;
                $sql = "UPDATE `cohortjaar` SET `algemeen` = NULL WHERE `cohortjaar`.`cjid` = {$jaar['cjid']};";
                echo 'registreer '.utf8_decode($tekst).' met '.$sql.'<br>';
            }
            else {
                $sql = "UPDATE `cohortjaar` SET `algemeen` = '$tekst' WHERE `cohortjaar`.`cjid` = {$jaar['cjid']};";
                echo 'update met '.$sql.'<br>';                
            }
            mysqli_query($DBverbinding, $sql);

        echo '<pre>';
        //print_r($jaar);
        echo '<pre>';
        //die();
        }  
        //$jaren = mysqli_query($DBverbinding, $sql);


        // gooi hier als 2020 de alg tekst in en update voor 2018 en 2019

    }

    //die();

    //$sql = "UPDATE `cohorten` SET `vid` = '{$vak['vid']}' WHERE `cohorten`.`vid` = {$vak['volgorde']};";
    // mysqli_query($DBverbinding, $sql);
}
*/

?>

        </div>
        <div id="notes">
            none
        </div>
    </body>
</html>
