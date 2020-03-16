<html>
  <head>
    <meta charset="utf-8"/>
    <title>Voorbeeld 9</title>
  </head>
  <body>
    <p>
      <?php
      function toon_tabel($sql,$DBverbinding) {
        $records = mysqli_query($DBverbinding, $sql);
        $record_teller=0;
        while($record = mysqli_fetch_assoc($records)) {
          $lijst[$record_teller]=$record;
          $record_teller++;
        }
        // Maak een HTML-tabel met opmaak
        echo '<h2>Huidige inhoud database weerstations:</h2>
              <table style="border-collapse: collapse; width: 450px; background: white; text-align: center; font-size: 1.2em;">';
        foreach ($lijst as $record) {
          // met tr wordt een nieuwe rij in de tabel gemaakt
          echo '<tr style="height: 20px;">';
          // met td wordt een nieuwe rij in de tabel gemaakt
          echo '<td style="border: 2px solid blue; padding: 5px;">'.$record['ws_id'].'</td>';
          echo '<td style="border: 2px solid blue; padding: 5px;">'.$record['plaats'].'</td>';
          echo '<td style="border: 2px solid blue; padding: 5px;">'.$record['beheerder'].'</td>';
          echo '</tr>';
          }
        echo '</table>';
      }

      $servernaam = "localhost";  // op Cloud9 gebruik je $servernaam = "localhost";
      $gebruikersnaam = "root";   // op Cloud9 gebruik je $gebruikersnaam = 'root';
      $wachtwoord = "";           // op Cloud9 gebruik je $wachtwoord = '';
      $database = "weerstations"; // op Cloud9 gebruik je jouw eigen databases
      $DBverbinding = mysqli_connect($servernaam, $gebruikersnaam, $wachtwoord, $database);
      
      // Toon alle weerstations in plaatsen die beginnen met een G
      $sql = "SELECT * FROM stations WHERE plaats LIKE 'G%'"; 
      toon_tabel($sql,$DBverbinding);
      
      // Update een veld van een record
      $sql = "UPDATE stations SET beheerder='<b>VELD</b>' WHERE ws_id=2";
      if (mysqli_query($DBverbinding, $sql)) {
        echo "<h3>De query is succesvol uitgevoerd (<i>$sql</i>)</h3>";
      }
      else {
        echo "<h3>Fouten: " . mysqli_error($DBverbinding);
      }      
      // Toon na het updaten opnieuw de tabel
      $sql = "SELECT * FROM stations WHERE plaats LIKE 'G%'";     
      toon_tabel($sql,$DBverbinding);
      
      // Voeg een record toe. MERK OP DAT WE GEEN ws_id toe hoeven te voegen, omdat in de database AUTO_INCREMENT aan staat
      // Alle nieuwe records worden aan het eind gedelete, maar MySQL neemt steeds een nieuw uniek nummer voor ws_id
      $sql = "INSERT INTO stations (plaats, beheerder) VALUES ('Garnwerd', '<b>JOHN<b>')";
      if (mysqli_query($DBverbinding, $sql)) {
        echo "<h3>De query is succesvol uitgevoerd (<i>$sql</i>)</h3>";
      }
      else {
        echo "<h3>Fouten: " . mysqli_error($DBverbinding);
      }      
      // Toon na het updaten opnieuw de tabel
      $sql = "SELECT * FROM stations WHERE plaats LIKE 'G%'";     
      toon_tabel($sql,$DBverbinding);
      
      // Verwijder het zojuist toegevoegde record
      $sql = "DELETE FROM stations WHERE plaats='Garnwerd'";
      if (mysqli_query($DBverbinding, $sql)) {
        echo "<h3>De query is succesvol uitgevoerd (<i>$sql</i>)</h3>";
      }
      else {
        echo "<h3>Fouten: " . mysqli_error($DBverbinding);
      }      
      // Toon na het updaten opnieuw de tabel
      $sql = "SELECT * FROM stations WHERE plaats LIKE 'G%'";     
      toon_tabel($sql,$DBverbinding);        
      
      // Hieronder zetten we alles weer terug zoals het was
      $sql = "UPDATE stations SET beheerder='Velthuizen' WHERE ws_id=2";
      mysqli_query($DBverbinding, $sql);
      $sql = "DELETE FROM stations WHERE ws_id>5";
      mysqli_query($DBverbinding, $sql);      

      mysqli_close($DBverbinding);      
      ?>      
    </p>
  </body>
</html>