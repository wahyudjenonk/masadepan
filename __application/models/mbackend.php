<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class mbackend extends CI_Model{
	function __construct(){
		parent::__construct();
		//$this->auth = unserialize(base64_decode($this->session->userdata('sipbbg-k3pr1')));
	}
	
	function getdata($type="", $balikan="", $p1="", $p2=""){
		$where = " WHERE 1=1 ";
		switch($type){
			case "user":
				$sql = " 
					SELECT A.*
					FROM tbl_user A WHERE A.nama_user='".$p1."'
				";
			break;
			case "cek_user":
				if($balikan=='get'){
					$sql = " SELECT A.*	FROM tbl_user A 
							WHERE A.nama_user='".$p1."'";
					$res=$this->db->query($sql)->row_array();
					return $res;
				}
				else{
					$sql = " SELECT A.*	FROM tbl_user A 
							WHERE A.nama_user='".$this->input->post('usr')."' OR A.email='".$this->input->post('email')."'";
					$res=$this->db->query($sql)->row_array();
					if(isset($res['nama_user'])){echo 2;}
					else echo 1;
					exit;
				}
			break;		
			case "tbl_user":
				$sql = " 
					SELECT A.*
					FROM tbl_user A
				";
				if($p1=='edit'){
					$sql .=" WHERE A.id=".$p2;
				}
			break;		
			case "produk":
				$sql = "
					SELECT A.*, B.nama_kategori
					FROM tbl_produk A
					LEFT JOIN cl_kategori_produk B ON B.id_kategori = A.cl_kategori_id
				";
			break;		
			case "supplier":
				$sql = "
					SELECT A.*
					FROM tbl_supplier A
				";
			break;		
			case "kategori_produk":
				$sql = "
					SELECT A.*
					FROM cl_kategori_produk A
				";
			break;		
			case "perangkat_kasir":
				$sql = "
					SELECT A.*, B.nama_outlet
					FROM tbl_perangkat_kasir A
					LEFT JOIN tbl_gerai_outlet B ON B.id = A.tbl_gerai_outlet_id 
				";
			break;		
			case "tbl_promo":
				$sql = "
					SELECT A.*
					FROM tbl_promo A
				";
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
	
	function get_combo($type="", $p1="", $p2=""){
		switch($type){
			case "cl_kategori_produk":
				$sql = "
					SELECT id, nama_kategori as txt
					FROM cl_kategori_produk
				";
			break;
			case "tbl_gerai_outlet_id":
				$sql = "
					SELECT id, nama_outlet as txt
					FROM tbl_gerai_outlet
				";
			break;
		}
		
		return $this->db->query($sql)->result_array();
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
		$post = array();
		$id = $this->input->post('id');
		$field_id = "id";
		$sts_crud = $this->input->post('sts_crud');
		unset($data['sts_crud']);
		
		switch ($table){
			case "produk":
				$path='__repo/produk/';
				$table = "tbl_".$table;
				if(!empty($_FILES['file_produk']['name'])){
					if($sts_crud == 'edit'){
						if($data['gambar_old'] != ""){
							$this->lib->hapus_file('satu', $path.$data['gambar_old']);
						}
					}
					
					$nm = str_replace(' ', '', $data['nama_produk']);
					$file = date('YmdHis')."_".$nm;
					$filename =  $this->lib->uploadnong($path, 'file_produk', $file); //$file.'.'.$extension;
					$data['gambar'] = $filename;
				}else{
					if($sts_crud == 'edit'){
						if(isset($data['gambar_old'])){
							$data['gambar'] = $data['gambar_old'];
						}else{
							$data['gambar'] = null;
						}
					}elseif($sts_crud == 'add'){
						$data['gambar'] = null;
					}
				}			
				
				unset($data['gambar_old']);
			break;
			case "supplier":
				$table = "tbl_".$table;
			break;
			case "kategori_produk":
				$table = "cl_".$table;
			break;
			case "perangkat_kasir":
				$table = "tbl_".$table;
			break;
		}
		
		if($sts_crud == 'add'){
			$data['create_date'] = date('Y-m-d H:i:s');
			$data['create_by'] = $this->auth['nama_user'];
			$this->db->insert($table, $data);
		}elseif($sts_crud == 'edit'){
			$data['update_date'] = date('Y-m-d H:i:s');
			$data['update_by'] = $this->auth['nama_user'];
			$this->db->update($table, $data, array($field_id=>$id) );
		}elseif($sts_crud == 'delete'){
			
		}
		
		if($this->db->trans_status() == false){
			$this->db->trans_rollback();
			return 0;
		}else{
			if($get_id=='get_id'){
				$this->db->trans_commit();
				return $id;
			}else{
				return $this->db->trans_commit();
			}
		}
	}
	
	function simpan_reg($p1="",$p2=""){
		$this->db->trans_begin();
		$post = array();
        foreach($_POST as $k=>$v){if($this->input->post($k)!=""){$post[$k] = $this->input->post($k);}}
		//print_r($post);exit;
		
		if($p1=="act"){
			$post['status']=1;
			$post['act_date']=date('Y-m-d H:i:s');
			$this->db->where('nama_user',$p2);
			$this->db->update('tbl_user',$post);
		}else{
			unset($post['password2']);
			//unset($post['password']);
			$post['password']=$this->encrypt->encode($post['password']);
			$post['reg_date']=date('Y-m-d H:i:s');
			$post['status']=0;
			$this->db->insert('tbl_user', $post);
		}
		if($this->db->trans_status() == false){
			$this->db->trans_rollback();
			return 0;
		}else{
			return $this->db->trans_commit();
			
		}
	}
		
}