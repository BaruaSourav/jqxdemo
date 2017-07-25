<?php

class Brands extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('BrandModel');
    }
    
   function index(){
       $this->load->view('BrandList');
    }
    
    function loadData(){
        
        echo json_encode( $this->BrandModel->getAllBrands());
    }

    //this function is for populating the dropdown this returns the name and id of the brands only

    function getBrandsForDD(){
        echo json_encode($this->BrandModel->brandsForDD());
    }


    function updateRow($id){
         $updateID= $id;
         $name=$this->input->post('name');
        
         $this->BrandModel->updateBrandbyID($id,$name);

    }

    function deleteBrand($id){
         $deleteid= $id;
         $this->BrandModel->deleteBrand($id);

    }
    function addBrand(){
        $name = $this->input->post('name');
        $this->BrandModel->addBrand($name);

    }

    function reportBrand(){

        $data['report_select'] = 0;
        $data['reportName'] = 'Brand Information Report';
        $data['result'] = $this->BrandModel->getAllBrandsasc();
        $data['f'] = 'BrandReport';
        $this->load->view('pdf_report_view',$data);
    }



}
    
    
    
    

