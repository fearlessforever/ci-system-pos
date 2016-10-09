<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

class Pos_pengeluaran extends CI_Model {
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
				case 'wkwkwkw': self::__pembayaran(); break;
				default: break;
			}
			echo json_js_array(json_encode(self::$_hasil));
			//$this->load->view('json',array('hasil'=>self::$_hasil));
			return ;
		}show_404();
	}
	private function __pembayaran(){
		//sleep(7);
		self::$_hasil['error']='Ada Kesalahan , coba lagi !!!';
		$data=array();
		$data['bayar'] = $this->input->post('bayar');
		$data['kembali'] = $this->input->post('kembali');
		$data['total_h'] = $this->input->post('total');
		// ---------------- VALIDASI ----------------- //
		if( !validasi_angka($data,'bayar|total_h',false ) ){
			self::$_hasil['error']='Kesalahan Dari input anda Bayar : '.$data['bayar'] .' Total Harga : '.$data['total_h']  ; return;
		}
		if( $data['bayar'] <  $data['total_h'] ){
			self::$_hasil['error']='Kesalahan Dari input anda Bayar, Pembayaran Tidak boleh lebih rendah dari Total Harga '; return;
		}
		if( ($data['bayar']- $data['total_h'] ) !=  $data['kembali'] ){
			self::$_hasil['error']='Kembalian tidak sesuai dengan yg dibayarkan'; return;
		}
		$data['detail'] = $this->input->post('list');
		$data['userid'] = $this->session->_user['userid'];
		if( !validasi_array($data,'detail|userid') ){
			self::$_hasil['error']='Tidak ada detail pembayaran'; return;
		}
		$data2=array();
		$a = json_decode($data['detail'] , true);
		if(isset($a ) && is_array($a ) ){
			$no=0;
			foreach($a  as $val)if(isset($val['id_barang'])){
				if( !validasi_angka($val,'total|harga') ){
					self::$_hasil['error']='Ada Kesalahan Pada List Barang : '.$val['id_barang'] ; return;
				}
				$data2[]=array('nmr'=>++$no,'id_barang'=>$val['id_barang'],'jumlah'=>$val['total'],'harga'=>$val['harga']);
			}
		}
		if(!isset($data2[0])){
			self::$_hasil['error']='List Barang Tidak Ditemukan !!!'; return;
		}
		// ---------------- END VALIDASI ----------------- //
		// ---------------- START simpan ke DB ----------------- //
		$set = $this->publisnya->datanya();
		$error = false;
		$this->db->trans_start();
			$code = $this->db->query("SELECT kode_auto('pembelian',true) as code ")->row_array();
			$data['id_transaksi'] = $code['code'];
			$this->db->query("INSERT INTO ".DB_KODE."transaksi(tipe,bayar,kembali,total_h,detail,userid,id_transaksi,tanggal,waktu) VALUES(1,?,?,?,?,?,?,current_date(),now() ) ",$data);
			
			// SAVE ke DB model Prepare
			mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT );
			if($stmt = mysqli_prepare($this->db->conn_id , "INSERT INTO ".DB_KODE."transaksi_detail(tipe,id_transaksi,tanggal,nmr,id_barang,jumlah,harga,userid) VALUES(1,?,CURRENT_DATE(),?,?,?,?,?) ") ){
				foreach($data2 as $val){
					try{
						$stmt->bind_param('sisiis',$code['code'],$val['nmr'],$val['id_barang'],$val['jumlah'],$val['harga'],$this->session->_user['userid'] );
					}catch(Exception $e){
						$error = $stmt->error;
						$this->db->_trans_status = FALSE; BREAK;
					}
					try{
						$stmt->execute();
					}catch(Exception $e){
						$error = $stmt->error;
						$this->db->_trans_status = FALSE; BREAK;
					}
				}
			}else{ $this->db->_trans_status = FALSE; }
			// END simpan ke DB model Prepare --------------------------
		  
		if($this->db->trans_status() === FALSE){// Check if transaction result successful
		   $this->db->trans_rollback();
		   self::$_hasil['error']= empty($set['debug_db']) ? 'Kesalahan Pada penyimpanan detail barang' : ( isset($error)? $error : $this->db->_error_message() ); 
		   return;
		}else{
		   $this->db->trans_complete();
		   $this->db->query("INSERT INTO ".DB_KODE."pengguna_ext(userid,nama,isi) VALUES(?,?,1) ON DUPLICATE KEY UPDATE isi=isi+1 ",array($this->session->_user['userid'] , 'trans_pengeluaran') );
		   self::$_hasil=array('berhasil'=>array('nota'=>$code['code'] ,'tanggal'=>date('Y-m-d') )  ); return;
		}
	}
	
}