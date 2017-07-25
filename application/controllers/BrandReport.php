<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BrandReport extends CI_Controller {

	function __construct()
    {
        parent::__construct();

		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		$this->output->set_header('Pragma: no-cache');
        $this->load->model('BrandModel', '', TRUE);//tell the model loading method to auto-connect by passing TRUE (boolean) via the third parameter, and connectivity settings, as defined in your database config file will be used
		//$this->load->model('miscode_cost_model', '', TRUE);
		//$this->load->model('common_model', '', TRUE);
	}
	function view ($menu_group,$menu_cat)
	{

		//if ($this->session->userdata['user']['login_status'])
		//{
			$id='';
            $report_list = array("Select One", "MIS Code wise Cost Allocation", "Vendor wise Payment Information (ALL)", "Vendor Payment Information (Individual)", "Category wise Monthly Expenditure Statement", "Vendor and Month wise TAX Payment History", "Vendor and Month wise VAT Payment History", "Department & Date wise Bill Return Report", "Bill Paid Report without VAT and TAX");


            //$result = $this->user_model->get_parameter_data('ref_service_category','name',"sts = '1'");
            $this->BrandModel->getAllBrandsasc();//getting all brands

            $service_list['0']="Select One";
            

            foreach ($result as $row){
                $service_list[$row->id] = $row->name;
            }

            $current_year= date("Y");

            $year_list['0']="Select All";
            for($i = 1990; $i <= $current_year; $i++){
                $year_list[$i] = $i;
            }

            $result = $this->user_model->get_parameter_data('vendor', 'name', "sts = '1'");
            
            $vendor_list = array();
            foreach ($result as $row){
                $vendor_list[$row->vendor_id] = $row->name;
            }


            $result = $this->user_model->get_parameter_data('cost_center', 'name', "sts = '1'");
            //$cost_center_list['0']="Select All";
            $cost_center_list=array();
            foreach ($result as $row){
                $cost_center_list[$row->code]=$row->name;
            }

            $result = $this->user_model->get_parameter_data('ref_department', 'name', "sts = '1'");
            //$cost_center_list['0']="Select All";
            $department_list=array();
            foreach ($result as $row){
                $department_list[$row->id]=$row->name;
            }

            $result = $this->user_model->get_parameter_data('ref_currency', 'name', "sts = '1'");
            //$cost_center_list['0']="Select All";
            $currency_list=array();
            foreach ($result as $row){
                $currency_list[$row->id]=$row->name;
            }
            //echo $_POST['currency_list'];exit;
            $report_list_sl = isset($_POST['report_list'])?$this->input->post('report_list'):0;
            $vendor_select=isset($_POST['vendor_list'])?$_POST['vendor_list']:0;
            $dept_select=isset($_POST['dept_list'])?$_POST['dept_list']:0;
            $cost_center_select=isset($_POST['cost_center_list'])?$_POST['cost_center_list']:0;
            $year_select=isset($_POST['year_list'])?$_POST['year_list']:0;
            $service_select=isset($_POST['service_list'])?$_POST['service_list']:0;
            $department_select=isset($_POST['department_list'])?$_POST['department_list']:0;
            $currency_select=isset($_POST['currency_list'])?$_POST['currency_list']:999;
            $rFromDat=isset($_POST['rFromDate'])?$_POST['rFromDate']:'';
            $rToDat=isset($_POST['rToDate'])?$_POST['rToDate']:'';
            $dFromDat=isset($_POST['dFromDate'])?$_POST['dFromDate']:'';
            $dToDat=isset($_POST['dToDate'])?$_POST['dToDate']:'';

            $ser_fields=$report_list_sl.':'.$vendor_select.':'.$cost_center_select.':'.$year_select.':'.$service_select.':'.$department_select.':'.implode('-',array_reverse(explode('/',$rFromDat))).':'.implode('-',array_reverse(explode('/',$rToDat))).':'.implode('-',array_reverse(explode('/',$dFromDat))).':'.implode('-',array_reverse(explode('/',$dToDat))).':'.$currency_select;

            $post_sts = count($_POST)>0?1:0;

            $result = $this->miscode_cost_model->get_vatax_all($post_sts, $report_list_sl, $cost_center_select, $vendor_select, $year_select, $service_select, $department_select, $rFromDat, $rToDat, $dFromDat, $dToDat, $currency_select);
            // echo $this->db->last_query();exit;

			$data = array(
                'menu_group'=> $menu_group,
                'menu_cat'=> $menu_cat,
                'report_list' => $report_list,
                'report_select' =>$report_list_sl,
                'cost_center_list' => $cost_center_list,
                'cost_center_select' => $cost_center_select,
                'vendor_list' => $vendor_list,
                'vendor_select' => $vendor_select,
                'year_list' => $year_list,
                'year_select' => $year_select,
                'service_list' => $service_list,
                'service_select' => $service_select,
                'department_list' => $department_list,
                'currency_list' => $currency_list,
                'department_select' => $department_select,
                'currency_select' => $currency_select,
                'rFromDat' => $rFromDat,
                'rToDat' => $rToDat,
                'dFromDat' => $dFromDat,
                'dToDat' => $dToDat,
                'result' => $result,
                'ser_fields' => $ser_fields,
                'post_sts' => $post_sts,
                'pages'=> 'miscode_cost/pages/grid'
            );

			$this->load->view('grid_layout',$data);

			//print_r($result);
			//die();
		// }

		// else {
		// 	redirect('/home');
		// }
	}


    function index() {
        // $aray = explode(":",$search_fieldes);

        // $report_list_sl = $aray[0];
        // $vendor_select = $aray[1];
        // $cost_center_select = $aray[2];
        // $year_select = $aray[3];
        // $service_select = $aray[4];
        // $rFromDat = $aray[5];
        // $rToDat = $aray[6];
        // $dFromDat = $aray[7];
        // $dToDat = $aray[8];
        // $currency_select = $aray[9];

        // if($report_list_sl == 1) {

        //     $mis_list = $this->miscode_cost_model->get_child_list('cost_center', 'id', $cost_center_select);


        // if($mis_list->mis_codes){
        //     $mis_heading = explode(",", $mis_list->mis_codes);
        // }

            // $date_start = date('Y-m-d');
            // $principalbr = 101;
            // $CurrCy = "BDT";
            // $EXCH_RATE = 1;
            // $dr = 0.00;
            // $cr = 0.00;
            // $tamt = 0.00;
            // $date = date('d-M-Y');

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

            $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Brand Information Report');
            $objPHPExcel->getActiveSheet()->getStyle("B2:E2")->getFont()->setSize(18);
            $objPHPExcel->getActiveSheet()->getStyle('B2:E2')->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $objPHPExcel->getActiveSheet()->mergeCells('B2:E2');
            // Setting the column headings
            $headings1 = array('Brand ID', 'Brand Name', '# of Models','# of Items');
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
            $result = $this->BrandModel->getAllBrandsasc();
            // $rst=$this->gefo_model->gefo_report_generation($ref_no);
            foreach($result as $row2)
            {
                // $cser=explode(',', $row2->mis_code);
                // $aser=explode(',', $row2->amount);
                // $i++;
                // $sum = 0;
                // $headings1 = array($row2->cost_center,$row2->gl_account,$row2->account_description);
                // $headings1 = array($row2->gl_account, $row2->account_description);
                // $k = 3; $h_total = 0; $v_total = 0;

                // for($m=0;$m<count($mis_heading);$m++){
                //     if (false !== $key = array_search($mis_heading[$m], $cser)) {

                //         $headings1 [$k++]=$aser[$key];
                //         $sum=$sum+$aser[$key];
                //     }else{
                //          $headings1 [$k++]='';
                //     }
                $BrandArray = array('brand_id' =>$row2->brand_id,
                                    'name'=> $row2->name,
                                    'models'=>$row2->noOfModels,
                                    'items'=>$row2->noOfItems );




            
            
            //$headings1 [++$k]=$sum;

          //  $objPHPExcel->getActiveSheet()->getStyle('B'.$rowNumber)->getNumberFormat()->setFormatCode('0000000000000');

            $objPHPExcel->getActiveSheet()->fromArray(array($BrandArray),NULL,'B'.$rowNumber);

            // $c= $objPHPExcel->getActiveSheet()->getHighestColumn(); 
            // // print_r($c);
            // // exit();
            // // $objPHPExcel->getActiveSheet()->getStyle($c.'5')->getFont()->setBold(true);
            // // $objPHPExcel->getActiveSheet()->setCellValue($c.'3','Grand Total');
            // $objPHPExcel->getActiveSheet()->setCellValue('A4', $row2->cost_center);
            // $objPHPExcel->getActiveSheet()->getStyle('A4')->getNumberFormat()->setFormatCode('000');
            // $objPHPExcel->getActiveSheet()->getStyle('A'.$rowNumber.':C'.$rowNumber)->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            // $objPHPExcel->getActiveSheet()->getStyle('A'.$rowNumber.':C'.$rowNumber)->getAlignment() ->setWrapText(true);
            // $objPHPExcel->getActiveSheet()->mergeCells('A4:A'.$rowNumber);
            // $objPHPExcel->getActiveSheet()->getColumnDimension($c)->setWidth(15);
            // $objPHPExcel->getActiveSheet()->setCellValue('D2','MIS');
            // $objPHPExcel->getActiveSheet()->mergeCells('D2:'.$c.'2');
            // $objPHPExcel->getActiveSheet()->getStyle('D2:'.$c.'2')->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $objPHPExcel->getActiveSheet()->getStyle($c.'3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            // $objPHPExcel->getActiveSheet()->getStyle('A'.$rowNumber.':'.$c.$rowNumber )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            // $objPHPExcel->getActiveSheet()->getStyle('D'.$rowNumber.':'.$c.$rowNumber)->getNumberFormat()->setFormatCode('#,##0.00');
            $rowNumber++;

            }
            $rowNumber+= 3;

            $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowNumber, 'Powered by MicroMac Techno Valley BD 2017');

        //     $rowNumber = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        //     $last_col= $objPHPExcel->getActiveSheet()->getHighestColumn();
        //     $total_row = $rowNumber +1 ;
        //     $r =4;
        //     $col = 'D';

        //     for ($m=0;$m<=count($mis_heading);$m++) {
        //       //$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber.'=SUM('.$col.$r.':'.$col.$rowNumber-1.')');
        //         $objPHPExcel->getActiveSheet()->SetCellValue($col.$total_row, "=SUM(".$col.$r.":".$col.$rowNumber.")");

        //         ++$col;
        //      }

        // $objPHPExcel->getActiveSheet()->setCellValue('A'.$total_row,$cost_center_select.' Total');
        // $objPHPExcel->getActiveSheet()->getStyle('A'.$total_row.':'.$last_col.$total_row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        // $objPHPExcel->getActiveSheet()->getStyle('A'.$total_row.':'.$last_col.$total_row)->getFont()->setBold(true);
        // $objPHPExcel->getActiveSheet()->getStyle($last_col.$total_row)->getNumberFormat()->setFormatCode('#,##0.00');
        //    // $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');

        // // Rename sheet
        // $objPHPExcel->getActiveSheet()->setTitle('Mis code wise cose allocation');
        // // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        // $objPHPExcel->setActiveSheetIndex(0);

        /** PHPExcel_IOFactory */
        require_once './application/Classes/PHPExcel/IOFactory.php';

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="BrandInformation'.time().'_'.date('d_m_Y').'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit();

        }

            // elseif($report_list_sl==4)
            // {
            // report 4

        // $service_select
        //$year_select=2014;
        // $month_headings=array();
        // $month_array=array();
        //   for($month_no=1; $month_no<=12; $month_no++)
        // {
        //     if($month_no==1){$month_name='Jan'; $month_arr='01';}
        //     if($month_no==2){$month_name='Feb'; $month_arr='02';}
        //     if($month_no==3){$month_name='Mar'; $month_arr='03';}
        //     if($month_no==4){$month_name='Apr'; $month_arr='04';}
        //     if($month_no==5){$month_name='May'; $month_arr='05';}
        //     if($month_no==6){$month_name='Jun'; $month_arr='06';}
        //     if($month_no==7){$month_name='Jul'; $month_arr='07';}
        //     if($month_no==8){$month_name='Aug'; $month_arr='08';}
        //     if($month_no==9){$month_name='Sep'; $month_arr='09';}
        //     if($month_no==10){$month_name='Oct'; $month_arr='10';}
        //     if($month_no==11){$month_name='Nov'; $month_arr='11';}
        //     if($month_no==12){$month_name='Dec'; $month_arr='12';}
        //     $month_headings[] = $month_name .'-'.$year_select;
        //     $month_array[]= $month_arr;
        // }


        //     $date_start=date('Y-m-d');
        //   //  $batch_no=$this->gefo_model->get_batch_no($ref_no);
        //     $principalbr=101;
        //     $CurrCy="BDT";
        //     $EXCH_RATE=1;
        //     $dr=0.00;
        //     $cr=0.00;
        //     $tamt=0.00;
        //     $date=date('d-M-Y');

        //         error_reporting(E_ALL);
        //         date_default_timezone_set('Asia/Dhaka');
        //         require_once './application/Classes/PHPExcel.php';
        //         $objPHPExcel = new PHPExcel();

        //         $objPHPExcel->setActiveSheetIndex(0);
        //         $rowNumber = 4;
        //         // style

        //         $BStyle = array(
        //                   'borders' => array(
        //                     'allborders' => array(
        //                       'style' => PHPExcel_Style_Border::BORDER_THIN
        //                     )
        //                   )
        //                 );

        // $objPHPExcel->getActiveSheet()->setCellValue('B4','Sky Lounge monthly expenditure statement for the year '.$year_select);
        // $objPHPExcel->getActiveSheet()->mergeCells('B4:F4');
        // $objPHPExcel->getActiveSheet()->getStyle("B4:F4")->getFont()->setSize(16);
        // $rowNumber = 6;

        //         $headings1 = array('Nature of Expenses');
        //         $objPHPExcel->getActiveSheet()->fromArray(array($headings1),NULL,'B'.$rowNumber);
        //         $objPHPExcel->getActiveSheet()->fromArray(array($month_headings),NULL,'C'.$rowNumber);

        //         $objPHPExcel->getActiveSheet()->getStyle('B4:F4')->getFont()->setBold(true);//A-J is column and 1 for first row.
        //         $objPHPExcel->getActiveSheet()->getStyle('A6:O6')->getFont()->setBold(true);//A-J is column and 1 for first row.
        //         $objPHPExcel->getActiveSheet()->getStyle('A6:O6')->getAlignment() ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //         $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        //         $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(90);
        //         $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        //         $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        //         $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        //         $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        //         $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        //         $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        //         $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        //         $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        //         $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        //         $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        //         $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        //         $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        //         $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        // $rowNumber++;
        //  $i=0;

        //     $result= $this->miscode_cost_model->get_sky_launge_data($service_select,$year_select);
        // //     // $rst=$this->gefo_model->gefo_report_generation($ref_no);
        //     foreach($result as $row2)
        //     {

        //     $i++;
        //     $nature_of_exp = array($row2->name_expense);
        //     // $headings1 = array($row2->gl_account,$row2->account_description);
        //     //     $k=3; $h_total=0; $v_total=0;
        //     $k=3; $h_total=0;
        //         for($j=0;$j<12;$j++){
        //             $amount= $row2->amount;
        //             if($month_array[$j]==$row2->pay_month){
        //                 $nature_of_exp [$k++]=$row2->amount;
        //                 $h_total +=$row2->amount;

        //             }else{
        //                 $nature_of_exp [$k++]='';
        //             }
        //         }
        //         ++$k;
        //          $nature_of_exp[++$k]=$h_total;

        //   //  $objPHPExcel->getActiveSheet()->getStyle('B'.$rowNumber)->getNumberFormat()->setFormatCode('0000000000000');

        //     $objPHPExcel->getActiveSheet()->fromArray(array($nature_of_exp),NULL,'B'.$rowNumber);
        //     $c= $objPHPExcel->getActiveSheet()->getHighestColumn(); //K
        //     // print_r($c);
        //     // exit();

        //      $objPHPExcel->getActiveSheet()->setCellValue('O6','Total');

        //     $rowNumber++;

        //     }
        //     $rowNumber = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        //     $last_col= $objPHPExcel->getActiveSheet()->getHighestColumn();
        //     // print_r($rowNumber); 11
        //     // print_r($last_col); O
        //     // exit();
        //     $total_row = $rowNumber +1 ;
        //     $r =7;
        //     $col = 'C';

        // //     for ($m=0;$m<=12;$m++) {
        // //   //$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber.'=SUM('.$col.$r.':'.$col.$rowNumber-1.')');
        // //   $objPHPExcel->getActiveSheet()->SetCellValue($col.$total_row, "=SUM(".$col.$r.":".$col.$rowNumber.")");

        // //     ++$col;
        // // }

        //  $objPHPExcel->getActiveSheet()->setCellValue('B'.$total_row,' Total');
        //  $objPHPExcel->getActiveSheet()->getStyle('B'.$total_row.':O'.$total_row)->getFont()->setBold(true);
        //  $objPHPExcel->getActiveSheet()->getStyle('B6:O'.$total_row)->applyFromArray($BStyle);


        // // Rename sheet
        // $objPHPExcel->getActiveSheet()->setTitle('monthly expenditure');
        // // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        // $objPHPExcel->setActiveSheetIndex(0);

        // /** PHPExcel_IOFactory */
        //   require_once './application/Classes/PHPExcel/IOFactory.php';

        // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="MIS_Wise_cost'.time().'_'.date('d_m_Y').'.xls"');
        // header('Cache-Control: max-age=0');
        // $objWriter->save('php://output');
        // exit();

        //     }

    // }

    // function miscode_cost_pdf($search_fieldes=NULL) {
    //     $aray = explode(":", $search_fieldes);
    //    // print_r($aray);exit;
    //     $report_list_sl = $aray[0];

    //     $vendor_select = $aray[1];
    //     $cost_center_select = $aray[2];
    //     $year_select = $aray[3];
    //     $service_select = $aray[4];
    //     $department_select = $aray[5];
    //     $rFromDat = $aray[6];
    //     $rToDat = $aray[7];
    //     $dFromDat = $aray[8];
    //     $dToDat = $aray[9];
    //     $currency_select = $aray[10];

    //     $result = $this->miscode_cost_model->get_vatax_all(1, $report_list_sl, $cost_center_select, $vendor_select, $year_select, $service_select, $department_select, $rFromDat, $rToDat, $dFromDat, $dToDat, $currency_select);

    //    if($report_list_sl == 2){ $report_name = "Vendor wise Payment Information"; }
    //    elseif($report_list_sl == 3){ $report_name = "Vendor Payment Information"; }
    //    elseif($report_list_sl == 5){ $report_name = "Vendor and Month wise TAX Payment History (Total TAX Paid)"; }
    //    elseif($report_list_sl == 6){ $report_name = "Vendor and Month wise VAT Payment History (Total VAT Paid)"; }
    //    elseif($report_list_sl == 7){ $report_name = "Department & Date wise Bill Return Report"; }
    //    elseif($report_list_sl == 8){ $report_name = "Bill Paid Report without VAT and TAX"; }

    //    if($vendor_select != 0)
    //       { $vendor_name = $this->miscode_cost_model->get_parameter_name('vendor', $vendor_select); }
    //    else { $vendor_name = ''; }

    //     $data = array(
    //         'report_select' => $report_list_sl,
    //         'vendor_select' => $vendor_select,
    //         'vendor_name' => $vendor_name,
    //         'rFromDat' => $rFromDat,
    //         'rToDat' => $rToDat,
    //         'dFromDat' => $dFromDat,
    //         'dToDat' => $dToDat,
    //         'result' => $result,
    //         'reportName' => $report_name,
    //         'f' => str_replace($report_name, ' ', '_')
    //     );

    //     $this->load->view('miscode_cost/pages/pdf_report_view', $data);
    // }

}
?>