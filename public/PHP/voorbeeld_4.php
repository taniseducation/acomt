<html>
  <head>
    <meta charset="utf-8"/>
    <title>Voorbeeld 4</title>
  </head>
  <body>
    <p>
      <?php
      echo "<h1>FOR | ";
      // herhaling met for
      $aantal=5;      
      for ($teller=1;$teller<=$aantal;$teller++) {
        echo $teller." | ";
      }
      echo "</h1>";
      
      echo "<h1>WHILE | ";
      //herhaling met white
      $controle=9;
      while ($controle>=$aantal) {
        echo $controle." | ";
        $controle--;                // verlaag de waarde van $controle met 1
      }
      echo "</h1>";
      
      echo "<h1>FOREACH | ";      
      //herhaling met foreach en een array
      $priem=array(2, 3, 5, 7, 11);
      foreach ($priem as $getal) {
        echo $getal." | ";
      }        
      echo "</h1>";
      ?>
    </p>
  </body>
</html>