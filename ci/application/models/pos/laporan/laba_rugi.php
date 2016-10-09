<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

class Laba_rugi extends CI_Model {
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
				//case 'detail': self::__detail(); break;
				case 'view': self::__view(); break;
				default: break;
			}
			echo json_js_array(json_encode(self::$_hasil));
			return ;
		}show_404();
	}
	
	/* private function __detail(){
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
	} */
	
	private function __view(){
		self::$_hasil =array('error'=>'Data Tidak Ditemukan');
		$table=''; $kondisi='';
		$data =array(
			'tgl_mulai'=> $this->input->post('tgl_mulai')
			,'tgl_akhir'=> $this->input->post('tgl_akhir')
		); 
		if( !validasi_tanggal($data ,'tgl_mulai|tgl_akhir') ){
			self::$_hasil['error']=  ' Tanggal mulai dan akhir tidak benar !!! '; return;
		}
		$retur = $this->input->post('retur');
		if(!empty($retur) && $retur == 'true'){
			$table =' LEFT JOIN '. DB_KODE .'transaksi_retur b ON a.id_transaksi=b.id_transaksi AND a.tanggal=b.tanggal ' ;
			$kondisi = ' AND b.id_transaksi IS NULL ';
		}
		
		$core = $this->db->query("
			SELECT 
				SUM( if(a.tipe =0 , a.total_h , 0) ) as pendapatan , SUM( if(a.tipe !=0 , a.total_h , 0) ) as pengeluaran,
				SUM( if(a.tipe =0 , 1 , 0) ) as trans_pendapatan , SUM( if(a.tipe !=0 , 1 , 0) ) as trans_pengeluaran
			FROM ".DB_KODE."transaksi a 
			{$table}
			WHERE a.tanggal BETWEEN ? AND ? {$kondisi}
			ORDER BY a.tanggal ASC LIMIT 1" , $data )->row_array();
		if(isset($core['pendapatan']) && is_array($core)){
			$core['tgl_mulai']= date('d F Y' ,strtotime($data['tgl_mulai']) ) ;
			$core['tgl_akhir']= date('d F Y' ,strtotime($data['tgl_akhir']) ) ;
			self::$_hasil = array('berhasil'=>$core);
		}
	}
}