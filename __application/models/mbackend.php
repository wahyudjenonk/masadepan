<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class mbackend extends CI_Model{
	function __construct(){
		parent::__construct();
		//$this->auth = unserialize(base64_decode($this->session->userdata('sipbbg-k3pr1')));
	}
	
	function getdata($type="", $balikan="", $p1="", $p2=""){
		$where = " WHERE 1=1 ";
		switch($type){
			case "tbl_user":
				$sql = " 
					SELECT A.*
					FROM tbl_user A
				";
				if($p1=='edit'){
					$sql .=" WHERE A.id=".$p2;
				}
			break;		
			
		}
		
		if($balikan == 'row_array'){
			return $this->result_query($sql,'row_array');
		}elseif($balikan == 'result_array'){
			return $this->result_query($sql);
		}else{
			return $this->result_query($sql,'json');
		}
	}
	
	function result_query($sql,$type=""){
		switch($type){
			case "json":
				$page = (integer) (($this->input->post('page')) ? $this->input->post('page') : "1");
				$limit = (integer) (($this->input->post('rows')) ? $this->input->post('rows') : "10");
				$count = $this->db->query($sql)->num_rows();
				
				if( $count >0 ) { $total_pages = ceil($count/$limit); } else { $total_pages = 0; } 
				if ($page > $total_pages) $page=$total_pages; 
				$start = $limit*$page - $limit; // do not put $limit*($page - 1)
				if($start<0) $start=0;
				  
				$sql = $sql . " LIMIT $start,$limit";
			
				$data=$this->db->query($sql)->result_array();  
						
				if($data){
				   $responce = new stdClass();
				   $responce->rows= $data;
				   $responce->total =$count;
				   return json_encode($responce);
				}else{ 
				   $responce = new stdClass();
				   $responce->rows = 0;
				   $responce->total = 0;
				   return json_encode($responce);
				} 
			break;
			case "row_obj":return $this->db->query($sql)->row();break;
			case "row_array":return $this->db->query($sql)->row_array();break;
			default:return $this->db->query($sql)->result_array();break;
		}
	}
	
	// GOYZ CROTZZZ
	function simpan_data($table,$data,$get_id=""){ //$sts_crud --> STATUS NYEE INSERT, UPDATE, DELETE
		$this->db->trans_begin();
		$id=$this->input->post('id');
		$sts_crud=$this->input->post('sts_crud');
		unset($data['sts_crud']);
		//print_r($_POST);exit;
		switch ($table){
			case "tbl_user":
				$this->load->library('encrypt');
				if(isset($data['status'])){unset($data['status']);$data['status']=1;}
				if(isset($data['password'])){
					if($data['password']!=''){
						unset($data['password']);
						$pass=$this->encrypt->encode($this->input->post('password'));
						$data['password']=$pass;
					}
				}
			break;
		}
		//echo $this->db->last_query();exit;
		
		if($this->db->trans_status() == false){
			$this->db->trans_rollback();
			return 0;
		} else{
			if($get_id=='get_id'){
				$this->db->trans_commit();
				return $id;
			}else{
				return $this->db->trans_commit();
			}
		}
	}
		
}