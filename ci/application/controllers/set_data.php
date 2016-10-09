<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Set_data extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		//$this->load->model('hel_publis','',true);
		$this->load->database();
	}
	
	public function run(){
		// Buat function kode_auto di database Dan Tabel nya
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `z_kode` (
				`nama` VARCHAR(27) NOT NULL,
				`pre_fix` CHAR(2) NOT NULL,
				`tgl` DATE NOT NULL,
				`nomor` INT(10) NOT NULL DEFAULT '0',
				PRIMARY KEY (`nama`)
			)
			COLLATE='utf8_general_ci'
			ENGINE=MyISAM
			;
		");
		$this->db->query("INSERT IGNORE INTO z_kode(nama,pre_fix,tgl,nomor) VALUES(?,?,CURRENT_DATE() , ?) ",array('penjualan','JB',0) );
		$this->db->query("INSERT IGNORE INTO z_kode(nama,pre_fix,tgl,nomor) VALUES(?,?,CURRENT_DATE() , ?) ",array('pembelian','BL',0) );
		$this->db->query("DROP FUNCTION IF EXISTS kode_auto; " );
		/*
			DELIMITER $$
			CREATE FUNCTION kode_auto (vid VARCHAR(10),rst BOOL) returns VARCHAR(7)
			DETERMINISTIC
			BEGIN
			DECLARE _noUrut INT DEFAULT 1;
			DECLARE _prefix CHAR(5);
				IF rst =false THEN
					UPDATE z_kode SET nomor = nomor+1 WHERE nama=vid LIMIT 1;
				ELSE
					UPDATE z_kode SET nomor =if(CURRENT_DATE() != tgl ,1,nomor+1) , tgl=CURRENT_DATE() WHERE nama=vid LIMIT 1;
				END IF;
				SELECT pre_fix,nomor INTO _prefix,_noUrut FROM z_kode WHERE nama=vid;
				return CONCAT(_prefix ,LPAD(_noUrut,5,'0') );
			END $$
			DELIMITER ;
		*/
		$this->db->query(
			"
			CREATE FUNCTION kode_auto (vid VARCHAR(10),rst BOOL) returns VARCHAR(7)
			DETERMINISTIC
			BEGIN
			DECLARE _noUrut INT DEFAULT 1;
			DECLARE _prefix CHAR(5);
				IF rst =false THEN
					UPDATE z_kode SET nomor = nomor+1 WHERE nama=vid LIMIT 1;
				ELSE
					UPDATE z_kode SET nomor =if(CURRENT_DATE() != tgl ,1,nomor+1) , tgl=CURRENT_DATE() WHERE nama=vid LIMIT 1;
				END IF;
				SELECT pre_fix,nomor INTO _prefix,_noUrut FROM z_kode WHERE nama=vid;
				return CONCAT(_prefix ,LPAD(_noUrut,5,'0') );
			END ;
			"
		);
		$this->db->query("DROP TRIGGER IF EXISTS  xhywhf_transaksi_detail_tai;" );
		/*
			DELIMITER $$
			CREATE TRIGGER xhywhf_transaksi_detail_tai
			AFTER INSERT ON xhywhf_transaksi_detail
			FOR EACH ROW
			BEGIN
				IF(NEW.tipe = 0) THEN
					UPDATE xhywhf_data_barang SET jumlah=if((jumlah < NEW.jumlah),0,(jumlah - NEW.jumlah) ) WHERE id_barang=NEW.id_barang LIMIT 1;
				ELSE
					UPDATE xhywhf_data_barang SET jumlah=jumlah+NEW.jumlah WHERE id_barang=NEW.id_barang LIMIT 1;
				END IF;
			END $$
			DELIMITER ;
		*/
		$this->db->query(
			"
			CREATE TRIGGER xhywhf_transaksi_detail_tai
			AFTER INSERT ON xhywhf_transaksi_detail
			FOR EACH ROW
			BEGIN
				IF(NEW.tipe = 0) THEN
					UPDATE xhywhf_data_barang SET jumlah=if((jumlah < NEW.jumlah),0,(jumlah - NEW.jumlah) ) WHERE id_barang=NEW.id_barang LIMIT 1;
				ELSE
					UPDATE xhywhf_data_barang SET jumlah=jumlah+NEW.jumlah WHERE id_barang=NEW.id_barang LIMIT 1;
				END IF;
			END ;
			"
		);
	}
}

/* End of file set_data.php */
/* Location: ./application/controllers/set_data.php */