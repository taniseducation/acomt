<?PHP
$kalenderJaar = 2021;
echo "<h1>Genereer cohorten voor een nieuw schooljaar ($kalenderJaar)</h1>";
$sql = 'select * from vakken';
$vakken = mysqli_query($DBverbinding, $sql);
if (mysqli_error($DBverbinding)) {
    echo("<h2>dbCheck:<br>".mysqli_error($DBverbinding)."</h2>$sql");
}
else {
    echo("<h2>dbCheck: OK voor ophalen vakken</h2>");
}

// echo "<h3>Eerst cohorten ophalen voor elk vak</h3>";
while($vak = mysqli_fetch_assoc($vakken)) {
    $cidLijst = [];
    echo "<h2>Aan de slag voor {$vak['vid']} = {$vak['vakNaam']}</h2><hr>";
    // AANDACHTSPUNT: meerdere cohortjaren? NEE, kopieren doe je altijd aan begin nieuwe sessie, dus max huidige jaar.
    $sql = "select * from cohorten where vid = {$vak['vid']} order by niveau DESC,beginjaar ASC";
    $cohorten = mysqli_query($DBverbinding, $sql);
    if (mysqli_error($DBverbinding) || mysqli_num_rows($cohorten) == 0) {
        echo("<h2>dbCheck: ".mysqli_num_rows($cohorten)." cohorten<br>".mysqli_error($DBverbinding)."</h2>");
    }
    
    else {
        foreach ($cohorten as $cohort) {
            array_push($cidLijst,$cohort['cid']);
            echo "<h3>cid:{$cohort['cid']} | vid:{$cohort['vid']} | niveau:{$cohort['niveau']} | beginJaar:{$cohort['beginJaar']}</h3>";
            if (($cohort['niveau'] == 'A' && $kalenderJaar - $cohort['beginJaar'] == 3) || ($cohort['niveau'] != 'A' && $kalenderJaar - $cohort['beginJaar'] == 2)) {
                echo "<h4>SLA OVER cid:{$cohort['cid']} | vid:{$cohort['vid']} | niveau:{$cohort['niveau']} | beginJaar:{$cohort['beginJaar']}</h4>";
            }
            else {
                echo "<h4>NEEM MEE cid:{$cohort['cid']} | vid:{$cohort['vid']} | niveau:{$cohort['niveau']} | beginJaar:{$cohort['beginJaar']}</h4>";
                $broncid = $cidLijst[count($cidLijst)-2];
                $targetcid = $cidLijst[count($cidLijst)-1];
                $bronjaar = $kalenderJaar - 1;
                $targetjaar = $kalenderJaar;
                echo '<h2>'.$targetcid.' kopieert van '.$broncid.' de items met cohortjaar '.$bronjaar.'</h2>';
                $sql = "select * from cohortjaar where jaar = $bronjaar and cid = $broncid";
                $record = mysqli_query($DBverbinding, $sql);
                if (mysqli_error($DBverbinding) || mysqli_num_rows($record) == 0) {
                    echo("<h2>dbCheck: ".mysqli_num_rows($record)." items<br>".mysqli_error($DBverbinding)." $sql</h2>");
                    die();
                }
                else {
                    $cj = mysqli_fetch_assoc($record);
                    $broncjid = $cj['cjid'];
                }                
                // de te kopieren items ophalen
                $sql = "select * from items where cid = $broncid and cjid = $broncjid";
                echo "<h1>> $sql </h1>";
                $bronitems = mysqli_query($DBverbinding, $sql);
                if (mysqli_error($DBverbinding) || mysqli_num_rows($bronitems) == 0) {
                    echo("<h2>dbCheck: ".mysqli_num_rows($bronitems)." bronitems<br>$sql<br>".mysqli_error($DBverbinding)."</h2>");
                }
                else {
                    // er zijn items en dus moeten we de targetgegevens vinden
                    $sql = "select * from cohortjaar where jaar = $targetjaar and cid = $targetcid";
                    $record = mysqli_query($DBverbinding, $sql);
                    if (mysqli_error($DBverbinding) || mysqli_num_rows($record) == 0) {
                        echo("<h2 style='color:red;'>dbCheck: ".mysqli_num_rows($record)." items<br>$sql<br>".mysqli_error($DBverbinding)."</h2>");
                        die();
                    }
                    else {
                        $cj = mysqli_fetch_assoc($record);
                        $targetcjid = $cj['cjid'];
                    }
  
                    // genereer nu nieuwe targetitems op basis van de bronitems
                    echo "<h2>Kopieer van cjid = $broncjid naar $targetcjid</h2>";
                    foreach ($bronitems as $bronitem) {
                        echo "<h5>cjid: {$bronitem['cjid']} {$bronitem['periode']}</h5>";
                        if ($bronitem['wegingVD'] == '') {$bronitem['wegingVD'] = 'NULL';}
                        if ($bronitem['wegingSE'] == '') {$bronitem['wegingSE'] = 'NULL';}
                        if ($bronitem['SE'] == '') {$bronitem['SE'] = 'NULL';}
                        
                        if ($bronitem['duur'] == '') {$bronitem['duur'] = 'NULL';}
                        if ($bronitem['herkansbaar'] == '') {$bronitem['herkansbaar'] = 'NULL';}
                        $bronitem['leerstofomschrijving'] = addslashes($bronitem['leerstofomschrijving']);
                        $bronitem['hulp'] = addslashes($bronitem['hulp']);
                        $bronitem['domeinen'] = addslashes($bronitem['domeinen']);
                        $bronitem['opmerkingAfname'] = addslashes($bronitem['opmerkingAfname']);
                        $sql = "INSERT INTO `items` (`id`, `cid`, `cjid`, `volgnr`, `periode`, `SOMcode`, `leerstofomschrijving`, `wegingVD`, `afname`, `hulp`, `duur`, `SE`, `wegingSE`, `herkansbaar`, `domeinen`, `datumAfname`, `opmerkingAfname`, `inTW`, `internRooster`, `intern`) VALUES (NULL, $targetcid, $targetcjid, {$bronitem['volgnr']}, {$bronitem['periode']}, NULL, '{$bronitem['leerstofomschrijving']}', {$bronitem['wegingVD']}, '{$bronitem['afname']}', '{$bronitem['hulp']}', {$bronitem['duur']}, {$bronitem['SE']}, {$bronitem['wegingSE']}, {$bronitem['herkansbaar']}, '{$bronitem['domeinen']}', NULL, '{$bronitem['opmerkingAfname']}', {$bronitem['inTW']}, NULL, NULL);";
                        //echo "<h4>$sql</h4>";
                        
                        if (!mysqli_query($DBverbinding,$sql)) {
                            
                            echo("FATALE FOUT: " . mysqli_error($DBverbinding));
                            echo "<h5>{$sql}</h5>";
                            die();
                        }
                        
                    } // einde foreach kopieren items
                } // einde else zoeken targetitems
            } // einde else NEEM MEE
        } // einde foreach cohort
        echo 'here<pre>';
        print_r($cidLijst);
        echo '<pre>';
    } // einde else connectie gelegd
    //die(); // eerst één vak
} // einde while vakken
?>