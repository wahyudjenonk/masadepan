<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class mbackend extends CI_Model{
	function __construct(){
		parent::__construct();
		//$this->auth = unserialize(base64_decode($this->session->userdata('sipbbg-k3pr1')));
	}
	
	function getdata($type="", $balikan="", $p1="", $p2=""){
		$where = " WHERE 1=1 ";
		switch($type){
				
			case "tbl_produk":
				if($this->auth['cl_user_group_id']==2)$where .=" AND A.tbl_user_id=".$this->auth['id'];
				$data=array();
				$sql="SELECT * FROM tbl_produk A ".$where." AND A.id=".$this->input->post('id');
				$data['header']=$this->db->query($sql)->row_array();
				$sql="SELECT A.* FROM tbl_foto_produk A 
					  LEFT JOIN tbl_produk B ON A.tbl_produk_id=B.id
					  WHERE B.tbl_user_id=".$this->auth['id']." 
					  AND A.tbl_produk_id=".$this->input->post('id');
				$data['foto']=$this->db->query($sql)->result_array();
				//print_r($data);
				return $data;
			break;
			case "tbl_foto_produk":
				$sql="SELECT A.* FROM tbl_foto_produk A 
					  LEFT JOIN tbl_produk B ON A.tbl_produk_id=B.id
					  WHERE B.tbl_user_id=".$this->auth['id']." 
					  AND A.id=".$this->input->post('id');
				return $this->db->query($sql)->row_array();
			break;
			case "user":
				$sql = " 
					SELECT A.*
					FROM tbl_user A WHERE A.nama_user='".$p1."' OR A.email='".$p1."'
				";
			break;
			case "cek_user":
				if($balikan=='get'){
					$sql = " SELECT A.*	FROM tbl_user A 
							WHERE A.email='".$p1."'";
					$res=$this->db->query($sql)->row_array();
					return $res;
				}
				else{
					$sql = " SELECT A.*	FROM tbl_user A 
							WHERE A.email='".$this->input->post('email')."'";
					$res=$this->db->query($sql)->row_array();
					if(isset($res['email'])){echo 2;}
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
				//echo "<pre>";print_r($this->auth);
				if($this->auth['cl_user_group_id']==2)$where .=" AND A.tbl_user_id=".$this->auth['id'];
				$sql = "
					SELECT A.*, B.nama_kategori, 
						DATE_FORMAT(A.create_date,'%d %b %Y %h:%i %p') as tanggal_buat
					FROM tbl_produk A
					LEFT JOIN cl_kategori_produk B ON B.id = A.cl_kategori_id
				".$where;
			break;		
			case "supplier":
				if($this->auth['cl_user_group_id']==2)$where .=" AND A.tbl_user_id=".$this->auth['id'];
				$sql = "
					SELECT A.*,
						DATE_FORMAT(A.create_date,'%d %b %Y %h:%i %p') as tanggal_buat
					FROM tbl_supplier A
				".$where;
			break;		
			case "kategori_produk":
				if($this->auth['cl_user_group_id']==2)$where .=" AND A.tbl_user_id=".$this->auth['id'];
				$sql = "
					SELECT A.*,
						DATE_FORMAT(A.create_date,'%d %b %Y %h:%i %p') as tanggal_buat
					FROM cl_kategori_produk A
				".$where;
			break;		
			case "perangkat_kasir":
				if($this->auth['cl_user_group_id']==2)$where .=" AND B.tbl_user_id=".$this->auth['id'];
				$sql = "
					SELECT A.*, B.nama_outlet,
						DATE_FORMAT(A.create_date,'%d %b %Y %h:%i %p') as tanggal_buat
					FROM tbl_perangkat_kasir A
					LEFT JOIN tbl_gerai_outlet B ON B.id = A.tbl_gerai_outlet_id 
				".$where;
			break;		
			case "tbl_promo":
				if($this->auth['cl_user_group_id']==2)$where .=" AND A.tbl_user_id=".$this->auth['id'];
				$sql = "
					SELECT A.*
					FROM tbl_promo A
				".$where;
			break;
			case "outlet":
				if($this->auth['cl_user_group_id']==2)$where .=" AND tbl_user_id=".$this->auth['id'];
				$sql = "
					SELECT *, 
						DATE_FORMAT(create_date,'%d %b %Y %h:%i %p') as tanggal_buat
					FROM tbl_gerai_outlet
				".$where;
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
		$where = " WHERE 1=1 ";
		switch($type){
			case "cl_kategori_produk":
				if($this->auth['cl_user_group_id']==2)$where .=" AND tbl_user_id=".$this->auth['id'];
				$sql = "
					SELECT id, nama_kategori as txt
					FROM cl_kategori_produk
				".$where;
			break;
			case "tbl_gerai_outlet_id":
				if($this->auth['cl_user_group_id']==2)$where .=" AND tbl_user_id=".$this->auth['id'];
				$sql = "
					SELECT id, nama_outlet as txt
					FROM tbl_gerai_outlet
				".$where;
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
				$table = "tbl_".$table;
				$data['tbl_user_id'] = $this->auth['id'];
				/*if(!empty($_FILES['file_produk']['name'])){
					if($sts_crud == 'edit'){
						if($data['gambar_old'] != ""){
							$this->lib->hapus_file('satu', $path.$data['gambar_old']);
						}
						$data['status_log'] = 'E';
						$this->db->where('tbl_produk_id',$id);
						$this->db->delete('tbl_log_data_transfer');
						
						
					}
					
					$nm = str_replace(' ', '', $data['nama_produk']);
					$file = date('YmdHis')."_".$nm;
					$filename =  $this->lib->uploadnong($path, 'file_produk', $file); //$file.'.'.$extension;
					$data['gambar'] = $filename;
					$data['status_log'] = 'A';
				}else{
					if($sts_crud == 'edit'){
						if(isset($data['gambar_old'])){
							$data['gambar'] = $data['gambar_old'];
						}else{
							$data['gambar'] = null;
						}
						$data['status_log'] = 'E';
						$this->db->where('tbl_produk_id',$id);
						$this->db->delete('tbl_log_data_transfer');
					}elseif($sts_crud == 'add'){
						$data['gambar'] = null;
						$data['status_log'] = 'A';
					}
				}			
				
				if($sts_crud == 'delete'){
					$getimagename = $this->db->get_where('tbl_produk', array('id'=>$id) )->row_array();
					$this->lib->hapus_file('satu', $path.$getimagename['gambar']);
				}else{
					unset($data['gambar_old']);
				}
				*/
				
				
				
			break;
			case "supplier":
				$table = "tbl_".$table;
				if($sts_crud == 'add'){
					$data['status'] = 1;
				}
				$data['tbl_user_id'] = $this->auth['id'];
			break;
			case "kategori_produk":
				$data['tbl_user_id'] = $this->auth['id'];
				$table = "cl_".$table;
			break;
			case "perangkat_kasir":
				//	$data['tbl_user_id'] = $this->auth['id'];
				$table = "tbl_".$table;
			break;
			case "outlet":
				$data['tbl_user_id'] = $this->auth['id'];
				//$data['create_by'] = $this->auth['email'];
				$table = "tbl_gerai_outlet";
			break;
		}
		
		if($sts_crud == 'add'){
			$data['create_date'] = date('Y-m-d H:i:s');
			$data['create_by'] = $this->auth['email'];
			$this->db->insert($table, $data);
			if($table=="tbl_produk"){
				$id=$this->db->insert_id();
			}
		}elseif($sts_crud == 'edit'){
			$data['update_date'] = date('Y-m-d H:i:s');
			$data['update_by'] = $this->auth['email'];
			$this->db->update($table, $data, array($field_id=>$id) );
		}elseif($sts_crud == 'delete'){
			$this->db->delete($table, array($field_id=>$id) );
			//echo $this->db->last_query();exit;
		}
		
		
		
		if($this->db->trans_status() == false){
			$this->db->trans_rollback();
			return 0;
		}else{
			if($table=="tbl_produk"){
				if($sts_crud !='delete'){
					$this->db->trans_commit();
					$js=array('msg'=>1,'data'=>$id);
					return json_encode($js);
				}else{
					return $this->db->trans_commit();
				}
			}else{
				if($get_id=='get_id'){
					$this->db->trans_commit();
					return $id;
				}else{
					return $this->db->trans_commit();
				}
			}
			
		}
	}
	
	function simpan_reg($p1="",$p2=""){
		$this->db->trans_begin();
		$post = array();
        foreach($_POST as $k=>$v){if($this->input->post($k)!=""){$post[$k] = $this->db->escape_str($this->input->post($k));}}
		//print_r($post);exit;
		
		if($p1=="act"){
			$post['status']=1;
			$post['act_date']=date('Y-m-d H:i:s');
			$this->db->where('email',$p2);
			$this->db->update('tbl_user',$post);
		}else{
			unset($post['password2']);
			//unset($post['password']);
			$post['password']=$this->encrypt->encode($post['password']);
			$post['reg_date']=date('Y-m-d H:i:s');
			$post['status']=0;
			$post['cl_user_group_id']=2;
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