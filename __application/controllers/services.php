<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class services extends CI_Controller {

    function __construct(){
        parent::__construct();
		header('Access-Control-Allow-Origin: *'); 
		$this->load->model('mservices');		
	}

	public function index(){
		$this->load->view('welcome_message');
	}
	
	function get_service($p1=""){
		//header('Content-Type: application/json');
		//print_r($_POST);exit;
		if($p1 == "get_produk"){
			echo $this->mservices->getdata('produk');
		}
		if($p1 == "get_kode"){
			//echo "xxx";exit;
			echo $this->mservices->getdata('gerai');
		}
		if($p1 == "upload_penjualan"){
			//print_r($_POST['data']);exit;
			$data=$this->input->post('data');
			if($data){
				$json = json_decode($data,true);
				echo $this->mservices->simpan('tbl_penjualan_outlet',$json);
			}
			
			
			//echo "<pre>";print_r($json);echo "</pre>";exit;
		}
	}
	
}
