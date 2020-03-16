<html>
  <head>
    <meta charset="utf-8"/>
    <title>Voorbeeld 7</title>
  </head>
  <body>
    <p>
      <?php
      $servernaam = "localhost";  // op Cloud9 gebruik je $servernaam = "localhost";
      $gebruikersnaam = "root";   // op Cloud9 gebruik je $gebruikersnaam = 'root';
      $wachtwoord = "";           // op Cloud9 gebruik je $wachtwoord = '';
      $database = "weerstations";    // op Cloud9 gebruik je jouw eigen databases
      
      //maak databaseverbinding
      $DBverbinding = mysqli_connect($servernaam, $gebruikersnaam, $wachtwoord, $database);
      // Controleer de verbinding
      if (!$DBverbinding) {
        // Geef de foutmelding die de server teruggeeft en stop met de uitvoer van PHP (die)
        die("Verbinding mislukt: " . mysqli_connect_error());
      }
      else {
        // Dit gedeelte laat je normaliter weg, maar is hier ter illustratie toegevoegd
        echo '<h1 style="color:green;">Verbinding gelukt</h1>';
      }
      
      echo "<h2>Eenvoudige query</h2>";
      // Voer een query uit
      $sql = "SELECT * FROM stations";
      $records = mysqli_query($DBverbinding, $sql);
      
      if (mysqli_num_rows($records) > 0) {
        // Voor elke rij uit de resultaattabel wordt een array aangemaakt
        // na elke aanroep gaat de pointer / cursor naar het volgende element uit de resultaatset van de query
        while($record = mysqli_fetch_assoc($records)) {
          echo "Beheerder ".$record["beheerder"]." werkt in ".$record["plaats"].".<br>";
        }
      }
      // Dit gedeelte kan ook worden weggelaten
      else {
        echo "0 resultaten";
      }
      
      echo "<h2>Aanhalingstekens</h2>";
      // Let op enkele en dubbele aanhalingstekens!
      $sql = "SELECT * FROM stations WHERE plaats='Groningen'";      
      $records = mysqli_query($DBverbinding, $sql);
      
      if (mysqli_num_rows($records) > 0) {
        while($record = mysqli_fetch_assoc($records)) {
          echo "Beheerder ".$record["beheerder"]." werkt in ".$record["plaats"].".<br>";
        }
      }

      echo "<h2>Variabelen gebruiken: let op de accolades</h2>";
      // Let op de accolades
      $merk='Vavetech';
      $type=array('luchtdruk','windkracht','temperatuur');
      // Een gewone variabele kun je in de query verwerken. Bij een array plaats je acoolades
      $sql = "SELECT * FROM meters WHERE NOT merk='$merk' AND type='{$type['0']}'";      
      $records = mysqli_query($DBverbinding, $sql);
      
      if (mysqli_num_rows($records) > 0) {
        while($record = mysqli_fetch_assoc($records)) {
          echo $record["merk"]." type ".$record["type"]." & voeding ".$record["voeding"].".<br>";
        }
      }    
      
      echo '<h2>Snelle truc om een waarde in een variabele te plaatsen. (Maar wat gebeurt er bij meerdere records?)</h2>';
      $sql = "SELECT * FROM stations WHERE plaats='Garrelsweer'";
      $naamBeheerder = mysqli_fetch_assoc(mysqli_query($DBverbinding, $sql))['beheerder'];
      echo 'Zijn naam is '.$naamBeheerder.'.';
      
      
      // Als je klaar bent dan sluit je de gemaakte verbinding met de database
      mysqli_close($DBverbinding);      
      ?>      
    </p>
  </body>
</html>