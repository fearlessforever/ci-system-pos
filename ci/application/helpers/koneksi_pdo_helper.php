<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('koneksi_pdo')){
	function koneksi_pdo($param ){
		$driver		= isset($param['driver']) ? $param['driver'] : ''; 
		$host		= isset($param['host']) ? $param['host'] : ''; 
		$db			= isset($param['db']) ? $param['db'] : ''; 
		$username	= isset($param['username']) ? $param['username'] : ''; 
		$password	= isset($param['password']) ? $param['password'] : '';
		$debug 		= isset($param['debug']) ? (bool)$param['debug'] : false;
		$error_mode	= isset($param['error_mode']) ? (bool)$param['error_mode'] : true;
		$force		= isset($param['force']) ? (bool)$param['force'] : false;
		$target		= (isset($param['target']) && is_string($param['target'])) ? $param['target'] : 'dbz';
		$extra 		= isset($param['extra']) ? $param['extra'] : array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') ;
		
		$CI =& get_instance();
		if(isset($CI->$target) && $force == false){
			return true;
		}else{
			try{
				$db = new PDO(
					$driver.':host='.$host.'; dbname='.$db , $username , $password , $extra
				);
				if($error_mode)$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e){
				if($debug)show_error( "PDOException: " . $e->getMessage() . "<br>",500);
				else{
					return false;
				}
			}
			$CI->$target = NULL;
			$CI->$target = $db ;
			return true;
		}
	}
}
/* if(function_exists('koneksi_run')){
	function koneksi_run($obj , $cmd , $debug=false){
		try{
			$obj
		}catch(PDOException $e){
			
		}
	}
} */