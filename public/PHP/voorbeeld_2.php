<html>
  <head>
    <meta charset="utf-8"/>
    <title>Voorbeeld 2</title>
  </head>
  <body>
    <p>
      <?php
      $waarde=9/10;
      $kwad=pow($waarde,2);
      $rec=1/$kwad;
      $afgerond=round($rec,7);
            
      echo "Het kwadraat van $waarde is $kwad.<br>
            Het omgekeerde daarvan is (afgerond:) $afgerond<br>";    
      ?>
    </p>
  </body>
</html>