<?PHP
// Fijne DOCS // https://rimas-kudelis.github.io/tcpdf/classes/TCPDF.html
/*  JS settings
    // A4 formaat is 21 x 29,7 cm | 72 ppi: 595 x 842
    var margeHorizontaal = 50;
    var margeVerticaal = 50;
    var contentBreedte = 842 - 2*margeHorizontaal;
    var contentHoogte = 595 - 2*margeVerticaal;
    var grootteKop = 60;

    var PTAType = 'niveau'; // 'vak' of 'niveau'
    var PTAsoort = 'A'; // A=PTA, B=PTB Bovenbouw
    var filterVak = 'NE';
    var filterNiveau = '4A';
    var voet = true;
    var waterMerk = false;
*/
class PTAPDF extends TCPDF {
    public function __construct() {
        parent::__construct();
        $this->setPageOrientation('L');
        $this->setPageUnit('pt'); // pt: point mm: millimeter (default) cm: centimeter in: inch
        $this->paginaBreedte = floor($this->getPageWidth());
        $this->paginaHoogte = floor($this->getPageHeight());
        $this->margeHorizontaal = 50;
        $this->margeVerticaal = 50;
        $this->contentBreedte = 842 - 2*$this->margeHorizontaal;
        $this->contentHoogte = 595 - 2*$this->margeVerticaal;
        $this->grootteKop = 60;
        $this->SetMargins($this->margeHorizontaal,$this->margeVerticaal,null);
        $this->SetHeaderMargin($this->margeVerticaal);
        $this->SetFooterMargin($this->margeVerticaal);

        $this->setHeaderFont(['courier','b',45]);
        $this->setFooterFont(['helvetica','b',30]); // STAAT NU IN EEN CEL
        $this->SetDefaultMonospacedFont('helvetica');
        $this->SetFont('helvetica', '', 11); // times helvetica courier dejavusans

        $this->setCellPaddings(5,5,5,5);
        $this->setCellMargins(0,0,0,0);
        $this->SetColor(240,240,240);
        $this->SetFillColor(0,255,255);
        $this->HeaderFillColor = 100;
        $this->HeaderTextColor = 240;
        $this->PageNumberColor = 100;
        $this->FooterTextColor = 200;
        $this->tabelFillColor = 245;
        $this->tabelLineColor = 240;
        $this->tabelcelHeaders = array('per','SOM','weging','her','duur','stofomschrijving','domeinen examen','hulpmiddelen');
        $this->defWidth = 50;
        $this->tabelCelbreedtes = array($this->defWidth,$this->defWidth,$this->defWidth,$this->defWidth,$this->defWidth,170,170,152);
    }

    public function Header() {
        //$image_file = K_PATH_IMAGES.'logo_example.jpg';
        //$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Cell(  $w,   $h,   $txt = '',   $border,   $ln,   $align = '',   $fill = false,   $link = '',
        //   $stretch,   $ignore_min_height = false,   $calign = 'T',   $valign = 'M') 
        $this->SetColor($this->HeaderTextColor);
        $this->SetFillColor($this->HeaderFillColor);
        $this->Cell($this->contentBreedte,null,'settings: cb='.$this->contentBreedte.' b='.array_sum($this->tabelCelbreedtes), 0, false, 'J', 1, null, 0, false, 'M', 'M');
    }

    public function Footer() {
        $this->SetY(-45); // negatief: vanaf onderen gerekend
        // SetFont(  $family,   $style = '',   $size = null,   $fontfile = '',   $subset = 'default',   $out = true) 
        $this->SetFont('helvetica',null,10);
        $this->SetTextColor($this->PageNumberColor);
        $this->SetColor(255,0,0);
        $this->Cell($this->contentBreedte,null, '|'.$this->PageNoFormatted().'|', 0, 0,'C',0,null, 0, false, 'M', 'M');
        $this->SetTextColor($this->FooterTextColor);
        $this->SetY(-45); // negatief: vanaf onderen gerekend
        $this->Cell($this->contentBreedte,null, 'PTA CSG Augustinus', 0, 1,'R',0,null, 0, false, 'M', 'M');
    }


    public function ptaJaarVak($data) {
        // lazy :)
        $w = $this->tabelCelbreedtes;
        $header = $this->tabelcelHeaders;        
        $this->SetFillColor($this->HeaderFillColor);
        $this->SetTextColor($this->HeaderTextColor);
        $this->SetDrawColor($this->HeaderFillColor);
        $this->SetLineWidth(0.1);
        $this->SetFont('', 'B');
        $align = 'C';
        for($i = 0; $i < count($header); ++$i) {
            if ($i > 4) {$align = 'L';}
            $this->MultiCell($w[$i],20,$header[$i],1,$align,true,0,null,null,true,0,false,true,null,'B',false);
        }
        $this->Ln();
        $this->SetFillColor($this->tabelFillColor);
        $this->SetDrawColor($this->tabelLineColor);
        $this->SetTextColor($this->HeaderFillColor);
        $this->SetFont(''); // fontreset
        $fill = 0;
        foreach($data as $row) {
            $align = 'C';
            for($i = 0; $i < count($header); ++$i) {
                if ($i > 4) {$align = 'L';}
                $this->MultiCell($w[$i],70,$row[$i],1,$align,$fill,0,null,null,true,0,false,true,null,'M',true);
            }
            $this->Ln();
            $fill=!$fill;
        }
    }
}
?>