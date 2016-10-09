<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hel_db extends CI_Model { 
	function __construct()
	{
		parent::__construct();
		//$this->statistik();
	}
	private function statistik(){
		$ip      = $this->input->ip_address();
		$tanggal = date("Y-m-d");
		$waktu   = time();
		$this->db->select("mengunjungi");
		$hasil = $this->dapatin_tabel_order_by_2_publis('_statistik', null , array( array('ip_addres',$ip) , array('tanggal',$tanggal) ) , null,1);
		$hasil = isset( $hasil[0]) ? $hasil[0] : $hasil;
		if($hasil){
			$hit = $hasil['mengunjungi']+1;
			$masukdb = array(
						'online'=>$waktu,
						'mengunjungi'=>$hit
					);
			$this->update_data('_statistik', array( array('ip_addres',$ip) , array('tanggal',$tanggal) ) ,$masukdb);
		}else{
			$masukdb = array(
						'ip_addres'=>$ip,
						'tanggal'=>$tanggal,
						'online'=>$waktu,
						'mengunjungi'=>1
					);
			$this->isi_data('_statistik',$masukdb);
		}
	}
	public function get_tag($string){
		$this->db->select("nama_tag");
		$hasil =$this->dapatin_tabel_order_by_2_publis('_tag',array('RAND()',''),$kondisi=null, null,1000, null);
		if(is_array($hasil)){
			$baru =array();
			foreach($hasil as $val){
				if(strstr( $string , $val['nama_tag'] ) !== false )$baru[$val['nama_tag']]=$val['nama_tag'];
			}
			return $baru;
		}
		
	}
	public function get_statistik(){
		$ip      = $this->input->ip_address();
		$tanggal = date("Y-m-d");
		$waktu   = time();
		$bataswaktu       = time() - 3600;
		$pengunjung = $this->itung_statistik('_statistik','count(mengunjungi)' ,array( array('tanggal',$tanggal) )); 
		$totalpengunjung = $this->itung_statistik('_statistik','count(mengunjungi)' ,null);
		$hits = $this->itung_statistik('_statistik','sum(mengunjungi)' , array( array('tanggal',$tanggal) ) );
		$totalhits = $this->itung_statistik('_statistik','sum(mengunjungi)' , null );
		$pengunjungonline = $this->itung_statistik('_statistik','count(mengunjungi)' , array( array('online >',$bataswaktu) ) );
		$data = array(
			'pengunjung'=>$pengunjung['count(mengunjungi)'],
			'totalpengunjung'=>$totalpengunjung['count(mengunjungi)'],
			'hits'=>$hits['sum(mengunjungi)'],
			'totalhits'=>$totalhits['sum(mengunjungi)'],
			'pengunjungonline'=>$pengunjungonline['count(mengunjungi)']
		);
		
		return $data;
	}
	private function itung_statistik($tabel,$select , $kondisi=null){
		//$this->db->select('(select count(mengunjungi) from items where brand_id = b.brand_id) as itemc',FALSE);
			//$this->db->select('(select count(mengunjungi) from '. DB_KODE_HEL .'_statistik)');
		//$this->db->select('(select count(*) from models where brand_id = b.brand_id) as modelc',FALSE);
		//$tanggal = date("Y-m-d"); $this->db->where('tanggal',$tanggal);
		
		$this->db->select($select);		//sum(mengunjungi)
		if( isset($kondisi) && count($kondisi)>0 ){
				foreach($kondisi as $kon){
					$this->db->where($kon[0],$kon[1]);
				}
			}
		$this->db->from(DB_KODE_HEL.$tabel); //_statistik
		$sql_hajar = $this->db->get();
		if($sql_hajar->num_rows > 0){
			$nidia = $sql_hajar->result_array();
			return $nidia[0];
		}
		return $nidia;
	}
	public function dapatin_id_grup(){
		 global $DB_KODE_HEL;
		if($this->session->userdata('level_user') ==0){ $lua=1;
			}else{ $lua=$this->session->userdata('level_user'); }
		$this->db->where('id_user_group',$lua);
		$sql_hajar=$this->db->get($DB_KODE_HEL.'_user_group');	
		if($sql_hajar->num_rows==1){
			$nidia = $sql_hajar->result_array();
			return $nidia[0];
		}
	}
	public function dapatin_modul(){
		 global $DB_KODE_HEL; 
		$this->db->where('status',1);
		$sql_hajar=$this->db->get($DB_KODE_HEL.'_modul');	
		if($sql_hajar->num_rows > 0){
			$nidia = $sql_hajar->result_array();
			return $nidia;
		}
	}
	public function dapatin_pengaturan_tunggal($nomornya='nama_sekolah'){
		 global $DB_KODE_HEL; 
		$this->db->where('nama_pengaturan',$nomornya);
		$sql_hajar=$this->db->get($DB_KODE_HEL.'_pengaturan');	
		if($sql_hajar->num_rows > 0){
			$nidia = $sql_hajar->result_array();
			return $nidia[0];
		}
	}
	public function dapatin_plug_limit($foldernya='elearning',$limit=1){
		 global $DB_KODE_HEL; 
		$this->db->where('folder_plugin',$foldernya);
		$this->db->where('status',1);
		$sql_hajar=$this->db->get($DB_KODE_HEL.'_plugin',$limit); 
		if($sql_hajar->num_rows > 0){
			$nidia = $sql_hajar->result_array();
			return $nidia[0];
		}
	}
	public function dapatin_plugin(){
		 global $DB_KODE_HEL;  
		$this->db->where('status',1);
		$sql_hajar=$this->db->get($DB_KODE_HEL.'_plugin'); 
		if($sql_hajar->num_rows > 0){
			$nidia = $sql_hajar->result_array();
			return $nidia;
		}
	}
	public function itung_row_tabel($tabel,$kondisi=null){
		global $DB_KODE_HEL;
			if(isset($kondisi))$this->db->where($kondisi['syarat'],$kondisi['nilai']);
			//return $this->db->count_all($DB_KODE_HEL.$tabel);
			$sql_hajar = $this->db->get($DB_KODE_HEL.$tabel); 
		return $sql_hajar->num_rows;
	}
	public function itung_row_tabel_multi_w($tabel,$kondisi=null){
		global $DB_KODE_HEL;
			if( isset($kondisi) && count($kondisi)>0 ){
				foreach($kondisi as $kon){
					$this->db->where($kon[0],$kon[1]);
				}
			}
			//return $this->db->count_all($DB_KODE_HEL.$tabel);
			$sql_hajar = $this->db->get($DB_KODE_HEL.$tabel); 
		return $sql_hajar->num_rows;
	}
	public function dapatin_tabel($tabel,$kondisi=null,$hasil=1){
		global $DB_KODE_HEL;
		if(isset($kondisi))$this->db->where($kondisi['syarat'],$kondisi['nilai']); 
		$sql_hajar = $this->db->get($DB_KODE_HEL.$tabel); 
		if($sql_hajar->num_rows > 0){
			$nidia = $sql_hajar->result_array();
			if($hasil == 1)return $nidia[0];
			if($hasil != 1)return $nidia ;
		}
	}
	public function dapatin_tabel_2w($tabel,$kondisi=null,$hasil=1){
		global $DB_KODE_HEL;
		if( isset($kondisi) && count($kondisi)>0 ){
			foreach($kondisi as $kon){
				$this->db->where($kon[0],$kon[1]);
			}
		}
		$sql_hajar = $this->db->get($DB_KODE_HEL.$tabel); 
		if($sql_hajar->num_rows > 0){
			$nidia = $sql_hajar->result_array();
			if($hasil == 1)return $nidia[0];
			if($hasil != 1)return $nidia ;
		}
	}
	public function pencarian($tabel,$kondisi,$cari=null,$urutnya=null,$hasil=1 ,$extra=NULL){
		$this->db->select("*"); 
		$this->db->from($tabel);	// 'users u, company c, roles r'
		if( isset($kondisi) && count($kondisi)>0 ){
			foreach($kondisi as $kon){
				$this->db->where($kon ); //contoh input $this->db->where('c.id = u.id_company'); $this->db->where('r.permissions = u.permissions');
			}
		} 
		if(isset($cari))$this->db->like($cari[0],$cari[1]);
		if( isset($extra) && count($extra)>0 ){
			foreach($extra as $ext ){
				$this->db->where($ext[0],$ext[1]);
			}
		}
		if(isset($urutnya))$this->db->order_by($urutnya[0],$urutnya[1]);		
		
		$sql_hajar = $this->db->get(); 
		if($sql_hajar->num_rows > 0){
			$nidia = $sql_hajar->result_array();
			if($hasil == 1)return $nidia[0];
			if($hasil != 1)return $nidia ;
		}
	}
	public function pencarian_multi($tabel,$kondisi,$cari=null,$urutnya=null,$hasil=1 ,$extra=NULL){
		$this->db->select("*"); 
		$this->db->from($tabel);	// 'users u, company c, roles r'
		if( isset($kondisi) && count($kondisi)>0 ){
			foreach($kondisi as $kon){
				$this->db->where($kon ); //contoh input $this->db->where('c.id = u.id_company'); $this->db->where('r.permissions = u.permissions');
			}
		} 
		if(isset($cari))$this->db->like($cari[0],$cari[1]);
		if( isset($extra) && count($extra)>0 ){
			foreach($extra as $ext ){
				$this->db->where($ext[0],$ext[1]);
			}
		}
		if( isset($urutnya) && count($urutnya)>0 ){
			foreach($urutnya as $urt){
				$this->db->order_by($urt[0],$urt[1]);
			}
		} 
		//if(isset($urutnya))$this->db->order_by($urutnya[0],$urutnya[1]);		
		
		$sql_hajar = $this->db->get(); 
		if($sql_hajar->num_rows > 0){
			$nidia = $sql_hajar->result_array();
			if($hasil == 1)return $nidia[0];
			if($hasil != 1)return $nidia ;
		}
	}
	
	public function dapatingaleri($tab1,$tab2,$field1,$field2,$kondisi,$cari,$urutnya,$hasil=1){
		$this->db->select('*');
		$this->db->from(DB_KODE_HEL.$tab1);
		$this->db->join(DB_KODE_HEL.$tab2, DB_KODE_HEL.$field1.' = '.DB_KODE_HEL.$field2);
		if( isset($kondisi) && count($kondisi)>0 ){
			foreach($kondisi as $kon){
				$this->db->where($kon[0],$kon[1]);
			}
		}
		if(isset($cari))$this->db->like($cari[0],$cari[1]);
		if(isset($urutnya))$this->db->order_by($urutnya[0],$urutnya[1]);
		$sql_hajar = $this->db->get(); 
		if($sql_hajar->num_rows > 0){
			$nidia = $sql_hajar->result_array();
			if($hasil == 1)return $nidia[0];
			if($hasil != 1)return $nidia ;
		}
	}
	public function dapatin_tabel_order_by($tabel,$urutnya,$kondisi=null,$hasil=1){
		global $DB_KODE_HEL;
		if(isset($kondisi))$this->db->where($kondisi['syarat'],$kondisi['nilai']);
		$this->db->order_by($urutnya[0],$urutnya[1]); 
		
		$sql_hajar = $this->db->get($DB_KODE_HEL.$tabel); 
		if($sql_hajar->num_rows > 0){
			$nidia = $sql_hajar->result_array();
			if($hasil == 1)return $nidia[0];
			if($hasil != 1)return $nidia ;
		}
	}
	public function dapatin_tabel_order_by_2($tabel,$urutnya=null,$kondisi=null,$cari=null,$hasil=1){
		global $DB_KODE_HEL;
		if( isset($kondisi) && count($kondisi)>0 ){
			foreach($kondisi as $kon){
				$this->db->where($kon[0],$kon[1]);
			}
		}
		if(isset($cari))$this->db->like($cari[0],$cari[1]);
		if(isset($urutnya))$this->db->order_by($urutnya[0],$urutnya[1]); 
		
		$sql_hajar = $this->db->get($DB_KODE_HEL.$tabel); 
		if($sql_hajar->num_rows > 0){
			$nidia = $sql_hajar->result_array();
			if($hasil == 1)return $nidia[0];
			if($hasil != 1)return $nidia ;
		}
	}
	public function js_gogo($link=null,$tunggu=500){
		if($link != null)$alihkan=base_url().$link.'/';
		else $alihkan=base_url();
		return '
		<script language="javascript">
			setTimeout("top.location.href = \''.$alihkan.'\'",'.$tunggu.');
		</script>
		';
	}
	public function pencarian_multi_publis($tabel,$kondisi,$cari=null,$urutnya=null,$hasil=1 ,$extra=NULL,$offset=null){
		$this->db->select("*"); 
		$this->db->from($tabel);	// 'users u, company c, roles r'
		if( isset($kondisi) && count($kondisi)>0 ){
			foreach($kondisi as $kon){
				$this->db->where($kon ); //contoh input $this->db->where('c.id = u.id_company'); $this->db->where('r.permissions = u.permissions');
			}
		} 
		if(isset($cari))$this->db->like($cari[0],$cari[1]);
		if( isset($extra) && count($extra)>0 ){
			foreach($extra as $ext ){
				$this->db->where($ext[0],$ext[1]);
			}
		}
		if( isset($urutnya) && count($urutnya)>0 ){
			foreach($urutnya as $urt){
				$this->db->order_by($urt[0],$urt[1]);
			}
		} 
		//if(isset($urutnya))$this->db->order_by($urutnya[0],$urutnya[1]);		
		
		
		if($offset == null)	{ $sql_hajar = $this->db->get('', $hasil); }
			else { $sql_hajar = $this->db->get('', $hasil, $offset); }
		
		if($sql_hajar->num_rows > 0){
			$nidia = $sql_hajar->result_array();
			return $nidia ;
		}
	}
	public function dapatin_tabel_order_by_2_publis($tabel,$urutnya=null,$kondisi=null,$cari=null,$hasil=1,$offset=null){
		global $DB_KODE_HEL;
		if( isset($kondisi) && count($kondisi)>0 ){
			foreach($kondisi as $kon){
				$this->db->where($kon[0],$kon[1]);
			}
		}
		if(isset($cari))$this->db->like($cari[0],$cari[1]);
		if(isset($urutnya))$this->db->order_by($urutnya[0],$urutnya[1]); 
		
		if($offset == null )	{ $sql_hajar = $this->db->get(DB_KODE_HEL.$tabel , $hasil); }
			else { $sql_hajar = $this->db->get(DB_KODE_HEL.$tabel , $hasil, $offset); }
		if($sql_hajar->num_rows > 0){
			$nidia = $sql_hajar->result_array();
			return $nidia ;
		}
	}
	/*************************** UPDATE *****************************/
	public function update_data($tabel, $kondisi=null ,$data){ 
		if( isset($kondisi) && count($kondisi)>0 ){
			foreach($kondisi as $kon){
				$this->db->where($kon[0],$kon[1]);
			}
		}   
		
		$sql_hajar = $this->db->update(DB_KODE_HEL.$tabel , $data); 
		return $sql_hajar;
	}
	/*************************** Instert *****************************/
	public function isi_data($tabel,$data){
		$sql_hajar = $this->db->insert(DB_KODE_HEL.$tabel,$data); 
		return $sql_hajar;
	}
	/*************************** Hapus  *****************************/
	public function hapus_data($tabel,$kondisi=null){
		if( isset($kondisi) && count($kondisi)>0 ){
			foreach($kondisi as $kon){
				$this->db->where($kon[0],$kon[1]);
			}
		}
		$sql_hajar = $this->db->delete(DB_KODE_HEL.$tabel); 
		return $sql_hajar;
	}
	/**************************** GetData ****************************/
	public function get_data($tabel,$urutnya=null,$kondisi=null,$cari=null,$hasil=1,$offset=null){ 
		if( isset($kondisi) && count($kondisi)>0 ){
			foreach($kondisi as $kon){
				$this->db->where($kon[0],$kon[1]);
			}
		}
		if(isset($cari))$this->db->like($cari[0],$cari[1]);
		if(isset($urutnya))$this->db->order_by($urutnya[0],$urutnya[1]); 
		
		if($offset == null )	{ $sql_hajar = $this->db->get(DB_KODE_HEL.$tabel , $hasil); }
			else { $sql_hajar = $this->db->get(DB_KODE_HEL.$tabel , $hasil, $offset); }
		if($sql_hajar->num_rows > 0){
			$nidia = $sql_hajar->result_array();
			if($hasil==1)return $nidia[0] ;
			return $nidia ;
		}
		return false;
	}
	public function pdo_get($string , $param=array() ,$tunggal=false){
		$host 		= 'localhost';
		$dbname 	= 'swalayan';
		$username 	= 'root';
		$password 	= '';

		$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password); 

		//$query = $pdo_object->query( $string ); //'SELECT * FROM xhywhf_data_barang'
		$query = $pdo->prepare( $string );
		if(count($param) > 0 ){
			foreach($param as $val){
				if($val['tipe']=='nomor' ){
					$query->bindValue($val['target'], (int) trim( $val['nilai'] ), PDO::PARAM_INT);
					//$query->bindValue(':skip', (int) trim($_GET['skip']), PDO::PARAM_INT);
				}
				else{
					$query->bindValue($val['target'], $val['nilai'] , PDO::PARAM_STR);
				} 
			}
			$query->execute();
			if($query->rowCount() > 0){
				$huft = $query->fetchAll(PDO::FETCH_ASSOC);
				if($tunggal)return $huft[0];
				return $huft;
			}
		}
		
		return false;
	}


} 