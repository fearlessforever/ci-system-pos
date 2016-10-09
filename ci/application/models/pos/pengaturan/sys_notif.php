<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

class Sys_notif extends CI_Model {
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
				case 'get-notif': self::__view(); break;
				case 'check-notif': self::__check_notif(); break;
				default: break;
			}
			echo json_js_array(json_encode(self::$_hasil));
			return ;
		}show_404();
	}
	private function __check_notif(){
		self::$_hasil =array('error'=>'Tidak Ada yang Baru');
		$core = $this->db->query("SELECT count(1) as hasil
			FROM ".DB_KODE."transaksi 
			WHERE MONTH(tanggal) = MONTH(NOW()) AND waktu > (SELECT isi FROM ".DB_KODE."pengguna_ext WHERE nama=? AND userid=? LIMIT 1) ",array('last_notif', $this->session->_user['userid'] ) )->row();
		if(isset($core->hasil) && $core->hasil > 0 ){
			self::$_hasil = array('berhasil'=> $core->hasil );
		}
	}
	
	private function __view(){
		self::$_hasil =array('error'=>'Data Tidak Ditemukan');
		$core = $this->db->query("
			SELECT DATE_FORMAT(a.waktu,'%d %M %Y ~ %H:%i') as n_waktu,a.tipe,a.id_transaksi as code,a.tanggal,.a.userid,b.nama,b.photo
			FROM ".DB_KODE."transaksi a
			LEFT JOIN ( SELECT x.userid,x.nama,GROUP_CONCAT(isi SEPARATOR '') as photo FROM ".DB_KODE."pengguna x LEFT JOIN ".DB_KODE."pengguna_ext xx ON xx.userid=x.userid WHERE xx.nama='folder' OR xx.nama='profile_pic' GROUP BY x.userid )
			b ON a.userid=b.userid
			ORDER BY a.waktu DESC LIMIT 5
			")->result_array();
			
		if(isset($core[0]) && is_array($core)){
			self::$_hasil = array('berhasil'=>$core );
			$this->db->query("INSERT INTO ".DB_KODE."pengguna_ext(userid,nama,isi) VALUES(?,?,NOW() ) ON DUPLICATE KEY UPDATE isi=VALUES(isi) ",
				array($this->session->_user['userid'] ,'last_notif' )
			);
		}
		 sleep(1);
	}
}