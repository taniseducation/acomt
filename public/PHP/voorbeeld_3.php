<html>
  <head>
    <meta charset="utf-8"/>
    <title>Voorbeeld 3</title>
  </head>
  <body>
    <p>
      <?php
      // aanmaken van een array
      $priem=array(2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97, 101, 103, 107, 109, 113);
      echo $priem[1]."<br>";                       // standaard verwijs je naar een element met een nummer, beginnend bij 0
      
      $namen=array();                                 // een lege array
      array_push($namen,"Martin","Marije");           // een array aanvullen (aan het eind)
      echo $namen[1]."<br>";
      
      $aanvulling=array("Maarten","Margje");
      $totaal=array_merge($namen,$aanvulling);        // twee arrays samenvoegen tot één
      echo $totaal[3]."</p>";
      
       echo "<h2>Hele array</h2>";
      print_r($totaal);                               // toon de volledige array op het scherm
      echo "<h2>Overzichtelijker</h2>";
      echo "<pre>";
      print_r($totaal);
      echo "</pre>";
      
      // aanmaken van een associatieve array met sleutels met een naam
      $vader=array('voornaam' =>'Rasmus', 'achternaam' => 'Lerdorf');
      $vader['bedrijf']='IBM';
      $vader['jaar']=1994;
      
      echo "<h2>".$vader['voornaam']." ".$vader['achternaam']." heeft PHP in ".$vader['jaar']." ontwikkeld bij ".$vader['bedrijf']."</h2>";
   
      ?>
    </p>
  </body>
</html>