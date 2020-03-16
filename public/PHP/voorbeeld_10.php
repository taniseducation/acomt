<html>
  <head>
    <meta charset="utf-8"/>
    <title>Voorbeeld 10</title>
  </head>
  <body>
    <p>
      <?php
      // Voeg onderstaande regel toe aan het begin van je PHP-bestand
      session_start();

      function toon_tabel($sql,$DBverbinding) {
        $records = mysqli_query($DBverbinding, $sql);
        $record_teller=0;
        while($record = mysqli_fetch_assoc($records)) {
          $lijst[$record_teller]=$record;
          $record_teller++;
        }
        echo '<h2>Gebruik &eacute;&eacute;n van onderstaande gebruikersgegevens om in te loggen:</h2>
              <table style="border-collapse: collapse; width: 450px; background: white; text-align: center; font-size: 1.2em;">
              <tr style="background-color: blue; color: white;"><th>gebruikersnaam</th><th>wachtwoord</th></tr>';
        foreach ($lijst as $record) {
          echo '<tr style="height: 20px;">';
          echo '<td style="border: 2px solid blue; padding: 5px;">'.$record['beheerder'].'</td>';
          echo '<td style="border: 2px solid blue; padding: 5px;">'.$record['plaats'].'</td>';
          echo '</tr>';
          }
        echo '</table>';
      }
      
      function toon_formulier() {
        echo '<h1>Login om verder te gaan.</h1>
         <form method="POST" action="">
           <label>Gebruiker</label>
           <input type="text" name="gebruikersnaam" placeholder="voer uw gebruikersnaam in...">
           <label>Wachtwoord</label>
           <input type="password" name="wachtwoord" placeholder="Geef uw wachtwoord...">
           <input type="submit" name="submit">
         </form>';   
      }

      $servernaam = "localhost";  // op Cloud9 gebruik je $servernaam = "localhost";
      $gebruikersnaam = "root";   // op Cloud9 gebruik je $gebruikersnaam = 'root';
      $wachtwoord = "";           // op Cloud9 gebruik je $wachtwoord = '';
      $database = "weerstations"; // op Cloud9 gebruik je jouw eigen databases
      $DBverbinding = mysqli_connect($servernaam, $gebruikersnaam, $wachtwoord, $database);

      $sql = "SELECT * FROM stations ORDER BY 1 DESC"; 
      toon_tabel($sql,$DBverbinding);
      
      if(isset($_POST['gebruikersnaam'])) {
          $naam=$_POST['gebruikersnaam'];
          $pass=$_POST['wachtwoord'];
          $sql="SELECT * FROM stations WHERE beheerder='".$naam."'AND plaats='".$pass."'";
          $records = mysqli_query($DBverbinding, $sql);      
          if (mysqli_num_rows($records) == 1) {
            $_SESSION["user"]= "$naam";
            header("Location: voorbeeld_10.php");
            exit();
          }
          else {
            echo "<h1 style='color: red;'>Gebruikersnaam of wachtwoord onjuist</h1>";
          }
      }

      mysqli_close($DBverbinding);    
      
      if (isset($_SESSION["user"])) {
        echo "<h1 style='color: green;'>Welkom ".$_SESSION["user"]."</h1>";
        echo 'De sessie wordt nu weer afgesloten. Klik F5 om opnieuw in te loggen.';
        session_destroy();
      }
      else {
        toon_formulier();
      }      
      ?>
    </p>
  </body>
</html>