<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

class Pos_supplier extends CI_Model {
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
				case 'view': self::__view(); break;
				case 'hapus': self::__hapus(); break;
				case 'duplicate': self::__duplicate(); break;
				default: break;
			}
			echo json_encode(self::$_hasil);
			//$this->load->view('json',array('hasil'=>self::$_hasil) );
			return ;
		}show_404();
	}
	private function __duplicate(){
		$code = $this->input->post('code');
		if( !validasi_angka($code) ){
			self::$_hasil['error']='ID harus Angka '; return;
		}
		$core = $this->db->query("SELECT id_supplier FROM ".DB_KODE."data_supplier WHERE id_supplier=? LIMIT 1",array('SUP'.$code))->row_array();
		if(isset($core['id_supplier'])){
			self::$_hasil['error']='Duplicate Detected';
		}else{ self::$_hasil=array('berhasil'=>'oke'); }
	}
	private function __edit(){
		self::$_hasil =array('error'=>'Gagal Simpan');
		$code = $this->input->post('code');
		if( !validasi_angka($code,'',true) ){
			self::$_hasil['error']='Ada Kesalahan , silahkan refresh halaman'; return;
		}
		if($code == 1){ self::$_hasil['error']='Anda tidak boleh Merubah Code Standar'; return;}
		
		$data =array();
		$data['namasupplier']=$this->input->post('namasupplier');
		$data['alamat']=$this->input->post('alamat');
		$data['kota']=$this->input->post('kota');
		$data['telepon']=$this->input->post('telepon');
		$data['kontakperson']= $this->input->post('kontakperson');
		$data['ket']=$this->input->post('keterangan');
		$data['ipaddress']= $this->input->ip_address() ;
		
		$this->db->where('id_supplier',$code )->limit(1);
		if($this->session->_user['level'] != 'admin'){
			$this->db->where('userid',$this->session->_user['userid'] );
		}
		$this->db->update(DB_KODE .'data_supplier',$data);
		$core = $this->db->affected_rows();
		if($core){
			self::$_hasil=array('berhasil'=>'Data Berhasil Disimpan'); 
			self::$_hasil['baru']=array(
				'code'=> $code ,'namasupplier'=>$data['namasupplier'],'alamat'=>$data['alamat'],'kota'=>$data['kota'],'telepon'=>$data['telepon'],'kontakperson'=>$data['kontakperson'],'ket'=>$data['ket'],'tglinsert'=>date("Y-m-d H:i:s") ,'tglupdate'=>date("Y-m-d H:i:s") 
			);
		}else self::$_hasil=array('error'=>'Tidak Ada Data yg Diubah');
	}
	private function __tambah(){
		self::$_hasil =array('error'=>'Gagal Simpan');
		$code = $this->input->post('code');
		if( !validasi_angka($code) ){
			self::$_hasil['error']='ID harus Angka '; return;
		}
		$data =array();
		$data['id_supplier']='SUP'.$code;
		$data['namasupplier']=$this->input->post('namasupplier');
		$data['alamat']=$this->input->post('alamat');
		$data['kota']=$this->input->post('kota');
		$data['telepon']=$this->input->post('telepon');
		$data['kontakperson']= $this->input->post('kontakperson');
		$data['ket']=$this->input->post('keterangan');
		$data['tglinsert']= date("Y-m-d H:i:s");
		$data['tglupdate']= date("Y-m-d H:i:s");
		$data['ipaddress']= $this->input->ip_address() ;
		$data['userid']= $this->session->_user['userid'] ;
		
		if( !validasi_array($data,'id_supplier|namasupplier|ipaddress|userid') ){
			self::$_hasil['error']='Nama Supplier Tidak Boleh Kosong'; return;
		}
		
		$this->db->query("INSERT IGNORE INTO ".DB_KODE."data_supplier(".implode(',',array_keys($data)).") VALUES(?".str_repeat(',?',(count($data)-1) ) .") " ,$data);
		$core = $this->db->affected_rows();
		if($core){
			self::$_hasil=array('berhasil'=>'Data Berhasil Disimpan');
			self::$_hasil['baru']=array(
				'code'=> $data['id_supplier'] ,'namasupplier'=>$data['namasupplier'],'alamat'=>$data['alamat'],'kota'=>$data['kota'],'telepon'=>$data['telepon'],'kontakperson'=>$data['kontakperson'],'ket'=>$data['ket'],'tglinsert'=>$data['tglinsert'],'tglupdate'=>$data['tglupdate']
			);
		}
	}
	private function __hapus(){
		self::$_hasil =array('error'=>'Gagal Hapus Supplier');
		$code = $this->input->post('code');
		if( !validasi_angka($code,'',true) ){
			self::$_hasil['error']='Ada Kesalahan , silahkan refresh halaman'; return;
		}
		
		if($code == 1){ self::$_hasil['error']='Anda tidak boleh menghapus Code Standar'; return;}
		
		$set = $this->publisnya->datanya();
		if(isset($set['boleh_hapus']['isi1']) && $set['boleh_hapus']['isi1'] != 1){
			self::$_hasil['error']='System Tidak Membolehkan Hapus Data'; return;
		}
		$core = $this->db->query("DELETE FROM ".DB_KODE."data_supplier WHERE id_supplier=? LIMIT 1" ,array($code) );
		if($core){
			self::$_hasil=array('berhasil'=>'Data Berhasil Dihapus');
		}
		else{
			self::$_hasil['error']= ($set['debug_db'] == true ) ? $this->db->_error_message() : 'Data Sudah Digunkan, Tidak bisa dihapus';
		}
	}
	private function __view(){
		$core = $this->db->query("
		SELECT id_supplier as code,namasupplier,alamat,kota,telepon,kontakperson,ket,tglinsert,tglupdate
		FROM ".DB_KODE."data_supplier LIMIT 1000")->result_array();
		if(isset($core[0]) && is_array($core)){
			$num = $this->db->count_all_results(DB_KODE.'data_supplier');
			self::$_hasil = array('berhasil'=>$core);
			self::$_hasil['total']= $num;
		}
	}
}