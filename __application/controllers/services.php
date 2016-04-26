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
		//print_r($_POST);
		if($p1 == "get_produk"){
			echo $this->mservices->getdata('produk');
		}
		if($p1 == "upload_penjualan"){
			echo "AAA";exit;
			//echo $this->mservices->getdata('produk');
			$jsonStr = file_get_contents("php://input"); //read the HTTP body.
			$json = json_decode($jsonStr,true);
			
			print_r($json);exit;
		}
	}
	
}
