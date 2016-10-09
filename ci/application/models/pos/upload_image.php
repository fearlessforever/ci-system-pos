<?php if(!defined('BASEPATH'))exit('No Direct script acces Allowed'); 

class Upload_image extends CI_Model {
	static $_hasil= array('error'=>'Mode Not Found');
	static $_hasil2= 'Not Found';
	static $_max_width = 850 ; static $_max_height = 650;
	static $_folder = '';
	static $_asset = 'assets/';
	
	function __construct() {
		parent::__construct();
		$this->load->helper('validasi');
		self::$_folder = 'upload/'. date('Y-m-d').'/';
	}
	
	public function run(){
		$mode = $this->input->post('mode'); $_not_found=true; $_referer=base_url();
		switch($mode){
			case 'setting-background':
				$_not_found=false; self::$_hasil2='Ada kesalahan, Gagal Disimpan !!!'; self::$_hasil=array('error'=>'Ada Kesalahan');
				if(!isset( $_FILES['upload_image']['tmp_name'] ))break;
				$_referer = $this->input->get_request_header('Referer') ; 
				if(!$_referer)break;
				$_controller = $this->input->post('controller2');
				$_referer .= '#'.$_controller.'.html';
				$_nama = md5('backgroundHlasflJKln890').'.jpg';
				self::$_folder = 'upload/profile/'; self::$_max_width=1200;
				$_check_img = self::generate_image_thumbnail($_FILES['upload_image']['tmp_name'] , $_nama );
				if(!$_check_img)break;
				/* if($_check_img){
					self::$_max_width=300;
					self::generate_image_thumbnail($_FILES['upload_image']['tmp_name'] , 't_'.$_nama );
				} */
				/******************** SAVE ******************************/
				$data =array();
				$data['nama']= 'sys_bg'; $data['isi1']= $_nama; $data['isi2']= self::$_folder ;
				
				if( validasi_array($data ,'nama|isi1|isi2') ){
					$this->db->query("INSERT INTO ". DB_KODE ."pengaturan(nama,isi1,isi2) VALUES(?,?,?) ON DUPLICATE KEY UPDATE isi1=VALUES(isi1),isi2=VALUES(isi2) ", $data );
					
					$_not_found=false; self::$_hasil2='Telah Disimpan'; self::$_hasil=array('berhasil'=>'Gambar Berhasil Disimpan');
				}
				/******************** SAVE ******************************/
				
				break;
			case 'profile-pic':
				$_not_found=false; self::$_hasil2='Ada kesalahan, Gagal Disimpan !!!'; self::$_hasil=array('error'=>'Ada Kesalahan');
				if(!isset( $_FILES['upload_image']['tmp_name'] ))break;
				$_referer = $this->input->get_request_header('Referer') ; 
				if(!$_referer)break;
				$_controller = $this->input->post('controller2');
				$_referer .= '#'.$_controller.'.html';
				$_nama = md5( $this->session->_user['userid'] ).'.jpg';
				self::$_folder = 'upload/profile/'; self::$_max_width=300;
				$_check_img = self::generate_image_thumbnail($_FILES['upload_image']['tmp_name'] , $_nama );
				if(!$_check_img)break;
				/* if($_check_img){
					self::$_max_width=300;
					self::generate_image_thumbnail($_FILES['upload_image']['tmp_name'] , 't_'.$_nama );
				} */
				/******************** SAVE ******************************/
				$data =array();
				$data['userid']= $this->session->_user['userid'];
				$data['nama']= self::$_folder ;
				$data['nama_file']= $_nama;
				if( validasi_array($data ,'userid|nama|nama_file') ){
					$this->db->query("INSERT INTO ". DB_KODE ."pengguna_ext(userid,nama,isi) VALUES(?,?,?) ON DUPLICATE KEY UPDATE isi=VALUES(isi) ", array($data['userid'] ,'folder',$data['nama'] ) );
					$this->db->query("INSERT INTO ". DB_KODE ."pengguna_ext(userid,nama,isi) VALUES(?,?,?) ON DUPLICATE KEY UPDATE isi=VALUES(isi) ", array($data['userid'] ,'profile_pic',$data['nama_file'] ) );
					
					$_not_found=false; self::$_hasil2='Telah Disimpan'; self::$_hasil=array('berhasil'=>'Gambar Berhasil Disimpan');
				}
				/******************** SAVE ******************************/
				
				break;
			case 'upload_barang_t':
				$_not_found=false; self::$_hasil2='Ada kesalahan, Gagal Disimpan !!!'; self::$_hasil=array('error'=>'Ada Kesalahan');
				$code = $this->input->post('code');
				if( !validasi_angka($code,'',true) )return;
				if(!isset( $_FILES['upload_image']['tmp_name'] ))break;
				$_referer = $this->input->get_request_header('Referer') ; 
				if(!$_referer)break;
				$_controller = $this->input->post('controller');
				$_referer .= '#'.$_controller.'.html';
				$_nama = md5( $_FILES['upload_image']['name']).'.jpg';
				$_check_img = self::generate_image_thumbnail($_FILES['upload_image']['tmp_name'] , $_nama );
				if(!$_check_img)break;
				if($_check_img){
					self::$_max_width=300;
					self::generate_image_thumbnail($_FILES['upload_image']['tmp_name'] , 't_'.$_nama );
				}
				/******************** SAVE ******************************/
				$data =array();
				$data['id_target']= $code;
				$data['folder']= self::$_folder ;
				$data['nama_file']= $_nama;
				$data['tanggal_b']= date('Y-m-d H:i:s');
				if( validasi_array($data ,'id_target|folder|nama_file|tanggal_b') ){
					$this->db->query("INSERT IGNORE INTO ". DB_KODE ."gambar(". implode(',',array_keys($data) ) .") VALUES(?,?,?,?) ", $data );
					
					$_not_found=false; self::$_hasil2='Telah Disimpan'; self::$_hasil=array('berhasil'=>'Gambar Berhasil Disimpan');
				}
				/******************** SAVE ******************************/
				break;
			case 'view': self::__view(); $_not_found=false; break;
			case 'hapus': self::__hapus(); $_not_found=false; break;
			case 'edit':
				$_not_found=false; self::$_hasil2='Ada kesalahan, Gagal Disimpan !!!'; self::$_hasil=array('error'=>'Ada Kesalahan');
				$code = $this->input->post('code');
					if( !validasi_angka($code,'',true) )return;
				if(!isset( $_FILES['upload_image']['tmp_name'] ))break;
				$_referer = $this->input->get_request_header('Referer') ; 
				if(!$_referer)break;
				
				$_file = $this->db->query("SELECT folder,nama_file FROM ".DB_KODE."gambar WHERE tipe=0 AND id_target=? LIMIT 1",array($code) )->row_array();
				if(!isset($_file['folder']))break;
				
				$_controller = $this->input->post('controller');
				$_referer .= '#'.$_controller.'.html';
				$_nama = md5( $_FILES['upload_image']['name']).'.jpg';
				$_check_img = self::generate_image_thumbnail($_FILES['upload_image']['tmp_name'] , $_nama );
				if(!$_check_img)break;
				if($_check_img){
					self::$_max_width=300;
					self::generate_image_thumbnail($_FILES['upload_image']['tmp_name'] , 't_'.$_nama );
				}
				/******************** SAVE ******************************/
				$data =array();
				$data['folder']= self::$_folder ;
				$data['nama_file']= $_nama;
				$data['tanggal_b']= date('Y-m-d H:i:s');
				if( validasi_array($data ,'folder|nama_file|tanggal_b') ){
					$this->db->where('id_target', $code )->limit(1)->update(DB_KODE ."gambar" , $data);
					$_not_found=false; self::$_hasil2='Telah Disimpan'; self::$_hasil=array('berhasil'=>'Gambar Berhasil Disimpan');
					
					if(isset($_file['folder'])){
						if(file_exists( self::$_asset . $_file['folder'] . $_file['nama_file'] ))
							unlink( self::$_asset . $_file['folder'] . $_file['nama_file'] );
						if(file_exists( self::$_asset . $_file['folder'] . 't_'.$_file['nama_file'] ))
							unlink( self::$_asset . $_file['folder'] . 't_'.$_file['nama_file'] );
					}
				}
				/******************** SAVE ******************************/
				break;
			default: break;
		}
		
		if($_not_found == false){
			$check = $this->input->is_ajax_request();
			if($check){
				header('Content-Type:application/json');
				echo json_js_array(json_encode(self::$_hasil));
			}else{
				//$this->load->view('biasa',array('hasil'=> self::$_hasil2 .' {memory_usage}') ); // 
				echo '<h1 style="text-align:center; color:red; font-weight:bold;">'. self::$_hasil2  .'</h1>';
				redirect($_referer , 'refresh');
			}
			return ;
		}show_404();
	}
	private function __view(){
		$core = $this->db->query("SELECT a.id_target as code,a.folder,a.nama_file,a.tanggal_b ,b.nama_barang as nama
			FROM ".DB_KODE."gambar a
			LEFT JOIN ".DB_KODE."data_barang b ON a.id_target=b.id_barang
			WHERE a.tipe=0 LIMIT 1000")->result_array();
		if(isset($core[0]) && is_array($core)){
			$num = $this->db->count_all_results(DB_KODE.'gambar');
			self::$_hasil = array('berhasil'=>$core);
			self::$_hasil['total']= $num;
		}
	}
	private function __hapus(){
		self::$_hasil =array('error'=>'Gagal Hapus Data !!!');
		$code = $this->input->post('code');
		if( !validasi_angka($code,'',true) ){
			self::$_hasil['error']='Ada Kesalahan , silahkan refresh halaman'; return;
		}
		if($code == 1){ self::$_hasil['error']='Anda tidak boleh menghapus Code Standar'; return;}
			$core = $this->db->query("SELECT isi1 FROM ".DB_KODE."pengaturan WHERE nama=? LIMIT 1",array('boleh_hapus') )->row();
		if(isset($core->isi1) && $core->isi1 != 1){
			self::$_hasil['error']='System Tidak Membolehkan Hapus Data'; return;
		}
		$_file = $this->db->query("SELECT folder,nama_file FROM ".DB_KODE."gambar WHERE tipe=0 AND id_target=? LIMIT 1",array($code) )->row_array();
		if(!isset($_file['folder'])){
			self::$_hasil['error']='Data Tidak Ditemukan'; return;
		}
		$this->db->query("DELETE FROM ".DB_KODE."gambar WHERE id_target=? AND tipe=0 LIMIT 1" ,array($code) );
		$core = $this->db->affected_rows();
		if($core){
			self::$_hasil=array('berhasil'=>'Data Berhasil Dihapus');
			// if(file_exists( self::$_asset . self::$_folder . $thumbnail_image_path ))
		}
		if(isset($_file['folder'])){
			if(file_exists( self::$_asset . $_file['folder'] . $_file['nama_file'] ))
				unlink( self::$_asset . $_file['folder'] . $_file['nama_file'] );
			if(file_exists( self::$_asset . $_file['folder'] . 't_'.$_file['nama_file'] ))
				unlink( self::$_asset . $_file['folder'] . 't_'.$_file['nama_file'] );
		}
	}
	private function generate_image_thumbnail($source_image_path, $thumbnail_image_path)
	{
		$source_gd_image=false;
		list($source_image_width, $source_image_height, $source_image_type) = @getimagesize($source_image_path);
		switch ($source_image_type) {
			case IMAGETYPE_GIF:
				$source_gd_image = imagecreatefromgif($source_image_path);
				break;
			case IMAGETYPE_JPEG:
				$source_gd_image = imagecreatefromjpeg($source_image_path);
				break;
			case IMAGETYPE_PNG:
				$source_gd_image = imagecreatefrompng($source_image_path);
				break;
		}
		
		/* Buat Folder */
		if(!file_exists( self::$_asset . self::$_folder ) ){
			mkdir( self::$_asset . self::$_folder , 0755, true);
			
		}
		$thumbnail_image_path = self::$_asset . self::$_folder . $thumbnail_image_path;
		/* End Of Buat Folder */
		
		if ($source_gd_image === false) {
			return false;
		}
		$source_aspect_ratio = $source_image_width / $source_image_height;
		$thumbnail_aspect_ratio = self::$_max_width / self::$_max_height;
		if ($source_image_width <= self::$_max_width && $source_image_height <= self::$_max_height) {
			$thumbnail_image_width = $source_image_width;
			$thumbnail_image_height = $source_image_height;
		} elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
			$thumbnail_image_width = (int) (self::$_max_height * $source_aspect_ratio);
			$thumbnail_image_height = self::$_max_height;
		} else {
			$thumbnail_image_width = self::$_max_width;
			$thumbnail_image_height = (int) (self::$_max_width / $source_aspect_ratio);
		}
		$thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
		imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);

		//$img_disp = imagecreatetruecolor(self::$_max_width,self::$_max_width);
		$img_disp = imagecreatetruecolor($thumbnail_image_width,$thumbnail_image_height);
		$backcolor = imagecolorallocate($img_disp,0,0,0);
		imagefill($img_disp,0,0,$backcolor);

			imagecopy($img_disp, $thumbnail_gd_image, (imagesx($img_disp)/2)-(imagesx($thumbnail_gd_image)/2), (imagesy($img_disp)/2)-(imagesy($thumbnail_gd_image)/2), 0, 0, imagesx($thumbnail_gd_image), imagesy($thumbnail_gd_image));

		imagejpeg($img_disp, $thumbnail_image_path, 65); // 90 = kualitas
		imagedestroy($source_gd_image);
		imagedestroy($thumbnail_gd_image);
		imagedestroy($img_disp);
		return true;
	}
}