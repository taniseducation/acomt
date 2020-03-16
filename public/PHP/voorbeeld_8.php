<html>
  <head>
    <meta charset="utf-8"/>
    <title>Voorbeeld 8</title>
  </head>
  <body>
    <p>
      <?php
      $servernaam = "localhost";  // op Cloud9 gebruik je $servernaam = "localhost";
      $gebruikersnaam = "root";   // op Cloud9 gebruik je $gebruikersnaam = 'root';
      $wachtwoord = "";           // op Cloud9 gebruik je $wachtwoord = '';
      $database = "weerstations";    // op Cloud9 gebruik je jouw eigen databases
      
      $DBverbinding = mysqli_connect($servernaam, $gebruikersnaam, $wachtwoord, $database);
      
      echo "<h2>Maak zelf een array van de resultaten</h2>";
      
      $sql = "SELECT * FROM stations WHERE plaats LIKE 'G%'";      
      $records = mysqli_query($DBverbinding, $sql);      
      $record_teller=0;
      if (mysqli_num_rows($records) > 0) {
        while($record = mysqli_fetch_assoc($records)) {
          // De array $lijst bevat straks alle resultaatrecords als elementen met de kolomnamen als sleutel
          $lijst[$record_teller]=$record;
          $record_teller++;
        }
      }
      
      echo "<pre>";
      print_r($lijst);
      echo "</pre>";
      mysqli_close($DBverbinding);      
      ?>      
    </p>
  </body>
</html>