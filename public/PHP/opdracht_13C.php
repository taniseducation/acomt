<?PHP
$titel=str_replace("_"," ",substr(__FILE__,strpos(__FILE__,"opdracht"),-4));
include('opdracht_begin.php');

/****************************
TYP HIERONDER JOUW PHPCODE
****************************/
function toon_logout() {
  echo '<h2>Klik hier om uit te loggen!</h2>
   <a href="logout13.php">Log Uit</a>';   
}

session_start();

if (isset($_SESSION["user"])) {
  echo "<h1 style='color: green;'>Welkom ".$_SESSION["user"]."</h1>";
  echo 'Kies voor een pagina binnen de sessie: 
  <br><a href="opdracht_13A.php">pagina A</a> | <a href="opdracht_13B.php">pagina B</a> | <span class="menu">pagina C</span>';

  toon_logout();
}
else {
  echo "<h1 style='color: red;'>U heeft niet de juist rechten om hier te zijn.</h1>";
  die();
}

/****************************
EINDE VAN JOUW PHPCODE
****************************/
include('opdracht_eind.php');
?>