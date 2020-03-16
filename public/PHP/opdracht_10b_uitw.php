<?PHP
$titel=str_replace("_"," ",substr(__FILE__,strpos(__FILE__,"opdracht"),-4));
include('opdracht_begin.php');
/****************************
TYP HIERONDER JOUW PHPCODE
****************************/

require('database.php');
$database = "postcode";
$DBverbinding = mysqli_connect($servernaam, $gebruikersnaam, $wachtwoord, $database);

$straat='Praam';
echo "<h2>Eerste deel: plaatsen met een $straat</h2>";
$plaatsnamen=array();
$sql = "SELECT DISTINCT(plaats) FROM postcode WHERE straat='$straat' ORDER BY plaats ASC";
$records = mysqli_query($DBverbinding, $sql);
      
while($record = mysqli_fetch_assoc($records)) {
  //echo $record["plaats"]."<br>";
  array_push($plaatsnamen,$record['plaats']);
}

foreach($plaatsnamen as $plaats) {
    echo $plaats." | ";
}


echo "<h2>Tweede deel: frequentie van straatnamen</h2>";
$straatnamen=array();
$sql = "SELECT DISTINCT(straat) FROM postcode WHERE plaats='Klijndijk' ORDER BY straat ASC";
$records = mysqli_query($DBverbinding, $sql);
      
while($record = mysqli_fetch_assoc($records)) {
  //echo $record["straat"]."<br>";
  array_push($straatnamen,$record['straat']);
}

foreach($straatnamen as $straat) {
    $sql = "SELECT COUNT(*) AS aantal,straat FROM postcode WHERE straat='$straat'";
    $records = mysqli_query($DBverbinding, $sql);
    
    while($record = mysqli_fetch_assoc($records)) {
        echo $record["straat"]." (".$record["aantal"].")<br>";
    }
}

mysqli_close($DBverbinding);  

/****************************
EINDE VAN JOUW PHPCODE
****************************/
include('opdracht_eind.php');
?>