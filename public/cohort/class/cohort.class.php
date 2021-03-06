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
    $this->cohortData['removeTab']=$vakData['removeTab']; // voor verwijderen overbodige Excel-tabs als vak die laag niet heeft

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
  function getD6P11() {
    // hele lege structuur nodig om bestaande waarden te resetten
    $data = [
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL],
        [NULL],
        [NULL],
        [NULL],
        [NULL],
        [NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL],
        [NULL],
        [NULL],
        [NULL],
        [NULL],
        [NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],
        [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL],              
        [NULL],
        [NULL],
        [NULL],
    ];
    if (isset($this->cohortJaren[0]['cjid'])) {$data[7] = [($this->cohortJaren[0]['cjid'])];}
    if (isset($this->cohortJaren[1]['cjid'])) {$data[19] = [($this->cohortJaren[1]['cjid'])];}
    if (isset($this->cohortJaren[2]['cjid'])) {$data[31] = [($this->cohortJaren[2]['cjid'])];}
    if (isset($this->cohortJaren[0]['algemeen']) && $this->cohortJaren[0]['algemeen'] != '0') {$data[8] = [NULL,NULL,NULL,$this->cohortJaren[0]['algemeen']];}
    if (isset($this->cohortJaren[1]['algemeen']) && $this->cohortJaren[1]['algemeen'] != '0') {$data[20] = [NULL,NULL,NULL,$this->cohortJaren[1]['algemeen']];}
    if (isset($this->cohortJaren[2]['algemeen']) && $this->cohortJaren[2]['algemeen'] != '0') {$data[32] = [NULL,NULL,NULL,$this->cohortJaren[2]['algemeen']];}

    $ptaJaarTeller = 0;
    $excelRij = 0; 
    foreach ($this->jaarItems as $cj) {
        $ptaJaar = $this->cohortJaren[$ptaJaarTeller]['jaar'];
        // echo '<h3>jaar '.$ptaJaar.' (teller = '.$ptaJaarTeller.' ) cjid = '.$this->cohortJaren[$ptaJaarTeller]['cjid'].'</h2>';
        foreach ($cj as $ci) {
            $data[$excelRij] = [$ci->itemData['id'],$ci->itemData['SOMcode'],NULL,$ci->itemData['periode'],"{$ci->itemData['leerstofomschrijving']}",$ci->itemData['wegingVD'],$ci->itemData['afname'],"{$ci->itemData['hulp']}",$ci->itemData['duur'],$ci->itemData['SE'],$ci->itemData['wegingSE'],$ci->itemData['herkansbaar'],"{$ci->itemData['domeinen']}"];
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