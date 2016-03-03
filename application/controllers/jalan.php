<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jalan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Jalan_model','get_db');
	}

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		if($this->session->userdata('USER_ID')){
			$this->load->view('jalan_view');	
		}else{
			die('You must login to access this page!');
		}	
	}

	public function read(){
		$page = isset($_POST['page'])?$_POST['page']:1; // get the requested page
		$param['limit'] = isset($_POST['rows'])?$_POST['rows']:5; // get how many rows we want to have into the grid
		$param['sidx'] = isset($_POST['sidx'])?$_POST['sidx']:false; // get index row - i.e. user click to sort
		$param['sord'] = isset($_POST['sord'])?$_POST['sord']:false; // get the direction
		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows']: false;
		$param['search'] = isset($_POST['_search'])?(($_POST['_search']=='false')?false:true):false;
		$param['filters'] = isset($_POST['filters'])?json_decode($_POST['filters']):false;
		if($totalrows !== false) {$param['limit'] = $totalrows;}
		$param['start'] = $param['limit']*$page - $param['limit'];
		$data = $this->get_db->read($param);
		$count = $this->get_db->read($param,true);
		if( $count->num_rows() >0 ) {
			$total_pages = ceil($count->num_rows()/$param['limit']);
		} else {
			$total_pages = 0;
		}
		$arr = array();
		foreach($data->result_array() as $idx=>$row){
			$cell = array();
			foreach($row as $col){
				$cell[] = $col;
			}

			$arr[$idx]['id'] = $row['JL_ID'];
			$arr[$idx]['cell'] = $cell;
		}
		echo '{"page":"'.$page.'","total":"'.$total_pages.'","records":"'.$count->num_rows().'","rows":'.json_encode($arr).'}';
	}

	public function action(){
		$act = false;
		if($_POST['oper'] == 'add'){
			$param = $_POST;
			unset($param['oper']);
			unset($param['id']);
			$act = $this->get_db->add($param);
		}else if($_POST['oper'] == 'edit'){
			$param = $_POST;
			unset($param['oper']);
			unset($param['id']);
			$act = $this->get_db->edit($_POST['id'],$param);
		}else if($_POST['oper'] == 'del'){
			$id_list = explode(',',$_POST['id']);
			$success=0;
			foreach($id_list as $id){
				if($this->get_db->delete($id)){
					$success++;
				}
			}
			if($success != 0){$act = true;}
		}

		if(!$act){
			echo '{"success":false,"message":"Process failed","id":null}';			
		}else{
			echo '{"success":true,"message":"","id":'.$act.'}';
		}
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/home.php */