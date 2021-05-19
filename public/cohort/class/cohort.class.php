<?PHP
class Cohort {
    public $cohortData;
    public $cohortJaren;
    public $jaarItems;
    public $items;

  function __construct($cohortData,$DBverbinding) {    
    $this->cohortData = $cohortData;

    $sql = "SELECT * FROM vakken WHERE vid = {$cohortData['vid']}";
    $vak = mysqli_query($DBverbinding, $sql);
    $vakData = mysqli_fetch_assoc($vak);
    $this->cohortData['vakCode']=$vakData['vakCode'];
    $this->cohortData['vakNaam']=$vakData['vakNaam'];

    $this->cohortJaren = [];
    $this->items = [];
    $this->jaarItems = [];
    $sql = "SELECT * FROM cohortjaar where cid=".$this->cohortData['cid'].";";
    $cohortJaren = mysqli_query($DBverbinding, $sql);
    while($jaar = mysqli_fetch_assoc($cohortJaren)) {
        array_push($this->cohortJaren,$jaar);
        $this->jaarItems[$jaar['cjid']] = [];
    }  
  }
  function voegItemToe($item) {
    array_push($this->items,$item);
    array_push($this->jaarItems[$item->itemData['cjid']],$item);
  }  
  function getB2B8($status) {
    $data = [$status,NULL,$this->cohortData['vakCode'],$this->cohortData['vid'],$this->cohortData['niveau'],$this->cohortData['beginJaar'],$this->cohortData['cid']];
    $data = array_chunk($data,1);
    return $data;
  }
  function getG6P11() {
    // hele lege structuur nodig om bestaande waarden te resetten
    $data = [
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL],
        [NULL],
        [NULL],
        [NULL],
        [NULL],
        [NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL],
        [NULL],
        [NULL],
        [NULL],
        [NULL],
        [NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],              
        [NULL],
        [NULL],
        [NULL],
    ];
    if (isset($this->cohortJaren[0]['algemeen'])) {$data[8] = [$this->cohortJaren[0]['algemeen']];}
    if (isset($this->cohortJaren[1]['algemeen'])) {$data[20] = [$this->cohortJaren[1]['algemeen']];}
    if (isset($this->cohortJaren[2]['algemeen'])) {$data[32] = [$this->cohortJaren[2]['algemeen']];}

    $ptaJaarTeller = 0;
    $excelRij = 0; 
    foreach ($this->jaarItems as $cj) {
        $ptaJaar = $this->cohortJaren[$ptaJaarTeller]['jaar'];
        // STOND LANG AAN echo '<h3>jaar '.$ptaJaar.' (teller = '.$ptaJaarTeller.' ) cjid = '.$this->cohortJaren[$ptaJaarTeller]['cjid'].'</h2>';
        foreach ($cj as $ci) {
            // booleans omzetten en hoe zit het met leestekens? op twee plekken.
            $data[$excelRij] = [$ci->itemData['periode'],$ci->itemData['leerstofomschrijving'],$ci->itemData['wegingVD'],$ci->itemData['afname'],$ci->itemData['hulp'],$ci->itemData['duur'],$ci->itemData['SE'],$ci->itemData['wegingSE'],$ci->itemData['herkansbaar'],$ci->itemData['domeinen']];
            $excelRij++;
        }
        $ptaJaarTeller++;
        if ($ptaJaarTeller == 1) {$excelRij = 12;}
        if ($ptaJaarTeller == 2) {$excelRij = 24;}
    }
    return $data;
  }  
}
?>