<html>
  <head>
    <meta charset="utf-8"/>
    <title>Voorbeeld 6</title>
  </head>
  <body>
    <p>
      <?php
      // Een functie die alleen iets uitvoert
      function dobbelsteen1() {
        $worp=1+rand(0,5);
        echo "<h2>Dobbelsteen1 is op de $worp gevallen.</h2>";
      }
      // het aanroepen van de functie
      dobbelsteen1();
      
      // een functie die een waarde teruggeeft
      function dobbelsteen2() {
        $worp=1+rand(0,5);
        return $worp;
      }
      
      echo "<h1>";
      $aantal=10;
      for ($w=0; $w<$aantal; $w++) {
        // het resultaat van de functie wordt in de variabele $uitkomst gezet
        $uitkomst=dobbelsteen2();
        echo "$uitkomst | ";
      }
      echo "</h1>";
      
      // een functie waaraan een parameter $invoer wordt meegegeven
      function gooi_N_worpen($aantal) {
        for ($n=0;$n<$aantal;$n++) {
          dobbelsteen1();
        }
      }
      // het aanroepen van de functie met het argument 3
      gooi_N_worpen(3);
      ?>
    </p>
  </body>
</html>