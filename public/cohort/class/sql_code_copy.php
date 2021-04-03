<?PHP
/* LETOP: query uitgezet vanwege vertroebeling
for ($v=0;$v<count($vakCodeLijst);$v++) {
    $sql = "INSERT INTO `vakken` (`vid`, `vakCode`, `vakNaam`) VALUES (NULL, '{$vakCodeLijst[$v]}', '{$vakNamenLijst[$v]}');";
    echo "$sql<br>";
    // STAAT UIT $records = mysqli_query($DBverbinding, $sql);
}

$sql = "SELECT * FROM fotos";
$records = mysqli_query($DBverbinding, $sql);
$aantalFotos = mysqli_num_rows($records);
if (isset($_GET["nr"]) && $_GET["nr"] <= $aantalFotos && $_GET["nr"] > 0) {
    $fotoNummer = $_GET["nr"];
}
else {
    $fotoNummer = 1;
}

$sql = "SELECT * FROM fotos WHERE id = $fotoNummer";
$record = mysqli_query($DBverbinding, $sql);
$fotoData = mysqli_fetch_assoc($record);

$sql = "SELECT id,naam FROM accounts";
$records = mysqli_query($DBverbinding, $sql);
$namen = [];
if (mysqli_num_rows($records) > 0) {
    while($naam = mysqli_fetch_assoc($records)) {
        $namen[$naam['id']] = utf8_decode($naam['naam']);
    }
}


$sql = "SELECT * FROM reacties WHERE foto = $fotoNummer";
$records = mysqli_query($DBverbinding, $sql);
$reacties = [];
if (mysqli_num_rows($records) > 0) {
    while($record = mysqli_fetch_assoc($records)) {
        array_push($reacties,$record);
    }
}
*/

?>

