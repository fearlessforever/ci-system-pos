var __ajax_p=false;
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
		var a = '<tr '+( (b.code != 1 ) ?'data-code="'+b.code+'" data-detail=\''+c+'\'' : '' )+' ><td>'+b.code+'</td><td>'+b.namasupplier+'</td><td>'+b.alamat+'</td><td>'+b.kota+'</td><td>'+b.telepon+'</td><td>'+b.kontakperson+'</td><td>'+( (b.code != 1 ) ?'<span class="btn btn-danger" data-tombol="hapus">HAPUS</span> &nbsp; <span class="btn btn-info" data-tombol="edit">EDIT</span>' : '-' )+'</td></tr>'; 
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
		var a = '<tr '+( (b.code != 1 ) ?'data-code="'+b.code+'" data-detail=\''+c+'\'' : '' )+' ><td>'+b.code+'</td><td>'+b.namasupplier+'</td><td>'+b.alamat+'</td><td>'+b.kota+'</td><td>'+b.telepon+'</td><td>'+b.kontakperson+'</td><td>'+( (b.code != 1 ) ?'<span class="btn btn-danger" data-tombol="hapus">HAPUS</span> &nbsp; <span class="btn btn-info" data-tombol="edit">EDIT</span>' : '-' )+'</td></tr>';
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
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Tambah Supplier</h4>');
				$('#modalnya-bro .modal-body').html('<form role="form" perintah="tambah"><div class="form-inline form-inline-box"> <div class="form-group"> <label >Code Supplier</label> <input class="form-control" placeholder="Code Supplier Misal 1" type="text" name="code">  <label class="btn btn-danger" data-tombol="check-duplicate" data-s="code"> Check Duplicate <i class="fa fa-history"></i></label> </div> </div> <div class="form-group"> <label >Nama Supplier</label> <input class="form-control" placeholder="Nama Supplier" type="text" name="namasupplier"></div> <div class="form-group"> <label >Alamat</label> <input class="form-control" placeholder="Alamat Supplier" type="text" name="alamat"> </div> <div class="form-group"> <label >Kota</label> <input class="form-control" placeholder="Kota Supplier" type="text" name="kota"> </div> <div class="form-group"> <label >Telpon</label> <input class="form-control" placeholder="Nomor Telpon Supplier" type="text" name="telepon"> </div> <div class="form-group"> <label >HP</label> <input class="form-control" placeholder="Nomor HP Supplier" type="text" name="kontakperson"> </div> <div class="form-group"> <label >Keterangan</label> <input class="form-control" placeholder="Keterangan Supplier" type="text" name="keterangan"> </div> <input type="hidden" name="mode" value="tambah"> <input type="hidden" name="controller" value="'+helmi.controller+'"> <input type="hidden" name="check-duplicate" value=""> </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				break;
			case 'check-duplicate':
				var aa = $(this).attr('data-s'),check=false,a=$(this),target=$('.modal-body input[name="'+aa+'"]');
				if( typeof aa !== 'undefined' && target.length > 0 ){
					if(target.val() == ''){
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
			case 'simpan-modal':
				$('#modalnya-bro form').trigger('submit');
				break;
			case 'hapus':
				var a = $(this).parents('tr');
				if(typeof a.data('code') !== 'undefined' ){
					buat_modal('modalnya-bro');  opsi_extra.table_c = a;
					$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Hapus Data</h4>');
					$('#modalnya-bro .modal-body').html('<p>Peringatan : Menghapus Code Supplier yang telah di gunakan di List Barang sangat tidak dianjurkan<br/>Jika Anda tetap ingin menghapus data ini silahkan klik Hapus untuk konfirmasi hapus<br><br>Anda akan menghapus Supplier dengan code berikut :<h4 class="label label-info">'+a.data('code')+'</h4> </p><form perintah="hapus"><input type="hidden" name="code" value="'+a.data('code')+'"><input type="hidden" name="mode" value="hapus"><input type="hidden" value="'+helmi.controller+'" name="controller" /></form>');
					$('#modalnya-bro .modal-footer').html('<button class="btn btn-danger" data-tombol="simpan-modal">Hapus</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
					$('#modalnya-bro').modal({show:true});
				}
				break;
			case 'edit':
				var a = $(this).parents('tr');
				if(typeof a.data('detail') !== 'undefined' ){
					buat_modal('modalnya-bro'); var b = helmi.quot(a.data('detail') ); opsi_extra.table_c = a;
					$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Edit Data</h4>');
					$('#modalnya-bro .modal-body').html('<form role="form" perintah="edit"> <div class="form-group"> <label >Code Supplier</label> <input disabled class="form-control" value="'+b.code+'" type="text" name="code"> </div> <div class="form-group"> <label >Nama Supplier</label> <input class="form-control" type="text" name="namasupplier" value="'+b.namasupplier+'"> </div> <div class="form-group"> <label >Alamat</label> <input class="form-control" value="'+b.alamat+'" type="text" name="alamat"> </div> <div class="form-group"> <label >Kota</label> <input class="form-control" value="'+b.kota+'" type="text" name="kota"> </div> <div class="form-group"> <label >Telpon</label> <input class="form-control" value="'+b.telepon+'" type="text" name="telepon"> </div> <div class="form-group"> <label >HP</label> <input class="form-control" value="'+b.kontakperson+'" type="text" name="kontakperson"> </div> <div class="form-group"> <label >Keterangan</label> <input class="form-control" value="'+b.ket+'" type="text" name="keterangan"> </div><input value="'+b.code+'" type="hidden" name="code"><input type="hidden" name="mode" value="edit"><input type="hidden" name="controller" value="'+helmi.controller+'"> </form>');
					$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
					$('#modalnya-bro').modal({show:true});
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
					var c = buat_tabel(data.berhasil) ; $('#tempat-table-crud').html(c); opsi_extra.table = $('table#table-gwa-crud').DataTable();
					__list_crud =null; c=null;
					if(data.total)$('#tempat-total-table').html('Jumlah Total Code di Table Ini : <span class="label label-success">'+data.total+'</span>');
				}
		} });
	}else{
		var c = buat_tabel(__list_crud) ; $('#tempat-table-crud').html(c); $('table#table-gwa-crud').dataTable();
		__list_crud =null; c=null;
	}
	
	function buat_tabel(e){
		var c='',b='';
		e = JSON.stringify(e); e = helmi.amankan(e); e = JSON.parse(e);
		if(e instanceof Array){
			$.each(e,function(k,val){
				b = JSON.stringify(val); //.replace(/'/g,"\\'"); //.replace(/'/g,'&quot;');
				c += '<tr '+( (val.code != 1 ) ?'data-code="'+val.code+'" data-detail=\''+b+'\'' : '' )+' ><td>'+val.code+'</td><td>'+val.namasupplier+'</td><td>'+val.alamat+'</td><td>'+val.kota+'</td><td>'+val.telepon+'</td><td>'+val.kontakperson+'</td><td>'+( (val.code != 1 ) ?'<span class="btn btn-danger" data-tombol="hapus">HAPUS</span> &nbsp; <span class="btn btn-info" data-tombol="edit">EDIT</span>' : '-' )+'</td></tr>';
			});
		}else{
			return'<table id="table-gwa-crud" class="table"><thead><tr><th>NO</th></tr></thead><tbody><tr><td><h2>TIDAK ADA DATA</h2></td></tr></tbody>';
		}
		return '<table id="table-gwa-crud" class="table"><thead><tr><th>Code</th><th>Nama Supplier</th><th>Alamat</th><th>Kota</th><th>Telepon</th><th>HP</th><th>Action</th></tr></thead><tbody>'+c+'</tbody></table>';
	}
});