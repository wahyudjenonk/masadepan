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
				$sql="SELECT * FROM tbl_harga_produk_peroutlet WHERE tbl_gerai_outlet_id=".$this->input->post('id_outlet');
				$data=$this->db->query($sql)->result_array();
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