<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

class Nota extends CI_Model {
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
				case 'detail': self::__detail(); break;
				case 'edit': self::__edit(); break;
				case 'view': self::__view(); break;
				default: break;
			}
			echo json_js_array(json_encode(self::$_hasil));
			return ;
		}show_404();
	}
	
	private function __detail(){
		self::$_hasil =array('error'=>'Gagal Simpan');
		$data =array();
		$data['id_transaksi'] = $this->input->post('code');
		if( !validasi_angka($data['id_transaksi']  ,'',true) ){
			self::$_hasil['error']='Nomor Nota Tidak Boleh Kosong'; return;
		}
		$data['tanggal'] = $this->input->post('tanggal');
		if( !validasi_array($data,'tanggal') ){
			self::$_hasil['error']='Tanggal Tidak boleh kosong'; return;
		}
		
		$set = $this->publisnya->datanya();
		
		$core = $this->db->query("
			SELECT a.id_barang,a.jumlah,a.harga,b.nama_barang as nama
			FROM ".DB_KODE."transaksi_detail a
			LEFT JOIN ".DB_KODE."data_barang b ON a.id_barang=b.id_barang
			WHERE a.id_transaksi=? AND a.tanggal=?
			" ,$data)->result_array();
		if(isset($core[0]) && is_array($core) ){
			self::$_hasil=array('berhasil'=>$core );
		}
		else{
			self::$_hasil['error']= ($set['debug_db'] == true ) ? $this->db->_error_message() : 'Data Tidak ditemukan';
		}
	}
	
	private function __view(){
		self::$_hasil =array('error'=>'Data Tidak Ditemukan');
		$data =null; $kondisi =null;
		$check =array(
			'tgl_mulai'=> $this->input->post('tgl_mulai')
			,'tgl_akhir'=> $this->input->post('tgl_akhir')
		); 
		if(!empty($check['tgl_mulai']) && !empty($check['tgl_akhir']) ){
			if( !validasi_tanggal($check ,'tgl_mulai|tgl_akhir') ){
				self::$_hasil['error']=  ' Tanggal mulai dan akhir tidak benar !!! '; return;
			}else{
				$data =$check; $kondisi = ' WHERE a.tanggal BETWEEN ? AND ? ';
			}
		}
		
		$core = $this->db->query("
			SELECT a.id_transaksi as code,a.tanggal ,a.tipe,a.bayar,a.total_h as total,a.kembali,DATE_FORMAT(a.waktu,'%d %M %Y ~ %H:%i') as waktu,if(b.id_transaksi IS NULL , 0, 1) as retur,c.nama
			FROM ".DB_KODE."transaksi a 
			LEFT JOIN ".DB_KODE."transaksi_retur b ON a.id_transaksi = b.id_transaksi AND a.tanggal = b.tanggal
			LEFT JOIN ".DB_KODE."pengguna c ON a.userid = c.userid
			{$kondisi}
			ORDER BY a.waktu DESC LIMIT 1000" , $data )->result_array();
		if(isset($core[0]) && is_array($core)){
			$num = $this->db->count_all_results(DB_KODE.'transaksi');
			self::$_hasil = array('berhasil'=>$core);
			self::$_hasil['total']= $num;
		}
	}
}