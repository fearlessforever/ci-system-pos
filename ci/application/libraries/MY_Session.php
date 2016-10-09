<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class MY_Session extends CI_Session{
	var $_user=array();
	public function is_logged_in(){
		$sess = $this->all_userdata();
		if(isset($sess['userid']) && isset($sess['nama'])){
			$this->_user = array('userid'=>$sess['userid'] ,'nama'=>$sess['nama'],'level'=>0,'nama_d'=>'');
			return true; 
		}else return false;
	}
}