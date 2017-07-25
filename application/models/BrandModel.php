<?php

	class Brand{
			var $name;
		}


	class BrandModel extends CI_MODEL
	{
		
		function __construct()
		{
			parent::__construct();
			$this->load->database();

		}
		


		public function getAllBrands(){

		
			$this->db->select('br.*, 
							   (SELECT COUNT(*) FROM items AS i WHERE i.brand_id=br.`brand_id` AND i.status=1) AS noOfItems,
 							   (SELECT COUNT(*) FROM models AS m WHERE m.brand_id=br.`brand_id` AND m.status=1) AS noOfModels', false)

					  ->order_by('brand_id','desc')->from('brands as br')->where('br.status',1);
		
			
			$q = $this->db->get();
			//echo $q->result();
			return $q->result();

		}


		public function getAllBrandsasc(){

		
			$this->db->select('br.*, 
							   (SELECT COUNT(*) FROM items AS i WHERE i.brand_id=br.`brand_id` AND i.status=1) AS noOfItems,
 							   (SELECT COUNT(*) FROM models AS m WHERE m.brand_id=br.`brand_id` AND m.status=1) AS noOfModels', false)

					  ->order_by('brand_id','asc')->from('brands as br')->where('br.status',1);
		
			
			$q = $this->db->get();
			//echo $q->result();
			return $q->result();

		}
		public function updateBrandbyID($id,$name){

			$data = array
			(
				'brand_id' => $id,
		        'name'  => $name
		        
			);


			$this->db->replace('brands',$data);
			

		}

		public function deleteBrand($id){

			
			$this->db->where('brand_id',$id);
			$this->db->set('status',0);
			$this->db->update('brands');

			$this->db->where('brand_id',$id);
			$this->db->set('status',0);
			$this->db->update('models');
			
			$this->db->where('brand_id',$id);
			$this->db->set('status',0);
			$this->db->update('items');
			
		}
		///////////////// Adding a row//////////////////////
		
		public function addBrand($param_name){
			$b= new Brand;
			$b->name = $param_name;
			$this->db->insert('brands', $b); 
		}
		// function returning id-name pair specially for dropdown of brands

		public function brandsForDD(){
			$this->db->select('brand_id,name')->from('brands')->where('status',1);
			$q= $this->db->get();
			return $q->result();

		}




	}




?>
