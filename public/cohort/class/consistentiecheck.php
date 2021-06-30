<?PHP
echo "<h3>Check op onregelmatigheden</h3>";
$checklist = [
    ["SE maar niet alles aangevuld","SELECT vakken.vakNaam,niveau,beginjaar,cohorten.cid,items.id FROM vakken,cohorten,cohortjaar,items WHERE vakken.vid = cohorten.vid AND cohorten.cid=cohortjaar.cid and items.cjid = cohortjaar.cjid AND NOT vakken.vid = 29 AND items.SE = 1 AND ((wegingSE is null AND NOT items.afname='hd') OR herkansbaar is null OR domeinen is null)"],
    ["Wel periode (of 0) maar geen inhoud","SELECT vakken.vakNaam,niveau,beginjaar,cohorten.cid,items.id,periode,leerstofomschrijving FROM vakken,cohorten,cohortjaar,items WHERE vakken.vid = cohorten.vid AND cohorten.cid=cohortjaar.cid and items.cjid = cohortjaar.cjid and items.cid = cohortjaar.cid AND NOT vakken.vid = 29 AND (items.periode > 4 or (items.periode < 1 AND not items.leerstofomschrijving is null)) ORDER BY vakken.vid ASC"],
    ["Meer dan 6 items per jaar","SELECT vakken.vakNaam,niveau,beginjaar,cohorten.cid,cohortjaar.cjid,count(*) as Nperjaar FROM vakken,cohorten,cohortjaar,items WHERE vakken.vid = cohorten.vid AND cohorten.cid=cohortjaar.cid and items.cjid = cohortjaar.cjid AND NOT vakken.vid = 29 GROUP BY items.cjid HAVING Nperjaar > 6 ORDER BY Nperjaar DESC"],
    ["HD maar toch gewicht","SELECT vakken.vakNaam,niveau,beginjaar,cohorten.cid,items.id,items.wegingVD,items.wegingSE FROM vakken,cohorten,cohortjaar,items WHERE vakken.vid = cohorten.vid AND cohorten.cid=cohortjaar.cid and items.cjid = cohortjaar.cjid AND NOT vakken.vid = 29 AND items.afname = 'hd' AND NOT (wegingVD IS null AND wegingSE IS null)"],
    ["PO maar toch toetsduur","SELECT vakken.vakNaam,niveau,beginjaar,cohorten.cid,items.id,items.duur FROM vakken,cohorten,cohortjaar,items WHERE vakken.vid = cohorten.vid AND cohorten.cid=cohortjaar.cid and items.cjid = cohortjaar.cjid AND NOT vakken.vid = 29 AND items.afname = 'po' AND NOT duur IS null"],


    ["niveau M met te veel cohortjaren","SELECT vakCode,vakken.vid,cohorten.cid,count(*) as Njaren FROM cohorten,cohortjaar,vakken WHERE cohorten.cid=cohortjaar.cid AND vakken.vid = cohorten.vid AND niveau = 'M' GROUP BY cohorten.cid HAVING Njaren > 2 ORDER BY Njaren DESC"],
    ["niveau H met te veel cohortjaren","SELECT vakCode,vakken.vid,cohorten.cid,count(*) as Njaren FROM cohorten,cohortjaar,vakken WHERE cohorten.cid=cohortjaar.cid AND vakken.vid = cohorten.vid AND niveau = 'H' GROUP BY cohorten.cid HAVING Njaren > 2 ORDER BY Njaren DESC"],
    ["niveau A met te veel cohortjaren","SELECT vakCode,vakken.vid,cohorten.cid,count(*) as Njaren FROM cohorten,cohortjaar,vakken WHERE cohorten.cid=cohortjaar.cid AND vakken.vid = cohorten.vid AND niveau = 'A' GROUP BY cohorten.cid HAVING Njaren > 3 ORDER BY Njaren DESC"]
];

$counter = 0;
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

