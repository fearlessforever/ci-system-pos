<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

class Pos_ukuran extends CI_Model {
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
				case 'tambah': self::__tambah(); break;
				case 'edit': self::__edit(); break;
				case 'view': self::__view(); break;
				case 'hapus': self::__hapus(); break;
				case 'duplicate': self::__duplicate(); break;
				default: break;
			}
			echo json_js_array(json_encode(self::$_hasil));
			return ;
		}show_404();
	}
	private function __duplicate(){
		$code = $this->input->post('code');
		if( !validasi_angka($code) ){
			self::$_hasil['error']='ID harus Angka '; return;
		}
		$core = $this->db->query("SELECT id_ukuran FROM ".DB_KODE."data_ukuran WHERE id_ukuran=? LIMIT 1",array('U'.$code))->row_array();
		if(isset($core['id_ukuran'])){
			self::$_hasil['error']='Duplicate Detected';
		}else{ self::$_hasil=array('berhasil'=>'oke'); }
	}
	private function __edit(){
		self::$_hasil =array('error'=>'Gagal Simpan');
		$code = $this->input->post('code');
		if( !validasi_angka($code,'',true) ){
			self::$_hasil['error']='Ada Kesalahan , silahkan refresh halaman'; return;
		}
		if($code == 1){ self::$_hasil['error']='Anda tidak boleh menghapus Code Standar'; return;}
		$keterangan = $this->input->post('ket');
		$data = array(
			'ket'=>$keterangan
		);
		$this->db->where('id_ukuran',$code )->limit(1);
		
		$this->db->update(DB_KODE .'data_ukuran',$data);
		$core = $this->db->affected_rows();
		if($core){
			self::$_hasil=array('berhasil'=>'Data Berhasil Disimpan'); 
			self::$_hasil['baru']=array('code'=> $code ,'ket'=> $keterangan );
		}else self::$_hasil=array('error'=>'Tidak Ada Data yg Diubah');
	}
	private function __tambah(){
		self::$_hasil =array('error'=>'Gagal Simpan');
		$code = $this->input->post('code');
		if( !validasi_angka($code) ){
			self::$_hasil['error']='ID harus Angka '; return;
		}
		$keterangan = $this->input->post('ket');
		$code = 'U'.$code;
		$data = array(
			'id_ukuran'=> $code,'ket'=>$keterangan
		);
		
		$this->db->query("INSERT IGNORE INTO ".DB_KODE."data_ukuran(".implode(',',array_keys($data)).") VALUES(?".str_repeat(',?',(count($data)-1) ) .") " ,$data);
		$core = $this->db->affected_rows();
		if($core){
			self::$_hasil=array('berhasil'=>'Data Berhasil Disimpan');
			self::$_hasil['baru']=array('code'=> $code ,'ket'=> $keterangan );
		}
	}
	private function __hapus(){
		self::$_hasil =array('error'=>'Gagal Hapus Ukuran');
		$code = $this->input->post('code');
		if( !validasi_angka($code,'',true) ){
			self::$_hasil['error']='Ada Kesalahan , silahkan refresh halaman'; return;
		}
		if($code == 1){ self::$_hasil['error']='Anda tidak boleh menghapus Code Standar'; return;}
		
		$set = $this->publisnya->datanya();
		if(isset($set['boleh_hapus']['isi1']) && $set['boleh_hapus']['isi1'] != 1){
			self::$_hasil['error']='System Tidak Membolehkan Hapus Data'; return;
		}
		$core = $this->db->query("DELETE FROM ".DB_KODE."data_ukuran WHERE id_ukuran=? LIMIT 1" ,array($code) );
		if($core){
			self::$_hasil=array('berhasil'=>'Data Berhasil Dihapus');
		}
		else{
			self::$_hasil['error']= ($set['debug_db'] == true ) ? $this->db->_error_message() : 'Data Sudah Digunkan, Tidak bisa dihapus';
		}
	}
	private function __view(){
		$core = $this->db->query("SELECT id_ukuran as code,ket FROM ".DB_KODE."data_ukuran LIMIT 1000")->result_array();
		if(isset($core[0]) && is_array($core)){
			$num = $this->db->count_all_results(DB_KODE.'data_ukuran');
			self::$_hasil = array('berhasil'=>$core);
			self::$_hasil['total']= $num;
		}
	}
}