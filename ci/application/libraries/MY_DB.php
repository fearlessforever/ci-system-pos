<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (class_exists('CI_DB')){
//if (class_exists('CI_DB_mysqli_driver')){
	
}
Class MY_DB extends CI_DB{
	function __construct($params=null){
		if($params == null){
			require APPPATH .'config/database' .EXT;
			$params = $db[$active_group];
		}
		parent::__construct($params );
		
		//$db =& DB($params, $active_record);
		//die(var_dump('<pre>',get_object_vars($db)));
		$db_obj = new MY_DB($params);
        $db=& $db_obj;
		$CI =& get_instance();
		$CI->db = '';
        $CI->db =$db;
	}
	public function tes_lah(){
		die("wkwkwkwkw");
	}
}