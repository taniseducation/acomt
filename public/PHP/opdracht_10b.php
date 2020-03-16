<?PHP
$titel=str_replace("_"," ",substr(__FILE__,strpos(__FILE__,"opdracht"),-4));
include('opdracht_begin.php');
/****************************
TYP HIERONDER JOUW PHPCODE
****************************/

require('database.php');
$database = "top_2000_v2";
$DBverbinding = mysqli_connect($servernaam, $gebruikersnaam, $wachtwoord, $database);
echo "<h2>RESULTAAT</h2>";
$sql = "SELECT * FROM artiest,titel,notering WHERE artiest.id=titel.artiest_id AND notering.lied_id=titel.id AND notering.jaar=2014 AND artiest='Nirvana' ORDER BY positie ASC";
$records = mysqli_query($DBverbinding, $sql);
      
while($record = mysqli_fetch_assoc($records)) {
  echo "<b>".$record["titel"]."</b> stond in 2014 op positie ".$record['positie'].".<br>";
}
mysqli_close($DBverbinding);  

/****************************
EINDE VAN JOUW PHPCODE
****************************/
include('opdracht_eind.php');
?>