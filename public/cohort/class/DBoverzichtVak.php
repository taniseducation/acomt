<?PHP
$vakafkorting = 'IF';
echo '<h3>codes voor het vak '.$vakafkorting.'</h3>';
$sql = "SELECT * FROM vakken where vakCode='$vakafkorting'";
$record = mysqli_query($DBverbinding, $sql);
$vakData = mysqli_fetch_assoc($record);
echo '<h2>gevonden cohorten voor '.$vakData['vakNaam'].':</h2>';

$sql = "SELECT * FROM cohorten where vid='{$vakData['vid']}'";
$recordsc = mysqli_query($DBverbinding, $sql);
while($c = mysqli_fetch_assoc($recordsc)) {
    echo '<h3>'.$c['niveau'].' Cohort '.$c['cid'].' met beginjaar '.$c['beginJaar'].'</h3>';
    $sql = "SELECT * FROM cohortjaar where cid='{$c['cid']}'";
    $recordsj = mysqli_query($DBverbinding, $sql);
    while($cj = mysqli_fetch_assoc($recordsj)) {
        echo '<h2>'.$cj['cjid'].' van cohort '.$cj['cid'].' met beginjaar '.$cj['jaar'].'</h2>';

        $sql = "SELECT * FROM items where cjid='{$cj['cjid']}'";
        $recordsi = mysqli_query($DBverbinding, $sql);
        while($i = mysqli_fetch_assoc($recordsi)) {
            echo '<h4>item '.$i['id'].' met volgnummer '.$i['volgnr'].' in periode '.$i['periode'].' ('.$i['leerstofomschrijving'].')</h4>';
        }
    }
}
die();
?>