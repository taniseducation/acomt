<?PHP
$nieuwBeginJaar = 2021;
echo "<h1>Genereer cohorten voor een nieuw schooljaar ($nieuwBeginJaar)</h1>";
$sql = 'select * from vakken';
$vakken = mysqli_query($DBverbinding, $sql);
if (mysqli_error($DBverbinding)) {
    echo("<h2>dbCheck:<br>".mysqli_error($DBverbinding)."</h2>$sql");
}
else {
    //echo("<h2>dbCheck: OK voor ophalen vakken</h2>");
}

echo "<h3>Eerst cohorten toevoegen ($nieuwBeginJaar)</h3>";
while($vak = mysqli_fetch_assoc($vakken)) {
    // voor elk vak nieuw cohort aanmaken
    // check eerst of er al niet een cohortjaar bestaat voor dit vak en niveau
    $sql = "select * from cohorten where vid = {$vak['vid']} and beginjaar = $nieuwBeginJaar";
    $cohorten = mysqli_query($DBverbinding, $sql);
    if (mysqli_error($DBverbinding) || mysqli_num_rows($cohorten) != 0) {
        // DEZE MOET WEER AAN echo("<h2>dbCheck: ".mysqli_num_rows($cohorten)." items<br>".mysqli_error($DBverbinding)."</h2>");
    }
    else {
        echo("<h2>dbCheck: OK voor {$vak['vid']} {$vak['vakNaam']}</h2>");
        // voeg nieuw cohortjaar in nu deze nog niet bestaat
        // deze sql werkt niet in 1x Handmatig gedaan voor 2021
        $sql = "INSERT INTO `cohorten` (`cid`, `vid`, `niveau`, `beginJaar`, `actief`, `edit`) VALUES (NULL, '{$vak['vid']}', 'M', '{$nieuwBeginJaar}', 1, 1);";
        $sql = $sql. "INSERT INTO `cohorten` (`cid`, `vid`, `niveau`, `beginJaar`, `actief`, `edit`) VALUES (NULL, '{$vak['vid']}', 'H', '{$nieuwBeginJaar}', 1, 1);";
        $sql = $sql. "INSERT INTO `cohorten` (`cid`, `vid`, `niveau`, `beginJaar`, `actief`, `edit`) VALUES (NULL, '{$vak['vid']}', 'V', '{$nieuwBeginJaar}', 1, 1);";
        $Nfouten = 0;
        if (!mysqli_query($DBverbinding,$sql)) {
            $Nfouten++;
            echo("FATALE FOUT <b>$Nfouten </b>: " . mysqli_error($DBverbinding));
            echo "<h5>{$sql}</h5>";
        }        
    }
}

echo "<h3>Nu cohortjaren per nieuw cohort ($nieuwBeginJaar)</h3>";

$sql = "select * from cohorten where beginjaar = $nieuwBeginJaar";
$cohorten = mysqli_query($DBverbinding, $sql);
if (mysqli_error($DBverbinding)) {
    echo("<h2>dbCheck:<br>".mysqli_error($DBverbinding)."</h2>$sql");
}
else {
    echo("<h2>dbCheck: OK voor ophalen nieuwe cohorten (N = ".mysqli_num_rows($cohorten).")</h2>");
    echo '<h1><b style="color: red;">LET OP:</b> staat vanaf hier uit, want geen check op bestaande cohortjaren</h1>';
    die();
    while($cohort = mysqli_fetch_assoc($cohorten)) {
        echo $cohort['cid'].' '.$cohort['vid'].' '.$cohort['niveau'].'<br>';
        // INVOEGEN
        $sql = "INSERT INTO `cohortjaar` (`cjid`, `cid`, `jaar`, `actief`, `edit`, `algemeen`) VALUES (NULL, '{$cohort['cid']}', '{$nieuwBeginJaar}', 1, 1, NULL);";
        echo $sql.'<br>';
        if (!mysqli_query($DBverbinding,$sql)) {
            echo("FATALE FOUT: " . mysqli_error($DBverbinding));
            echo "<h5>{$sql}</h5>";
        }  
        $nieuwBeginJaar+=1;
        $sql = "INSERT INTO `cohortjaar` (`cjid`, `cid`, `jaar`, `actief`, `edit`, `algemeen`) VALUES (NULL, '{$cohort['cid']}', '{$nieuwBeginJaar}', 1, 1, NULL);";
        echo $sql.'<br>';
        if (!mysqli_query($DBverbinding,$sql)) {
            echo("FATALE FOUT: " . mysqli_error($DBverbinding));
            echo "<h5>{$sql}</h5>";
        }  
        if ($cohort['niveau']=='V') {
            $nieuwBeginJaar+=1;
            $sql = "INSERT INTO `cohortjaar` (`cjid`, `cid`, `jaar`, `actief`, `edit`, `algemeen`) VALUES (NULL, '{$cohort['cid']}', '{$nieuwBeginJaar}', 1, 1, NULL);";
            echo $sql.'<br>';
            if (!mysqli_query($DBverbinding,$sql)) {
                echo("FATALE FOUT: " . mysqli_error($DBverbinding));
                echo "<h5>{$sql}</h5>";
            }       
        }
        // INVOEGEN 
    }
}

?>