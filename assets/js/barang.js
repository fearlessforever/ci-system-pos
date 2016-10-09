var __ajax_p=false,opsi_extra=[];
$(document).off('click','[data-tombol]');
$(document).off('submit','#modalnya-bro form');
var opsi_extra={};
opsi_extra.hapus = function(){
	if(typeof opsi_extra.table !== 'undefined' && typeof opsi_extra.table_c !== 'undefined'){
		opsi_extra.table.row( opsi_extra.table_c ).remove().draw();
		setTimeout(function(){ $('#modalnya-bro').modal('hide'); }, 1000);
	}
};
opsi_extra.edit = function(){
	var aa = $('#table-gwa-crud');
	if( aa.length > 0 && typeof opsi_extra.table_c !== 'undefined' && typeof opsi_extra.table_b !== 'undefined'){
		var b = opsi_extra.table_b ; var c = JSON.stringify( opsi_extra.table_b ); c= helmi.amankan(c);
		var a = '<tr data-code="'+b.code+'" data-detail=\''+ c +'\'><td>EDITED</td><td>'+b.code+'</td><td>'+b.nama+'</td><td>'+b.tipe+'</td> <td>'+( (b.code != 1 ) ?'<span data-tombol="hapus" class="btn btn-danger">HAPUS</span> &nbsp; <span data-tombol="edit" class="btn btn-info">EDIT</span> &nbsp; <span data-tombol="view" class="btn btn-info" title="Tampilkan"><i class="fa fa-eye"></i></span> &nbsp; <a href="'+helmi.home+'print-barcode/'+b.code+'" class="btn btn-warning" target="_blank"><i class="fa fa-print" title="Cetak Barcode"></i></a>' : '-' )+'</td></tr>'; 
		opsi_extra.table_c.remove();
		aa.find('tbody').prepend( a ); 
		opsi_extra.table = aa.DataTable();
		setTimeout(function(){ $('#modalnya-bro').modal('hide'); }, 1000);
	}
};
opsi_extra.tambah = function(){
	var aa = $('#table-gwa-crud');
	if( aa.length > 0 && typeof opsi_extra.table_b !== 'undefined'){
		var b = opsi_extra.table_b ; var c = JSON.stringify( opsi_extra.table_b ); c= helmi.amankan(c);
		var a = '<tr data-code="'+b.code+'" data-detail=\''+ c +'\'><td>TAMBAH</td><td>'+b.code+'</td><td>'+b.nama+'</td><td>'+b.tipe+'</td> <td>'+( (b.code != 1 ) ?'<span data-tombol="hapus" class="btn btn-danger">HAPUS</span> &nbsp; <span data-tombol="edit" class="btn btn-info">EDIT</span> &nbsp; <span data-tombol="view" class="btn btn-info" title="Tampilkan"><i class="fa fa-eye"></i></span> &nbsp; <a href="'+helmi.home+'print-barcode/'+b.code+'" class="btn btn-warning" target="_blank"><i class="fa fa-print" title="Cetak Barcode"></i></a>' : '-' )+'</td></tr>';
		aa.find('tbody').prepend( a ); 
		opsi_extra.table = aa.DataTable();
		setTimeout(function(){ $('#modalnya-bro').modal('hide'); }, 1000);
	}
};

$(document).ready(function(){
	
	$(document).on('click','[data-tombol]',function(e){
		e.preventDefault();
		switch($(this).attr('data-tombol')){
			case 'tambah' :
				buat_modal('modalnya-bro');
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Tambah Barang</h4>');
				$('#modalnya-bro .modal-body').html('<form role="form" perintah="tambah"><div class="form-inline form-inline-box"><div class="form-group"> <label >Code Barang</label> <input class="form-control" placeholder="Code nya Misal 1" type="text" name="code"> <label class="btn btn-danger" data-tombol="check-duplicate" data-s="code"> Check Duplicate <i class="fa fa-history"></i></label> </div></div><div class="form-group"> <label >Nama Barang</label> <input class="form-control" placeholder="Barang Misal Samsung Tab" type="text" name="nama_barang"> </div><div class="form-inline form-inline-box"><div class="form-group"> <label >Jumlah Barang</label> <input class="form-control" placeholder="Jumlah nya Misal 1" type="text" name="jmlbarang"> </div></div><div class="form-group"> <label >Harga Jual (satuan)</label> <input class="form-control" placeholder="Harga Jual nya Misal 1000" type="text" name="hrgbarang"> </div> <div class="form-group"> <label >Harga Beli Barang / Modal (satuan)</label> <input class="form-control" placeholder="Harga Beli Barang / Modal Misal 900" type="text" name="mdlbarang"> </div> <div class="form-inline form-inline-box"><div class="form-group"><label >Pilih Satuan</label> <select class="form-control pilihan-satuan" name="satuan"><option value="1">-</option></select></div> <label class="btn btn-success" data-tombol="load-select" data-s="satuan"> Pilihan Lain <i class="fa fa-history"></i></label></div><div class="form-inline form-inline-box"><div class="form-group"><label >Pilih Tipe</label> <select class="form-control pilihan-tipe" name="tipe"><option value="1">-</option></select></div> <label class="btn btn-success" data-tombol="load-select" data-s="tipe"> Pilihan Lain <i class="fa fa-history"></i></label></div><div class="form-inline form-inline-box"><div class="form-group"><label >Pilih Ukuran / Size</label> <select class="form-control pilihan-ukuran" name="ukuran"><option value="1">-</option></select></div> <label class="btn btn-success" data-tombol="load-select" data-s="ukuran"> Pilihan Lain <i class="fa fa-history"></i></label></div><div class="form-inline form-inline-box"><div class="form-group"><label >Pilih Supplier </label> <select class="form-control pilihan-supplier" name="supplier"><option value="1">-</option></select></div> <label class="btn btn-success" data-tombol="load-select" data-s="supplier"> Pilihan Lain <i class="fa fa-history"></i></label></div><input type="hidden" name="mode" value="tambah"> <input type="hidden" name="controller" value="'+helmi.controller+'"><input type="hidden" name="check-duplicate" value=""> </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				break;
			case 'simpan-modal': $('#modalnya-bro form').trigger('submit'); break;
			case 'hapus':
				var a = $(this).parents('tr');
				if(typeof a.data('code') !== 'undefined' ){
					buat_modal('modalnya-bro');  opsi_extra.table_c = a;
					$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Hapus Data</h4>');
					$('#modalnya-bro .modal-body').html('<p>Peringatan : Menghapus Code Barang yang telah di gunakan di List Barang sangat tidak dianjurkan<br/>Jika Anda tetap ingin menghapus data ini silahkan klik Hapus untuk konfirmasi hapus<br><br>Anda akan menghapus Barang dengan code berikut :<h4 class="label label-info">'+a.data('code')+'</h4> </p><form perintah="hapus"><input type="hidden" name="code" value="'+a.data('code')+'"><input type="hidden" name="mode" value="hapus"><input type="hidden" value="'+helmi.controller+'" name="controller" /></form>');
					$('#modalnya-bro .modal-footer').html('<button class="btn btn-danger" data-tombol="simpan-modal">Hapus</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
					$('#modalnya-bro').modal({show:true});
				}
				break;
			case 'check-duplicate':
				var aa = $(this).attr('data-s'),check=false,a=$(this),target=$('.modal-body input[name="'+aa+'"]');
				if( typeof aa !== 'undefined' && target.length > 0 ){
					if(target.val() == ''){ 
						//target.attr('placeholder','Silahkan Isi form ini dulu').focus().parents('div.form-group').addClass('has-error');
						helmi.form_e(target,'Silahkan Isi form ini dulu');
						return; 
					}
					$.ajax({
						url:helmi.current+'ajax',type:'POST',data:{mode:'duplicate',code: target.val() ,controller:helmi.controller },dataType:'json',
						beforeSend:function(){
							 a.attr('disabled','disabled');
						}
						,success:function(data){
							if(data.berhasil){
								 a.removeClass('btn-danger').addClass('btn-success');  check =true; target.attr('readonly','readonly');
								 $('.modal-body input[name="check-duplicate"]').val('oke');
								 helmi.form_o(target);
							}else if(data.error){ helmi.form_e(target,data.error); }
						},complete:function(){ if(check == false){ a.removeAttr('disabled'); } }
					});
				}
				break;
			case 'load-select':
				var a= $(this);
				if(typeof opsi_extra[a.attr('data-s')] !== 'undefined' ){
					var c = buat_opsi_modal(opsi_extra[a.attr('data-s')] ); $('.modal-body select.pilihan-'+a.attr('data-s') ).html(c);
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
							$('.modal-body select.pilihan-'+a.attr('data-s') ).html(c); 
						}
					}
				});
				break;
			case 'edit':
				var a = $(this).parents('tr');
				if(typeof a.data('detail') !== 'undefined' ){
					buat_modal('modalnya-bro'); var b = helmi.quot(a.data('detail')); opsi_extra.table_c = a;
					$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Edit Data</h4>');
					$('#modalnya-bro .modal-body').html('<form role="form" perintah="edit"> <div class="form-group"> <label >Code Barang</label> <input disabled class="form-control" value="'+ b.code +'" type="text" name="code"> </div><div class="form-group"> <label >Nama Barang</label> <input class="form-control" value="'+ b.nama +'" type="text" name="nama_barang"> </div><div class="form-group"> <label >Jumlah Barang</label> <input class="form-control" value="'+ b.jumlah +'" type="text" name="jmlbarang"> </div><div class="form-group"> <label >Harga Jual Barang</label> <input class="form-control" value="'+ b.harga +'" type="text" name="hrgbarang"> </div><div class="form-group"> <label >Harga Beli Barang</label> <input class="form-control" value="'+ b.modal +'" type="text" name="mdlbarang"> </div><div class="form-inline form-inline-box"><div class="form-group"><label >Pilih Satuan</label> <select class="form-control pilihan-satuan" name="satuan"><option value="'+b.satuan+'">'+b.satuan+'</option></select></div> <label class="btn btn-success" data-tombol="load-select" data-s="satuan"> Pilihan Lain <i class="fa fa-history"></i></label></div>   <div class="form-inline form-inline-box"><div class="form-group"><label >Pilih Tipe</label> <select class="form-control pilihan-tipe" name="tipe"><option value="'+b.tipe+'">'+b.tipe+'</option></select></div> <label class="btn btn-success" data-tombol="load-select" data-s="tipe"> Pilihan Lain <i class="fa fa-history"></i></label></div><div class="form-inline form-inline-box"><div class="form-group"><label >Pilih Ukuran / Size</label> <select class="form-control pilihan-ukuran" name="ukuran"><option value="'+b.ukuran+'">'+b.ukuran+'</option></select></div> <label class="btn btn-success" data-tombol="load-select" data-s="ukuran"> Pilihan Lain <i class="fa fa-history"></i></label></div><div class="form-inline form-inline-box"><div class="form-group"><label >Pilih Supplier </label> <select class="form-control pilihan-supplier" name="supplier"><option value="'+b.supplier+'">'+b.supplier+'</option></select></div> <label class="btn btn-success" data-tombol="load-select" data-s="supplier"> Pilihan Lain <i class="fa fa-history"></i></label></div><input value="'+ b.code +'" type="hidden" name="code"><input type="hidden" name="mode" value="edit"><input type="hidden" name="controller" value="'+helmi.controller+'"> </form>');
					$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
					$('#modalnya-bro').modal({show:true});
				}
				break;
			case 'view':
				var a = $(this).parents('tr');
				if(typeof a.data('detail') !== 'undefined' ){
					buat_modal('modalnya-bro'); var b = helmi.quot(a.data('detail'));
					$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Detail informasi dari <span class="label label-info">'+ b.code +' </span></h4>');
					$('#modalnya-bro .modal-body').html('<div style="text-align:center; min-height:150px;"><img src="'+helmi.asset+'loading.gif" /></div>');
					$('#modalnya-bro .modal-footer').html(' <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
					$('#modalnya-bro').modal({show:true});
					$.ajax({
						url:helmi.current+'ajax',type:'POST',data:{mode:'detail',code:b.code,controller:helmi.controller },dataType:'json'
						,success:function(data){
							/* if(data.berhasil){
								var b = data.berhasil; data.berhasil='';
								var c = '<h1>'+b.nama+'</h1><p class="well">Code Barang : '+b.id_barang+'<br>Jumlah Barang : '+b.jumlah+'<br>Harga Jual Barang : '+b.harga+'<br>Modal / Harga Beli Barang : '+ b.modal +' <br>Tanggal Disimpan : '+b.t_simpan+'<br>Tanggal Di Update : '+b.t_update+'</p>';
								c += '<p>Code Tipe Barang : '+b.tipe +'<br> Ket.Tipe : '+b.tipe_k+' </p>';
								c += '<p>Code Satuan Barang : '+b.satuan +'<br> Ket.Satuan : '+b.satuan_k+' </p>';
								c += '<p>Code Ukuran Barang : '+b.ukuran +'<br> Ket.Ukuran : '+b.ukuran_k+' </p>';
								c += '<p>Code Supplier Barang : '+b.supplier +'<br> Nama Supplier : '+b.supplier_n+'<br> Alamat Supplier : '+b.supplier_a+'<br> Kota Supplier : '+b.supplier_k+'<br> Telpon : '+b.supplier_t+'<br> HP : '+b.supplier_hp+'<br> Ket : '+b.supplier_ket+' </p>';
								if(b.gambar_fol && b.gambar_fil ) c += '<p><img style=" width:400px; height:400px;" src="'+ helmi.asset + b.gambar_fol + b.gambar_fil +'" class="img-responsive" /></p>';
								$('#modalnya-bro .modal-body').html(c);
								$('#modalnya-bro').modal('handleUpdate');
							} */
							if(data.berhasil){
								var c=''; var b = data.berhasil;
								c += '<h1>'+b.nama+'</h1>';
								c += '<p><ul class="col-lg-5"  style="margin-left:21px;"><li>Code Barang :  '+b.id_barang+'  </li><li>Jumlah / Stock  :  '+b.jumlah+'  </li><li>Harga Jual :  '+b.harga+'  </li><li>Harga Beli :  '+b.modal+'  </li><li>Tipe : <ul><li>Code : '+b.tipe+' </li><li>Keterangan : '+b.tipe_k+' </li></ul> </li><li>Satuan :  <ul><li>Code : '+b.satuan+' </li><li>Keterangan : '+b.satuan_k+' </li></ul> </li><li>Ukuran :  <ul><li>Code : '+b.ukuran+' </li><li>Keterangan : '+b.ukuran_k+' </li></ul> </li><li>Supplier : <ul><li> Code : '+b.supplier+'</li><li> Nama : '+b.supplier_n+'</li><li> Alamat : '+b.supplier_a+'</li><li> Kota : '+b.supplier_k+'</li><li> Telpon : '+b.supplier_t+'</li><li> HP : '+b.supplier_hp+'</li><li> Ket : '+b.supplier_ket+'</li></ul> </li><li>Tanggal : <ul><li> Buat : '+b.t_simpan+'</li><li> Update : '+b.t_update+'</li></ul></li></ul>';
								c += (b.gambar_fol && b.gambar_fil) ? ' <div class="col-lg-6"><img style="border-radius:17px;" src="'+ helmi.asset + b.gambar_fol + b.gambar_fil +'" class="img-responsive" /> ' : '';
								c += '</p>';
								
								$('#modalnya-bro .modal-body').html('<div class="row">'+c+'</div>');
								$('#modalnya-bro').modal('handleUpdate');
							}else if(data.error){
								$('#modalnya-bro .modal-body').html('<div class="alert alert-danger"><strong>Error : </strong>'+data.error+'</div>');
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
				$('#modalnya-bro').modal('handleUpdate');
			},complete:function(){
				__ajax_p=false;
			}
		});
	});
	
	if(__list_crud == ''){
		$.ajax({url:helmi.current+'ajax',type:'POST',data:{mode:'view',controller:helmi.controller }
			,success:function(data){ 
				if(data.berhasil){
					var c = buat_tabel(data.berhasil) ; $('#tempat-table-crud').html(c); opsi_extra.table = $('table#table-gwa-crud').DataTable();
					__list_crud =null; c=null;
					if(data.total)$('#tempat-total-table').html('Jumlah Total Code di Table Ini : <span class="label label-success">'+data.total+'</span>');
				}else{
					var c= buat_tabel(data.error); $('#tempat-table-crud').html(c);
				}
		} });
	}
	function buat_tabel(e){
		var c='',no=0;
		e = JSON.stringify(e); e = helmi.amankan(e); e = JSON.parse(e);
		if(e instanceof Array){
			$.each(e,function(k,val){
				c += '<tr data-code="'+val.code+'" data-detail=\''+ JSON.stringify(val) +'\'><td>'+(++no)+'</td><td>'+val.code+'</td><td>'+val.nama+'</td><td>'+val.tipe+'</td> <td>'+( (val.code != 1 ) ?'<span data-tombol="hapus" class="btn btn-danger">HAPUS</span> &nbsp; <span data-tombol="edit" class="btn btn-info">EDIT</span> &nbsp; <span data-tombol="view" class="btn btn-info" title="Tampilkan"><i class="fa fa-eye"></i></span> &nbsp; <a href="'+helmi.home+'print-barcode/'+val.code+'" class="btn btn-warning" target="_blank"><i class="fa fa-print" title="Cetak Barcode"></i></a>' : '-' )+'</td></tr>';
			});
		}else{
			return '<table id="table-gwa-crud" class="table"><thead><tr><th>No</th></tr></thead><tbody><tr><td><h2>TIDAK ADA DATA</h2></td></tr></tbody>';
		}
		return '<table id="table-gwa-crud" class="table"><thead><tr><th>No</th><th>Code Barang</th><th>Nama</th><th>Tipe</th> <th>Action</th></tr></thead><tbody>'+c+'</tbody></table>';
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