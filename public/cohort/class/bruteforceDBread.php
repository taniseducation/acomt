<?PHP
// bruteforce alle cohorten
$sql = "SELECT * FROM cohorten";
$records = mysqli_query($DBverbinding, $sql);
while($record = mysqli_fetch_assoc($records)) {
    ${'c'.$record['cid']} = new Cohort($record,$DBverbinding);
}
// bruteforce alle items
$sql = "SELECT * FROM items";
$records = mysqli_query($DBverbinding, $sql);
while($record = mysqli_fetch_assoc($records)) {
    ${'i'.$record['id']} = new Item($record);
    ${'c'.$record['cid']}->voegItemToe(${'i'.$record['id']});
}

/*
$filter['niveau'] = 'M';
$filter['beginJaar'] = '2019';
$filter['vakCode'] = 'IF';
$filter['vid'] = 14;
*/

function selecteerCohort($filter,$DBverbinding) {
    $sql = "SELECT * FROM cohorten where vid = {$filter['vid']} and niveau = '{$filter['niveau']}' and beginJaar = {$filter['beginJaar']}";
    $record = mysqli_query($DBverbinding, $sql);
    if (mysqli_num_rows($record) == 0) {
        return null;
    }
    else {
        $cselect = mysqli_fetch_assoc($record);
        return $cselect['cid'];
    }
}

function selecteerCIDperVak($filter,$DBverbinding) {
    $lijst = [];
    $sleutel = 0;
    $sql = "SELECT * FROM cohorten where vid = {$filter['vid']}";
    $records = mysqli_query($DBverbinding, $sql);
    while($record = mysqli_fetch_assoc($records)) {
        $lijst[$sleutel]=$record;
        $sleutel++;
    }
    return $lijst;
}

/*
$filterCohort = selecteerCohort($filter,$DBverbinding);
echo '<pre>';
print_r(${'c'.$filterCohort}->cohortData);
echo '<pre>';
foreach (${'c'.$filterCohort}->items as $item) {
    echo '<pre>';
    print_r($item->itemData);
    echo '<pre>';
}
*/
?>