<?php

namespace App\LibPDF ;
use Anouar\Fpdf\Fpdf as baseFpdf;


class DamagedProductPDF extends baseFpdf{


    public function __construct(){
        $orientation = 'L';
        $unit = 'mm';
        $size = 'A4';
        parent::__construct($orientation, $unit, $size);
    }

    function Header(){
        if($this->PageNo() != 1){
            $this->SetFont('Arial','B',12);
            $this->cell(25,6,"SL",1,"","C");
            $this->cell(35,6,"Product Code",1,"","C");
            $this->cell(50,6,"Name",1,"","C");
            $this->cell(45,6,"Category",1,"","C");
            $this->cell(40,6,"Purchase Price",1,"","C");
            $this->cell(25,6,"Quantity",1,"","C");
            $this->cell(35,6,"Date",1,"","C");
            //$this->Cell(35,5,'User','TRB',0,'C');
            $this->Ln(); // Line break
        }
    }

    function SetCellMargin($margin){
        // Set cell margin
        $this->cMargin = $margin;
    }

    function Footer(){
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }


}