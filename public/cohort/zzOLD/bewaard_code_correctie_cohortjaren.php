<?PHP
// opzoeken foute cohortjaren

$lijstcid = [];
$Nfouten = 0;
$sql = "select cohorten.cid,cjid,beginJaar,jaar from cohorten,cohortjaar where cohorten.cid = cohortjaar.cid";
$results = mysqli_query($DBverbinding, $sql);
if (mysqli_error($DBverbinding)) {
    echo("<h2>dbCheck:<br>".mysqli_error($DBverbinding)."</h2>$sql");
}
else {
    while($result = mysqli_fetch_assoc($results)) {
        //echo "<h2>{$result['cid']}</h2>";
        if ($result['cid'] != $lijstcid[count($lijstcid)-1]) {
            array_push($lijstcid,$result);
        }
    }

    for ($l=0;$l<count($lijstcid);$l++) {
        $sql = "SELECT * FROM `cohortjaar` WHERE cid = {$lijstcid[$l]['cid']} order by jaar ASC LIMIT 1";
        $jaren = mysqli_query($DBverbinding, $sql);
        if (mysqli_num_rows($jaren) > 0) {
            while($jaar = mysqli_fetch_assoc($jaren)) {
                if ($lijstcid[$l]['beginJaar'] != $jaar['jaar']) {
                    $Nfouten++;
                    echo "<h4>($Nfouten) cid {$jaar['cid']} | cjid {$jaar['cjid']} | beginjaar {$lijstcid[$l]['beginJaar']} | jaar {$jaar['jaar']}</h4>";
                    echo '<pre>';
                    //print_r($lijstcid[$l]);
                    echo '<pre>';
                }
            }
        }
    }
}

// correctie op gevonden fouten ZELF cid instellen
die();

$sql = "select * from cohortjaar where cid >= 181 and cid <= 273";
$jaren = mysqli_query($DBverbinding, $sql);
if (mysqli_error($DBverbinding)) {
    echo("<h2>dbCheck:<br>".mysqli_error($DBverbinding)."</h2>$sql");
}
else {
    $vorigecid = -1;
    while($cj = mysqli_fetch_assoc($jaren)) {
        if ($cj['cid'] == $vorigecid) {
            $jaar = $jaar + 1;
        }
        else {
            $jaar = 2021;
            $vorigecid = $cj['cid'];
        }
        echo "<h4>{$cj['cjid']} | {$cj['cid']} | {$cj['jaar']} krijgt jaar = $jaar ($vorigecid)</h4>";
        $sql = "UPDATE cohortjaar SET jaar = '$jaar' WHERE cjid = '{$cj['cjid']}';";
        if (!mysqli_query($DBverbinding,$sql)) {
            echo("FATALE FOUT <b>$Nfouten </b>: " . mysqli_error($DBverbinding));
            echo "<h2>{$sql}</h2>";
            die();
        }
    }
}



?>