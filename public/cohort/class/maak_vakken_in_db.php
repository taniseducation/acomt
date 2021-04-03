<?PHP
// LETOP: query uitgezet vanwege vertroebeling
for ($v=0;$v<count($vakCodeLijst);$v++) {
    $sql = "INSERT INTO `vakken` (`vid`, `vakCode`, `vakNaam`) VALUES (NULL, '{$vakCodeLijst[$v]}', '{$vakNamenLijst[$v]}');";
    echo "$sql<br>";
    // STAAT UIT $records = mysqli_query($DBverbinding, $sql);
}
?>

