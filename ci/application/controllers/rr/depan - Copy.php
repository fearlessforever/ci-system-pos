<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Depan extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		//$this->load->library('template_adminpanel');
		//$this->load->library('my_uri');
		//$this->config->set_item('url_suffix','.js');
		$this->load->model('hel_db','',true);
		$this->load->model('hel_publis','',true); 
	}
	
	private function _ceklogin(){
		$data=$this->hel_publis->datanya();
		$login = $this->session->userdata('isLoggedin');
		if(!empty($login) || $login != null)redirect($data['home'].'user/');
	}	
	public function index()
	{
		$this->_ceklogin();
		$cobalogin = $this->input->post('email',true);
		if( ( $cobalogin )){
			$this->_login();
		}
		else{
			$data=$this->hel_publis->datanya(); 
			$data['halaman_sendiri']=$this->load->view('dashboard/login/login',$data,true);
			$data['halaman_js']=$this->load->view('dashboard/login/login-js',$data,true);
			$this->load->view('dashboard/'.$data['theme'].'/z_load_view',$data);
		}
	}
	public function resetpass(){
		$data=$this->hel_publis->datanya(); 
		$data['halaman_sendiri']=$this->load->view('dashboard/login/reset',$data,true);
		$this->load->view('dashboard/'.$data['theme'].'/z_load_view',$data);
	}
	public function logout(){
		$login = $this->session->userdata('isLoggedin');
		if(!empty($login) || $login != null){
		 $this->session->sess_destroy(); 
		 echo "<script> var name ='hel_swalayan'; document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;'; window.location='index.html'; </script> ";
		}else{
		 redirect( base_url() );
		}
	}
	private function _login(){
		$email = $this->input->post('email',true); 
		$password = $this->input->post('password',true);
		
			$email = $this->db->escape($email);
			$this->db->where( "( userid=$email OR email=$email )"  ,null ,false);
			$this->db->where('passnya', md5($password) );
			$sql_hajar  = $this->db->get(DB_KODE_HEL.'_pengguna' , 1 );
			/*
$param =array(
	array('tipe'=>'string' , 'target'=>':email' , 'nilai'=> $this->input->post('email',true) ),
	array('tipe'=>'string' , 'target'=>':pass' , 'nilai'=> md5($password) ),
	array('tipe'=>'nomor' , 'target'=>':batas' , 'nilai'=> '1' )
);
$stringparam = "SELECT nama,blokir,level FROM ".DB_KODE_HEL . "_pengguna WHERE (userid=:email OR email=:email) AND passnya=:pass LIMIT 0,:batas" ;
$tes = $this->hel_db->pdo_get($stringparam ,$param ,true); */
			
		if($sql_hajar->num_rows > 0){
			$sessionsss =array(
				'isLoggedin'=>true
			);
			$this->session->set_userdata($sessionsss);
				echo '<span class="label label-success" > LoggedIn </span>';
				echo '<script>window.location = \'user/\';</script>';
		}
		else{ 
			echo '<span class="label label-danger" > Wrong Email or Password </span><br/>You might not authorize to acces this page';  
		}
		
		//echo'<pre>';
		//print_r( $tes );
		
	} 	
}

/* End of file depan.php */
/* Location: ./application/controllers/depan.php */