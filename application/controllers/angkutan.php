<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Angkutan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Angkutan_model','get_db');
	}

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		if($this->session->userdata('USER_ID')){
			$ang_types = $this->get_db->get_angkutan_type();
			$ang_type = "{";
			foreach($ang_types->result_array() as $idx=>$tp){
				$ang_type .= $tp['TP_ID'].":'".addslashes($tp['TP_NAME'])."'";
				if($idx < $ang_types->num_rows()-1){
					$ang_type .= ",";
				}
			}
			$ang_type .= "}";

			$jalans = $this->get_db->get_jalan();
			$jalan = "{";
			foreach($jalans->result_array() as $idx=>$tp){
				$jalan .= $tp['JL_ID'].":'".addslashes($tp['JL_NAME'])."'";
				if($idx < $jalans->num_rows()-1){
					$jalan .= ",";
				}
			}
			$jalan .= "}";

			$data['ang_type'] = $ang_type;
			$data['jalan'] = $jalan;
			$this->load->view('angkutan_view',$data);	
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
			$cell[] = '<a href="javascript:void(0);" onclick="show_route('.$row['ANG_ID'].',\''.$row['ANG_NAME'].'\',\''.$row['ANG_TRAYEK'].'\');">Show Route</a>';
			$arr[$idx]['id'] = $row['ANG_ID'];
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

	public function upload_image(){
		$folder = 'picture/';
		if(!file_exists($folder.$_FILES['ANG_IMG']['name'])){
			if(move_uploaded_file($_FILES['ANG_IMG']['tmp_name'],$folder.$_FILES['ANG_IMG']['name'])){
				if($this->get_db->edit($_POST['ANG_ID'],array('ANG_IMG'=>$_FILES['ANG_IMG']['name']))){
					echo '{"success":true,"message":"Update Success"}';		
				}else{
					echo '{"success":true,"message":"Upload Success, but update data failed"}';	
				}
				
			}else{
				echo '{"success":false, "message":"Upload failed"}';		
			}
		}else{
			if($this->get_db->edit($_POST['ANG_ID'],array('ANG_IMG'=>$_FILES['ANG_IMG']['name']))){
				echo '{"success":true,"message":"Upload ALready Exist and Update Success"}';		
			}else{
				echo '{"success":true,"message":"Upload ALready Exist,but update data failed"}';	
			}
		}
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/home.php */