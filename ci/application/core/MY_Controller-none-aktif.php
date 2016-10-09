<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_User extends CI_Controller {
	var $_user=array();
	public function is_logged_in(){
		$sess = $this->session->all_userdata();
		if(isset($sess['userid']) && isset($sess['nama'])){
			return true; 
		}else return false;
	}
}