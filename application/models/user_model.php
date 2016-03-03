<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

	public function read($param = false, $is_count = false){
		if($param){
			if($param['search']){
				foreach($param['filters']->rules as $rule){
					$this->db->where("upper(".$rule->field.") like '%".strtoupper($rule->data)."%'");
				}
			}
			if($param['sidx']){
				$this->db->order_by($param['sidx'],$param['sord']);
			}
			if(!$is_count){
				$this->db->limit($param['limit'],$param['start']);
			}
			return $this->db->get('adm_user');echo $this->db->last_query();
		}
		return false;		
	}


	public function add($param = false){
		if($param){
			if($this->db->insert('adm_user',$param)){
				return $this->db->insert_id();
			}else{
				return false;
			}
		}
		return false;
	}

	public function edit($id = false,$param = false){
		if($id && $param){
			$this->db->where('USER_ID',$id);
			if($this->db->update('adm_user',$param)){
				return $id;
			}else{
				return false;
			}
		}
		return false;
	}

	public function delete($id = false){
		if($id){
			$this->db->where('USER_ID',$id);
			if($this->db->delete('adm_user')){
				return $id;
			}else{
				return false;
			}
		}
		return false;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/home.php */