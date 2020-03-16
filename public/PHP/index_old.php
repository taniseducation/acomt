<!DOCTYPE html>
<html>
    <head>
        <title>PHP startpagina</title>
    </head>
    <body>
        <h1>Overzicht voorbeelden:</h1>
        <p>
        <?PHP toonVoorbeeldenLijst(); ?>
        <?PHP toonOpdrachtenLijst(); ?>
        </p>
    </body>
</html>

<?PHP
function toonVoorbeeldenLijst() {
    for ($v=1;$v<=10;$v++) {
        echo "<a href=\"voorbeeld_$v.php\">voorbeeld $v</a><br>";
    }
}

function toonOpdrachtenLijst() {
    for ($o=1;$o<=13;$o++) {
        echo '<a href="opdracht_'.$o.'.php">opdracht '.$o.'</a>';
        echo ' | <a href="opdracht_'.$o.'_uitw.php">uitwerking '.$o.'</a><br>';
    }
}

?>