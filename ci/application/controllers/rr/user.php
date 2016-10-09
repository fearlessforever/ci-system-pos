<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('hel_publis','publisnya',true);
		self::ceklogin();
		$this->load->helper('utama');
	}
	public function route($id=null){
		switch($id){
			case 'pages': self::pages(); break;
			case 'ajax': self::ajax(); break;
			case null:
				$data=$this->publisnya->datanya();
				$data['userdata']=array();
				$core = $this->db->query("SELECT nama,isi FROM ". DB_KODE ."pengguna_ext WHERE userid=? LIMIT 27",array( $this->session->_user['userid'] ) )->result_array();
				if(isset($core[0]) && is_array($core) ){
					foreach($core as $val)$data['userdata'][ $val['nama'] ]=$val['isi'];
				}
				$this->load->view('tema/'.$data['theme'].'/z_load_view',$data);
				break;
			default : show_404();
		}
	}
	private function ceklogin(){
		$login = $this->session->is_logged_in();
		if(!$login)redirect(base_url());
		else{
			$this->db->save_queries=false;
			$core = $this->db->query("SELECT userid,level,nama FROM ".DB_KODE."pengguna WHERE userid=? LIMIT 1",array( $this->session->_user['userid'] ) )->row_array();
			if(isset($core['userid'])){
				$this->session->_user['nama']= isset($core['nama']['18']) ? substr($core['nama'],0,17).' ...' : $core['nama'];
				$this->session->_user['level']=$core['level'];
				$this->session->_user['modul']=array();
				$core = explode(' ',$this->session->_user['nama'] );
				$this->session->_user['nama_d']= $core[0];
				$this->db->query("INSERT INTO ".DB_KODE."pengguna_ext(userid,nama,isi) VALUES(?,?,UNIX_TIMESTAMP() ) ON DUPLICATE KEY UPDATE isi=VALUES(isi) ",array($this->session->_user['userid'] , 'last_activity') );
				$_modul = $this->db->query("SELECT nama_app FROM ".DB_KODE."pengguna_izin WHERE level =?" ,array($this->session->_user['level'] ) )->result_array();
				if(isset($_modul[0]) && is_array($_modul) ){
					foreach($_modul as $k => $val){
						$_modul[ $val['nama_app'] ] =$val['nama_app']; unset($_modul[$k]);
					}
					$this->session->_user['modul'] = $_modul;
				}
			}else{
				$this->session->sess_destroy();
				redirect(base_url());
			}
		}
	}
	private function pages(){
		$check = $this->input->is_ajax_request();
		if($check){
			$id = $this->uri->segment(3);
			$nama_app = preg_replace('/[^0-9a-z_-]/i',null,$id) ;
			if(isset($nama_app[0])){
				$core = $this->db->query("SELECT nama_app as nama,file_aplikasi as file,perawatan FROM z_aplikasi WHERE nama_app=? AND mode=? LIMIT 1",array($nama_app,'pos'))->row();
				if(isset($core->nama)){
					if(!file_exists(APPPATH .'views/dashboard/'.$core->file . EXT))die('<h1 style="text-align:center;"> Application Not Install</h1>' );
					if($core->perawatan != 0 )die('<h1 style="text-align:center;"> Application Not Available Right Now</h1>' );
					if($this->session->_user['level'] != 'admin' && !isset($this->session->_user['modul'][ $core->nama ] ) )
						die('<h1 style="text-align:center; font-weight:bold; color:red;">Anda Tidak Boleh Mengakses Menu INi</h1>');
					$data=$this->publisnya->datanya();
					$data['__controller']=$core->nama;
					$this->load->view('dashboard/'.$core->file,$data);
					return;
				}
			}
		}show_404();
	}
	private function ajax($id=null){
		$id = $this->input->post('controller');
		$nama_app = preg_replace('/[^0-9a-z_-]/i',null,$id) ;
		if(isset($nama_app[0])){
			$core = $this->db->query("SELECT nama_app as nama,file_model as file,perawatan FROM z_aplikasi WHERE nama_app=? AND mode=? LIMIT 1",array($nama_app,'pos'))->row();
			if(isset($core->nama)){
				if(!file_exists(APPPATH .'models/pos/'.$core->file . EXT))die('<h1 style="text-align:center;"> Application Not Install</h1>' );
				if($core->perawatan != 0 )die('<h1 style="text-align:center;"> Application Not Available Right Now</h1>' );
				/* //$nama_app = explode('/',$core->file); $nama_app = end($nama_app); */
				$this->load->model('pos/'.$core->file ,'jalankan',true);
				$this->jalankan->run();
				return;
			}
		}show_404();
	}
	/* public function tesaja(){
		$db['hostname'] = 'mysql:host=localhost;dbname=swalayan';
		$db['username'] = 'root';
		$db['password'] = '';
		$db['database'] = 'swalayan';
		$db['dbdriver'] = 'pdo';
		
		//$dsn = 'pdo://root:@localhost/swalayan';
	
		$this->pdo = $this->db; //$this->load->database($db, true);
		$stmt = $this->pdo->query("SELECT * FROM xhywhf_data_barang");  
		echo '<pre>'; $tes = $stmt->result_array();
		var_dump( $tes[0]['id']  );
		var_dump(PDO::getAvailableDrivers());
		
		$host 		= 'localhost';
		$dbname 	= 'swalayan';
		$username 	= 'root';
		$password 	= '';

		$pdo_object = new PDO("mysql:host=$host;dbname=$dbname", $username, $password); 

		$query = $pdo_object->query('SELECT * FROM xhywhf_data_barang');

		var_dump($query->fetchAll(PDO::FETCH_ASSOC));
		//$this->db->select('barcode');
		$tes = $this->hel_db->get_data($tabel='_data_barang',$urutnya=null,$kondisi=null,$cari=null,$hasil=1,$offset=null);
		
		var_dump($tes);
	} */
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */