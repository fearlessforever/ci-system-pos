<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Depan extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('hel_publis','',true);
	}
	
	public function index()
	{
		$check_login = $this->session->is_logged_in();
		if($check_login){
			redirect(base_url('gwe-keren')); exit;
		}
		$cobalogin = $this->input->post('email');
		if( ( $cobalogin )){
			self::_login();
		}
		else{
			$data=$this->hel_publis->datanya(); 
			$data['contents']=$this->load->view('dashboard/login/login',$data,true);
			$data['halaman_js']=$this->load->view('dashboard/login/login-js',$data,true);
			$this->load->view('tema/'.$data['theme'].'/z_load_view',$data);
		}
	}
	public function logout(){
		$check_login = $this->session->is_logged_in();
		if($check_login){
			$this->session->sess_destroy(); 
			echo "<script> var name ='".$this->session->sess_cookie_name ."'; document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;'; window.location='index.html'; </script> ";
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
			$sql_hajar  = $this->db->get(DB_KODE .'pengguna' , 1 );
		if($sql_hajar->num_rows > 0){
			$sessionsss = $sql_hajar->row_array();
			//die(var_dump($sessionsss));
			$sessionsss =array(
				'userid'=>$sessionsss['userid'],'nama'=>$sessionsss['nama']
			);
			$this->session->set_userdata($sessionsss);
				echo '<span class="label label-success" > LoggedIn </span>';
				echo '<script>window.location = \'gwe-keren/\';</script>';
		}
		else{ 
			echo '<span class="label label-danger" > Wrong Email or Password </span><br/>You might not authorize to acces this page';  
		}
		
	} 	
}

/* End of file depan.php */
/* Location: ./application/controllers/depan.php */