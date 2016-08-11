<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class backend extends CI_Controller {

	function __construct(){
        parent::__construct();
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("If-Modified-Since: Mon, 22 Jan 2008 00:00:00 GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Cache-Control: private");
		header("Pragma: no-cache");
		$this->auth = unserialize(base64_decode($this->session->userdata($this->config->item('user_data'))));
		$this->host	= $this->config->item('base_url');
		$this->smarty->assign('host',$this->host);
		$this->smarty->assign('auth', $this->auth);
		$this->load->model('mbackend');
		$this->load->library('lib');
		$this->smarty->assign("acak", md5(date('H:i:s')));
	}

	public function index(){		
		if($this->auth){
			$this->smarty->display('main-backend.html');
		}else{
			if($this->session->flashdata('error')){
				$this->smarty->assign("error", $this->session->flashdata('error'));
			}
			$this->smarty->display('main-login.html');
		}
	}
	
	function modul($p1,$p2){
		if($this->auth){
			$this->smarty->assign("main", $p1);
			$this->smarty->assign("mod", $p2);
			$temp='template/'.$p2.'.html';
			if(!file_exists($this->config->item('appl').APPPATH.'views/'.$temp)){$this->smarty->display('konstruksi.html');}
			else{$this->smarty->display($temp);}	
		}
	}	
	
	function getdisplay($type="", $p1="", $p2=""){
		$display = false;
		switch($type){
			case "get-form":
				$sts_crud = $this->input->post('editstatus');
				//$this->smarty->assign("acak", md5(date('YmdHis').'ind') );				
				
				if($sts_crud == 'edit'){
					$table = $this->input->post('ts');
					
					$id = $this->input->post('id');
					$data = $this->db->get_where($table, array('id'=>$id) )->row_array();
					$this->smarty->assign('data', $data);
				}
				
				switch($p1){
					case "produk":
						$this->smarty->assign('cl_kategori_id', $this->lib->fillcombo('cl_kategori_produk', 'return', ($sts_crud == 'edit' ? $data['cl_kategori_id'] : "") ) );
						$this->smarty->assign('status', $this->lib->fillcombo('status', 'return', ($sts_crud == 'edit' ? $data['status'] : "") ) );
						if($sts_crud == 'edit'){
							$data = $this->mbackend->getdata('tbl_produk','get');
							$this->smarty->assign('data', $data);
						}
					break;
					case "kategori_produk":
						$this->smarty->assign('status', $this->lib->fillcombo('status', 'return', ($sts_crud == 'edit' ? $data['status'] : "") ) );
					break;
					case "perangkat_kasir":
						$this->smarty->assign('perangkat_id', $this->lib->randomString('20', 'angkahuruf') );
						$this->smarty->assign('tbl_gerai_outlet_id', $this->lib->fillcombo('tbl_gerai_outlet_id', 'return', ($sts_crud == 'edit' ? $data['tbl_gerai_outlet_id'] : "") ) );
					break;
					case "promo":
						$this->smarty->assign('flag_outlet', $this->lib->fillcombo('flag_outlet', 'return', ($sts_crud == 'edit' ? $data['flag_outlet'] : "") ) );
					break;
					case "supplier":
						$this->smarty->assign('status', $this->lib->fillcombo('status', 'return', ($sts_crud == 'edit' ? $data['status'] : "") ) );
					break;
				}
				
				$this->smarty->assign("main", $p1);
				$this->smarty->assign("acak_form", md5(date('H:i:s')) );
				$this->smarty->assign("sts_crud", $sts_crud);
				$temp = 'form/form-'.$p1.'.html';
				$display = true;
				if(!file_exists($this->config->item('appl').APPPATH.'views/'.$temp)){$this->smarty->display('konstruksi.html');}
			break;
		}
		
		if($display == true){
			$this->smarty->display($temp);
		}
	}
	
	function getdata($p1){
		echo $this->mbackend->getdata($p1,"json");
	}	
	
	function cruddata($p1){
		$post = array();
		
        foreach($_POST as $k=>$v){
			if($this->input->post($k)!=""){
				//$post[$k] = $this->db->escape_str($this->input->post($k));
				$post[$k] = $this->input->post($k);
			}
			
		}
		echo $this->mbackend->simpan_data($p1, $post);
	}
	function upload(){
		//print_r($_POST);exit;
		//echo microtime();exit;
		$t = microtime(true);
		$micro = sprintf("%06d",($t - floor($t)) * 1000000);
		$d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
		$mod=$this->input->post('mod');
		$data=array('create_date'=>date('Y-m-d H:i:s'),
					'create_by'=>$this->auth['email']
		);
		switch($mod){
			case "tbl_foto_produk":
				$id=$this->input->post('tbl_produk_id');
				
				$upload_path='__repo/produk/';
				$data['tbl_produk_id']=$id;
				$tbl="tbl_foto_produk";
				$object='file_nya';
				if(isset($_FILES['file_nya'])){
					$file=$_FILES['file_nya']['name'];
					$nameFile =$d->format("YmdHisu");// $this->string_sanitize(pathinfo($file, PATHINFO_FILENAME));
						$upload=$this->lib->uploadnong($upload_path, $object, $nameFile);
						if($upload){
							$data['foto_produk']=$upload;
							$_POST['sts_crud']='add';
							echo $this->mbackend->simpan_data($tbl,$data);
						}else{
							echo 2;
						}
				}
			break;
			
		}
		
		
		
		//echo $upload;
	}
	function hapus_file(){
		if($this->auth){
			$mod=$this->input->post('mod');
			switch($mod){
				case "foto_produk":
					$data=$this->mbackend->getdata('tbl_foto_produk','row_array');
					//print_r($data);exit;
					
					if(isset($data['foto_produk'])){
						$path='__repo/produk/';
						chmod($path.$data['foto_produk'],0777);
						unlink($path.$data['foto_produk']);
						$_POST['id']=$data['id'];
						$_POST['sts_crud']='delete';
						echo $this->mbackend->simpan_data('tbl_foto_produk',$data);
					}
				break;
			}
		}
	}
	
}
