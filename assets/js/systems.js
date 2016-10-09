var __ajax_p=false,opsi_extra={}; opsi_extra.userdata='';
$(document).off('click','[data-tombol]');
$(document).off('submit','#modalnya-bro form');
if( $('#ui-datepicker-div').length > 0 ){
	$('#ui-datepicker-div').remove();
}

$(document).ready(function(){
	$(document).on('click','[data-tombol]',function(e){
		e.preventDefault();
		switch($(this).attr('data-tombol')){ 
			case 'set-photo-profile':
				buat_modal('modalnya-bro');
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title label label-info"> Edit Nama </h4> ' );
				$('#modalnya-bro .modal-body').html('<form method="POST" enctype="multipart/form-data" action="'+helmi.current+'ajax" role="form"><div class="form-group"><label> Set Photo Profile </label><input  type="file" name="upload_image"  /></div><input type="hidden" name="controller" value="data-image" /><input type="hidden" name="controller2" value="'+helmi.controller+'" /><input type="hidden" name="mode" value="setting-background" /> </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				''
				break;
			case 'tanggal-list': 
				$(this).datepicker({dateFormat: 'yy-mm-dd'}); $(this).datepicker("show");
				//if (!$(this).hasClass("hasDatepicker")) { }
				break;
			case 'simpan': 
				var a = $('#settingan-system');
				$.ajax({
					url:helmi.current+'ajax',data:a.serialize() ,type:'POST',dataType:'json'
					,beforeSend:function(){
						if( a.parent('div').find('.loading-nya-bro').length > 0){
							a.parent('div').find('.loading-nya-bro').html('<img src="'+helmi.asset+'loading.gif" />');
						}else{
							a.parent('div').append('<div class="loading-nya-bro" style="text-align:center;"><img src="'+helmi.asset+'loading.gif" /></div>');
						}
					}
					,success:function(data){
						if(data.error){
							a.parent('div').find('.loading-nya-bro').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button><strong>Error :</strong> '+ data.error +'</div>');
						}else if(data.berhasil){
							a.parent('div').find('.loading-nya-bro').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button><strong>Success :</strong> '+ data.berhasil +'</div>');
						}
					}
				});
				break;
			case 'simpan-modal':
				$('#modalnya-bro form').trigger('submit');
				break;
				
			default: break;
		}
	});
	
	/* if(opsi_extra.userdata == ''){
		$.ajax({
			url:helmi.current+'ajax',data:{controller:helmi.controller , mode:'view'},type:'POST',dataType:'json'
			,success:function(data){
				if(data.berhasil){
					var e=data.berhasil,c = buat_tabel(data.berhasil); opsi_extra.userdata=data.berhasil;
					$('#user-profile').html(c);
					$('#tab-preview').html('<div class="main-box-body" style="min-height:200px;"><div class="form-group "> <label> Nama : </label> <input disabled class="form-control" value="'+e.nama+'" ></div> <div class="form-inline"> <button class="btn btn-success" data-tombol="set-name">Set nama</button> &nbsp; <button class="btn btn-info" data-tombol="set-photo-profile">Set Photo profile</button> &nbsp; <button class="btn btn-danger" data-tombol="set-password">Set Password</button></div></div>');
				}
			}
		});
	} */
	
	$(document).on('submit','#modalnya-bro form',function(e){
		if( typeof $(this).attr('action') === 'undefined'){
			e.preventDefault();
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
					}
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
	
	function buat_tabel(e){
		var c='';
		 c += '<header class="main-box-header clearfix"> <h2>'+e.nama+'</h2> </header>';
		 c += '<div class="main-box-body clearfix">';
		 c += '<div class="profile-status"> <i class="fa fa-circle"></i> Online </div>';
		 c += '<img style="max-width:250px;" src="'+( (typeof e.folder !== 'undefined' && typeof e.profile_pic !== 'undefined' ) ? helmi.asset + e.folder +e.profile_pic : helmi.asset + 'noimage.jpg' )+'" alt="" class="profile-img img-responsive center-block">';
		 c += '<div class="profile-label"> <span class="label label-danger">'+e.level+'</span> </div>';
		 c += '<div class="profile-stars"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <span>Super User</span> </div>';
		 c += '<div class="profile-since"> Member since: '+e.buat+' </div>';
		 c += '<div class="profile-details"> <ul class="fa-ul"> <li><i class="fa-li fa fa-truck"></i>Trans Pengeluaran: <span>'+e.trans_pengeluaran+'</span></li> <li><i class="fa-li fa fa-comment"></i>Trans Pendapatan: <span>'+e.trans_pendapatan+'</span></li> </ul> </div>';
		 //c += '<div class="profile-message-btn center-block text-center"> <a href="#" class="btn btn-success"> <i class="fa fa-envelope"></i> Send message </a> </div>';
		 c += '</div>';
		 return c;
	}
});