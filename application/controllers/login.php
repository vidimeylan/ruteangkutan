<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('login_model','get_db');
	}

	
	public function do_login()
	{
		if ($_POST)
		{
			$cond['USERNAME'] = $_POST['user'];
			$cond['PASSWORD'] = md5($_POST['pass']);
			$get_user_data = $this->get_db->get_user_data($cond);
			if ($get_user_data->num_rows() > 0)
			{
				$arr_session = array();
				foreach ($get_user_data->row() as $key => $value)
				{
					$arr_session[$key] = $value;
				}
				$this->session->set_userdata($arr_session);
				echo '{"success": true}';
			}
			else
			{
				echo '{"success": false, "reason": "Invalid username or password."}';
			}
		}
		else
		{
			redirect();
		}
	}
	
	
	
	public function do_logout()
	{
		$this->session->sess_destroy();
		redirect();
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/home.php */