var __ajax_p=false;
$(document).off('click','[data-tombol]');
$(document).off('submit','#modalnya-bro form');
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
		var a = '<tr data-code="'+b.code+'" data-detail=\''+c+'\'><td>BARU</td><td>'+b.code+'</td><td>'+b.ket+'</td><td>'+( (b.code != 1 ) ?'<span data-tombol="hapus" class="btn btn-danger"><i class="fa fa-joomla"></i></span>' : '-' )+'</td></tr>';
		aa.find('tbody').prepend( a );
		setTimeout(function(){ $('#modalnya-bro').modal('hide'); }, 1000);
	}
};

$(document).ready(function(){
	$(document).on('click','[data-tombol]',function(e){
		e.preventDefault();
		switch($(this).attr('data-tombol')){
			case 'tambah' :
				buat_modal('modalnya-bro');
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Tambah Modul Yang diperbolehkan</h4>');
				$('#modalnya-bro .modal-body').html('<form role="form" perintah="tambah"><div class="form-inline form-inline-box"><div class="form-group"> <label >Pilih Modul </label> <select class="form-control" name="modul">'+buat_opsi()+'</select> </div></div><div class="form-group"> <label >Untuk User Tipe : </label> <input class="form-control" disabled type="text" value="Kasir"> </div> <input type="hidden" name="mode" value="tambah"> <input type="hidden" name="controller" value="'+helmi.controller+'"> </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				break;
				
			case 'simpan-modal':
				$('#modalnya-bro form').trigger('submit');
				break;
			case 'hapus':
				var a = $(this).parents('tr');
				if(typeof a.data('detail') !== 'undefined' ){
					buat_modal('modalnya-bro'); opsi_extra.table_c = a; var b=a.data('detail');
					$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Hapus Data</h4>');
					$('#modalnya-bro .modal-body').html('<p> Anda akan menghapus Modul berikut :<h4 class="label label-info">'+ b.ket+'</h4> diakses oleh kasir ?</p><form perintah="hapus"><input type="hidden" name="code" value="'+ b.app +'"><input type="hidden" name="mode" value="hapus"><input type="hidden" value="'+helmi.controller+'" name="controller" /></form>');
					$('#modalnya-bro .modal-footer').html('<button class="btn btn-danger" data-tombol="simpan-modal">Hapus</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
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
					var c = buat_tabel(data.berhasil) ; $('#tempat-table-crud').html(c); 
					__list_crud =null; c=null; 
				}else if(data.error){
					$('#tempat-table-crud').html( buat_tabel('') );
				}
				if(data.list_app){
					opsi_extra.list_app = data.list_app; 
				}
		} });
	}
	function buat_tabel(e){
		var c='',no=0,b='';
		e = JSON.stringify(e); e = helmi.amankan(e); e = JSON.parse(e);
		if(e instanceof Array){
			$.each(e,function(k,val){
				b = JSON.stringify(val);
				c += '<tr data-code="'+val.code+'" data-detail=\''+b+'\'><td>'+(++no)+'</td><td>'+val.code+'</td><td>'+val.ket+'</td><td>'+( (val.code != 1 ) ?'<span data-tombol="hapus" class="btn btn-danger"><i class="fa fa-joomla"></i></span>' : '-' )+'</td></tr>';
			});
		}else{
			c ='';
		}
		return '<table id="table-gwa-crud" class="table table-hover"><thead><tr><th width="100">No</th><th>Tipe User</th><th>Nama Modul</th><th>Action</th></tr></thead><tbody>'+c+'</tbody></table>';
	}
	function buat_opsi(e){
		var c='';
		if(typeof opsi_extra.list_app !== 'undefined' && opsi_extra.list_app instanceof Object){
			$.each(opsi_extra.list_app , function(k,v){
				c +='<option value="'+v.app+'" '+( (typeof e !== 'undefined' && e == v.app)?'selected':'' )+'>'+v.ket+'</option>';
			});
		}else{
			c ='<option value="">Tidak Ada</option>';
		}
		return c;
	}
});