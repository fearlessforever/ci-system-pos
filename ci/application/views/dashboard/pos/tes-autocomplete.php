<?php
	header('Content-Type:application/json');
	$daridb = $this->db->query("SELECT * FROM ".DB_KODE."data_barang ")->result_array();
	$barang=array();
	foreach($daridb as $val){
		$barang[]=array('value'=>$val['item_name'],'label'=>$val['item_name'],'kode'=>$val['barcode'],'gambar'=>$asset.'/barang/'.$val['gambar'],'jml'=>$val['jumlah'],'harga'=>$val['harga'],'tipe'=>$val['item_type']);
	}
	/*$barang = array(
		array('value'=>'IPhone','label'=>'IPhone Coy','kode'=>'A01'),
		array('value'=>'IPad','label'=>'IPad Coy','kode'=>'A02'),
		array('value'=>'IPod','label'=>'IPod Coy','kode'=>'A03')
	);*/
	//echo json_encode( array("c++", "java", "php", "coldfusion", "javascript", "asp", "ruby") );
	echo json_encode( $barang );