var __ajax_p=false;
$(document).off('click','[data-tombol]');
$(document).off('submit','#modalnya-bro form');
if( $('#ui-datepicker-div').length > 0 ){
	$('#ui-datepicker-div').remove();
}

$(document).ready(function(){
	$(document).on('click','[data-tombol]',function(e){
		e.preventDefault();
		switch($(this).attr('data-tombol')){
			case 'get-list' :
				
				var a = $(this).parents('.form-inline') , b=true , c={};
				if( a.find('input[name="tgl_mulai"]').val() == '' ){
					b =false;
					helmi.form_e( a.find('input[name="tgl_mulai"]') ,'Tanggal Tidak Boleh Kosong');
				}
				if( a.find('input[name="tgl_akhir"]').val() == '' ){
					b =false;
					helmi.form_e( a.find('input[name="tgl_akhir"]') ,'Tanggal Tidak Boleh Kosong');
				}
				
			if(b){
				c.mode = 'view'; c.controller = helmi.controller ;
				c.tgl_mulai = a.find('input[name="tgl_mulai"]').val() ; c.tgl_akhir = a.find('input[name="tgl_akhir"]').val() ;
				
				$.ajax({url:helmi.current+'ajax',type:'POST',data:c
					,beforeSend:function(){
						$('#tempat-table-crud').html('<div style="text-align:center; min-height:150px;"><img src="'+ helmi.asset +'loading.gif" /></div>');
					},success:function(data){ 
						if(data.berhasil){
							var c = buat_tabel(data.berhasil) ; $('#tempat-table-crud').html(c); $('table#table-gwa-crud').dataTable();
							__list_crud =null; c=null;
							if(data.total)$('#tempat-total-table').html('Jumlah Total Retur di Table Ini : <span class="label label-success">'+data.total+'</span>');
						}
						else{
							$('#tempat-table-crud').html(buat_tabel('') ); 
						}
				} });
			}				
				break;
			case 'tanggal-list': 
				$(this).datepicker({dateFormat: 'yy-mm-dd'}); $(this).datepicker("show");
				//if (!$(this).hasClass("hasDatepicker")) { }
				break;
			case 'simpan-modal':
				$('#modalnya-bro form').trigger('submit');
				break;
			case 'view':
				var a = $(this).parents('tr');
				if(typeof a.data('detail') !== 'undefined' ){
					buat_modal('modalnya-bro');  var b = helmi.quot(a.data('detail') );
					$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title label label-info">Detail : Nota : '+b.code+' / '+b.tanggal+' </h4>&nbsp; '+( (b.tipe == 0 ) ? '<span class="label label-success">Pendapatan : '+b.waktu+'</span>' : '<span class="label label-danger">Pengeluaran : '+b.waktu+'</span>') + ' &nbsp; <span class="label label-default">'+ b.nama.substr(0,17) +'</span> ' );
					$('#modalnya-bro .modal-body').html('<div style="text-align:center;"><img src="'+helmi.asset+'loading.gif"  /></div>');
					$('#modalnya-bro .modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
					$('#modalnya-bro').modal({show:true});
					$.ajax({
						url:helmi.current +'ajax',type:'POST',dataType:'json',data:{controller:helmi.controller ,code: b.code , tanggal: b.tanggal,mode:'detail'},
						success:function(data){
							if(data.berhasil){
								var d ='',total=0;
								$.each( data.berhasil ,function(k,v){
									v.harga = parseInt(v.harga); v.jumlah = parseInt(v.jumlah);
									total +=  v.harga * v.jumlah ; 
									d += '<tr><td>'+v.id_barang+'</td><td>'+v.nama+'</td><td>'+v.jumlah+'</td><td>'+ v.harga.nomornya(0,3,'.') +'</td><td>'+ (v.harga * v.jumlah ).nomornya(0,3,'.') +'</td> </tr>';
								});
								b.bayar = parseInt(b.bayar); b.kembali = parseInt(b.kembali);
								
								d = '<thead><tr><th>Code</th><th>Nama</th><th>Jumlah</th><th>Harga</th><th>harga Akumulasi</th></tr></thead><tbody>'+d+'</tbody>';
								$('#modalnya-bro .modal-body').html('<div class="table-responsive"><table class="table">'+d+'</table></div> <div ><label class="total_jml">Total : Rp. '+ total.nomornya(0,3,'.') +',- <br> Bayar : Rp. '+b.bayar.nomornya(0,3,'.') +',- <hr/> Kembali : Rp. '+b.kembali.nomornya(0,3,'.') +',- </label></div> '+ (( b.retur == 1) ? '<div> <span style="white-space:normal;" class="label label-danger">* Nota Ini memiliki retur , check menu retur dengan Nota : '+b.code+' / '+b.tanggal+' Untuk detail informasi</span> </div>' : '' ) );
							}else if(data.error){
								$('#modalnya-bro .modal-body').html('<div class="alert alert-danger"><strong> Error : </strong> '+data.error+' </div>');
							}
							$('#modalnya-bro').modal('handleUpdate');
						}
					});
				}
				break; 
			default: break;
		}
	});
	
	
	
	$(document).on('submit','#modalnya-bro form',function(e){
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
	});
	
	if(__list_crud == ''){
		$.ajax({url:helmi.current+'ajax',type:'POST',data:{mode:'view',controller:helmi.controller }
			,success:function(data){ 
				if(data.berhasil){
					var c = buat_tabel(data.berhasil) ; $('#tempat-table-crud').html(c); $('table#table-gwa-crud').dataTable();
					__list_crud =null; c=null;
					if(data.total)$('#tempat-total-table').html('Jumlah Total Nota di Table Ini : <span class="label label-success">'+data.total+'</span>');
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
				c += '<tr data-code="'+val.code+'" data-detail=\''+b+'\'><td>'+(++no)+'</td><td>'+val.code+'</td><td>'+val.tanggal+'</td><td '+(val.retur ==1 ? 'style="text-decoration: line-through;" title="Canceled Transaksi"' : '' )+'>'+d+'</td><td>'+( (val.code != 1 ) ?'<span data-tombol="view" class="btn btn-info" title="Tampilkan"><i class="fa fa-eye"></i></span> &nbsp; <a target="_blank" href="'+helmi.home+'print-nota/'+val.code+'/'+val.tanggal+'" class="btn btn-danger" title="PRINT"><i class="fa fa-print"></i></a>' : '-' )+'</td></tr>';
			});
		}else{
			return '<table class="table"><thead><tr><th>-</th> </tr></thead><tbody><tr><td><h2>TIDAK ADA DATA</h2></td></tr></tbody></table>';
		}
		return '<table id="table-gwa-crud" class="table"><thead><tr><th>No</th><th>Nota</th><th>Tanggal</th><th>Transaksi</th><th>Action</th></tr></thead><tbody>'+c+'</tbody></table>';
	}
});