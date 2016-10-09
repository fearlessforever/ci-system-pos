var __ajax_p=false;
$(document).off('click','[data-tombol]');
$(document).off('submit','#modalnya-bro form');
if( $('#ui-datepicker-div').length > 0 ){
	$('#ui-datepicker-div').remove();
}
var opsi_extra={};
opsi_extra.hapus = function(){
	if( typeof opsi_extra.table_c !== 'undefined'){
		opsi_extra.table_c.remove();
		setTimeout(function(){ $('#modalnya-bro').modal('hide'); }, 1000);
	}
};

opsi_extra.tambah = function(){
	var aa = $('#table-gwa-crud');
	if( aa.length > 0 && typeof opsi_extra.table_b !== 'undefined'){
		var b = opsi_extra.table_b ; var c = JSON.stringify( opsi_extra.table_b ); c= helmi.amankan(c);
		var a = '<tr data-code="'+b.code+'" data-detail=\''+c+'\'><td>BARU</td><td>'+b.ket+'</td><td>'+b.nama+'</td><td>'+( (b.code != 0 ) ?'<span data-tombol="hapus" class="btn btn-danger">HAPUS</span> &nbsp; <span data-tombol="view" class="btn btn-info"><i class="fa fa-eye"></i></span> ' : '-' )+'</td></tr>';
		aa.find('tbody').prepend( a ); 
		//opsi_extra.table = aa.DataTable();
		setTimeout(function(){ $('#modalnya-bro').modal('hide'); }, 1000);
	}
};
opsi_extra.buat_ju=function(c){
	var d='',no=0,jml1=0,jml2=0 ;
	$.each(c,function(k,v){
		v.angka =parseInt(v.angka);
		d += '<tr><td>'+(no!=v.tgl?v.tgl:'')+'</td><td>'+(v.tipe==0?'&nbsp; &nbsp; &nbsp;':'')+v.ket+'<br><i style="color:red;position:relative;left:49px;bottom:5px; font-size:9px;">('+v.code_ket+')</i></td><td>'+v.code+'</td><td> '+(v.tipe==1? 'Rp. '+v.angka.nomornya(0,3,'.')+',-':'')+' </td><td> '+(v.tipe==0?'Rp. '+v.angka.nomornya(0,3,'.')+',-' :'')+'</td></tr>';
		no=v.tgl;
		if(v.tipe==1)jml1 +=v.angka; else jml2 +=v.angka;
	});
	d += '<tr style="font-weight:bold; font-size:27px; color:red;"><td colspan="2"></td><td>Jumlah</td><td>Rp. '+jml1.nomornya(0,3,'.')+',-</td><td>Rp. '+jml2.nomornya(0,3,'.')+',-</td></tr>';
	d = '<table class="table table-bordered"><thead><tr><th width="100">Tanggal</th><th>Nama Akun</th><th>Ref</th><th>Debit</th><th>Kredit</th></tr></thead><tbody>'+d+'</tbody></table>';
	return d;
};
opsi_extra.buat_bb=function(c){
	var d='',no=0,jml1=0,jml2=0,dd='',db,kd;
	$.each(c,function(k,v){
		d +='<div style="margin:17px 0 0; color:red; font-weight:bold; font-size:17px;"><span class="pull-left">Nama Akun : '+ c[k][0].code_ket +'</span><span class="pull-right">Kode Akun : '+ k +'</span></div>';
		dd=''; db=0; kd=0; no='';
		$.each(v,function(kk,vv){
			vv.angka =parseInt(vv.angka);
			if(vv.tipe==1){
				if(kd > 0){
					kd = kd - vv.angka ;
					if(kd < 0)db = kd*-1;
				}else{
					db = db+vv.angka ;
				}
			}else{
				if(db > 0){
					db = db - vv.angka ;
					if(db < 0)kd = db*-1;
				}else{
					kd = kd+vv.angka ;
				} 
			}
			dd += '<tr><td>'+(no!=vv.tgl?vv.tgl:'')+'</td><td>'+(vv.tipe==0?'&nbsp; &nbsp; &nbsp;':'')+vv.ket+'<br><i style="color:red;position:relative;left:49px;bottom:5px; font-size:9px;">('+vv.code_ket+')</i></td><td>'+vv.code+'</td><td> '+(vv.tipe==1? 'Rp. '+vv.angka.nomornya(0,3,'.')+',-':'-')+' </td><td> '+(vv.tipe==0?'Rp. '+vv.angka.nomornya(0,3,'.')+',-' :'-')+'</td><td>'+(db > 0? 'Rp. '+db.nomornya(0,3,'.')+',-' :'-')+'</td><td>'+(kd > 0? 'Rp. '+kd.nomornya(0,3,'.')+',-' :'-')+'</td></tr>';
			no=vv.tgl;
		});
		d = '<div class="table-responsive">'+d+'<table class="table table-bordered"><thead><tr><th width="100" rowspan="2">Tanggal</th><th rowspan="2">Nama Akun</th><th rowspan="2">Ref</th><th rowspan="2">Debit</th><th rowspan="2">Kredit</th><th colspan="2" style="text-align:center;">Saldo</th></tr><tr><th>Debit</th><th>Kredit</th></tr></thead><tbody>'+dd+'</tbody></table></div>';
		
		
		//if(v.tipe==1)jml1 +=v.angka; else jml2 +=v.angka;
	});
	//d += '<tr style="font-weight:bold; font-size:27px; color:red;"><td colspan="2"></td><td>Jumlah</td><td>Rp. '+jml1.nomornya(0,3,'.')+',-</td><td>Rp. '+jml2.nomornya(0,3,'.')+',-</td></tr>';
	//d = '<table class="table table-bordered"><thead><tr><th width="100">Tanggal</th><th>Nama Akun</th><th>Ref</th><th>Debit</th><th>Kredit</th></tr></thead><tbody>'+d+'</tbody></table>';
	return d;
};

$(document).ready(function(){
	$(document).on('click','[data-tombol]',function(e){
		e.preventDefault();
		switch($(this).attr('data-tombol')){
			case 'tambah' :
				buat_modal('modalnya-bro'); opsi_extra.input_cnt =0;
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Tambah Kredit / Debit </h4>');
				var a='',b='';
				a +=' <div style="border:7px solid rgb(209, 50, 50); margin:7px 0; padding:5px;"><div class="form-group"> <label > Keterangan </label> <input class="form-control" placeholder="Misal Gaji Udin" type="text" name="ket['+opsi_extra.input_cnt+']"> </div><div class="form-group"> <label > Jumlah </label> <input class="form-control" placeholder="Jumlah Kredit atau Debit misal 1.000.000" type="text" name="angka['+opsi_extra.input_cnt+']"> </div><div class="form-inline form-inline-box"><div class="form-group"> <label >Ref / Nomor Akun</label>  <select class="form-control pilihan-idref" name="idref['+opsi_extra.input_cnt+']"><option ></option></select></div> <label class="btn btn-success" data-tombol="load-select" data-s="idref"> Pilihan Lain <i class="fa fa-history"></i></label></div> <input type="hidden" value="debit" name="tipe['+opsi_extra.input_cnt+']"> </div>';
				
				opsi_extra.input_cnt +=1;
				b +='<div style="border:7px solid rgb(65, 216, 19);  margin:7px 0; padding:5px;"><div class="form-group"> <label > Keterangan </label> <input class="form-control" placeholder="Misal Kas" type="text" name="ket['+opsi_extra.input_cnt+']"> </div><div class="form-group"> <label > Jumlah </label> <input class="form-control" placeholder="Jumlah Kredit atau Debit misal 1.000.000" type="text" name="angka['+opsi_extra.input_cnt+']"> </div><div class="form-inline form-inline-box"><div class="form-group"> <label >Ref / Nomor Akun</label>  <select class="form-control pilihan-idref" name="idref['+opsi_extra.input_cnt+']"><option ></option></select></div> <label class="btn btn-success" data-tombol="load-select" data-s="idref"> Pilihan Lain <i class="fa fa-history"></i></label></div> <input type="hidden" value="kredit" name="tipe['+opsi_extra.input_cnt+']"> </div>';
				
				$('#modalnya-bro .modal-body').html('<div style="height:457; "><form role="form" perintah="tambah"><div class="form-inline form-inline-box"><div class="form-group"> <label >Tanggal Kredit / Debit </label> <input class="form-control" placeholder="hari ini" value="hari ini" type="text" name="tanggal" data-tombol="tanggal-list"> </div></div> <p></p> <ul class="nav nav-tabs"> <li class="active"><a href="#tab1" data-toggle="tab">Debit</a></li> <li class=""><a href="#tab2" data-toggle="tab">Kredit </a></li> </ul><div class="tab-content"> <div class="tab-pane active" id="tab1"> '+ a +' <button class="btn btn-danger" data-tombol="debit_p">Tambah Debit form</button></div>    <div class="tab-pane" id="tab2"> '+b+' <button class="btn btn-danger" data-tombol="kredit_p">Tambah Kredit form</button></div></div> <input type="hidden" name="mode" value="tambah"> <input type="hidden" name="controller" value="'+helmi.controller+'"> </form></div>') ;
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				
				$('#modalnya-bro').modal({show:true});
				break;
			case 'debit_p':
				if(typeof opsi_extra.input_cnt === 'undefined' || opsi_extra.input_cnt >= 7){$(this).attr('disabled','disabled'); break; }
				opsi_extra.input_cnt +=1;
				var b ='<div style="border:7px solid rgb(209, 50, 50); margin:7px 0; padding:5px;"> <div class="form-group"> <label > Keterangan </label> <input class="form-control" placeholder="Misal Gaji Udin" type="text" name="ket['+opsi_extra.input_cnt+']"> </div><div class="form-group"> <label > Jumlah </label> <input class="form-control" placeholder="Jumlah Kredit atau Debit misal 1.000.000" type="text" name="angka['+opsi_extra.input_cnt+']"> </div><div class="form-inline form-inline-box"><div class="form-group"> <label >Ref / Nomor Akun</label>  <select class="form-control pilihan-idref" name="idref['+opsi_extra.input_cnt+']"><option ></option></select></div> <label class="btn btn-success" data-tombol="load-select" data-s="idref"> Pilihan Lain <i class="fa fa-history"></i></label></div> <input type="hidden" value="debit" name="tipe['+opsi_extra.input_cnt+']"> </div>';
				
				$('#modalnya-bro .modal-body #tab1').prepend(b); $('#modalnya-bro').modal('handleUpdate');
				break;
			case 'kredit_p':
				if(typeof opsi_extra.input_cnt === 'undefined' || opsi_extra.input_cnt >= 7){$(this).attr('disabled','disabled'); break; }
				opsi_extra.input_cnt +=1;
				var b ='<div style="border:7px solid rgb(65, 216, 19);  margin:7px 0; padding:5px;"><div class="form-group"> <label > Keterangan </label> <input class="form-control" placeholder="Misal Kas" type="text" name="ket['+opsi_extra.input_cnt+']"> </div><div class="form-group"> <label > Jumlah </label> <input class="form-control" placeholder="Jumlah Kredit atau Debit misal 1.000.000" type="text" name="angka['+opsi_extra.input_cnt+']"> </div><div class="form-inline form-inline-box"><div class="form-group"> <label >Ref / Nomor Akun</label>  <select class="form-control pilihan-idref" name="idref['+opsi_extra.input_cnt+']"><option ></option></select></div> <label class="btn btn-success" data-tombol="load-select" data-s="idref"> Pilihan Lain <i class="fa fa-history"></i></label></div></div><input type="hidden" value="kredit" name="tipe['+opsi_extra.input_cnt+']"> </div>';
				
				$('#modalnya-bro .modal-body #tab2').prepend( b); $('#modalnya-bro').modal('handleUpdate');
				break;
			case 'load-select':
				var a= $(this);
				if(typeof opsi_extra[a.attr('data-s')] !== 'undefined' ){
					var c = buat_opsi_modal(opsi_extra[a.attr('data-s')] ); 
					//$('.modal-body select.pilihan-'+a.attr('data-s') ).html(c);
					a.parents('.form-inline-box').find('select').html(c);
					a.attr('disabled','disabled');
					return;
				}
				$.ajax({
					url:helmi.current+'ajax',type:'POST',data:{mode:'load-opsi',pilihan:a.attr('data-s'),controller:helmi.controller },dataType:'json',
					beforeSend:function(){
						 a.attr('disabled','disabled');
					}
					,success:function(data){
						if(data.berhasil){
							var b = JSON.stringify(data.berhasil); b=helmi.amankan(b); b= JSON.parse(b);
							opsi_extra[a.attr('data-s')] = b;
							var c = buat_opsi_modal(b );
							//$('.modal-body select.pilihan-'+a.attr('data-s') ).html(c); 
							a.parents('.form-inline-box').find('select').html(c);
						}
					}
				});
				break;
			case 'simpan-modal':
				$('#modalnya-bro form').trigger('submit');
				break;
			case 'hapus':
				var a = $(this).parents('tr');
				if(typeof a.data('code') !== 'undefined' ){
					buat_modal('modalnya-bro'); opsi_extra.table_c = a;
					$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Hapus Data</h4>');
					$('#modalnya-bro .modal-body').html('<p>Peringatan : Menghapus data untuk Laporan ini sangat tidak dianjurkan <br/>Jika Anda tetap ingin menghapus data ini silahkan klik Hapus untuk konfirmasi hapus<br><br>Anda akan menghapus Info Debit / Kredit berikut : </p><form perintah="hapus"><input type="hidden" name="code" value="'+a.data('code')+'"><input type="hidden" name="mode" value="hapus"><input type="hidden" value="'+helmi.controller+'" name="controller" /></form><div id="loading-ny"><div style="text-align:center;"><img src="'+helmi.asset+'loading.gif" /></div></div>');
					$('#modalnya-bro .modal-footer').html(' <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
					$('#modalnya-bro').modal({show:true});
					$.ajax({
						url:helmi.current+'ajax',type:'POST',data:{mode:'detail',code: a.data('code') ,controller:helmi.controller },dataType:'json'
						,success:function(c){
							if(c.berhasil){
								var d='',no=0;
								$.each(c.berhasil ,function(k,v){
									v.angka =parseInt(v.angka);
									d += '<tr><td>'+(no==0?v.tanggal:'')+'</td><td>'+(v.tipe==0?'&nbsp; &nbsp; &nbsp;':'')+v.ket+'<br><i style="color:red;position:relative;left:49px;bottom:5px; font-size:9px;">('+v.code_ket+')</i></td><td>'+v.code+'</td><td> '+(v.tipe==1? 'Rp. '+v.angka.nomornya(0,3,'.')+',-':'')+' </td><td> '+(v.tipe==0?'Rp. '+v.angka.nomornya(0,3,'.')+',-' :'')+'</td></tr>';
									no++;
								});
								d = '<table class="table "><thead><tr><th width="100">Tanggal</th><th>Nama Akun</th><th>Ref</th><th>Debit</th><th>Kredit</th></tr></thead><tbody>'+d+'</tbody></table>';
								$('#modalnya-bro .modal-body #loading-ny').html(d);
								$('#modalnya-bro .modal-footer').html('<button class="btn btn-danger" data-tombol="simpan-modal">Hapus</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
							}
						}
					});
				}
				break;
			case 'view-tanggal':
				var a = $(this).parents('form');
				if(a.find('input[name="tglmulai"]').val() == ''){
					helmi.form_e( a.find('input[name="tglmulai"]') ,'Tanggal Pertama Tidak Boleh Kosong'); return false;
				}
				if(a.find('input[name="tglakhir"]').val() == ''){
					helmi.form_e( a.find('input[name="tglakhir"]') ,'Tanggal Kedua Tidak Boleh Kosong'); return false;
				}
				$.ajax({
					url:helmi.current+'ajax',type:'POST',data:a.serialize() ,dataType:'json'
					,success:function(c){
						if(c.berhasil ){
							$('#tempat-table-crud').html( buat_tabel(c.berhasil) ); 
						}else if(c.error){
							$('#tempat-table-crud').html( buat_tabel('') ); 
						}
					}
				});
				break;
			case 'view-jurnal':
				var a = $(this).parents('form');
				if(a.find('input[name="tglmulai"]').val() == ''){
					helmi.form_e( a.find('input[name="tglmulai"]') ,'Tanggal Pertama Tidak Boleh Kosong'); return false;
				}
				if(a.find('input[name="tglakhir"]').val() == ''){
					helmi.form_e( a.find('input[name="tglakhir"]') ,'Tanggal Kedua Tidak Boleh Kosong'); return false;
				}
				$.ajax({
					url:helmi.current+'ajax',type:'POST',data:a.serialize() ,dataType:'json'
					,beforeSend:function(){
						$('#tempat-table-crud2').html('<div style="text-align:center; margin:100px;"><img src="'+helmi.asset+'loading.gif" /></div>'); 
					}
					,success:function(c){
						if(c.berhasil ){
							var d = '<div class="table-responsive">'+ opsi_extra.buat_ju(c.berhasil) +'</div>'; 
							$('#tempat-table-crud2').html('<div style="text-align:center;"><h1>Jurnal Umum </h1><span class="label label-info">Dari Tanggal '+c.tgl1+' ~ '+c.tgl2+'</span><br><br></div>'+d);
							if(c.buku_besar){
								$('#tempat-table-crud2').append( ' <div style="text-align:center; margin:27px 0 0;" ><h1>Buku Besar </h1><span class="label label-info">Dari Tanggal '+c.tgl1+' ~ '+c.tgl2+'</span><br><br></div>'+ opsi_extra.buat_bb(c.buku_besar) );
							}
						}else if(c.error){
							$('#tempat-table-crud2').html('<div style="text-align:center;"><h3>Tidak Ada Data Ditemukan</h3></div>'); 
						}
					}
				});
				break;
			case 'tanggal-list': 
				$(this).datepicker({dateFormat: 'yy-mm-dd'}); $(this).datepicker("show");
				break;
			case 'view':
				var a = $(this).parents('tr');
				if(typeof a.data('detail') !== 'undefined' ){
					buat_modal('modalnya-bro'); var b = helmi.quot(a.data('detail') ); opsi_extra.table_c = a;
					$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title"> Detail Debit / Kredit : <span class="label label-info">'+b.ket+'</span></h4><br>Ditambahkan : '+b.jam );
					$('#modalnya-bro .modal-body').html('<div style="text-align:center;"><img src="'+helmi.asset+'loading.gif" /></div>');
					$('#modalnya-bro .modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
					$('#modalnya-bro').modal({show:true});
					$.ajax({
						url:helmi.current+'ajax',type:'POST',data:{mode:'detail',code:b.code,controller:helmi.controller },dataType:'json'
						,success:function(c){
							if(c.berhasil){
								var d='',no=0;
								$.each(c.berhasil ,function(k,v){
									v.angka =parseInt(v.angka);
									d += '<tr><td>'+(no==0?v.tanggal:'')+'</td><td>'+(v.tipe==0?'&nbsp; &nbsp; &nbsp;':'')+v.ket+'<br><i style="color:red;position:relative;left:49px;bottom:5px; font-size:9px;">('+v.code_ket+')</i></td><td>'+v.code+'</td><td> '+(v.tipe==1? 'Rp. '+v.angka.nomornya(0,3,'.')+',-':'')+' </td><td> '+(v.tipe==0?'Rp. '+v.angka.nomornya(0,3,'.')+',-' :'')+'</td></tr>';
									no++;
								});
								d = '<table class="table table-bordered"><thead><tr><th width="100">Tanggal</th><th>Nama Akun</th><th>Ref</th><th>Debit</th><th>Kredit</th></tr></thead><tbody>'+d+'</tbody></table>';
								$('#modalnya-bro .modal-body').html(d);
							}
						}
					});
				}
				break;
			default: break;
		}
	});
	
	$(document).on('submit','#modalnya-bro form',function(e){
		e.preventDefault(); var a=$(this);
		if( $(this).find('[name="check-duplicate"]').val() == ''){
			helmi.form_e( $(this).find('[name="code"]') ,'Silahkan Isi form ini dulu');
			return;
		}
		if(__ajax_p){return;}else{ __ajax_p=true;}
		$.ajax({
			url:helmi.current+'ajax',data:$(this).serialize(),type:'POST',dataType:'json'
			,beforeSend:function(){
				if($('#modalnya-bro .modal-body .loading-nya-bro').length > 0){
					$('#modalnya-bro .modal-body .loading-nya-bro').html('<img src="'+helmi.asset+'loading.gif" />');
				}else{
					$('#modalnya-bro .modal-body').append('<div class="loading-nya-bro" style="text-align:center;"><img src="'+helmi.asset+'loading.gif" /></div>');
				}
			}
			,success:function(data){
				if(data.error){
					$('#modalnya-bro .modal-body .loading-nya-bro').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button><strong>Error :</strong> '+ data.error +'</div>');
				}else if(data.berhasil){
					$('#modalnya-bro .modal-body .loading-nya-bro').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button><strong>Success :</strong> '+ data.berhasil +'</div>');
					if(data.baru)opsi_extra.table_b = data.baru;
					if(typeof a.attr('perintah') !== 'undefined' ){
						opsi_extra[ a.attr('perintah') ]();
					}
				}
			},complete:function(){
				__ajax_p=false;
			}
		});
	});
	
	if(__list_crud == ''){
		$.ajax({url:helmi.current+'ajax',type:'POST',data:{mode:'view',controller:helmi.controller }
			,success:function(data){ 
				if(data.berhasil){
					var c = buat_tabel(data.berhasil) ; $('#tempat-table-crud').html(c); 
					__list_crud =null; c=null;
					if(data.total)$('#tempat-total-table').html('Jumlah Total Data di Table Ini : <span class="label label-success">'+data.total+'</span>');
				}else if(data.error){
					$('#tempat-table-crud').html( buat_tabel('') ); 
				}
		} });
	}
	function buat_tabel(e){
		var c='',no=0,b='';
		e = JSON.stringify(e); e = helmi.amankan(e); e = JSON.parse(e);
		if(e instanceof Array){
			$.each(e,function(k,val){
				b = JSON.stringify(val);
				c += '<tr data-code="'+val.code+'" data-detail=\''+b+'\'><td>'+(++no)+'</td><td>'+val.ket+'</td><td>'+val.nama+'</td><td>'+( (val.code != 0 ) ?'<span data-tombol="hapus" class="btn btn-danger">HAPUS</span> &nbsp; <span data-tombol="view" class="btn btn-info"><i class="fa fa-eye"></i></span> ' : '-' )+'</td></tr>';
			});
		}else{
			c ='';
		}
		return '<table id="table-gwa-crud" class="table table-hover"><thead><tr><th>No</th><th>Debit / Kredit (Tgl)</th><th>Ditambahkan Oleh</th><th>Action</th></tr></thead><tbody>'+c+'</tbody></table>';
	}
	function buat_opsi_modal(e){
		var c='';
		if(e instanceof Array){
			$.each(e,function(k,val){
				c += '<option value="'+val.code+'">'+val.nama+'</option>';
			});
		}
		return c;
	}
});