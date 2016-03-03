<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {

	public function read($param = false, $is_count = false){
		if($param){
			if($param['sidx']){
				$this->db->order_by($param['sidx'],$param['sord']);
			}
			if(!$is_count){
				$this->db->limit($param['limit'],$param['start']);
			}
			return $this->db->get('ref_angkutan_type');echo $this->db->last_query();
		}
		return false;		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/home.php */