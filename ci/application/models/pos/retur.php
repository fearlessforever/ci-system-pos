<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

class Retur extends CI_Model {
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
				case 'hapus': self::__hapus(); break;
				case 'view': self::__view(); break;
				default: break;
			}
			echo json_js_array(json_encode(self::$_hasil));
			return ;
		}show_404();
	}
	
	private function __tambah(){
		self::$_hasil =array('error'=>'Gagal Simpan');
		$data =array();
		$data['id_transaksi'] = $this->input->post('code');
		if( !validasi_angka($data['id_transaksi']  ,'',true) ){
			self::$_hasil['error']='Nomor Nota Tidak Boleh Kosong'; return;
		}
		$data['tanggal'] = $this->input->post('tanggal');
		$data['tanggal'] = ($data['tanggal'] == 'hari ini') ? date('Y-m-d') : $data['tanggal'] ;
		$data['keterangan'] = $this->input->post('ket');
		if( !validasi_array($data,'keterangan') ){
			self::$_hasil['error']='Keterangan Tidak boleh kosong'; return;
		}
		$data['userid'] = $this->session->_user['userid'];
		$set = $this->publisnya->datanya();
		
		$core = $this->db->query("INSERT INTO ".DB_KODE."transaksi_retur(".implode(',',array_keys($data)).",waktu) VALUES(?".str_repeat(',?',(count($data)-1) ) .",NOW()) " ,$data);
		if($core){
			self::$_hasil=array('berhasil'=>'Data Berhasil Disimpan');
			self::$_hasil['baru']=array('code'=>$data['id_transaksi'] ,'tanggal'=>$data['tanggal'],'ket'=>$data['keterangan'],'tipe'=>'');
		}
		else{
			self::$_hasil['error']= ($set['debug_db'] == true ) ? $this->db->_error_message() : 'Ada Kesalahan , Data Tidak bisa Disimpan ( misal : nota tidak ditemukan ) ';
		}
	}
	private function __hapus(){
		self::$_hasil =array('error'=>'Gagal Hapus Satuan');
		$code = $this->input->post('code');
		$tanggal = $this->input->post('tanggal');
		if( !validasi_angka($code,'',true) ){
			self::$_hasil['error']='Ada Kesalahan , silahkan refresh halaman'; return;
		}
		if($code == 1){ self::$_hasil['error']='Anda tidak boleh menghapus Code Standar'; return;}
		
		$set = $this->publisnya->datanya();
		if(isset($set['boleh_hapus']['isi1']) && $set['boleh_hapus']['isi1'] != 1){
			self::$_hasil['error']='System Tidak Membolehkan Hapus Data'; return;
		}
		$core = $this->db->query("DELETE FROM ".DB_KODE."transaksi_retur WHERE id_transaksi=? AND tanggal=? LIMIT 1" ,array($code,$tanggal) );
		if($core){
			self::$_hasil=array('berhasil'=>'Data Berhasil Dihapus');
		}
		else{
			self::$_hasil['error']= ($set['debug_db'] == true ) ? $this->db->_error_message() : 'Data Sudah Digunkan, Tidak bisa dihapus';
		}
	}
	private function __edit(){
		self::$_hasil =array('error'=>'Gagal Simpan');
		$data =array();
		$data['id_transaksi'] = $this->input->post('code');
		
		if( !validasi_angka($data['id_transaksi'] ,'',true) ){
			self::$_hasil['error']='Ada Kesalahan , silahkan refresh halaman'; return;
		}
		if($data['id_transaksi'] == 1){ self::$_hasil['error']='Anda tidak boleh Merubah Code Standar'; return;}
		$data['keterangan'] = $this->input->post('ket');
		$data['tanggal'] = $this->input->post('tanggal');
		if( !validasi_array($data ,'keterangan|tanggal') ){
			self::$_hasil['error']='Keterangan Dan Tanggal Tidak boleh kosong'; return;
		}
		
		$this->db->where('id_transaksi',$data['id_transaksi']  )->where('tanggal',$data['tanggal'] )->limit(1);
		
		$this->db->update(DB_KODE .'transaksi_retur',array('keterangan' => $data['keterangan'] ) );
		$core = $this->db->affected_rows();
		if($core){
			self::$_hasil=array('berhasil'=>'Data Berhasil Disimpan'); 
			self::$_hasil['baru']=array('code'=>$data['id_transaksi'] ,'tanggal'=>$data['tanggal'],'ket'=>$data['keterangan'],'tipe'=>'');
		}else self::$_hasil=array('error'=>'Tidak Ada Data yg Diubah');
	}
	private function __view(){
		$core = $this->db->query("
			SELECT a.id_transaksi as code,a.tanggal,a.keterangan as ket,b.tipe
			FROM ".DB_KODE."transaksi_retur a
			LEFT JOIN ".DB_KODE."transaksi b ON a.id_transaksi = b.id_transaksi AND a.tanggal = b.tanggal
			ORDER BY a.tanggal DESC
			LIMIT 1000")->result_array();
		if(isset($core[0]) && is_array($core)){
			$num = $this->db->count_all_results(DB_KODE.'transaksi_retur');
			self::$_hasil = array('berhasil'=>$core);
			self::$_hasil['total']= $num;
		}
	}
}