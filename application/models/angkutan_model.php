<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Angkutan_model extends CI_Model {

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
			$this->db->select('A.ANG_ID,B.TP_NAME,A.ANG_NAME,A.ANG_TRAYEK,A.ANG_IMG');
			$this->db->from('ref_angkutan A');
			$this->db->join('ref_angkutan_type B','A.ANG_TYPE = B.TP_ID','left');
			return $this->db->get();echo $this->db->last_query();
		}
		return false;		
	}

	public function get_angkutan_type(){
		$this->db->select('TP_ID,TP_NAME');
		return $this->db->get('ref_angkutan_type');
	}

	public function get_jalan(){
		$this->db->select('JL_ID,JL_NAME');
		return $this->db->get('ref_jalan');
	}

	public function add($param = false){
		if($param){
			if($this->db->insert('ref_angkutan',$param)){
				return $this->db->insert_id();
			}else{
				return false;
			}
		}
		return false;
	}

	public function edit($id = false,$param = false){
		if($id && $param){
			$this->db->where('ANG_ID',$id);
			if($this->db->update('ref_angkutan',$param)){
				return $id;
			}else{
				return false;
			}
		}
		return false;
	}

	public function delete($id = false){
		if($id){
			$this->db->where('ANG_ID',$id);
			return $this->db->delete('ref_angkutan');
		}
		return false;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/home.php */