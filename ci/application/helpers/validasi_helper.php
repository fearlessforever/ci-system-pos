<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('validasi_array')){
		function validasi_array(&$data,$rules=null,$no_isi=true){
			$rule = isset($rules) ? explode('|',$rules) : null;
			if(isset($rule[0]) && is_array($rule)){
				foreach($rule as $val){
					if(empty($data[$val]) && $no_isi )return false; else $data[$val]=empty($data[$val])? '' : $data[$val];
				}
				return true;
			}
			return false;
		}
	}
	if(!function_exists('validasi_angka')){
		function validasi_angka(&$data,$rules=null,$huruf=false,$isi=false){
			if(is_array($data) ){
				$rule = isset($rules) ? explode('|',$rules) : null;
				if(isset($rule[0]) && is_array($rule)){
					foreach($rule as $val){
						if(empty($data[$val]) && $isi == false)return false;
						else{
							 $data[$val]= ($huruf == true) ? preg_replace('/[^0-9a-z]/i','',$data[$val] ) : preg_replace('/[^0-9]/','', $data[$val] );
							 if(!$huruf){
								if(!$isi){
									if(empty($data[$val]))return false;
								}else{ 
									$data[$val]= $isi;
								}
							 }else{
								$a = $data[$val] ;
								if(!isset($a[0]) && $isi == false) return false;
							 }
							 
						}
					}
					return true;
				}
			}elseif(!is_object($data)){
				$data = ($huruf == true) ? preg_replace('/[^0-9a-z]/i','',$data) : preg_replace('/[^0-9]/','', $data );
				if(isset($data[0]) )return true;
			}
			
			return false;
		}
	}
	if(!function_exists('validasi_tanggal')){
		function validasi_tanggal(&$data,$rules=null){
			if(is_array($data)){
				$rule = isset($rules) ? explode('|',$rules) : null;
				if(isset($rule[0]) && is_array($rule)){
					$hasil = true;
					foreach($rule as $val){
						if(empty($data[$val]) ){$hasil = false; continue;}
						$data[$val]= preg_replace('/[^0-9\:\- ]/','',$data[$val] ) ;
						if(empty($data[$val]) )$hasil = false;
					}
					return $hasil;
				}
			}elseif(!is_object($data)){
				$data = preg_replace('/[^0-9\:\- ]/','',$data);
				if(isset($data[0]) )return true;
			}
			return false;
		}
	}

/* End of file validasi_helper.php */
/* Location: ./application/helpers/validasi_helper.php */