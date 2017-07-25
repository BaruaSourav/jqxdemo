<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelReport extends CI_Controller {

	function __construct()
    {
        parent::__construct();

		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		$this->output->set_header('Pragma: no-cache');
        $this->load->model('ModModel', '', TRUE);//tell the model loading method to auto-connect by passing TRUE (boolean) via the third parameter, and connectivity settings, as defined in your database config file will be used
		
        //$this->load->model('miscode_cost_model', '', TRUE);
		//$this->load->model('common_model', '', TRUE);
	}
	

    function index() {
        
            error_reporting(E_ALL);
            date_default_timezone_set('Asia/Dhaka');
            
            //importing the PHPExcel library
            require_once './application/Classes/PHPExcel.php';
            //creating a phpExcel object 
            $objPHPExcel = new PHPExcel();
            //setting presenr=t sheets index to 0
            $objPHPExcel->setActiveSheetIndex(0);
            // $rowNumber defines from where we will start the reports table
            $rowNumber = 6;
            //Setting Date
            $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Date: '.date("F j, Y"));

            $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Model Information Report');
            $objPHPExcel->getActiveSheet()->getStyle("B2:E2")->getFont()->setSize(18);
            $objPHPExcel->getActiveSheet()->getStyle('B2:E2')->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $objPHPExcel->getActiveSheet()->mergeCells('B2:E2');
            // Setting the column headings
            $headings1 = array('Model ID', 'Model Name', 'Brand Name [ID]','# of Items');
            $objPHPExcel->getActiveSheet()->fromArray(array($headings1), NULL,'B'.$rowNumber);
            
            //$objPHPExcel->getActiveSheet()->fromArray(array($mis_heading), NULL,'D'.$rowNumber);
            
            //excel file header set to bold
            $objPHPExcel->getActiveSheet()->getStyle('B2:E2')->getFont()->setBold(true);
            //setting the heading formats 
            $objPHPExcel->getActiveSheet()->getStyle('B6:E6')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B6:E6')->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //setting width of all the columns

            $objPHPExcel->getActiveSheet()
                        ->getStyle('B2:E2')
                        ->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setRGB('42cef4');

            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            //getting the highest column of the active worksheet
            $c= $objPHPExcel->getActiveSheet()->getHighestColumn();

            $objPHPExcel->getActiveSheet()->getStyle('B'.$rowNumber.':'.$c.$rowNumber )->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$rowNumber.':'.$c.$rowNumber )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$rowNumber.':'.$c.$rowNumber)->getFont()->setBold(true);

            $rowNumber++;
            $i = 0;

            //$result= $this->miscode_cost_model->get_search_data($cost_center_select);
            $result = $this->ModModel->getAllModelsasc();
            // $rst=$this->gefo_model->gefo_report_generation($ref_no);
            foreach($result as $row2)
            {
                
                $ModelArray = array('model_id' =>$row2->model_id,
                                    'name'=> $row2->name,
                                    'brandName'=>$row2->brandName.'['.$row2->brand_id.']',
                                    'items'=>$row2->noOfItems );




            
            
            //$headings1 [++$k]=$sum;

          //  $objPHPExcel->getActiveSheet()->getStyle('B'.$rowNumber)->getNumberFormat()->setFormatCode('0000000000000');

            $objPHPExcel->getActiveSheet()->fromArray(array($ModelArray),NULL,'B'.$rowNumber);

            
            $rowNumber++;

            }
            $rowNumber+= 3;
            $objPHPExcel->getActiveSheet()
                        ->getStyle('B7:E256')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowNumber, 'Powered by MicroMac Techno Valley BD 2017');

        
        require_once './application/Classes/PHPExcel/IOFactory.php';

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ModelInformation'.time().'_'.date('d_m_Y').'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit();

        }

       
}
?>