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
				$this->smarty->assign("acak", md5(date('YmdHis').'ind') );				
				
				if($sts_crud == 'edit'){
					$table = "tbl_".$p1;
					$id = $this->input->post('id');
					$data = $this->db->get_where($table, array('id'=>$id) )->row_array();
					$this->smarty->assign('data', $data);
				}
				
				switch($p1){
					case "produk":
						$this->smarty->assign('cl_kategori_id', $this->lib->fillcombo('cl_kategori_produk', 'return', ($sts_crud == 'edit' ? $data['cl_kategori_id'] : "") ) );
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
		
		/*
		if(isset($post['upload_na'])){
			if(isset($post['upload_na']))unset($post['upload_na']);
			if(isset($post['modul_detil']))unset($post['modul_detil']);
			$id_header=$this->mbackend->simpan_data($p1, $post,'get_id');
			
			unset($_FILES['file_icon_foto_services']);
			unset($_FILES['file_icon_foto_product']);
			
			echo $this->upload($this->input->post('modul_detil'), $id_header, $post);
		}else{
		}
		*/
		echo $this->mbackend->simpan_data($p1, $post);
	}

	
}
