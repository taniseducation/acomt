<?PHP
$titel=str_replace("_"," ",substr(__FILE__,strpos(__FILE__,"opdracht"),-4));
include('opdracht_begin.php');
?>
<h1>Overzicht voorbeelden:</h1>
<?PHP toonVoorbeeldenLijst(); ?>
<h1>Overzicht opdrachten (uitwerking):</h1>
<?PHP toonOpdrachtenLijst(); ?>
<?PHP
include('opdracht_eind.php');
function toonVoorbeeldenLijst() {
    for ($v=1;$v<=10;$v++) {
        echo " <a href=\"voorbeeld_$v.php\"> $v </a> * ";
    }
}
function toonOpdrachtenLijst() {
    for ($o=2;$o<=13;$o++) {
        if ($o==9) {echo '<br>';}
        echo ' <a href="opdracht_'.$o.'.php">'.$o.'</a>';
        echo ' <a href="opdracht_'.$o.'_uitw.php">(U'.$o.')</a> * ';
    }
}
?>
<script>
document.getElementById("opdracht").style.color = "#ff3300";
</script>