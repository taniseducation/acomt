<?PHP
class Cohort {
    /*
    public $cid;
    public $vakCode;
    public $niveau;
    public $beginjaar;
    public $actief;
    public $edit;
    */
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
    // Algemeen: G14 => data[8] dus verschil is 6
    if (isset($this->cohortJaren[0]['algemeen'])) {$data[8] = [$this->cohortJaren[0]['algemeen']];}
    if (isset($this->cohortJaren[1]['algemeen'])) {$data[20] = [$this->cohortJaren[1]['algemeen']];}
    if (isset($this->cohortJaren[2]['algemeen'])) {$data[32] = [$this->cohortJaren[2]['algemeen']];}

    $ptaJaarTeller = 0;
    $excelRij = 0; 
    foreach ($this->jaarItems as $cj) {
        $ptaJaar = $this->cohortJaren[$ptaJaarTeller]['jaar'];
        echo '<h3>jaar '.$ptaJaar.' (teller = '.$ptaJaarTeller.' ) cjid = '.$this->cohortJaren[$ptaJaarTeller]['cjid'].'</h2>';
        foreach ($cj as $ci) {
            // SCHRIJF DROPDOWNS https://spreadsheet-coding.com/phpspreadsheet/create-xlsx-files-with-drop-down-list-data-validation/
                // of  https://stackoverflow.com/questions/49516348/can-i-create-multiselect-dropdown-using-phpspreadsheet
            // data validatie op dropdown of handmatige invoer? https://spreadsheet-coding.com/
            $data[$excelRij] = [$ci->itemData['periode'],$ci->itemData['leerstofomschrijving'],NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL];            
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