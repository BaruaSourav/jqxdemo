<?php


/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Colored Table
 * @author Nicola Asuni
 * @copyright 2004-2008 Nicola Asuni - Tecnick.com S.r.l (www.tecnick.com) Via Della Pace, 11 - 09044 - Quartucciu (CA) - ITALY - www.tecnick.com - info@tecnick.com
 * @link http://tcpdf.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 * @since 2008-03-04
 */
//error_reporting(0);
//require_once('./application/tcpdf/config/lang/eng.php');
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
require_once('./application/tcpdf/tcpdf.php');

// extend TCPF with custom functions
class MYPDF extends TCPDF {


    //Colored table
    function showBody($query,$creditData="") {
        //Colors, line width and bold font
        $this->SetFillColor(0);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.3);
        $this->writeHTML($creditData, false, false, false, true,'L');
        $this->Ln();
        //$this->writeHTMLCell(10, $h, 15, $this->getY()+3, "ahsgd asd sdg ghdg hgsd ag jasd gjhajgas jaagjh agajgahag a jag fadgj", 1, 0, 0, true, 'C');
    }
    //Generic Header of this report
    function showHeader()
    {
        $this->SetFont("dejavusans", "B", 12);
        $this->Cell(180,0,"MMTV Product Management Report",'',2,'C',0);
        $this->SetFont("dejavusans", "B", 10);
        $this->Cell(180,0,"Product Report",'',2,'C',0);
        $this->SetFont("dejavusans", "B", 8);
        // $this->Ln();
        // $this->writeHTML("<u>Documentation Check List</u>", true, false, false, true, 'C');
        $this->Ln();
        $this->SetFont("dejavusans", "", 8);
        $this->Cell(180,0,"Date: ".date("d M Y"),'',2,'R',0);
        $this->Ln();
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("MicroMac Techno Valley LTD.");
$pdf->SetTitle("MMTV Storage Report");
$pdf->SetSubject("Storage Report");
$pdf->SetKeywords("MMTV Storage");

// remove default header
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
/*
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
*/

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
//$pdf->setLanguageArray($l);

// add a page
$pdf->AddPage('P');
$rcv_total_amount = 0; 
$disb_total_amount = 0;

$ListData = '<table style="font-size:10px" width="100%"  border="0" cellspacing="0" cellpadding="1" align="center">
    <tr><td style="text-align:right"><img align="center" height="40" width="40" src="'.base_url().'images/cell.png"></td></tr>
    <tr><td style="font-size:10px;font-weight:bold" ><u>'.$reportName.'</u></td></tr>
    <tr><td></td></tr>
    <tr><td></td></tr>
    <tr>
        <td align="left">
        <table style="font-size:6px" width="100%" border="0.3" cellspacing="0" cellpadding="2" align="center">';
        //$sl=1;
        if($report_select == 0)
        {
            $ListData .= '<tr style="text-align:left; font-weight:bold; background-color:#268ed6;" >
                <td align="center" width="10%" class="head"> Brand ID</td>
                <td align="center" width="20%" class="head" > Brand Name</td>
                <td align="center" width="30%" class="head" > Models of this Brand</td>
                <td align="center" width="30%" class="head" > Items of this Brand</td>
            </tr>';
            foreach ($result as $row1)
            {
                $ListData.='<tr style="vertical-align:top;">
                    <td style="text-align:center;">'.$row1->brand_id.'</td>
                    <td style="text-align:left;">'.$row1->name.'</td>
                    <td style="text-align:center;">'.$row1->noOfModels.'</td>
                    <td style="text-align:center;">'.$row1->noOfItems.'</td>

                </tr>';
                //$rcv_total_amount = $rcv_total_amount + $row1->payable_amount;

               // $sl++;
            }
            // $ListData.='<tr style="vertical-align:top;">
            // <td style="text-align:right;" colspan="8"><strong>Total Recieved Amount</strong></td>
            // <td style="text-align:right;"><strong>'.number_format($rcv_total_amount, 2, '.', ',').'</strong></td>

            // </tr>';


        }
        elseif($report_select == 1)
        {
            $ListData .= '<tr style="text-align:left; font-weight:bold; background-color:#268ed6;" >
                <td align="center" width="10%" class="head"> Model ID</td>
                <td align="center" width="20%" class="head" > Model Name</td>
                <td align="center" width="30%" class="head" > Brand Name</td>
                <td align="center" width="30%" class="head" > Items of this Brand</td>
            </tr>';
            foreach ($result as $row1)
            {
                $ListData .= '<tr style="vertical-align:top;">
                    <td style="text-align:center;">'.$row1->model_id.'</td>
                    <td style="text-align:left;">'.$row1->name.'</td>
                    <td style="text-align:center;">'.$row1->brandName.'</td>
                    <td style="text-align:center;">'.$row1->noOfItems.'</td>

                </tr>';
               // $rcv_total_amount = $rcv_total_amount + $row1->payable_amount;
                //$sl++;
            }
            // $ListData.='<tr style="vertical-align:top;">
            // <td style="text-align:right;" colspan="7"><strong>Total Recieved Amount</strong></td>
            // <td style="text-align:right;"><strong>'.number_format($rcv_total_amount, 2, '.', ',').'</strong></td>
            // </tr>';
        }

        elseif($report_select == 2) // if item report
        {
           $ListData .= '<tr style="text-align:left; font-weight:bold; background-color:#268ed6;" >
                <td align="center" width="10%" class="head"> Item ID</td>
                <td align="center" width="20%" class="head" > Item Name</td>
                <td align="center" width="30%" class="head" > Brand Name</td>
                <td align="center" width="30%" class="head" > Model Name</td>
            </tr>';
            foreach ($result as $row1)
            {
                $ListData .= '<tr style="vertical-align:top;">
                    <td style="text-align:center;">'.$row1->item_id.'</td>
                    <td style="text-align:left;">'.$row1->name.'</td>
                    <td style="text-align:center;">'.$row1->brandName.'['.$row1->brand_id.']</td>
                    <td style="text-align:center;">'.$row1->modelName.'['.$row1->model_id.']</td>

                </tr>';
               // $rcv_total_amount = $rcv_total_amount + $row1->payable_amount;
                //$sl++;
            }
        }

      
    /////////////////////////////////////////////////////////

$ListData.= '</table>
    </td>
    </tr>
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size:7px;">&nbsp;&nbsp;** System generated report, No signature is required.</td></tr>
    </table>
    <div  style="text-align:center;margin-top:25px;">
        Sourav Barua 2017 @ mmtv 
    </div>

    ';

$pdf->SetFont('helvetica', '', 10);
$pdf->showHeader();
// Print colored table
$pdf->showBody("",$ListData);
//Close and output PDF document
$pdf->Output($f.".pdf", "D");

//============================================================+
// END OF FILE
//============================================================+
?>
