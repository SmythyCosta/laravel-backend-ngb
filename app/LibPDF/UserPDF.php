<?php

namespace App\LibPDF;
use Anouar\Fpdf\Fpdf as baseFpdf;

class UserPDF extends baseFpdf{

	public function __construct(){
		$orientation = 'L';
		$unit = 'mm';
		$size = 'A4';
		parent::__construct($orientation, $unit, $size);
	}

	function Header(){
		if($this->PageNo() != 1){
			$this->SetFont('Arial','B',12);
	        $this->cell(25,6,"ID",1,"","C");
	        $this->cell(45,6,"Name",1,"","L");
	        $this->cell(45,6,"Email",1,"","L");
	        $this->cell(45,6,"Phone",1,"","L");
	        $this->cell(35,6,"Address",1,"","L");
			$this->Ln();
		}
	}

}