<?php

class Models extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('ModModel');
        $this->load->model('BrandModel');
    }
    
   function index(){
       $this->load->view('ModelList');
    }
    
    function loadData(){
        
        echo json_encode( $this->ModModel->getAllModels());
    }

    function updateRow($id){
         $updateID= $id;
         $name = $this->input->post('name');
         $brand_id = $this->input->post('brand_id');
         
         $this->ModModel->updateModelbyID($id,$brand_id,$name);

    }


    function getModelsForDD(){
        $bid= $this->input->get('brand_id');
        echo json_encode($this->ModModel->modelsForDD($bid));
    }


    function deleteModel($id){
         $deleteid= $id;
         $this->ModModel->deleteModel($id);

    }

    function addModel(){
        $name = $this->input->post('name');
        $brand_id = $this->input->post('brand_id');
        $this->ModModel->addModel($name,$brand_id);

    }
    function reportModel(){

        $data['report_select'] = 1;
        $data['reportName'] = 'Model Information Report';
        $data['result'] = $this->ModModel->getAllModelsasc();
        $data['f'] = 'ModelReport';
        $this->load->view('pdf_report_view',$data);
    }








}
    
    
    
    

