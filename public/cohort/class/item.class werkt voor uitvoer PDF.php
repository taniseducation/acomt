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
    
    if ($this->itemData['herkansbaar'] == 0) {$this->itemData['herkansbaar'] = 'nee';}
    if ($this->itemData['herkansbaar'] == 'NULL' || $this->itemData['herkansbaar'] == null) {$this->itemData['herkansbaar'] = 'kies...';}
    if ($this->itemData['herkansbaar'] == 1) {$this->itemData['herkansbaar'] = 'ja';} else {if ($this->itemData['SE'] == 'ja') {$this->itemData['herkansbaar'] = 'nee';}}
    // $this->itemData['leerstofomschrijving']=utf8_decode($this->itemData['leerstofomschrijving']);
    $this->itemData['SOMcode']=$this->itemData['SOMcode'];
    $this->itemData['leerstofomschrijving']=$this->itemData['leerstofomschrijving'];
    $this->itemData['hulp']=utf8_encode($this->itemData['hulp']);
    $this->itemData['domeinen']=utf8_encode($this->itemData['domeinen']);
    $this->itemData['opmerkingAfname']=utf8_encode($this->itemData['opmerkingAfname']);
    $this->itemData['internRooster']=utf8_encode($this->itemData['internRooster']);
  }

  function dbExcelIDentiek($excel) {
      $notice = '';
      if ($this->itemData['periode'] != $excel['G']) {$notice = $notice.'periode gewijzigd. ';}
      if ($this->itemData['leerstofomschrijving'] != $excel['H']) {$notice = $notice.'leerstof gewijzigd. ';}
      if ($this->itemData['wegingVD'] != $excel['I'] && !($this->itemData['wegingVD'] == null && $excel['I']=='NULL')) {$notice = $notice.'weging VD gewijzigd. ';}
      if ($this->itemData['afname'] != $excel['J']) {$notice = $notice.'afname gewijzigd. ';}
      if ($this->itemData['hulp'] != $excel['K']) {$notice = $notice.'hulp gewijzigd. ';}
      if ($this->itemData['duur'] != $excel['L'] && !($this->itemData['duur'] == null && $excel['L']=='NULL')) {$notice = $notice.'duur gewijzigd. ';}
      // SE-status is voor de check al omgezet in numeriek, dus aangepaste check
      // if ($this->itemData['SE'] != $excel['M']) {$notice = $notice.'SE-status gewijzigd. ';}
      if (($this->itemData['SE']=='ja' && $excel['M']!=1) || ($this->itemData['SE']=='nee' && $excel['M']!=0)) {$notice = $notice.'SE-status gewijzigd. ';}
      if ($this->itemData['wegingSE'] != $excel['N'] && !($this->itemData['wegingSE'] == null && $excel['N']=='NULL')) {$notice = $notice.'weging SE gewijzigd. ';}
      // herkansbaar is voor de check al omgezet in numeriek, dus aangepaste check
      // if ($this->itemData['herkansbaar'] != $excel['O']) {$notice = $notice.'herkansbaarheid gewijzigd. ';}
      if (($this->itemData['herkansbaar']=='ja' && $excel['O']!=1) || ($this->itemData['herkansbaar']=='nee' && $excel['O']!=0) || $excel['O']=='NULL') {$notice = $notice.'herkansbaarheid gewijzigd. ';}
      if ($this->itemData['domeinen'] != $excel['P']) {$notice = $notice.'domeinen gewijzigd. ';}
      if ($notice == '') {
          echo '<h4>identiek item</h4>';
          return true;
      }
      else {
          echo '<h4>verschil: '.$notice.'</h4>';
        echo '<pre>';
        print_r($excel);
        echo '</pre>';
        echo '<hr><pre>';
        print_r($this->itemData);
        echo '</pre>';          
          return false;
        }      
  }
}
?>