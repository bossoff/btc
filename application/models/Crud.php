<?php

 class Crud extends CI_Model{
 	
 	public function settings($type){
 		$query = $this->db->get_where(db_prefix().'settings',['type' => $type]);
 		if($query->num_rows()>0){
 			return $query->row()->description;
 		}
 		return False;
 	}

 	public function smtp($type){
 		$query = $this->db->get_where(db_prefix().'smtp',['type' => $type]);
 		if($query->num_rows()>0){
 			return $query->row();
 		}
 		return False;
 	}


 	public function logactivities($param){
       $query = $this->db->insert(db_prefix().'activities', $param);
       return $query;
	}


	public function get_package(){
		$query =  $this->db->get(db_prefix().'package')->result_array();
		return $query;
	}	

}

?>