var __ajax_p=false;
$(document).off('click','[data-tombol]');
$(document).off('submit','#modalnya-bro form');
var opsi_extra={};
opsi_extra.edit = function(){
	var aa = $('#table-gwa-crud');
	if( aa.length > 0 && typeof opsi_extra.table_c !== 'undefined' && typeof opsi_extra.table_b !== 'undefined'){
		opsi_extra.table_c.remove();
		var b = opsi_extra.table_b ; var c = JSON.stringify( opsi_extra.table_b ); c= helmi.amankan(c);
		var a = '<tr data-code="'+b.code+'" data-detail=\''+c+'\'><td>EDITED</td><td>'+b.code+'</td><td>'+b.ket+'</td><td>'+( (b.code != 1 ) ?'<span data-tombol="edit" class="btn btn-info"><i class="fa fa-joomla"></i></span>' : '-' )+'</td></tr>';
		aa.find('tbody').prepend( a );
		setTimeout(function(){ $('#modalnya-bro').modal('hide'); }, 1000);
	}
};

opsi_extra.tambah = function(){
	var aa = $('#table-gwa-crud');
	if( aa.length > 0 && typeof opsi_extra.table_b !== 'undefined'){
		var b = opsi_extra.table_b ; var c = JSON.stringify( opsi_extra.table_b ); c= helmi.amankan(c);
		var a = '<tr data-code="'+b.code+'" data-detail=\''+c+'\'><td>BARU</td><td>'+b.code+'</td><td>'+b.ket+'</td><td>'+( (b.code != 1 ) ?'<span data-tombol="edit" class="btn btn-info"><i class="fa fa-joomla"></i></span>' : '-' )+'</td></tr>';
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
				$('#modalnya-bro .modal-body').html('<form role="form" perintah="tambah"><div class="form-inline form-inline-box"><div class="form-group"><label >Username </label> <input class="form-control" placeholder="Username Untuk Login" type="text" name="code"> <label class="btn btn-danger" data-tombol="check-duplicate" data-s="code"> Check Duplicate <i class="fa fa-history"></i></label></div></div><div class="form-inline form-inline-box"><div class="form-group"><label >Password : </label> <input class="form-control" placeholder="Ketik Password Untuk User baru ini login" type="text" name="password">  </div></div><div class="form-group"><label> Nama : </label><input class="form-control" placeholder="Ketik nama user" type="text" name="nama" /> </div> <input type="hidden" name="mode" value="tambah_user"> <input type="hidden" name="controller" value="'+helmi.controller+'"> <input type="hidden" name="check-duplicate" value=""> </form>');
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
			case 'edit':
				var a = $(this).parents('tr');
				if(typeof a.data('detail') !== 'undefined' ){
					buat_modal('modalnya-bro'); opsi_extra.table_c = a; var b=a.data('detail');
					$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Edit Password</h4>');
					$('#modalnya-bro .modal-body').html('<p> Edit Password User Berikut :<h4 class="label label-info">'+ b.ket+'</h4> </p><form perintah="edit"><div class="form-inline-box"><label>Password : </label><input class="form-control" name="password" placeholder="Password Baru" /></div><input type="hidden" name="code" value="'+ b.code +'"><input type="hidden" name="mode" value="edit_pass"><input type="hidden" value="'+helmi.controller+'" name="controller" /></form>');
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
		$.ajax({url:helmi.current+'ajax',type:'POST',data:{mode:'view-user',controller:helmi.controller }
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
				c += '<tr data-code="'+val.code+'" data-detail=\''+b+'\'><td>'+(++no)+'</td><td>'+val.code+'</td><td>'+val.ket+'</td><td>'+( (val.code != 1 ) ?'<span data-tombol="edit" class="btn btn-info"><i class="fa fa-joomla"></i></span>' : '-' )+'</td></tr>';
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