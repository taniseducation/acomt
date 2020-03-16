<?php
// Commentaar kan gegeven worden met //
/*  Wie meerdere regels commentaar
    heeft kan gebruik maken van de /* (begin) met aan het eind */

// PHP kan foutmeldingen weergeven; zie http://php.net/manual/en/function.error-reporting.php
error_reporting(E_ALL);

// Merk op dat elke regel eindigt met ;

// variabelen beginnen met een dollar-teken
$voornaam = "Augustinus";   // tekst met dubbele aanhalingstekens
$achternaam = 'van Hippo';  // tekst met enkele aanhalingstekens
$geboren = 354;             // integer
$leeftijd = 2017-$geboren;  // variabele op basis van berekening
$dagen = $leeftijd*365;     // berekening
$volledige_naam = $voornaam." ".$achternaam;
?>
     
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Voorbeeld 1</title>
  </head>
  <body>
    <h1>
      <?php echo $volledige_naam; ?>
    </h1>
    <p>
      <b>Dubbele aanhalingstekens:</b>
      <?php echo "$voornaam werd geboren in $geboren."; ?>
      <br><b>Enkele aanhalingstekens:</b>
      <?php echo '$voornaam werd geboren in $geboren.'; ?>
      <br><b>Dit werkt wel:</b>
      <?php echo $voornaam.' werd geboren in '.$geboren.'.'; ?>      
    </p>
    <p>
      <?php
      // Binnen de html kun je op elk moment beginnen met een stukje PHP
      echo "Als hij nog zou leven, dan zou hij nu <i>grofweg</i> $dagen dagen oud zijn.";
      ?>
    </p>
  </body>
</html>