<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

class Systems extends CI_Model {
	static $_hasil= array('error'=>'Mode Not Found');
	function __construct() {
		parent::__construct();
		$this->load->helper('validasi');
	}
	
	public function run(){
		$check = $this->input->is_ajax_request();
		if($check){
			header('Content-Type:application/json');
			$mode = $this->input->post('mode');
			switch($mode){
				case 'simpan': self::__simpan(); break;
				default: break;
			}
			echo json_js_array(json_encode(self::$_hasil));
			return ;
		}show_404();
	}
	private function __simpan(){
		self::$_hasil =array('error'=>'Gagal Simpan');
		$data =array(
			'alamat'=> $this->input->post('alamat',TRUE)
			,'title'=> $this->input->post('title',TRUE)
			,'boleh_hapus'=> $this->input->post('hapus_boleh',TRUE)
			,'debug_db'=> $this->input->post('debug_db',TRUE)
		);
		$data['boleh_hapus'] = empty($data['boleh_hapus']) ? 0 : 1 ;
		$data['debug_db'] = empty($data['debug_db']) ? 0 : 1 ;
		if( !validasi_array($data,'alamat|title') ){
			self::$_hasil =array('error'=>'Alamat Dan nama System Tidak Boleh Kosong !!!'); return;
		}
		
		$data = array_merge($data , array('alamat','title','boleh_hapus','debug_db') ) ;
		$save = $this->db->query("UPDATE ".DB_KODE."pengaturan SET isi1=CASE
			WHEN nama = 'alamat' THEN ?
			WHEN nama = 'title' THEN ?
			WHEN nama = 'boleh_hapus' THEN ?
			WHEN nama = 'debug_db' THEN ?
			ELSE isi1
			END
			WHERE nama IN (?,?,?,? ) " , $data );
		
		if($save){
			$save = $this->db->affected_rows();
			self::$_hasil= ($save) ? array('berhasil'=>'Data Berhasil Disimpan') : array('error'=>'Tidak Ada Data Yang Berubah');
		}else{
			$_msg = $this->db->_error_message() ; $set = $this->publisnya->datanya();
			self::$_hasil=array('error'=> ($set['debug_db']) ? $_msg : 'Data Tidak Berhasil Disimpan' );
		}
	}
}