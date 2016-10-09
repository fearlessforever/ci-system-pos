<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

class User_profile extends CI_Model {
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
				case 'ganti-password': self::__change_pass(); break;
				case 'ganti-nama': self::__change_name(); break;
				case 'view': self::__view(); break;
				default: break;
			}
			echo json_js_array(json_encode(self::$_hasil));
			return ;
		}show_404();
	}
	private function __change_name(){
		self::$_hasil =array('error'=>'Gagal Simpan');
		$data =array(
			'nama'=> $this->input->post('nama',TRUE)
		);
		if( !validasi_array($data,'nama') ){
			self::$_hasil =array('error'=>'Nama Tidak Boleh Kosong !!!'); return;
		}
		$this->db->query("UPDATE ".DB_KODE."pengguna SET nama=? WHERE userid=? LIMIT 1" , array( $data['nama'],$this->session->_user['userid']  ) );
		$save = $this->db->affected_rows();
		if($save)self::$_hasil=array('berhasil'=>'Data Berhasil Disimpan'); else self::$_hasil=array('error'=>'Tidak Ada Data yg Diubah');
	}
	private function __change_pass(){
		self::$_hasil =array('error'=>'Gagal Simpan');
		$data =array(
			'pass_lama'=> $this->input->post('pass_lama')
			,'pass_baru'=> $this->input->post('pass_baru')
			,'pass_baru_con'=> $this->input->post('pass_baru_con')
		);
		if( !validasi_array($data,'pass_lama|pass_baru|pass_baru_con') ){
			self::$_hasil =array('error'=>'Pass Lama , Baru dan Konfirmasi Tidak Boleh Kosong !!!'); return;
		}
		if( $data['pass_lama'] == $data['pass_baru'] ){
			self::$_hasil =array('error'=>'Pass Baru Tidak Boleh Sama Dengan Pass Lama !!! '); return;
		}
		if( $data['pass_baru'] != $data['pass_baru_con'] ){
			self::$_hasil =array('error'=>'Pass Baru Tidak sama Dengan Password Konfirmasi !!! '); return;
		}
		$core = $this->db->query("SELECT passnya FROM ".DB_KODE."pengguna WHERE userid=? LIMIT 1",array( $this->session->_user['userid'] ) )->row_array();
		if(!isset($core['passnya'])){
			self::$_hasil =array('error'=>'User Id Tidak Ditemukan !!!'); return;
		}
		if($core['passnya'] != md5($data['pass_lama']) ){
			self::$_hasil =array('error'=>'Pass Lama Tidak Sama !!!'); return;
		}
		$save = md5($data['pass_baru']);
		$this->db->query("UPDATE ".DB_KODE."pengguna SET passnya=? WHERE userid=? LIMIT 1",array($save, $this->session->_user['userid'] ) ) ;
		$save = $this->db->affected_rows();
		if($save)self::$_hasil=array('berhasil'=>'Data Berhasil Disimpan'); else self::$_hasil=array('error'=>'Tidak Ada Data yg Diubah');
	}
	
	private function __view(){
		self::$_hasil =array('error'=>'Data Tidak Ditemukan');
		$userid = $this->input->post('userid');
		$userid = empty($userid) ? $this->session->_user['userid'] : $userid ;
		if( !validasi_angka($userid ,'',true) ){
			self::$_hasil['error']='Userid Tidak Boleh Kosong'; return;
		}
		
		$core = $this->db->query("SELECT userid,DATE_FORMAT(buat,'%d %M %Y ~ %H:%i') as buat,level,nama FROM ".DB_KODE."pengguna WHERE userid=? LIMIT 1",array( $userid ) )->row_array();
		if(!isset($core['userid'])){
			self::$_hasil =array('error'=>'User Tidak ditemukan'); return;
		}
		
		$userdata = array(); $userdata = $core ;
		$core = $this->db->query("SELECT nama,isi FROM ". DB_KODE ."pengguna_ext WHERE userid=? LIMIT 27",array( $userid ) )->result_array();
		if(isset($core[0]) && is_array($core) ){
			foreach($core as $val)$userdata[ $val['nama'] ]=$val['isi'];
		}
		self::$_hasil = array('berhasil'=>$userdata );
	}
}