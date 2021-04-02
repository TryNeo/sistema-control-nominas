<?php 
require_once ("./fpdf/fpdf.php");

class reporte extends fpdf{
    protected $Author;
    protected $fontName;
    protected $user;

    public function __construct(){
        parent::__construct();
        $this->fontName = 'helvetica';
        $this->Author = $_SESSION['user_data']['nombre']." ".$_SESSION['user_data']['apellido'];
        $this->user = $_SESSION['user_data']['usuario'];
    }
    
    function renderHeader($title,$subtitle,$path_image,$position_x,$position_y,$width){
        $this->Image($path_image,$position_x,$position_y,$width);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont($this->fontName, 'B', 26);
        $this->Cell(0, 80, utf8_decode($title), 0, 0,'C');
        $this->SetY(12);
        $this->SetTextColor(51, 51, 51);
        $this->SetFont($this->fontName, '', 9);
        $this->Cell(0, 90, utf8_decode($subtitle), 0, 0,'C');
        $this->Ln();
    }

    function renderText($title) {
        $this->SetTextColor(51, 51, 51);
        $this->SetY(70);
        $this->SetFont($this->fontName, '', 17);
        $this->Cell(0, 12, utf8_decode($title), 0,0,'C');
        $this->Ln();
    }

    
    function Footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','B',10);
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
        $this->SetX(0);
    }

}

?>