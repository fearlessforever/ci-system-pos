<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

class Pos_input_kre_deb extends CI_Model {
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
				case 'load-opsi': self::__opsi(); break;
				case 'tambah': self::__tambah(); break;
				case 'hapus': self::__hapus(); break;
				case 'view': self::__view(); break;
				case 'detail': self::__detail(); break;
				case 'jurnal': self::__jurnalny(); break;
				default: break;
			}
			echo json_js_array(json_encode(self::$_hasil));
			return ;
		}show_404();
	}
	private function __jurnalny(){
		self::$_hasil=array('error'=>'Data Tidak Ditemukan');
		$data =array(
			'tgl_a'=>$this->input->post('tglmulai')
			,'tgl_b'=>$this->input->post('tglakhir')
		);
		if(!validasi_tanggal($data ,'tgl_a|tgl_b')){
			self::$_hasil['error']='Tanggal Tidak Boleh Kosong'; return;
		}
		$core = $this->db->query("
			SELECT a.id_ref as code,a.detail as ket,a.tipe,a.angka,DATE_FORMAT(b.tanggal,'%d %M %Y') as tgl,c.ket as code_ket
			FROM ".DB_KODE."debit_kredit_detail a 
			LEFT JOIN ".DB_KODE."debit_kredit b ON a.id_kredeb=b.id_kredeb 
			LEFT JOIN ".DB_KODE."data_ref c ON a.id_ref=c.id_ref 
			WHERE b.tanggal BETWEEN ? AND ?
			ORDER BY tanggal ASC
			LIMIT 500
			" , $data )->result_array();
		if(isset($core[0]) && is_array($core) ){
			self::$_hasil=array('berhasil'=>$core ); 
			self::$_hasil['tgl1']=date('d F Y',strtotime($data['tgl_a']) ) ;
			self::$_hasil['tgl2']=date('d F Y',strtotime($data['tgl_b']) ) ;
			$bb=array(); $_bb_c=array();
			foreach($core as $val){
				if(!isset( $_bb_c[ $val['code'] ] )){
					$_bb_c[ $val['code'] ] = $val['code'];
					$bb[ $val['code'] ][] = $val ;
				}else{
					$bb[ $val['code'] ][] = $val;
				}
			}
			self::$_hasil['buku_besar']=$bb;
		}
	}
	private function __detail(){
		self::$_hasil=array('error'=>'Data Tidak Ditemukan');
		$code = $this->input->post('code');
		if( !validasi_angka($code ) ){
			self::$_hasil['error']='Ada Kesalahan , silahkan refresh halaman'; return;
		}
		$core = $this->db->query("
			SELECT a.id_ref as code,a.detail as ket,a.tipe,a.angka,DATE_FORMAT(b.tanggal,'%d %M %Y') as tanggal,c.ket as code_ket
			FROM ".DB_KODE."debit_kredit_detail a 
			LEFT JOIN ".DB_KODE."debit_kredit b ON a.id_kredeb=b.id_kredeb 
			LEFT JOIN ".DB_KODE."data_ref c ON a.id_ref=c.id_ref 
			WHERE a.id_kredeb=?
			LIMIT 500
			" , array($code) )->result_array();
		if(isset($core[0]) && is_array($core) ){
			self::$_hasil=array('berhasil'=>$core ); 
		}
	}
	private function __opsi(){
		self::$_hasil=array('error'=>'Data Tidak Ditemukan');
		$core = $this->db->query("
			SELECT id_ref as code,ket as nama FROM ".DB_KODE."data_ref ORDER BY id_ref ASC LIMIT 500
			")->result_array();
		if(isset($core[0]) && is_array($core) ){
			self::$_hasil=array('berhasil'=>$core ); 
		}
	}
	
	private function __tambah(){
		self::$_hasil =array('error'=>'Gagal Simpan');
		$waktu = $this->input->post('tanggal');
		if($waktu == 'hari ini'){
			$waktu =date('Y-m-d');
		}else{
			if( !validasi_tanggal($waktu) ){
				self::$_hasil['error']='Tanggal Tidak Boleh Kosong'; return;
			}
		}
		$jml_kredit =0; $jml_debit=0;
		$idref = $this->input->post('idref'); $datas=null;
		if( $idref && is_array($idref) ){
			$ket = $this->input->post('ket');
			$angka = $this->input->post('angka');
			$tipe = $this->input->post('tipe');
			foreach($idref as $k => $val){
				$_data = array(
					'id_ref'=>$val , 'angka'=>isset($angka[$k]) ? $angka[$k] :null, 'tipe'=>isset($tipe[$k]) ? $tipe[$k] :null, 'detail'=>isset($ket[$k]) ? $ket[$k] :null
				);
				if( !validasi_array($_data ,'id_ref|angka|tipe|detail') ){
					self::$_hasil['error']='Nomor Akun,Keterangan, Dan Jumlah Tidak boleh kosong & Jumlah Harus angka ' ; return;
				}
				if( $_data['tipe'] == 'kredit'){ $jml_kredit += $_data['angka']; $_data['tipe'] =0; }else{ $jml_debit += $_data['angka']; $_data['tipe'] =1; }
				$datas[]=$_data;
			}
		}
		
		if( $jml_debit != $jml_kredit ){
			self::$_hasil['error'] = 'Jumlah Kredit Tidak Sama Dengan Debit !!!'; return;
		}
		if(empty($datas)){
			self::$_hasil['error'] = 'Tidak Ada detail informasi kredit dan debit'; return;
		}
		
		$data = array(
			'userid'=> $this->session->_user['userid']
			,'tanggal'=> $waktu
		);
		
		$tipe = $this->input->post('tipe');
		//$data['tipe'] = ($tipe == 1) ? 1 : 0;
		/* Ctt: $tipe = 0 = Kredit ,  1 = Debit */
		$set = $this->publisnya->datanya();
		
		$this->db->trans_start();
		
		$core = $this->db->query("INSERT INTO ".DB_KODE."debit_kredit(".implode(',',array_keys($data)).") VALUES(?".str_repeat(',?',(count($data)-1) ) .") " ,$data);
		if($core){
			// SAVE ke DB model Prepare
			$id_kredeb = $this->db->insert_id();
			mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT );
			if($stmt = mysqli_prepare($this->db->conn_id , "INSERT INTO ".DB_KODE."debit_kredit_detail(id_ref,tipe,id_kredeb,angka,detail ) VALUES(?,?,?,?,?) ") ){
				foreach($datas as $val){
					try{
						$stmt->bind_param('iiiis',$val['id_ref'],$val['tipe'],$id_kredeb,$val['angka'],$val['detail'] );
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
		}
		else{ $this->db->_trans_status = FALSE; }
		
		if($this->db->trans_status() === FALSE){// Check if transaction result successful
		   $this->db->trans_rollback();
		   self::$_hasil['error']= empty($set['debug_db']) ? 'Gagal Simpan DEBIT / KREDIT ' : ( isset($error)? $error : $this->db->_error_message() ); 
		   return;
		}else{
		   $this->db->trans_complete();
		   $core = $this->db->query("
				SELECT a.id_kredeb as code,DATE_FORMAT(a.tanggal,'%d %M %Y') as ket ,c.nama,DATE_FORMAT(a.waktu,'%d %M %Y ~ %H:%i') as jam
				FROM ".DB_KODE."debit_kredit a 
				LEFT JOIN ".DB_KODE."pengguna c ON a.userid = c.userid
				WHERE a.id_kredeb=?
				LIMIT 1",array( $id_kredeb ) )->row();
		   self::$_hasil=array('berhasil'=>'Data Berhasil Disimpan' ); 
		   self::$_hasil['baru']=$core; 
		   return;
		}
		
	}
	private function __hapus(){
		self::$_hasil =array('error'=>'Gagal Hapus Ref');
		$code = $this->input->post('code');
		if( !validasi_angka($code,'',true) ){
			self::$_hasil['error']='Ada Kesalahan , silahkan refresh halaman'; return;
		}
		
		$set = $this->publisnya->datanya();
		if(isset($set['boleh_hapus']['isi1']) && $set['boleh_hapus']['isi1'] != 1){
			self::$_hasil['error']='System Tidak Membolehkan Hapus Data'; return;
		}
		$core = $this->db->query("DELETE FROM ".DB_KODE."debit_kredit WHERE id_kredeb=? LIMIT 1" ,array($code) );
		if($core){
			self::$_hasil=array('berhasil'=>'Data Berhasil Dihapus');
		}
		else{
			self::$_hasil['error']= ($set['debug_db'] == true ) ? $this->db->_error_message() : 'Data Tidak bisa dihapus';
		}
	}
	private function __view(){
		$data=null; $kondisi='';
		$tgl_a = $this->input->post('tglmulai');
		$tgl_b = $this->input->post('tglakhir');
		if($tgl_a && $tgl_b){
			$data = array('tgl_a'=>$tgl_a ,'tgl_b'=>$tgl_b);
			if(!validasi_tanggal($data ,'tgl_a|tgl_b')){
				self::$_hasil['error']='Tanggal Tidak Boleh Kosong'; return;
			}
			$kondisi='WHERE a.tanggal BETWEEN ? AND ? ';
		}
		$core = $this->db->query("
			SELECT a.id_kredeb as code,DATE_FORMAT(a.tanggal,'%d %M %Y') as ket ,c.nama,DATE_FORMAT(a.waktu,'%d %M %Y ~ %H:%i') as jam
			FROM ".DB_KODE."debit_kredit a 
			LEFT JOIN ".DB_KODE."pengguna c ON a.userid = c.userid
			{$kondisi}
			ORDER BY a.tanggal DESC
			LIMIT 300", $data )->result_array();
		if(isset($core[0]) && is_array($core)){
			self::$_hasil = array('berhasil'=>$core); 
		}
	}
}