<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
	LIBRARY CIPTAAN JINGGA LINTAS IMAJI
	KONTEN LIBRARY :
	- Upload File
	- Upload File Multiple
	- RandomString
	- CutString
	- Kirim Email
	- Konversi Bulan
	- Fillcombo
*/
class lib {
	public function __construct(){
		
	}
	
	//class Upload File Version 1.0 - Beta
	function uploadnong($upload_path="", $object="", $file=""){
		//$upload_path = "./__repository/".$folder."/";
		
		$ext = explode('.',$_FILES[$object]['name']);
		$exttemp = sizeof($ext) - 1;
		$extension = $ext[$exttemp];
		
		$filename =  $file.'.'.$extension;
		
		$files = $_FILES[$object]['name'];
		$tmp  = $_FILES[$object]['tmp_name'];
		if(file_exists($upload_path.$filename)){
			unlink($upload_path.$filename);
			$uploadfile = $upload_path.$filename;
		}else{
			$uploadfile = $upload_path.$filename;
		} 
		
		move_uploaded_file($tmp, $uploadfile);
		if (!chmod($uploadfile, 0775)) {
			echo "Gagal mengupload file";
			exit;
		}
		
		return $filename;
	}
	// end class Upload File
	
	//class Upload File Multiple Version 2.0 - Beta Update Goyz
	function uploadmultiplenong($upload_path=""){
		$nama_file=array();
		//print_r($_FILES);exit;
		if(!file_exists($upload_path))mkdir($upload_path, 0777, true);
		if($_FILES){
			foreach($_FILES as $v=>$x){
				$fileElementName=$v;
				if(count($_FILES[$fileElementName]['name'])>0){
					foreach($_FILES[$fileElementName]['name'] as $a=>$b){
						if($b!=""){
							//echo $b.'<br>';
							$new_name=date('YmdHis')."_".$a;
							$ext = explode('.',$b);
							$exttemp = sizeof($ext) - 1;
							$extension = $ext[$exttemp];
							$filename =  $new_name.'.'.$extension;
							$nama_file[]=$filename;
							$files = $_FILES[$fileElementName]['name'][$a];
							$tmp  = $_FILES[$fileElementName]['tmp_name'][$a];
							if(file_exists($upload_path.$filename)){
								unlink($upload_path.$filename);
								$uploadfile = $upload_path.$filename;
							}else{
								$uploadfile = $upload_path.$filename;
							} 
							
							move_uploaded_file($tmp, $uploadfile);
							if (!chmod($uploadfile, 0775)) {
								echo "Gagal mengupload file";
								exit;
							}
						}
					}
				}
				
				
			}
			return $nama_file;
		}
		
		//exit;
		
	}
	//end Class Upload File
	
	//Hapus File
	function hapus_file($type="", $path=""){
		switch($type){
			case "satu":
				unlink($path);
			break;
		}
	}
	//End Hapus File
	
	//class Make Directory
	function makedir($dirpath="", $mode=0777){
		if(!is_dir($dirpath)) {
			mkdir($dirpath);
		}
		return true;
	}
	//End class Make Directory	
	
	//class Random String Version 1.0
	function randomString($length,$parameter="") {
        $str = "";
		$rangehuruf = range('A','Z');
		$rangeangka = range('0','9');
		if($parameter == 'angka'){
			$characters = array_merge($rangeangka);
		}elseif($parameter == "huruf"){
			$characters = array_merge($rangeangka);
		}else{
			$characters = array_merge($rangehuruf, $rangeangka);
		}
         $max = count($characters) - 1;
         for ($i = 0; $i < $length; $i++) {
              $rand = mt_rand(0, $max);
              $str .= $characters[$rand];
         }
         return $str;
    }
	//end Class Random String
	
	//Class CutString
	function cutstring($text, $length) {
		//$isi_teks = htmlentities(strip_tags($text));
		$isi_teks = $text;
		$isi = substr($isi_teks,0,$length);
		$isi = substr($isi_teks,0,strrpos($isi," "));
		$isi = $isi.' ...';
		return $isi;
	}
	//end Class CutString
	
	//Class Kirim Email
	function kirimemail($type="", $email="", $p1="", $p2="", $p3="", $p4=""){
		$ci =& get_instance();
		$ci->load->library('My_PHPMailer');
		$ci->load->library('encrypt');
				
		$html = "";
		$subject = "";
		switch($type){
			case "email_news":
				$subject = "Roger's Newsletter Notification";
				$html = "
					<center><img src='http://www.rogersalon.com/__assets/images/logo-email.png' /></center>
					<br/>
					<br/>
					<h1>".$p1."</h1>
					<br/>
					".$p2."
					<br/>
					<br/>
					<a href='http://www.rogersalon.com/#news'>Continue</a>
				";
			break;
			case "email_notif":
				$subject = "Aktivasi User";
				$html = "
					<center>SELAMAT DATANG </center>
					<br/>
					<br/>
					<h1>Aktivasi USER Jingga Resto</h1>
					<br/>
					Berikut User dan password yang anda registrasikan <br>
					UserName : ".$email."<br>
					Password : ".$ci->encrypt->decode($p1)."<br>
					silahkan klik link dibawah ini untuk melakukan aktivasi user. terima kasih atas partisipasinya
					<br/>
					<br/>
					<a href='".$ci->config->item('base_url')."Aktivasi/".base64_encode($email)."'>aktivasi</a>
				";
			break;
			case "email_reservasi":
				$subject = "Rogers Reservation Notification";
				$html = "
					<h1>Roger's Reservasi Untuk Cabang ".$p1."</h1>
					<br/>
					<br/>
					<table width='100%'>
						<tr>
							<td width='20%'>Nama</td>
							<td width='5%'>:</td>
							<td width='75%'>".$p2['nama']."</td>
						</tr>
						<tr>
							<td>ID Member</td>
							<td>:</td>
							<td>".$p2['id_member']."</td>
						</tr>
						<tr>
							<td>No. Handphone</td>
							<td>:</td>
							<td>".$p2['phone']."</td>
						</tr>
						<tr>
							<td>Email</td>
							<td>:</td>
							<td>".$p2['email']."</td>
						</tr>
						<tr>
							<td>Tanggal</td>
							<td>:</td>
							<td>".date('d-m-Y',strtotime($p2['tgl']))."</td>
						</tr>
						<tr>
							<td>Layanan</td>
							<td>:</td>
							<td>".$p3."</td>
						</tr>
						<tr>
							<td>Request Tambahan</td>
							<td>:</td>
							<td>".$p2['request']."</td>
						</tr>
					</table>
					<br/>
					<br/>
					Silahkan Mengkonfirmasi Ke Customer terkait Terima Kasih.
					
				";
			break;
		}
				
		try{
			$mail = new PHPMailer();
			$email_body = $html;
			
			if($ci->config->item('SMTP')) $mail->IsSMTP();
			$mail->SMTPAuth   = $ci->config->item('SMTPAuth');       
			$mail->SMTPSecure = "tls";
			$mail->Port       = $ci->config->item('Port');                    
			$mail->Host       = $ci->config->item('Host'); 
			$mail->Username   = $ci->config->item('Username');     
			$mail->Password   = $ci->config->item('Password');            
			
			$mail->From = $ci->config->item('EmaiFrom');
			$mail->AddReplyTo($ci->config->item('EmaiFrom'), $ci->config->item('EmaiFromName'));
			$mail->SetFrom    = $ci->config->item('EmaiFrom');
			$mail->FromName   = $ci->config->item('EmaiFromName');			
			$mail->AddAddress($email);
			
			$mail->Subject   = $subject;
			$mail->AltBody   = "To view the message, please use an HTML compatible email viewer!"; 
			$mail->WordWrap  = 100; 
			$mail->MsgHTML($email_body);
			$mail->IsHTML(true);			
			$mail->SMTPDebug = 1;
			
			if($mail->Send()){
				return 1;
			}else{
				//return 0;
				echo $mail->ErrorInfo;
			}
			
		} catch (phpmailerException $e) {
			return 0;
		}
		//*/
		
	}	
	//End Class KirimEmail
	
	//Class Konversi Bulan
	function konversi_bulan($bln){
		switch($bln){
			case 1:$bulan='Januari';break;
			case 2:$bulan='Februari';break;
			case 3:$bulan='Maret';break;
			case 4:$bulan='April';break;
			case 5:$bulan='Mei';break;
			case 6:$bulan='Juni';break;
			case 7:$bulan='Juli';break;
			case 8:$bulan='Agustus';break;
			case 9:$bulan='September';break;
			case 10:$bulan='Oktober';break;
			case 11:$bulan='November';break;
			case 12:$bulan='Desember';break;
		}
		return $bulan;
	}
	//End Class Konversi Bulan
	
	//Class Fillcombo
	function fillcombo($type="", $balikan="", $p1="", $p2="", $p3=""){
		$ci =& get_instance();
		$ci->load->model('mbackend');
		
		$v = $ci->input->post('v');
		if($v != ""){
			$selTxt = $v;
		}else{
			$selTxt = $p1;
		}
		
		
		$optTemp = '<option value="0"> -- Pilih -- </option>';
		
		switch($type){
			case "status":
				$data = array(
					'0' => array('id'=>'1','txt'=>'Aktif'),
					'1' => array('id'=>'0','txt'=>'Non-Aktif'),
				);
			break;
			case "flag_outlet":
				$data = array(
					'0' => array('id'=>'1','txt'=>'Semua Outlet'),
					'1' => array('id'=>'0','txt'=>'Outlet Tertentu'),
				);
			break;
			default:
				$data = $ci->mbackend->get_combo($type, $p1, $p2);
			break;
		}
		
		if($data){
			foreach($data as $k=>$v){
				if($selTxt == $v['id']){
					$optTemp .= '<option selected value="'.$v['id'].'">'.$v['txt'].'</option>';
				}else{ 
					$optTemp .= '<option value="'.$v['id'].'">'.$v['txt'].'</option>';	
				}
			}
		}
		
		if($balikan == 'return'){
			return $optTemp;
		}elseif($balikan == 'echo'){
			echo $optTemp;
		}
		
	}
	//End Class Fillcombo
	
	
}