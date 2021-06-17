<?PHP
// SELECT vakCode,vakken.vid,cohorten.cid,count(*) as Njaren FROM cohorten,cohortjaar,vakken WHERE cohorten.cid=cohortjaar.cid AND vakken.vid = cohorten.vid AND niveau = 'A' GROUP BY cohorten.cid HAVING Njaren > 3 ORDER BY Njaren DESC

$checklist = [
    ["niveau M met te veel cohortjaren","SELECT vakCode,vakken.vid,cohorten.cid,count(*) as Njaren FROM cohorten,cohortjaar,vakken WHERE cohorten.cid=cohortjaar.cid AND vakken.vid = cohorten.vid AND niveau = 'M' GROUP BY cohorten.cid HAVING Njaren > 2 ORDER BY Njaren DESC"],
    ["niveau H met te veel cohortjaren","SELECT vakCode,vakken.vid,cohorten.cid,count(*) as Njaren FROM cohorten,cohortjaar,vakken WHERE cohorten.cid=cohortjaar.cid AND vakken.vid = cohorten.vid AND niveau = 'H' GROUP BY cohorten.cid HAVING Njaren > 2 ORDER BY Njaren DESC"],
    ["niveau A met te veel cohortjaren","SELECT vakCode,vakken.vid,cohorten.cid,count(*) as Njaren FROM cohorten,cohortjaar,vakken WHERE cohorten.cid=cohortjaar.cid AND vakken.vid = cohorten.vid AND niveau = 'A' GROUP BY cohorten.cid HAVING Njaren > 3 ORDER BY Njaren DESC"]
];

foreach ($checklist as $check) {
    echo "<h4>{$check[0]}</h4>";
    sql2tabel($DBverbinding,$check[1]);
}

function sql2tabel($c,$sql) {
    if ($records=mysqli_query($c,$sql)) {
        echo '<h5>'.mysqli_num_rows($records).' resultaten</h5>';
        echo '<table>';
        $doeTabelHeader = true;
        while($row = mysqli_fetch_assoc($records))
        {
            if ($doeTabelHeader) {
                echo "<tr>";
                foreach (array_keys($row) as $kopje) {
                    echo "<th>$kopje</th>";
                }
                echo "</tr>";
                $doeTabelHeader = false;
            }
            echo "<tr>";
            foreach($row AS $key => $value)    {
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }
        echo '</table>';
        mysqli_free_result($records);
    }      
    else {
        echo "<h5><b>niks gevonden</b></h5>";
    }
    echo "<hr>";
}
?>