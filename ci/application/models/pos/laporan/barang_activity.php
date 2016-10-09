<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

class Barang_activity extends CI_Model {
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
		$data =array(
			'code'=> $this->input->post('code')
			,'tgl_mulai'=> $this->input->post('tgl_mulai')
			,'tgl_akhir'=> $this->input->post('tgl_akhir')
		);
		
		if( !validasi_angka($data['code']  ,'',true) ){
			self::$_hasil['error']='Code Barang Tidak Boleh Kosong'; return;
		}
		
		if( !validasi_array($data,'code|tgl_mulai|tgl_akhir') ){
			self::$_hasil['error']='Tanggal Tidak boleh kosong'; return;
		}
		
		$set = $this->publisnya->datanya();
		
		$core = $this->db->query("
			SELECT DATE_FORMAT(aa.tanggal,'%d %M %Y') as tanggal_e, SUM( if(aa.tipe = 0,aa.jumlah,0) ) as pendapatan, SUM( if(aa.tipe != 0,aa.jumlah,0) ) as pengeluaran  FROM (
			SELECT a.tanggal,a.jumlah,a.tipe 
			FROM ".DB_KODE."transaksi_detail a 
			WHERE a.id_barang = ? AND a.tanggal BETWEEN ? AND  ?
			ORDER BY a.tanggal DESC ) aa GROUP BY aa.tanggal ORDER BY aa.tanggal DESC
			LIMIT 50
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
		$table=''; $kondisi='';
		$data =array(
			'tgl_mulai'=> $this->input->post('tgl_mulai')
			,'tgl_akhir'=> $this->input->post('tgl_akhir')
		); 
		if( !validasi_tanggal($data ,'tgl_mulai|tgl_akhir') ){
			self::$_hasil['error']=  ' Tanggal mulai dan akhir tidak benar !!! '; return;
		}/* 
		$retur = $this->input->post('retur');
		if(!empty($retur) && $retur == 'true'){
			$table =' LEFT JOIN '. DB_KODE .'transaksi_retur b ON a.id_transaksi=b.id_transaksi AND a.tanggal=b.tanggal ' ;
			$kondisi = ' AND b.id_transaksi IS NULL ';
		} */
		
		$core = $this->db->query("
			SELECT aa.*,bb.nama_barang as nama FROM (
			SELECT a.id_barang as code , SUM( if(a.tipe = 0,a.jumlah,0) ) as pendapatan, SUM( if(a.tipe != 0,a.jumlah,0) ) as pengeluaran
			FROM ".DB_KODE."transaksi_detail a 
			WHERE a.tanggal BETWEEN ? AND ? 
			GROUP BY a.id_barang
			) aa LEFT JOIN ".DB_KODE."data_barang bb ON aa.code=bb.id_barang
			" , $data )->result_array();
		if(isset($core[0]) && is_array($core)){
			//$core['tgl_mulai']= date('d F Y' ,strtotime($data['tgl_mulai']) ) ;
			//$core['tgl_akhir']= date('d F Y' ,strtotime($data['tgl_akhir']) ) ;
			self::$_hasil = array('berhasil'=>array(
				'tgl_mulai'=> date('d F Y' ,strtotime($data['tgl_mulai']) )
				,'tgl_mulai_a'=> $data['tgl_mulai']
				,'tgl_akhir'=> date('d F Y' ,strtotime($data['tgl_akhir']) )
				,'tgl_akhir_a'=> $data['tgl_akhir']
				,'detail'=>$core
			));
		}
	}
}