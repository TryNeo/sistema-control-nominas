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
    
    function renderHeader($title,$path_image,$position_x,$position_y,$width){
        $this->Image($path_image,$position_x,$position_y,$width);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont($this->fontName, 'B', 20);
        $this->Cell(0, 30, utf8_decode($title), 0, 1,'C');
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