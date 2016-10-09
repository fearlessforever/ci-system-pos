<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('json_js_array')){
		function json_js_array($string=''){
			return str_replace(array('<','>',"'"),array('&lt;','&gt;','&#039;'),$string);
		}
	}
	

/* End of file utama_helper.php */
/* Location: ./application/helpers/utama_helper.php */