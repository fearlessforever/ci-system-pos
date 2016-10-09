<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

class Pos_user_izin extends CI_Model {
	static $_hasil= array('error'=>'Mode Not Found');
	function __construct() {
		parent::__construct();
		$this->load->helper('validasi');
	}
	static $list_default =array('dashboard','sys-notif','info','user-set-modul','user-profile','systems');
	
	public function run(){
		$check = $this->input->is_ajax_request();
		if($check){
			header('Content-Type:application/json');
			$mode = $this->input->post('mode');
			switch($mode){
				case 'tambah': self::__tambah(); break;
				case 'hapus': self::__hapus(); break;
				case 'view': self::__view(); break;
				
				case 'duplicate': self::__duplicate(); break;
				case 'tambah_user': self::__tambah_user(); break;
				case 'view-user': self::__view_user(); break;
				case 'edit_pass': self::__edit_pass(); break;
				default: break;
			}
			echo json_js_array(json_encode(self::$_hasil));
			return ;
		}show_404();
	}
	private function __edit_pass(){
		$code = $this->input->post('code');
		$code = preg_replace('/[^0-9a-z_]/i',null,$code) ;
		if( empty($code)){
			self::$_hasil['error']='Ada Kesalahan , reload Halaman '; return;
		}
		$data=array( 
			'passnya'=> $this->input->post('password')
		);
		if(!validasi_array($data ,'passnya')){
			self::$_hasil['error']='Password Tidak Boleh Kosong'; return;
		}
		$data['passnya']=md5($data['passnya']);
		$this->db->where('userid',$code)->where('level !=','admin')->limit(1)->update(DB_KODE .'pengguna' , $data);
		if($this->db->affected_rows() ){
			self::$_hasil=array('berhasil'=>'Data Telah Disimpan');
			self::$_hasil['baru']=array('code'=>$code ,'ket'=>'EDITED') ;
		}else{
			self::$_hasil['error']='Tidak Ada Data Yang Diubah'; 
		}
	}
	private function __duplicate(){
		$code = $this->input->post('code');
		$code = preg_replace('/[^0-9a-z_]/i',null,$code) ;
		if( empty($code)){
			self::$_hasil['error']='Username Kosong, Hanya dibolehkan A-Z , Angka dan Garis Bawah _ '; return;
		}
		$core = $this->db->query("SELECT userid FROM ".DB_KODE."pengguna WHERE userid=? LIMIT 1",array($code) )->row_array();
		if(isset($core['userid'])){
			self::$_hasil['error']='Username Sudah Digunakan, coba yang lain';
		}else{
			self::$_hasil =array('berhasil'=>$code );
		}
	}
	private function __tambah_user(){
		$code = $this->input->post('code');
		$code = preg_replace('/[^0-9a-z_]/i',null,$code) ;
		$data=array(
			'userid'=>$code
			,'passnya'=> $this->input->post('password')
			,'nama'=> $this->input->post('nama')
			,'buat'=>date('Y-m-d H:i:s')
			,'level'=>'kasir'
		);
		if(!validasi_array($data ,'userid|passnya|nama')){
			self::$_hasil['error']='Username & Password Tidak Boleh Kosong'; return;
		}
		$data['passnya']=md5($data['passnya']);
		self::$_hasil['error']= $data;
		$set = $this->publisnya->datanya();
		$core = $this->db->query("INSERT INTO ".DB_KODE."pengguna (".implode(',',array_keys($data)).") VALUES(?".str_repeat(',?',(count($data)-1) ) .") " ,$data );
		
		if($core){
			$dataz=array(
				$code,'folder'
				,$code,'profile_pic'
				,$code,'last_activity'
				,$code,'trans_pendapatan'
				,$code,'trans_pengeluaran'
				,$code,'last_notif'
			);
			$this->db->query("INSERT INTO ".DB_KODE."pengguna_ext (userid,nama,isi) VALUES(?,?,''),(?,?,''),(?,?,0),(?,?,0),(?,?,0),(?,?,NOW() ) " ,$dataz );
			self::$_hasil=array('berhasil'=> 'Data berhasil Ditambahkan');
			self::$_hasil['baru'] = array('code'=>$code ,'ket'=>$data['nama'] ) ;
			
		}else{
			self::$_hasil['error']= ($set['debug_db'] == true ) ? $this->db->_error_message() : 'Data Tidak Berhasil Ditambahkan';
		}
	}
	private function __view_user(){
		$core = $this->db->query(
			"SELECT userid as code,nama as ket 
			FROM ".DB_KODE."pengguna 
			WHERE level != 'admin'
			LIMIT 100"
		)->result_array();
		if(isset($core[0]) && is_array($core) ){
			self::$_hasil=array('berhasil'=>$core );
		}
	}
	
	private function __tambah(){
		self::$_hasil =array('error'=>'Gagal Simpan');
		$code = $this->input->post('modul');
		$code = preg_replace('/[^0-9a-z_-]/i',null,$code) ;
		if( empty($code)){
			self::$_hasil['error']='Modul Tidak Boleh Kosong, silahkan refresh halaman'; return;
		}
		if(in_array($code , self::$list_default)){
			self::$_hasil['error']='Modul Ini Tidak Dizinkan Dirubah'; return;
		}
		$data=array(
			'level'=>'kasir'
			,'nama_app'=>$code
		);
		$set = $this->publisnya->datanya();
		$core = $this->db->query("INSERT INTO ".DB_KODE."pengguna_izin(".implode(',',array_keys($data)).") VALUES(?".str_repeat(',?',(count($data)-1) ) .") " ,$data );
		
		if($core){
			self::$_hasil=array('berhasil'=>'Data Berhasil Disimpan');
			$core = $this->db->query("
				SELECT a.level as code,b.keterangan as ket,a.nama_app as app
				FROM ".DB_KODE."pengguna_izin a
				LEFT JOIN z_aplikasi b ON a.nama_app = b.nama_app
				WHERE a.nama_app=?
				LIMIT 1" , array($code) )->row_array();
			if( is_array($core) )self::$_hasil['baru']=$core;
			
		}else{
			self::$_hasil['error']= ($set['debug_db'] == true ) ? $this->db->_error_message() : 'Data Tidak Berhasil Ditambahkan';
		}
	}
	private function __hapus(){
		self::$_hasil =array('error'=>'Gagal Hapus Data');
		$code = $this->input->post('code');
		$code = preg_replace('/[^0-9a-z_-]/i',null,$code) ;
		if( empty($code)){
			self::$_hasil['error']='Modul Tidak Boleh Kosong, silahkan refresh halaman'; return;
		}
		
		$set = $this->publisnya->datanya();
		if(isset($set['boleh_hapus']['isi1']) && $set['boleh_hapus']['isi1'] != 1){
			self::$_hasil['error']='System Tidak Membolehkan Hapus Data'; return;
		}
		$data =array_merge(array($code) ,self::$list_default );
		$core = $this->db->query("DELETE FROM ".DB_KODE."pengguna_izin WHERE nama_app=? AND level='kasir' AND nama_app NOT IN (?". str_repeat(',?',( count(self::$list_default)-1) ) .") LIMIT 1" , $data );
		if($core){
			if( $this->db->affected_rows() ) self::$_hasil=array('berhasil'=>'Data Berhasil Dihapus');
			else{
				self::$_hasil['error']= 'Data Tidak ada yg dihapus';
			}
		}
		else{
			self::$_hasil['error']= ($set['debug_db'] == true ) ? $this->db->_error_message() : 'Data Tidak ada yg dihapus';
		}
	}
	private function __view(){
		$core = $this->db->query("
			SELECT a.level as code,b.keterangan as ket,a.nama_app as app
			FROM ".DB_KODE."pengguna_izin a
			LEFT JOIN z_aplikasi b ON a.nama_app = b.nama_app
			LIMIT 100")->result_array();
		if(isset($core[0]) && is_array($core)){
			self::$_hasil = array('berhasil'=>$core); 
		}
		$core = $this->db->query("
			SELECT nama_app as app,keterangan as ket
			FROM  z_aplikasi 
			WHERE nama_app NOT IN (? ". str_repeat(',?', (count(self::$list_default )-1 ) ) ." )
			LIMIT 100", self::$list_default )->result_array();
		if(isset($core[0]) && is_array($core)){
			self::$_hasil['list_app']=$core; 
		}
	}
}