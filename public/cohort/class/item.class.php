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
      $notice = '';
      echo '<hr><pre>';
      print_r($excel);
      echo '</pre>';
      echo '<h5>'.$this->itemData['leerstofomschrijving'].'</h5>';
      echo '<h5>'.$excel['H'].'</h5>';
      if ($this->itemData['periode'] != $excel['G']) {$notice = $notice.'periode gewijzigd. ';}
      if ($this->itemData['leerstofomschrijving'] != $excel['H']) {$notice = $notice.'leerstof gewijzigd. ';}
      if ($this->itemData['wegingVD'] != $excel['I']) {$notice = $notice.'weging VD gewijzigd. ';}
      if ($this->itemData['afname'] != $excel['J']) {$notice = $notice.'afname gewijzigd. ';}
      if ($this->itemData['hulp'] != $excel['K']) {$notice = $notice.'hulp gewijzigd. ';}
      if ($this->itemData['duur'] != $excel['L']) {$notice = $notice.'duur gewijzigd. ';}
      if ($this->itemData['SE'] != $excel['M']) {$notice = $notice.'SE-status gewijzigd. ';}
      if ($this->itemData['wegingSE'] != $excel['N']) {$notice = $notice.'weging SE gewijzigd. ';}
      if ($this->itemData['herkansbaar'] != $excel['O']) {$notice = $notice.'herkansbaarheid gewijzigd. ';}
      if ($this->itemData['domeinen'] != $excel['P']) {$notice = $notice.'domeinen gewijzigd. ';}
      if ($notice == '') {
          echo '<h1>identiek item</h1>';
          return true;
      }
      else {
          echo '<h1>'.$notice.'</h1>';
          return false;
        }      
  }
}
?>