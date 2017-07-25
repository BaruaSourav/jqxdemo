<?php


	class Item {
			var $name;
			var $brand_id;
			var $model_id;
			var $date_added;
	}
	
	class ItemModel extends CI_MODEL
	{
		
		function __construct()
		{
			parent::__construct();
			$this->load->database();

		}
		


		public function getAllItems(){

		
			$this->db->select('i.*, 
							   (SELECT name FROM brands AS br WHERE br.brand_id=i.brand_id) AS brandName,
 							   (SELECT name FROM models AS m WHERE i.model_id=m.model_id) AS modelName', false)

					  			->order_by('item_id','desc')->from('items as i')->where('i.status',1);
		
			
			$q = $this->db->get();
			return $q->result();


		}
		public function getAllItemsasc(){

		
			$this->db->select('i.*, 
							   (SELECT name FROM brands AS br WHERE br.brand_id=i.brand_id) AS brandName,
 							   (SELECT name FROM models AS m WHERE i.model_id=m.model_id) AS modelName', false)

					  			->order_by('item_id','asc')->from('items as i')->where('i.status',1);
		
			
			$q = $this->db->get();
			return $q->result();


		}


		public function updateItembyID($id,$brand_id,$model_id,$name,$date_added){
			

			$data = array
			(	

				'item_id' =>$id,
				'model_id' =>$model_id,
				'brand_id' => $brand_id,
		        'name'  => $name,
		        'date_added'=>date('Y-m-d H:i:s', strtotime($date_added))
		        
			);



			$this->db->replace('items',$data);
			

		}
		////////////// deleting a model by supplied id
		public function deleteItem($id){

			
		
			$this->db->where('item_id',$id);
			$this->db->set('status',0);
			$this->db->update('items');
			
		}
		///////////////// Adding a row//////////////////////
		
		public function addItem($param_name,$param_brand_id,$param_model_id,$param_date){
			

			$i= new Item;
			$i->name = $param_name;
			$i->brand_id = $param_brand_id;
			$i->model_id = $param_model_id;

			//$date = str_replace('/', '-', $param_date);
			echo $param_date;

			$i->date_added = $param_date;

			$this->db->insert('items', $i); 
			
		}




	}




?>
