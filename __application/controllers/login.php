<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
		$this->host	= $this->config->item('base_url');
		$this->smarty->assign('host',$this->host);
		$this->smarty->assign("acak", md5(date('H:i:s')));
	}
	
	public function index(){
		$user=$this->db->escape_str($this->input->post('user'));
		$pass=$this->db->escape_str($this->input->post('pwd'));
		$error=false;
		if($user && $pass){
			$cek_user=$this->mbackend->getdata('user', 'row_array', $user);
			//print_r($cek_user);exit;
			if(count($cek_user)>0){
				if(isset($cek_user['status']) && $cek_user['status']==1){
					if($pass==$this->encrypt->decode($cek_user['password'])){
						$this->session->set_userdata($this->config->item('user_data'), base64_encode(serialize($cek_user)));	
					}
					else{
						$error=true;
						$this->session->set_flashdata('error', 'Password Invalid');
					}
				}else{
					$error=true;
					$this->session->set_flashdata('error', 'USER Tidak Aktif ');
				}
			}else{
				$error=true;
				$this->session->set_flashdata('error', 'User Tidak Terdaftar');
			}
		}else{
			$error=true;
			$this->session->set_flashdata('error', 'Isi User Dan Password');
		}
		
		header("Location: ".$this->host."backend ");
	
		
	}
	
	function logout(){
		$this->session->unset_userdata($this->config->item('user_data'), 'limit');
		$this->session->sess_destroy();
		header("Location: ".$this->host." ");
	}
	function register($p1="",$p2=""){
		$usr="";
		if($p2!=""){$usr=base64_decode($p2);}
		if($p1=="notif"){
			$this->load->library('lib');
			$data=$this->mbackend->getdata('cek_user','get',$usr);
			$this->lib->kirimemail("email_notif", $data['email'],$data['password']);
			return $this->smarty->display('registrasi/notif.html');
		}else if($p1=="act"){
			$data=$this->mbackend->getdata('cek_user','get',$usr);
			if($this->mbackend->simpan_reg("act",$data['email'])==1){
				return $this->smarty->display('registrasi/act.html');
			}
		}
		$opt="<option value='L'>Laki - laki </option><option value='L'>Wanita</option>";
		$this->smarty->assign('opt',$opt);
		$this->smarty->display('registrasi/register.html');
	}
	function simpan_reg(){
		echo $this->mbackend->simpan_reg();
	}
	function cek_user(){
		echo $this->mbackend->getdata('cek_user');
	}

}
