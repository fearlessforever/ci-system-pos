<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Barcode extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		
	}
	public function run( ){
		$id = $this->uri->segment(2);
		if(empty($id))show_404();
		$this->load->library('');
		
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-store, no-cache, must-revalidate"); 
		header("Cache-Control: post-check=0, pre-check=0", false); 
		header("Pragma: no-cache"); 	
		header('Content-type: image/jpeg');
		
		require_once(APPPATH .'libraries/php-barcode/BarcodeGenerator' . EXT);
		require_once(APPPATH .'libraries/php-barcode/BarcodeGeneratorPNG' . EXT);
		
		$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
		echo $generator->getBarcode($id, $generator::TYPE_CODE_128);
	}
	public function cetak(){
		$id = $this->uri->segment(2);
		if(empty($id))show_404();
		$this->load->helper('validasi');
		if(!validasi_angka($id ,'',true) )show_404();
		
		$this->load->database();
		$core = $this->db->query("
			SELECT a.id_barang as code,a.nama_barang as nama 
			FROM ".DB_KODE."data_barang a 
			WHERE a.id_barang=? LIMIT 1 
		" , array($id) )->row_array();
		if(isset($core['code'])){
			/* $this->load->model('hel_publis','publisnya',true);
			$data = $this->publisnya->datanya( ); */
			$data['core']=$core;
			$this->load->view('view-barcode' , $data);
		}else{
			/* $this->load->model('hel_publis','publisnya',true);
			$data = $this->publisnya->datanya( ); 
			$data['core']=array('code'=>$id,'nama'=>'tesasfagasgasgasgasgasgasgasgasgasg');
			$this->load->view('view-barcode' , $data); */
			show_404();
		}
		
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */