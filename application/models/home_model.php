<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model {

	public function search_route($param = false){
		if($param){
			if($param['start'] && $param['end']){
				$this->db->select("LOCATE('937',r.ROUTE) STARTIDX,LOCATE('12',r.ROUTE) ENDIDX,r.*,a.*,t.*",false);
				$this->db->from('adm_route r');
				$this->db->join('ref_angkutan a','r.ANG_ID = a.ANG_ID','left');
				$this->db->join('ref_angkutan_type t','a.ANG_TYPE = t.TP_ID','left');
				$this->db->where("(r.ROUTE like '{$param['start']};%' OR r.ROUTE like '%;{$param['start']};%' or r.ROUTE like '%;{$param['start']}')");
				$this->db->where("(r.ROUTE like '{$param['end']};%' OR r.ROUTE like '%;{$param['end']};%' or r.ROUTE like '%;{$param['end']}')");
				$this->db->where("LOCATE('{$param['start']}',r.ROUTE) < LOCATE('{$param['end']}',r.ROUTE) ORDER BY substrCount(r.ROUTE,';') ASC");
				return $this->db->get(); echo $this->db->last_query();
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function get_jalan($param = false){
		$this->db->select("JL_NAME as label, JL_ID as id");
		if($param['search']){
			$this->db->where("upper(JL_NAME) like '%".strtoupper($param['search'])."%'");	
		}
		return $this->db->get('ref_jalan');
	}

	public function get_jalan_name($id = false){
		if($id){
			$this->db->where("JL_ID",$id);	
			return $this->db->get('ref_jalan');
			
		}else{
			return false;
		}
	}

	public function get_route($id = false){
		if($id){
			$this->db->where("(ROUTE like '{$id};%' OR ROUTE like '%;{$id};%' or ROUTE like '%;{$id}') ORDER BY substrCount(ROUTE,';') ASC");
			return $this->db->get('adm_route');
		}else{
			return false;
		}
	}

	public function direct_search($param=false){
		if($param){
			 return $this->db->query("
				/* Direct Access */
				SELECT 		rat.*,ra.*,
							(SELECT N.JL_NAME FROM ref_jalan N WHERE N.JL_ID = A.ROUTE) NAIK,
							(SELECT T.JL_NAME FROM ref_jalan T WHERE T.JL_ID = B.ROUTE) TURUN
				FROM 		adm_route A 
				LEFT JOIN 	adm_route B 
				ON 			A.ANG_ID = B.ANG_ID
				LEFT JOIN 	ref_angkutan ra 
				ON 			A.ANG_ID = ra.ANG_ID
				LEFT JOIN 	ref_angkutan_type rat 
				ON 			ra.ANG_TYPE = rat.TP_ID
				WHERE 		A.ROUTE = '".$param['start']."'
				AND 		B.ROUTE = '".$param['end']."'
				AND 		B.RT_ID >= A.RT_ID 
				GROUP BY 	B.ANG_ID
				ORDER BY 	B.RT_ID	
			");
			echo $this->db->last_query();
		}else{
			return false;
		}
	}

	// Pencarian berdasarkan titik keberangkatan
	public function base_search($param = false){
		if($param){
			 return $this->db->query("
				SELECT 		rat.*,ra.*,rj.*,A.ANG_ID,
							GROUP_CONCAT(B.ROUTE SEPARATOR ';') ROUTE,GROUP_CONCAT(rj2.JL_NAME SEPARATOR ';') ROUTE_NAME
				FROM 		adm_route A 
				LEFT JOIN 	adm_route B 
				ON 			A.ANG_ID = B.ANG_ID
				LEFT JOIN 	ref_angkutan ra 
				ON 			A.ANG_ID = ra.ANG_ID
				LEFT JOIN 	ref_angkutan_type rat 
				ON 			ra.ANG_TYPE = rat.TP_ID
				LEFT JOIN 	ref_jalan rj
				ON 			A.ROUTE = rj.JL_ID
				LEFT JOIN 	ref_jalan rj2
				ON 			B.ROUTE = rj2.JL_ID
				WHERE 		A.ROUTE = ".$param['start']."
				AND 		B.RT_ID > A.RT_ID 
				GROUP BY 	A.ANG_ID
				HAVING count(A.ANG_ID) > 0
				ORDER BY 	B.ROUTE
			"); echo $this->db->last_query();
		}else{
			return false;
		}
	}

	public function advance_search($param = false){
		if($param){
			
		}else{
			return false;
		}
	}

	public function infoangkutan($id = false){
		if($id){
			$this->db->from('ref_angkutan A');
			$this->db->join('ref_angkutan_type B','A.ANG_TYPE = B.TP_ID','left');
			$this->db->where('A.ANG_ID',$id);
			return $this->db->get();
		}
		return false;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/home.php */