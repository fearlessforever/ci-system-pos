<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Printnya extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		
	}
	public function run($id=null){
		//$hash = $this->uri->segment(4,0); if(empty($hash))show_404();
		$id = $this->uri->segment(2,0); $tgl = $this->uri->segment(3,0);
		if(empty($id) || empty($tgl))show_404();
		
		$this->load->model('hel_publis','publisnya',true);
		$this->load->helper('utama');
		
		$set = $this->publisnya->datanya();
		$data = array(
			$id ,$tgl 
		);
		$core = $this->db->query("
			SELECT a.id_barang,a.jumlah,a.harga,b.nama_barang as nama
			FROM ".DB_KODE."transaksi_detail a
			LEFT JOIN ".DB_KODE."data_barang b ON a.id_barang=b.id_barang
			WHERE a.id_transaksi=? AND a.tanggal=?
			" ,$data)->result_array();
		if(isset($core[0]) && is_array($core) ){
			$set['nota'] = $this->db->query("
				SELECT a.tipe,DATE_FORMAT(a.waktu ,'%d-%m-%Y %H:%i') as waktu,a.id_transaksi as code , a.bayar,a.kembali,b.nama
				FROM ".DB_KODE."transaksi a
				LEFT JOIN ".DB_KODE."pengguna b ON a.userid=b.userid
				WHERE a.id_transaksi=? AND a.tanggal=? LIMIT 1 ", $data )->row_array();
			$set['nota_list'] = $core ;
			
			$this->load->view('nota',$set );
		}else{
			show_404();
		}
		
		/* if( $hash == md5($set['key_hash'].$id.$tgl.date('Y-m-d') ) ){
			echo 'hahaha';
		}else{
			show_404();
		} */
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */