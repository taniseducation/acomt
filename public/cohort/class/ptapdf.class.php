<?PHP
/*  PDF
    - transparant watermerk
        https://tcpdf.org/examples/example_042/
    - autofitting tekst passen in cellen
        https://tcpdf.org/examples/example_005/
    - cel documentatie
        https://rimas-kudelis.github.io/tcpdf/classes/TCPDF.html#method_Cell
    - multicell documentatie
        https://rimas-kudelis.github.io/tcpdf/classes/TCPDF.html#method_MultiCell
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
        $this->FooterY = -0.5*$this->margeVerticaal;
        $this->grootteKop = 60;
        $this->SetMargins($this->margeHorizontaal,$this->margeVerticaal,null);
        $this->SetHeaderMargin($this->margeVerticaal);
        $this->SetFooterMargin($this->margeVerticaal);
        // onderstaande regel eenmalig gebruiken voor genereren
        // $this->fontName = TCPDF_FONTS::addTTFfont('css/NeueHaas.ttf', 'TrueTypeUnicode', '', 96);
        // gebruik times helvetica courier dejavusans ++ alles in de map CSS
        $this->SetDefaultMonospacedFont('helvetica');
        $this->SetFont('Corbel', '', 11); 
        $this->setHeaderFont(['NeueHaas',null,36]); // Segoe of NeueHaas
        $this->setFooterFont(['helvetica','b',30]); // STAAT NU IN EEN CEL

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
        $this->defCelheaderhoogte = 20;
        $this->defCelhoogte = 60;
        $this->defWidth = 44;
        $this->tabelCelbreedtes = array($this->defWidth,$this->defWidth,$this->defWidth,$this->defWidth,$this->defWidth,196,196,130);

        $this->laag = null;
    }

    public function Header() {
        //$image_file = K_PATH_IMAGES.'logo_example.jpg';
        //$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Cell(  $w,   $h,   $txt = '',   $border,   $ln,   $align = '',   $fill = false,   $link = '',
        //   $stretch,   $ignore_min_height = false,   $calign = 'T',   $valign = 'M')
        // DIT KAN NIET IN HEADER WANT DIE IS NIET
        $currentY=$this->GetY();
        $this->SetTextColor($this->HeaderTextColor);
        $this->SetFillColor($this->HeaderFillColor);
        //$this->Cell($this->contentBreedte,null,'settings: cb='.$this->contentBreedte.' b='.array_sum($this->tabelCelbreedtes), 0, false, 'J', 1, null, 0, false, 'M', 'M');
        $this->Cell($this->contentBreedte,null,'', 0, false, 'C', 1, null, 0, false, 'M', 'M');
        $this->SetY($currentY - 3);
        $this->Cell($this->contentBreedte,null,'', 0, false, 'C', 0, null, 0, false, 'M', 'M');
        $this->SetFontSize(50);
        $this->SetY($currentY - 3);
        $this->Cell($this->defWidth*2,null,$this->laag, 0, false, 'C', 0, null, 0, false, 'M', 'M');
    }

    public function Footer() {
        $this->SetY($this->FooterY); // negatief: vanaf onderen gerekend
        $this->SetFont('helvetica',null,10);
        $this->SetTextColor($this->PageNumberColor);
        $this->Write(0,'|'.$this->PageNoFormatted().'|', '', 0, 'C', true, 0, false, true, 0);
        $this->SetTextColor($this->FooterTextColor);
        $currentY=$this->GetY();
        $this->SetY($currentY - 12);
        $this->Write(0,'PTA CSG Augustinus', 0,false, 'L', true, 0, false, true, 0);
         /*
        $this->SetY($this->FooterY); // negatief: vanaf onderen gerekend
        $this->SetFont('helvetica',null,10);
        $this->SetTextColor($this->PageNumberColor);
        $this->SetColor(255,0,0);
        $this->Cell($this->contentBreedte,null, '|'.$this->PageNoFormatted().'|', 0, 0,'C',0,null, 0, false, 'M', 'M');
        $this->SetTextColor($this->FooterTextColor);
        $this->SetY($this->FooterY); // negatief: vanaf onderen gerekend
        $this->Cell($this->contentBreedte,null, 'PTA CSG Augustinus', 0, 1,'R',0,null, 0, false, 'M', 'M');
        */
    }


    public function ptaJaarVak($vak,$data,$algemeen) {
        $this->AddPage();
        $this->SetFont('NeueHaas', '', 36);
        $this->SetTextColor($this->HeaderTextColor);
        $this->SetFillColor($this->HeaderFillColor);
        $currentY=$this->GetY();
        $this->SetY($currentY - 3);
        $this->Cell($this->contentBreedte,null,$vak, 0, false, 'C', 0, null, 0, false, 'M', 'M');        
        $this->SetFont('Corbel', '', 11);
        $this->SetTextColor($this->HeaderTextColor);
        // lazy :)
        $w = $this->tabelCelbreedtes;
        $header = $this->tabelcelHeaders;        
        $this->SetFillColor($this->HeaderFillColor);
        $this->SetTextColor($this->HeaderTextColor);
        $this->SetDrawColor($this->HeaderFillColor);
        $this->SetLineWidth(0.1);
        $this->SetFont('', 'B');
        
        $this->Ln(30);
        for($i = 0; $i < count($header); ++$i) {
            if ($i > 4) {$align = 'L';} else {$align = 'C';}
            $this->MultiCell($w[$i],$this->defCelheaderhoogte,$header[$i],1,$align,true,0,null,null,true,0,false,true,null,'B',false);
        }
        $this->Ln();
        $this->SetFillColor($this->tabelFillColor);
        $this->SetDrawColor($this->tabelLineColor);
        $this->SetTextColor($this->HeaderFillColor);
        $this->SetFont(''); // fontreset
        $fill = 0;
        foreach($data as $row) {
            for($i = 0; $i < count($header); ++$i) {
                if ($i > 4) {$align = 'L';} else {$align = 'C';}
                $this->MultiCell($w[$i],$this->defCelhoogte,$row[$i],1,$align,$fill,0,null,null,true,0,false,true,null,'M',true);
            }
            $this->Ln();
            $fill=!$fill;
        }
        $currentY=$this->GetY();
        $this->SetY($currentY + 10);
        $this->SetFillColor($this->HeaderFillColor);
        $this->SetTextColor($this->HeaderTextColor);
        $this->SetDrawColor($this->HeaderFillColor);
        $this->SetLineWidth(0.1);
        $this->SetFont('', 'B');        
        $this->MultiCell($this->contentBreedte,$this->defCelheaderhoogte,'Opmerkingen',1,'L',true,0,null,null,true,0,false,true,null,'B',false);
        $this->SetTextColor($this->HeaderFillColor);
        $this->Ln();
        $this->MultiCell($this->contentBreedte,$this->defCelhoogte,$algemeen,1,'L',false,0,null,null,true,0,false,true,null,'B',false);
    }
}
?>