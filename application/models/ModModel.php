<?php
	class Model {
		var $name;
		var $brand_id;
	}

	class ModModel extends CI_MODEL
	{
		
		function __construct()
		{
			parent::__construct();
			$this->load->database();

		}
		


		public function getAllModels(){

		
			$this->db->select('mo.*, 
							   (SELECT name FROM brands AS br WHERE br.brand_id=mo.brand_id) AS brandName,
 							   (SELECT COUNT(*) FROM items AS i WHERE i.model_id=mo.model_id AND i.status=1) AS noOfItems', false)

					  			->order_by('model_id','desc')->from('models as mo')->where('mo.status',1);
		
			
			$q = $this->db->get();

			return $q->result();

		}

		public function getAllModelsasc(){

		
			$this->db->select('mo.*, 
							   (SELECT name FROM brands AS br WHERE br.brand_id=mo.brand_id) AS brandName,
 							   (SELECT COUNT(*) FROM items AS i WHERE i.model_id=mo.model_id AND i.status=1) AS noOfItems', false)

					  			->order_by('model_id','asc')->from('models as mo')->where('mo.status',1);
		
			
			$q = $this->db->get();

			return $q->result();

		}



		public function updateModelbyID($id,$brand_id,$name){

			$data = array
			(

				'model_id' =>$id,
				'brand_id' => $brand_id,
		        'name'  => $name
		        
			);


			$this->db->replace('models',$data);
			

		}
		////////////// deleting a model by supplied id
		public function deleteModel($id){

			
			$this->db->where('model_id',$id);
			$this->db->set('status',0);
			$this->db->update('models');
			$this->db->where('model_id',$id);
			$this->db->set('status',0);
			$this->db->update('items');
			
		}
		///////////////// Adding a row//////////////////////
		
		public function addModel($param_name,$param_brand_id){
			

			$m= new Model;
			$m->name = $param_name;
			$m->brand_id = $param_brand_id;
			$this->db->insert('models', $m); 
			
		}

		public function modelsForDD($id){
			$this->db->select('model_id,name')->from('models')->where('status=1 AND brand_id='.$id);
			$q= $this->db->get();
			return $q->result();

		}





	}




?>
