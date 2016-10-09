<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

class Pos_barang extends CI_Model {
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
				case 'load-opsi': self::__opsi(); break;
				case 'edit': self::__edit(); break;
				case 'hapus': self::__hapus(); break;
				case 'view': self::__view(); break;
				case 'detail': self::__detail(); break;
				case 'duplicate': self::__duplicate(); break;
				case 'autocomplete': self::__cari_barang_dr_nama(); break;
				default: break;
			}
			echo json_js_array(json_encode(self::$_hasil));
			return ;
		}show_404();
	}
	private function __duplicate(){
		$code = $this->input->post('code');
		if( !validasi_angka($code) ){
			self::$_hasil['error']='ID barang harus Angka '; return;
		}
		$core = $this->db->query("SELECT id_barang FROM ".DB_KODE."data_barang WHERE id_barang=? LIMIT 1",array('B'.$code))->row_array();
		if(isset($core['id_barang'])){
			self::$_hasil['error']='Duplicate Detected';
		}else{ self::$_hasil=array('berhasil'=>'oke'); }
	}
	private function __cari_barang_dr_nama(){
		self::$_hasil =array('error'=>'Barang Tidak Ditemukan');
		$code = $this->input->post('code');
		$core = $this->db->query("
			SELECT a.id_barang,a.nama_barang as nama,a.jumlah,a.harga,a.modal,a.id_tipe as tipe,a.id_satuan as satuan,a.id_ukuran as ukuran,a.id_supplier as supplier
			,DATE_FORMAT(a.tglinsert,'%d %M %y ~ %H:%i') as t_simpan,DATE_FORMAT(a.tglupdate,'%d %M %y ~ %H:%i') as t_update
			,b.ket as satuan_k
			,c.namasupplier as supplier_n,c.alamat as supplier_a,c.kota as supplier_k,c.telepon as supplier_t,c.kontakperson as supplier_hp,c.ket as supplier_ket
			,d.ket as tipe_k,e.ket as ukuran_k
			,f.folder as gambar_fol,f.nama_file as gambar_fil
			FROM ".DB_KODE."data_barang a
			LEFT JOIN ".DB_KODE."data_satuan b ON a.id_satuan=b.id_satuan
			LEFT JOIN ".DB_KODE."data_supplier c ON a.id_supplier=c.id_supplier
			LEFT JOIN ".DB_KODE."data_tipe d ON a.id_tipe=d.id_tipe
			LEFT JOIN ".DB_KODE."data_ukuran e ON a.id_ukuran=e.id_ukuran
			LEFT JOIN ".DB_KODE."gambar f ON a.id_barang=f.id_target
			WHERE a.nama_barang LIKE CONCAT('%',?,'%') LIMIT 7",array($code) )->result_array();
		if(isset($core[0]) && is_array($core)){
			self::$_hasil = array('berhasil'=>$core); 
		}
	}
	private function __detail(){
		self::$_hasil =array('error'=>'Barang Tidak Ditemukan');
		$code = $this->input->post('code'); //$code = preg_replace('/[^0-9a-z]/i','',$code); if(!isset($code[0]))return ;
		if( !validasi_angka($code,'',true) ){
			self::$_hasil['error']='Ada Kesalahan , silahkan refresh halaman'; return;
		}
		$core = $this->db->query("
			SELECT a.id_barang,a.nama_barang as nama,a.jumlah,a.harga,a.modal,a.id_tipe as tipe,a.id_satuan as satuan,a.id_ukuran as ukuran,a.id_supplier as supplier
			,DATE_FORMAT(a.tglinsert,'%d %M %y ~ %H:%i') as t_simpan,DATE_FORMAT(a.tglupdate,'%d %M %y ~ %H:%i') as t_update
			,b.ket as satuan_k
			,c.namasupplier as supplier_n,c.alamat as supplier_a,c.kota as supplier_k,c.telepon as supplier_t,c.kontakperson as supplier_hp,c.ket as supplier_ket
			,d.ket as tipe_k,e.ket as ukuran_k
			,f.folder as gambar_fol,f.nama_file as gambar_fil
			FROM ".DB_KODE."data_barang a
			LEFT JOIN ".DB_KODE."data_satuan b ON a.id_satuan=b.id_satuan
			LEFT JOIN ".DB_KODE."data_supplier c ON a.id_supplier=c.id_supplier
			LEFT JOIN ".DB_KODE."data_tipe d ON a.id_tipe=d.id_tipe
			LEFT JOIN ".DB_KODE."data_ukuran e ON a.id_ukuran=e.id_ukuran
			LEFT JOIN ".DB_KODE."gambar f ON a.id_barang=f.id_target
			WHERE a.id_barang=? LIMIT 1",array($code) )->row_array();
		if(isset($core['id_barang']) && is_array($core)){
			self::$_hasil = array('berhasil'=>$core); 
		}
	}
	private function __edit(){
		self::$_hasil =array('error'=>'Gagal Simpan');
		$code = $this->input->post('code'); 
		if( !validasi_angka($code,'',true) ){
			self::$_hasil['error']='Ada Kesalahan , silahkan refresh halaman'; return;
		}
		if($code == 1){ self::$_hasil['error']='Anda tidak boleh Merubah Code Standar'; return;}
		$data =array();
		
		$data['nama_barang']=$this->input->post('nama_barang');
		$data['jumlah']=$this->input->post('jmlbarang');
		$data['harga']=$this->input->post('hrgbarang');
		$data['modal']=$this->input->post('mdlbarang');
		$data['id_tipe']=$this->input->post('tipe');
		$data['id_satuan']=$this->input->post('satuan');
		$data['id_ukuran']=$this->input->post('ukuran');
		$data['id_supplier']=$this->input->post('supplier');
		$data['userid']=$this->session->_user['userid'];
		if( !validasi_array($data ,'nama_barang|userid') ){
			self::$_hasil['error']='Nama Barang tidak boleh kosong '; return;
		}
		if( !validasi_angka($data ,'jumlah|harga|modal') ){
			self::$_hasil['error']='Jumlah Barang, Harga Jual, Harga Beli Harus Angka ' ; return;
		}
		validasi_angka($data ,'id_tipe|id_satuan|id_ukuran|id_supplier',true);
		
		$core = $this->db->query("SELECT id_barang FROM ".DB_KODE."data_barang WHERE id_barang=? LIMIT 1",array($code) )->row_array();
		if(!isset($core['id_barang'])){
			self::$_hasil['error']='ID barang Tidak Ditemukan '; return;
		}
		$this->db->where('id_barang',$code )->limit(1)->update(DB_KODE .'data_barang',$data);
		$core = $this->db->affected_rows();
		if($core){
			self::$_hasil=array('berhasil'=>'Data Berhasil Disimpan'); 
			self::$_hasil['baru']=array(
				'code'=> $code ,'nama'=>$data['nama_barang'],'tipe'=>$data['id_tipe'],'satuan'=>$data['id_satuan'],'ukuran'=>$data['id_ukuran'],'supplier'=>$data['id_supplier'],'jumlah'=>$data['jumlah'],'harga'=>$data['harga'],'modal'=>$data['modal']
			);
		}else self::$_hasil=array('error'=>'Tidak Ada Data yg Diubah');
	}
	private function __tambah(){
		self::$_hasil =array('error'=>'Gagal Simpan');
		$code = $this->input->post('code'); 
		if( !validasi_angka($code ) ){
			self::$_hasil['error']='Ada Kesalahan , silahkan refresh halaman'; return;
		}
		$data =array();
		$data['id_barang']='B'.$code;
		$data['nama_barang']=$this->input->post('nama_barang');
		$data['jumlah']=$this->input->post('jmlbarang');
		$data['harga']=$this->input->post('hrgbarang');
		$data['modal']=$this->input->post('mdlbarang');
		$data['id_tipe']=$this->input->post('tipe');
		$data['id_satuan']=$this->input->post('satuan');
		$data['id_ukuran']=$this->input->post('ukuran');
		$data['id_supplier']=$this->input->post('supplier');
		$data['tglinsert']=date('Y-m-d H:i:s');
		$data['tglupdate']=date('Y-m-d H:i:s');
		$data['userid']=$this->session->_user['userid'];
		if( !validasi_array($data ,'id_barang|nama_barang|userid') ){
			self::$_hasil['error']=' Nama Barang tidak boleh kosong '; return;
		}
		if( !validasi_angka($data ,'jumlah|harga|modal') ){
			self::$_hasil['error']='Jumlah Barang, Harga Jual, Harga Beli Harus Angka ' ; return;
		}
		validasi_angka($data ,'id_tipe|id_satuan|id_ukuran|id_supplier',true);
		
		$this->db->query("INSERT IGNORE INTO ".DB_KODE."data_barang(".implode(',',array_keys($data)).") VALUES(?".str_repeat(',?',(count($data)-1) ) .") " ,$data);
		$core = $this->db->affected_rows();
		if($core){
			self::$_hasil=array('berhasil'=>'Data Berhasil Disimpan');
			self::$_hasil['baru']=array(
				'code'=>$data['id_barang'],'nama'=>$data['nama_barang'],'tipe'=>$data['id_tipe'],'satuan'=>$data['id_satuan'],'ukuran'=>$data['id_ukuran'],'supplier'=>$data['id_supplier'],'jumlah'=>$data['jumlah'],'harga'=>$data['harga'],'modal'=>$data['modal']
			);
		}
	}
	private function __hapus(){
		self::$_hasil =array('error'=>'Gagal Hapus Data');
		$code = $this->input->post('code');
		if( !validasi_angka($code,'',true) ){
			self::$_hasil['error']='Ada Kesalahan , silahkan refresh halaman'; return;
		}
		if($code == 1){ self::$_hasil['error']='Anda tidak boleh menghapus Code Standar'; return;}
		
		$set = $this->publisnya->datanya();
		if(isset($set['boleh_hapus']['isi1']) && $set['boleh_hapus']['isi1'] != 1){
			self::$_hasil['error']='System Tidak Membolehkan Hapus Data'; return;
		}
		
		$core = $this->db->query("DELETE FROM ".DB_KODE."data_barang WHERE id_barang=? LIMIT 1" ,array($code) );
		if($core){
			self::$_hasil=array('berhasil'=>'Data Berhasil Dihapus');
		}
		else{
			self::$_hasil['error']= ($set['debug_db'] == true ) ? $this->db->_error_message() : 'Data Sudah Digunkan, Tidak bisa dihapus';
		}
	}
	private function __view(){
		$_image = $this->input->post('pilihan');
		if($_image){
			// ini untuk dapatin list barang yg belum ada gambar
			$core = $this->db->query("
				SELECT id_barang as code,nama_barang as nama 
				FROM ".DB_KODE."data_barang a
				LEFT JOIN ".DB_KODE."gambar b ON a.id_barang = b.id_target
				WHERE b.id_target IS NULL
				LIMIT 1000")->result_array();
			if(isset($core[0]) && is_array($core)){
				$num = $this->db->count_all_results(DB_KODE.'data_barang');
				self::$_hasil = array('berhasil'=>$core);
				self::$_hasil['total']= $num;
			}
		}else{
			$core = $this->db->query("
				SELECT id_barang as code,nama_barang as nama,id_tipe as tipe,id_satuan as satuan,id_ukuran as ukuran,id_supplier as supplier,jumlah,harga,modal
				FROM ".DB_KODE."data_barang LIMIT 1000")->result_array();
			if(isset($core[0]) && is_array($core)){
				$num = $this->db->count_all_results(DB_KODE.'data_barang');
				self::$_hasil = array('berhasil'=>$core);
				self::$_hasil['total']= $num;
			}
		}
		
	}
	private function __opsi(){
		$mode = $this->input->post('pilihan');
		switch($mode){
			case 'satuan': 
				$core = $this->db->query(" SELECT id_satuan as code,ket as nama FROM ".DB_KODE."data_satuan LIMIT 1000")->result_array();
				break;
			case 'tipe': 
				$core = $this->db->query(" SELECT id_tipe as code,ket as nama FROM ".DB_KODE."data_tipe LIMIT 1000")->result_array();
				break;
			case 'ukuran': 
				$core = $this->db->query(" SELECT id_ukuran as code,ket as nama FROM ".DB_KODE."data_ukuran LIMIT 1000")->result_array();
				break;
			case 'supplier': 
				$core = $this->db->query(" SELECT id_supplier as code,namasupplier as nama FROM ".DB_KODE."data_supplier LIMIT 1000")->result_array();
				break;
			default: return;
		}
		
		if(isset($core[0]) && is_array($core)){
			self::$_hasil = array('berhasil'=>$core);
		}
	}
}