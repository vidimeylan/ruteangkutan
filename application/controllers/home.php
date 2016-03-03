<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('home_model','hm');
	}

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		$param['search'] = isset($_POST['search'])?$_POST['search']:false;
		$data = $this->hm->get_jalan($param);
		if($data){
			$def['jalan'] = json_encode($data->result_array());
		}else{
			$def['jalan'] = null;
		}
		$this->load->view('home_view',$def);
	}

	
	public function search($start = false,$end = false){
		$param['start'] = isset($_POST['start'])?$_POST['start']:0;
		$param['end'] 	= isset($_POST['end'])?$_POST['end']:0;
		$param['org'] 	= isset($_POST['org'])?$_POST['org']:'Dari ... ';
		$param['dest'] 	= isset($_POST['dest'])?$_POST['dest']:'Tujuan ... ';

		// Mencari rute langsung
		$ds = $this->hm->direct_search($param);
		$o = '';
		$o2 = '';
		$error = '<table id="result_list" ><tr><td> Rute tidak ditemukan .. </td></tr></table>';

		// Jika ada rute langsung
		if($ds->num_rows()>0){
			$o .= '<table id="result_list" >';
			foreach($ds->result_array() as $idx=>$ang){
				$o .= '<tr><td>';
				$o .= '<table class="trayek-group">';
				$o .= '<tr class="trayek">';
				$o .= '<td class="no_urut">'.($idx+1).'</td>';
				$o .= '<td class="nama_angkutan" colspan="2"  idAngkutan="'.$ang['ANG_ID'].'">'.$ang['TP_NAME'].' - '.$ang['ANG_NAME'].' ( '.$ang['ANG_TRAYEK'].' ) '.'<span class="double_arrow"></span></td>';
				$o .= '</tr>';
				$o .= '<tr class="step">';
				$o .= '<td></td>';
				$o .= '<td class="naik"> Naik Dari : '.$ang['NAIK'].'</td>';
				$o .= '<td class="turun"> Turun di : '.$ang['TURUN'].'</td>';
				$o .= '</tr>';
				$o .= '</table><hr>';
				$o .= '</td></tr>';
			}
			$o .= '</table>';
		// Jika rute langsung tidak ditemukan

		}else{
			$tmp_arr = array();
			// Mencari rute angkutan yang melewati titik keberangkatan.
			$bs = $this->hm->base_search($param);
			// Jika query benar
			if($bs){
				// Jika ada angkutan yang ditemukan
				if($bs->num_rows()>0){
					$o .= '<table id="result_list" >';
					$no = 1;
					// Tiap rute yang ditemukan, kembali dicari rute sambungannya
					$finish = false;
					foreach($bs->result_array() as $idx=>$ang){											
																		
						// Kolom rute, dipecah berdasarkan semicolon ";"
						$s_route = explode(';',$ang['ROUTE']);
						$s_route_name = explode(';',$ang['ROUTE_NAME']);

						// Masing-masing rute pecahan, dicari rute sambungan menuju titik tujuan
						foreach($s_route as $idx_n=>$next_route){													
							$param2['start'] 	= $next_route;
							$param2['end'] 		= $param['end']; 							
							if(!in_array($param2,$tmp_arr)){
								$tmp_arr[] = $param2;
								// Mencari rute sambungan, menuju titik tujuan
								$ds2 = $this->hm->direct_search($param2);
								// Jika query benar
								if($ds2){
									// Jika ada rute sambungan, langsung ke titik tujuan
									if($ds2->num_rows()>0){
										$ang2 = $ds2->row_array();
										$o .= '<tr><td>';	
										$finish = $finish || true;	
										// $o .= "<script>$('#".$no.'-'.$ang['ANG_ID']."').tipsy({live: true});</script>";
										$o .= '<table class="trayek-group">';
											
										$o .= '<tr class="trayek">';
										$o .= '<td class="no_urut">'.($no++).'</td>';
										$o .= '<td class="nama_angkutan" colspan="2" idAngkutan="'.$ang['ANG_ID'].'">'.$ang['TP_NAME'].' - '.$ang['ANG_NAME'].' ( '.$ang['ANG_TRAYEK'].' ) '.'<span class="double_arrow"></span></td>';
										$o .= '</tr>';
										$o .= '<tr class="step">';
										$o .= '<td></td>';
										$o .= '<td class="naik"> Naik Dari : '.$ang['JL_NAME'].'</td>';
										$o .= '<td class="turun"> Turun di : '.$s_route_name[$idx_n].'</td>';
										$o .= '</tr>';
										
										$o .= '<tr class="trayek">';
										$o .= '<td class="no_urut"></td>';
										$o .= '<td class="nama_angkutan" colspan="2"  idAngkutan="'.$ang2['ANG_ID'].'"> sambung '.$ang2['TP_NAME'].' - '.$ang2['ANG_NAME'].' ( '.$ang2['ANG_TRAYEK'].' ) '.'<span class="double_arrow"></span></td>';
										$o .= '</tr>';
										$o .= '<tr class="step">';
										$o .= '<td></td>';
										$o .= '<td class="naik"> Naik Dari : '.$ang2['NAIK'].'</td>';
										$o .= '<td class="turun"> Turun di : '.$ang2['TURUN'].'</td>';
										$o .= '</tr>';		
																		
										$o .= '</table><hr>';	
										$o .= '</td></tr>';													
									}
								}
							}												
						}						
					}
					
					if(!$finish) $o .= '<tr><td> Rute tidak ditemukan .. </td></tr>';
					$o .= '</table>';					
				// Jika tidak ada yang melewati titik keberangkatan, tampilkan pesan error
				}else{
					$o = $error;
				}
			// Jika query salah
			}else{
				$o = $error;
			}
		}
		// echo $o;
		$data = $this->hm->get_jalan();
		if($data){
			$param['jalan'] = json_encode($data->result_array());
		}else{
			$param['jalan'] = null;
		}
		$param['result'] = $o;
		$this->load->view('result_view',$param);
	}

	function angkutan_tip($id){
		$o = 'No data found';
		if($id != 'undefined'){
			$ang_info = $this->hm->infoangkutan($id);
			if($ang_info){
				$ang_info = $ang_info->row_array();
				$o = '<table class="tip-content">';
				$o .= '<tr>';
				$o .= '<td class="tip-title" colspan="3">Informasi Detail</td>';
				$o .= '</tr>';
				$o .= '<tr>';
				$o .= '<td class="tip-item" >Type Angkutan </td>';
				$o .= '<td class="tip-value">'.$ang_info['TP_NAME'].'</td>';
				$o .= '<td rowspan="4" class="tip-image">';
				$o .= '<img src="'.base_url().'/picture/'.($ang_info['ANG_IMG'] == ''?'default.jpg':$ang_info['ANG_IMG']).'"/>';
				$o .= '</td>';
				$o .= '</tr>';
				$o .= '<tr>';
				$o .= '<td class="tip-item">Nama Angkutan </td>';
				$o .= '<td class="tip-value">'.$ang_info['ANG_NAME'].'</td>';
				$o .= '</tr>';			
				$o .= '<tr>';
				$o .= '<td class="tip-item">Trayek </td>';
				$o .= '<td class="tip-value">'.$ang_info['ANG_TRAYEK'].'</td>';
				$o .= '</tr>';
				$o .= '<tr>';
				$o .= '<td class="tip-item">Tarif </td>';
				$o .= '<td class="tip-value" colspan="2">'.(($ang_info['TP_TARIF'] == '')?'-':$ang_info['TP_TARIF']).'</td>';
				$o .= '</tr>';
				$o .= '</table>';
			}
		}
		echo $o;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/home.php */