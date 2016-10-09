var __ajax_p=false;
$(document).off('click','[data-tombol]');
$(document).off('submit','#modalnya-bro form');
if( $('#ui-datepicker-div').length > 0 ){
	$('#ui-datepicker-div').remove();
}
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
		var a = '<tr data-code="'+b.code+'" data-detail=\''+c+'\'><td>EDITED</td><td>'+b.code+'</td><td>'+b.tanggal+'</td><td><span class="label label-warning">EDITED</span></td><td>'+( (b.code != 1 ) ?'<span data-tombol="hapus" class="btn btn-danger">HAPUS</span> &nbsp; <span data-tombol="edit" class="btn btn-info">EDIT</span>' : '-' )+'</td></tr>'; 
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
		var a = '<tr data-code="'+b.code+'" data-detail=\''+c+'\'><td>BARU</td><td>'+b.code+'</td><td>'+b.tanggal+'</td><td><span class="label label-info">BARU</span></td><td>'+( (b.code != 1 ) ?'<span data-tombol="hapus" class="btn btn-danger">HAPUS</span> &nbsp; <span data-tombol="edit" class="btn btn-info">EDIT</span>' : '-' )+'</td></tr>';
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
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Tambahkan Retur </h4>');
				$('#modalnya-bro .modal-body').html('<form role="form"  perintah="tambah"><div class="form-inline form-inline-box"><div class="form-group"> <label >Nomor Nota</label> <input class="form-control" placeholder="Code nya Misal 1" type="text" name="code"> </div></div><div class="form-inline form-inline-box"><div class="form-group"> <label >Tanggal</label> <input class="form-control" data-tombol="tanggal-list" value="hari ini" type="text" name="tanggal"> </div></div><div class="form-group"> <label >Keterangan </label> <input class="form-control" placeholder="Keterangan cancel transaksi" type="text" name="ket"> </div> <input type="hidden" name="mode" value="tambah"> <input type="hidden" name="controller" value="'+helmi.controller+'">  </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				break;
			case 'tanggal-list': 
				$(this).datepicker({dateFormat: 'yy-mm-dd'}); $(this).datepicker("show");
				//if (!$(this).hasClass("hasDatepicker")) { }
				break;
			case 'simpan-modal':
				$('#modalnya-bro form').trigger('submit');
				break;
			case 'hapus':
				var a = $(this).parents('tr');
				if(typeof a.data('detail') !== 'undefined' ){
					buat_modal('modalnya-bro');  var b = helmi.quot(a.data('detail') );  opsi_extra.table_c = a;
					$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Hapus Data</h4>');
					$('#modalnya-bro .modal-body').html('<p>Peringatan : Menghapus Retur yang sudah lama dibuat sangat tidak dianjurkan<br/>Jika Anda tetap ingin menghapus data ini silahkan klik Hapus untuk konfirmasi hapus<br><br>Anda akan menghapus Retur dengan Nota berikut :<h4 class="label label-info">'+b.code+' / '+b.tanggal+'</h4> </p><form perintah="hapus"><input type="hidden" name="code" value="'+ b.code +'"><input type="hidden" name="tanggal" value="'+ b.tanggal +'"><input type="hidden" name="mode" value="hapus"><input type="hidden" value="'+helmi.controller+'" name="controller" /></form>');
					$('#modalnya-bro .modal-footer').html('<button class="btn btn-danger" data-tombol="simpan-modal">Hapus</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
					$('#modalnya-bro').modal({show:true});
				}
				break;
			case 'edit':
				var a = $(this).parents('tr');
				if(typeof a.data('detail') !== 'undefined' ){
					buat_modal('modalnya-bro'); var b = helmi.quot(a.data('detail') );  opsi_extra.table_c = a;
					$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Edit Data</h4>');
					$('#modalnya-bro .modal-body').html('<form role="form" perintah="edit"> <div class="form-group"> <label >Code Satuan</label> <input disabled class="form-control" value="'+b.code+'" type="text" > </div><div class="form-group"> <label >Tanggal</label> <input disabled class="form-control" value="'+b.tanggal+'" type="text" > </div><div class="form-group"> <label >Keterangan</label> <input class="form-control" value="'+b.ket+'" type="text" name="ket"> </div><input type="hidden" name="tanggal" value="'+ b.tanggal +'"><input value="'+b.code+'" type="hidden" name="code"><input type="hidden" name="mode" value="edit"><input type="hidden" name="controller" value="'+helmi.controller+'"> </form>');
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
					if(data.total)$('#tempat-total-table').html('Jumlah Total Retur di Table Ini : <span class="label label-success">'+data.total+'</span>');
				}
				else{
					$('#tempat-table-crud').html(buat_tabel('') ); 
				}
		} });
	}
	function buat_tabel(e){
		var c='',no=0,b='',d='';
		e = JSON.stringify(e); e = helmi.amankan(e); e = JSON.parse(e);
		if(e instanceof Array){
			$.each(e,function(k,val){
				b = JSON.stringify(val);
				d = (val.tipe == 0 ) ? '<span class="label label-success">pendapatan</span>' : '<span class="label label-danger">pengeluaran</span>' ;
				c += '<tr data-code="'+val.code+'" data-detail=\''+b+'\'><td>'+(++no)+'</td><td>'+val.code+'</td><td>'+val.tanggal+'</td><td>'+d+'</td><td>'+( (val.code != 1 ) ?'<span data-tombol="hapus" class="btn btn-danger">HAPUS</span> &nbsp; <span data-tombol="edit" class="btn btn-info">EDIT</span>' : '-' )+'</td></tr>';
			});
		}else{
			return '<table class="table"><thead><tr><th>-</th> </tr></thead><tbody><tr><td><h2>TIDAK ADA DATA</h2></td></tr></tbody></table>';
		}
		return '<table id="table-gwa-crud" class="table"><thead><tr><th>No</th><th>Nota</th><th>Tanggal</th><th>Retur</th><th>Action</th></tr></thead><tbody>'+c+'</tbody></table>';
	}
});