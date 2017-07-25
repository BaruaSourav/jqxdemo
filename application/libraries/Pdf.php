<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
        //$this->load->helper('url');
    }


    //Page header
    public function Header() {

    	// set cell padding
		$this->setCellPaddings(1, 1, 1, 1);
        // Logo
        $image_file = base_url('images/mmtvlogo.png');
        $this->Image($image_file, 15, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 14);
        // Title
        $this->MultiCell(70, 8,"ABC Store Reports \n", 0, 'L', 0, 0, '', '', true);
        //$this->ln(); 
        $this->SetFont('helvetica', 'B', 8);
        $this->MultiCell(70, 10,"Powered By MicroMac Techno Valley", 0, 'L', 0, 0, '30', '16', true);
        $this->MultiCell(70, 10,date("Y-m-d H:i:s"), 0, 'R', 0, 0, '120', '', true);
        //$this->Cell(50, 5, 'ABC Store Report'."\n", 0, false, 'L', 0, '', 0, false, 'M', 'M');
       	

        // $this->SetFont('helvetica', 'B', 11);
        // $this->Cell(0, 15, 'Powered by MicroMac Techno Valley', 0, false, 'L', 0, '', 0, false, 'M', 'M');
    }
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */