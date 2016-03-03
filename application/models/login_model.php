<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function get_user_data($cond)
	{
		$this->db->from('adm_user');
		$this->db->where('UPPER(USER_NAME)', "'".strtoupper($cond['USERNAME'])."'", FALSE);
		$this->db->where('UPPER(PASSWORD)', "'".strtoupper($cond['PASSWORD'])."'", FALSE);
		$this->db->order_by('USER_NAME', 'ASC');
		// return $this->db->get('ADM_USER');
		return $this->db->get();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/home.php */