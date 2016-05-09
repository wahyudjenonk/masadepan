<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class mservices extends CI_Model {

	function __construct() {
		parent::__construct();
		
        $ci = & get_instance();
	}
	
	function getdata($type, $p1=""){
		$where = "";
		switch($type){
			case "produk":
				//$sql="SELECT * FROM tbl_harga_produk_peroutlet WHERE tbl_gerai_outlet_id=".$this->input->post('id_outlet');
				//$sql="SELECT * FROM tbl_produk";
				$sts=0;
				$sql="SELECT * FROM tbl_log_data_transfer WHERE tbl_gerai_outlet_id=".$this->input->post('id');
				$res=$this->db->query($sql)->result_array();
				if(count($res)>0){
					$sql="SELECT A.id as id_cloud,A.kode_produk,A.nama_produk,A.deskripsi,A.hpp,
							A.margin,A.harga_jual,A.`status`,A.gambar,A.status_log
							FROM tbl_produk A
							WHERE A.id NOT IN (
								SELECT DISTINCT A.tbl_produk_id FROM tbl_log_data_transfer A WHERE A.tbl_gerai_outlet_id=".$this->input->post('id')."
							) AND A.`status`=1";
					
				}
				else{
					$sql="SELECT A.id as id_cloud,A.kode_produk,A.nama_produk,A.deskripsi,
							A.hpp,A.margin,A.harga_jual,A.`status`,A.gambar,A.status_log
							FROM tbl_produk A WHERE A.`status`=1";
							
				}
				$data=$this->db->query($sql)->result_array();
				foreach($data as $v){
					$ins_log=array('tbl_produk_id'=>$v['id_cloud'],
								   'tbl_gerai_outlet_id'=>$this->input->post('id'),
								   'create_date'=>date('Y-m-d H:i:s'));
					if($this->db->insert('tbl_log_data_transfer',$ins_log))$sts=1;
				}
				if($sts==1){return json_encode($data);}
				else{return json_encode(array('msg'=>0));}
			break;
			case "gerai":
				//print_r($_POST);exit;
				$sql="SELECT B.*,A.nama_perangkat,A.perangkat_id 
					  FROM tbl_perangkat_kasir A 
					  LEFT JOIN tbl_gerai_outlet B ON A.tbl_gerai_outlet_id=B.id 
					  WHERE A.perangkat_id='".$this->input->post('kode')."'";
				//$sql="SELECT * FROM tbl_perangkat_kasir WHERE perangkat_id=1";
				$data=$this->db->query($sql)->row_array();
				if(count($data)==0)$data=array('status'=>0);
				else{
					$sql="UPDATE tbl_perangkat_kasir set status=1 WHERE perangkat_id='".$this->input->post('kode')."'";
					$this->db->query($sql);
					$data['stat']=1;
				}
			break;
		}
		
		return json_encode($data);
	}
	
	function upload($type,$p1=""){
		//echo $_POST['judul'];exit;
		print_r($_POST);exit;
		$date=date('YmdHis');
		$fileElementName='file_ebook';
		$k_name = $this->db->query("
					SELECT sub_kategori
					FROM cl_sub_kategori
					WHERE id = '".$post['cl_sub_kategori_id']."'
				")->row_array();
		$k_nama = str_replace(" ", "_", $k_name['sub_kategori']);
		$upload_dir = "repository/file/".strtolower($k_nama)."/";
		
		
		//$upload_dir="repo/ebook/";
		$newFilename = $date;
		
		//print_r($this->sesina);exit;
		$fName = $_FILES[$fileElementName]['tmp_name'];
		$fSize = @filesize($_FILES[$fileElementName]['tmp_name']);
		@unlink($_FILES[$fileElementName]);		
		$filename = basename($_FILES[$fileElementName]['name']);
		//$tmp = explode(".", $filename);
		$tmp = pathinfo($filename, PATHINFO_EXTENSION);
		$newFilename .= '.'.$tmp;
		$uploadfile = $upload_dir . $newFilename;
		if(!file_exists($upload_dir))mkdir($upload_dir, 0777, true);
		if(file_exists($uploadfile)){chmod($uploadfile,0777);unlink($uploadfile);}
		
		move_uploaded_file($_FILES[$fileElementName]['tmp_name'], $uploadfile);
		
		if(!chmod($uploadfile, 0775)){
			
			$data["msg"]=2;
			$data["error"]="xx";
			$data["id"]="";
			//echo json_encode($data);exit;
		}
		else{
			$data["msg"]="OK";
			$data["error"]="";
			$data["id"]="";
			
		}
		echo json_encode($data);exit;
		
	}

	
}