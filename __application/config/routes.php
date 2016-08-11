<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "backend";
$route['login'] = "login";
$route['logout'] = "login/logout";
$route['Daftar'] = "login/register";
$route['CekUser'] = "login/cek_user";
$route['Registrasi'] = "login/simpan_reg";
$route['Notifikasi/(:any)'] = "login/register/notif/$1";
$route['Aktivasi/(:any)'] = "login/register/act/$1";
$route['Upload-Gambar'] = "backend/upload";
$route['HapusFile'] = "backend/hapus_file";
$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */