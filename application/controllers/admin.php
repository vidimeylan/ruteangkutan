<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('admin_model','get_db');
	}

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		if($this->session->userdata('USER_ID')){
			$this->load->view('admin_view');	
		}else{
			die('You must login to access this page!');
		}		
	}

	public function welcome(){
		$this->load->view('welcome_view');
	}

	public function read(){
		$page = isset($_POST['page'])?$_POST['page']:1; // get the requested page
		$param['limit'] = isset($_POST['rows'])?$_POST['rows']:5; // get how many rows we want to have into the grid
		$param['sidx'] = isset($_POST['sidx'])?$_POST['sidx']:false; // get index row - i.e. user click to sort
		$param['sord'] = isset($_POST['sord'])?$_POST['sord']:false; // get the direction
		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows']: false;
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
			$arr[$idx]['id'] = $row['TP_ID'];
			$arr[$idx]['cell'] = array($row['TP_ID'],$row['TP_NAME']);
		}
		echo '{"page":"'.$page.'","total":"'.$total_pages.'","records":"'.$count->num_rows().'","rows":'.json_encode($arr).'}';
	}

	public function save(){
		print_r($_POST);
	}

	public function get_data(){
		$examp = isset($_REQUEST["q"])?$_REQUEST["q"]:false; //query number

		$page = isset($_REQUEST['page'])?$_REQUEST['page']:5; // get the requested page
		$limit = isset($_REQUEST['rows'])?$_REQUEST['rows']:5; // get how many rows we want to have into the grid
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:false; // get index row - i.e. user click to sort
		$sord = isset($_REQUEST['sord'])?$_REQUEST['sord']:false; // get the direction
		if(!$sidx) $sidx =1;

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows']: false;
		if($totalrows) {$limit = $totalrows;}
				
		$dbhost = 'localhost';
		$dbuser   = 'root';
		$dbpassword = 'root';
		$database = 'griddemo';
		$wh = "";
		$db = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Connection Error: " . mysql_error());

		mysql_select_db($database) or die("Error conecting to db.");

		$result = mysql_query("SELECT COUNT(*) AS count FROM invheader a, clients b WHERE a.client_id=b.client_id".$wh);
		$row = mysql_fetch_array($result,MYSQL_ASSOC);
		$count = $row['count'];

		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
        if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
        if ($start<0) $start = 0;
        $SQL = "SELECT a.id, a.invdate, b.name, a.amount,a.tax,a.total,a.note FROM invheader a, clients b WHERE a.client_id=b.client_id".$wh." ORDER BY ".$sidx." ".$sord. " LIMIT ".$start." , ".$limit;
		$result = mysql_query( $SQL ) or die("Could not execute query.".mysql_error());
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i=0; $amttot=0; $taxtot=0; $total=0;
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$amttot += $row['amount'];
			$taxtot += $row['tax'];
			$total += $row['total'];
			$responce->rows[$i]['id']=$row['id'];
            $responce->rows[$i]['cell']=array($row['id'],$row['invdate'],$row['name'],$row['amount'],$row['tax'],$row['total'],$row['note']);
            $i++;
		}
		// $responce->userdata['amount'] = $amttot;
		// $responce->userdata['tax'] = $taxtot;
		// $responce->userdata['total'] = $total;
		// $responce->userdata['name'] = 'Totals:';
		//echo $json->encode($responce); // coment if php 5
        echo json_encode($responce);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/home.php */