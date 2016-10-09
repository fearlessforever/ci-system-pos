var __ajax_p=false,opsi_extra=[];
$(document).off('click','[data-tombol]');
$(document).off('submit','#modalnya-bro form');
opsi_extra.hapus = function(){
	if(typeof opsi_extra.table !== 'undefined' && typeof opsi_extra.table_c !== 'undefined'){
		opsi_extra.table.row( opsi_extra.table_c ).remove().draw();
		setTimeout(function(){ $('#modalnya-bro').modal('hide'); }, 1000);
	}
};

$(document).ready(function(){
	$(document).on('click','[data-tombol]',function(e){
		e.preventDefault();
		switch($(this).attr('data-tombol')){
			case 'tambah' :
				buat_modal('modalnya-bro');
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Tambah Gambar dari Barang / Jasa</h4>');
				$('#modalnya-bro .modal-body').html('<form method="POST" enctype="multipart/form-data" action="'+helmi.current+'ajax" role="form"><div class="form-inline form-inline-box"><div class="form-group"><label >Pilih Id Barang </label> <select class="form-control pilihan-barang" name="code"><option value="1">-</option></select></div> <label class="btn btn-success" data-tombol="load-select" data-s="barang"> Pilihan Lain <i class="fa fa-history"></i></label></div> <div class="form-group"><label >Pilih File Gambar </label> <input type="file" name="upload_image" /></div><input type="hidden" name="mode" value="upload_barang_t"> <input type="hidden" name="controller" value="'+helmi.controller+'" /> </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				break;
			case 'simpan-modal': $('#modalnya-bro form').trigger('submit'); break;
			case 'hapus': 
				var a = $(this).parents('tr');
				if(typeof a.data('detail') !== 'undefined' ){
					buat_modal('modalnya-bro'); var b = helmi.quot(a.data('detail') );  opsi_extra.table_c = a;
					$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Hapus Data</h4>');
					$('#modalnya-bro .modal-body').html('<div class="row"><p>Peringatan : Menghapus Gambar Barang yang telah di gunakan di List Barang sangat tidak dianjurkan<br/>Jika Anda tetap ingin menghapus data ini silahkan klik Hapus untuk konfirmasi hapus<br><br>Anda akan menghapus Gambar dengan code berikut :<h4 class="label label-info">'+b.code+'</h4> </p><form perintah="hapus"><input type="hidden" name="code" value="'+b.code+'"><input type="hidden" name="mode" value="hapus"><input type="hidden" value="'+helmi.controller+'" name="controller" /></form><div class="center"><div class="col-lg-6"><img src="'+helmi.asset+b.folder+b.nama_file+'" class="img-responsive" /></div></div></div>');
					$('#modalnya-bro .modal-footer').html('<button class="btn btn-danger" data-tombol="simpan-modal">Hapus</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
					$('#modalnya-bro').modal({show:true});
				}
				break;
			case 'load-select': 
				var a= $(this);
				if(typeof opsi_extra[a.attr('data-s')] !== 'undefined' ){
					var c = buat_opsi_modal(opsi_extra[a.attr('data-s')] ); $('.modal-body select.pilihan-'+a.attr('data-s') ).html(c);
					a.attr('disabled','disabled');
					return;
				}
				if(__ajax_p){return;}else{ __ajax_p=true;}
						
				$.ajax({
					url:helmi.current+'ajax',type:'POST',data:{mode:'view',pilihan:a.attr('data-s'),controller:'data-barang' },dataType:'json',
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
					},complete:function(){
						__ajax_p=false;
					}
				});
				break;
			case 'edit':
				var a = $(this).parents('tr');
				if(typeof a.data('detail') !== 'undefined' ){
					buat_modal('modalnya-bro'); var b = helmi.quot(a.data('detail') );
					$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Edit Data</h4>');
					$('#modalnya-bro .modal-body').html('<div class="row"><form method="POST" enctype="multipart/form-data" action="'+helmi.current+'ajax" role="form"> <div class="form-group"> <label >Code Barang</label> <input disabled class="form-control" value="'+b.code+'" type="text" name="code"> </div><div class="form-group"> <label >Pilih File Gambar Baru</label> <input name="upload_image" type="file" /> </div><input value="'+b.code+'" type="hidden" name="code"><input type="hidden" name="mode" value="edit"><input type="hidden" name="controller" value="'+helmi.controller+'"> </form><div class="center"><div class="col-lg-6"><img src="'+helmi.asset+b.folder+b.nama_file+'" class="img-responsive" /></div></div></div>');
					$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
					$('#modalnya-bro').modal({show:true});
				}
				break;
			default: break;
		}
	});
	
	
	$(document).on('submit','#modalnya-bro form',function(e){
		if( typeof $(this).attr('action') === 'undefined'){
			e.preventDefault();  var a=$(this);
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
			
		}else{
			var id = $(this).find('select[name="code"]').val();
			var file = $(this).find('input[name="upload_image"]').val(); 
			if( $('#modalnya-bro .modal-body .error-pesan').length > 0){
				
			}else{ $('#modalnya-bro .modal-body').append('<div class="error-pesan"></div>'); }
			if( id == '1' ){
				e.preventDefault(); 
				$('#modalnya-bro .modal-body .error-pesan').html('<div class="alert alert-danger"><strong>Error : </strong>Silahkan pilih ID barang terlebih dahulu<button class="close" data-dismiss="alert">&times;</button></div>');
				return;
			}
			if( file == '' ){
				e.preventDefault(); 
				$('#modalnya-bro .modal-body .error-pesan').html('<div class="alert alert-danger"><strong>Error : </strong>Silahkan pilih File Gambar terlebih dahulu<button class="close" data-dismiss="alert">&times;</button></div>');
				return;
			}
			if($('#modalnya-bro .modal-body .loading-nya-bro').length > 0){
				$('#modalnya-bro .modal-body .loading-nya-bro').html('<img src="'+helmi.asset+'loading.gif" />');
			}else{
				$('#modalnya-bro .modal-body').append('<div class="loading-nya-bro" style="text-align:center;"><img src="'+helmi.asset+'loading.gif" /></div>');
			} 
		}
		
		
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
		var c='',no=0,b='',nama='';
		e = JSON.stringify(e); e = helmi.amankan(e); e = JSON.parse(e);
		if(e instanceof Array){
			$.each(e,function(k,val){
				nama = val.nama ; val.nama='';
				b = JSON.stringify(val);
				c += '<tr data-code="'+val.code+'" data-detail=\''+b+'\'><td>'+(++no)+'</td><td>'+val.code+'</td><td>'+ nama +'</td><td>'+val.tanggal_b+'</td><td><img src="'+helmi.asset+val.folder+'t_'+val.nama_file+'" style="width:50px;height:50px" /></td><td>'+( (val.code != 1 ) ?'<span data-tombol="hapus" class="btn btn-danger">HAPUS</span> &nbsp; <span data-tombol="edit" class="btn btn-info">EDIT</span>' : '-' )+'</td></tr>';
			});
		}else{
			return '<table id="table-gwa-crud" class="table"><thead><tr><th>No</th></tr></thead><tbody><tr><td><h2>TIDAK ADA DATA</h2></td></tr></tbody>';
		}
		return '<table id="table-gwa-crud" class="table"><thead><tr><th>No</th><th>Code Barang</th><th>Nama</th><th>Tanggal</th><th>Gambar</th><th>Action</th></tr></thead><tbody>'+c+'</tbody></table>';
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