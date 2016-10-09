<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

class Hel_publis extends CI_Model {
	var $meta='';
	function __construct() {
		parent::__construct();
		
	}
	
	public function datanya(){
		$buat =array();
		$core = $this->db->query("SELECT nama,isi1,isi2 FROM ".DB_KODE."pengaturan LIMIT 17")->result_array();
		if(isset($core[0]) && is_array($core) ){
			foreach($core as $val){
				$k = $val['nama']; unset($val['nama']); 
				$buat[ $k ] = $val; 
			}
		}
		
		$buat['home']=base_url(); 
		$buat['key_hash']=( isset($buat['key_hash']['isi1'][3]) && is_string($buat['key_hash']['isi1']) )? $buat['key_hash']['isi1'] : 'Ngasaljfs'; 
		$buat['debug_db']= empty($buat['debug_db']['isi1']) ? FALSE : (bool) $buat['debug_db']['isi1'];
		$buat['sys_demo']= empty($buat['sys_demo']['isi1']) ? FALSE : (bool) $buat['sys_demo']['isi1'];
		$buat['sys_notif']= empty($buat['sys_notif']['isi1']) ? FALSE : (bool) $buat['sys_notif']['isi1'];
		//$buat['pos_sidebar']=( isset($buat['pos_sidebar']['isi1'][3]) && is_string($buat['pos_sidebar']['isi1']) )? json_decode($buat['pos_sidebar']['isi1'],TRUE) : NULL;
		$buat['asset']=( isset($buat['asset']['isi1'][3]) && is_string($buat['asset']['isi1']) && $buat['asset']['isi2'] == 1 )? $buat['asset']['isi1'] : base_url().'assets/';
		$buat['theme']=( isset($buat['theme']['isi1'][3]) && is_string($buat['theme']['isi1']) )? $buat['theme']['isi1'] : 'sentor';
		$buat['__current']=$buat['home'] . $this->uri->uri_string() .'/';
		$buat['__now']=$buat['home'] . $this->uri->slash_segment(1) ;
		//die(var_dump('<pre>',$buat));
		return $buat;
	}
}