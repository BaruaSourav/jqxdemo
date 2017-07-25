<?php

class Items extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('ModModel');
        $this->load->model('BrandModel');
         $this->load->model('ItemModel');
    }
    
   function index(){
       $this->load->view('ItemList');
    }
    
    function loadData(){
        
        echo json_encode( $this->ItemModel->getAllItems());

    }

    function updateRow($id){
         $updateID= $id;
         $name = $this->input->post('name');
         $brand_id = $this->input->post('brand_id');
         $model_id = $this->input->post('model_id');
         $date_added = $this->input->post('date_added');
         
         echo $date_added;
         $this->ItemModel->updateItembyID($id,$brand_id,$model_id,$name,$date_added);

    }

    function deleteItem($id){
         $deleteid= $id;
         $this->ItemModel->deleteItem($id);

    }

    function addItem(){
        $name = $this->input->post('name');
        $brand_id = $this->input->post('brand_id');
        $model_id = $this->input->post('model_id');
        $date_added = date('Y-m-d', time());
        echo $date_added;

        $this->ItemModel->addItem($name,$brand_id,$model_id,$date_added);

    }
     function reportItem(){

        $data['report_select'] = 2;
        $data['reportName'] = 'Item Information Report';
        $data['result'] = $this->ItemModel->getAllItemsasc();
        $data['f'] = 'ItemReport';
        $this->load->view('pdf_report_view',$data);
    }






}
    
    
    
    

