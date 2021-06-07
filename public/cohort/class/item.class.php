<?PHP
class Item {
  public $itemData;

  function __construct($item) {
    $this->itemData = $item;
    if ($this->itemData['duur'] == 0) {$this->itemData['duur'] = null;}
    if ($this->itemData['hulp'] == '0') {$this->itemData['hulp'] = null;}
    if ($this->itemData['wegingVD'] == 0) {$this->itemData['wegingVD'] = null;}
    if ($this->itemData['wegingSE'] == 0) {$this->itemData['wegingSE'] = null;}
    if ($this->itemData['SE'] == 1) {$this->itemData['SE'] = 'ja';} else {$this->itemData['SE'] = 'nee';}
    if ($this->itemData['herkansbaar'] == 1) {$this->itemData['herkansbaar'] = 'ja';} else {if ($this->itemData['SE'] == 'ja') {$this->itemData['herkansbaar'] = 'nee';}}
    $this->itemData['leerstofomschrijving']=utf8_decode($this->itemData['leerstofomschrijving']);
    $this->itemData['hulp']=utf8_decode($this->itemData['hulp']);
    $this->itemData['domeinen']=utf8_decode($this->itemData['domeinen']);
    $this->itemData['opmerkingAfname']=utf8_decode($this->itemData['opmerkingAfname']);
    $this->itemData['internRooster']=utf8_decode($this->itemData['internRooster']);
  }

  function dbExcelIDentiek($excel) {
      return false;
  }
}
?>