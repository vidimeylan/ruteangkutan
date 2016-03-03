<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Route_model extends CI_Model {

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
			if($param['ANG_ID']){
				$this->db->where('A.ANG_ID',$param['ANG_ID']);
			}
			$this->db->select("A.RT_ID,B.JL_NAME,A.ROUTE_TYPE,A.ORDER");
			$this->db->from('adm_route A');
			$this->db->join('ref_jalan B','A.ROUTE = B.JL_ID','left');
			return $this->db->get();echo $this->db->last_query();
		}
		return false;		
	}


	public function add($param = false){
		if($param){
			if($this->db->insert('adm_route',$param)){
				return $this->db->insert_id();
			}else{
				return false;
			}
		}
		return false;
	}

	public function edit($id = false,$param = false){
		if($id && $param){
			$this->db->where('RT_ID',$id);
			if($this->db->update('adm_route',$param)){
				return $id;
			}else{
				return false;
			}
		}
		return false;
	}

	public function delete($id = false){
		if($id){
			$this->db->where('RT_ID',$id);
			return $this->db->delete('adm_route');
		}
		return false;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/home.php */