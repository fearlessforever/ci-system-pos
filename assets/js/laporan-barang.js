var __ajax_p=false; var opsi_extra=[];
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
				
				$.ajax({url:helmi.current+'ajax',type:'POST',data:c,dateType:'json'
					,beforeSend:function(){
						$('#tempat-table-crud').html('<div style="text-align:center; min-height:150px;"><img src="'+ helmi.asset +'loading.gif" /></div>');
					},success:function(data){ 
						if(data.berhasil){
							var b =data.berhasil;
							b.pendapatan = parseInt(b.pendapatan); b.pengeluaran = parseInt(b.pengeluaran);
							var hasil = b.pendapatan - b.pengeluaran ;
							var c= '<div style="text-align:center;"><h1>Laporan Pergerakan Barang </h1> <span class="label label-info">Dari Tanggal '+ b.tgl_mulai +' ~ '+ b.tgl_akhir +' </span></div>';
							if(data.berhasil.detail){
								c +='<br><div class="table-responsive"><table class="table"><thead><tr><th>No</th><th>Code</th><th>Nama Barang</th><th>Penjualan (-)</th><th>Pembelian (+)</th><th>-</th></tr></thead><tbody>';
								var cc=0,bb='';
								$.each(data.berhasil.detail ,function(k,v){
									opsi_extra[v.code]=v;
									c +='<tr><td>'+(++cc)+'</td><td>'+v.code+'</td><td>'+v.nama+'</td><td>'+v.pendapatan+'</td><td>'+v.pengeluaran+'</td><td><button title="Detail Laporan Barang" class="btn btn-danger" data-tombol="detail" data-tombol-id="'+v.code+'"><i class="fa fa-eye"></i></button> &nbsp; <button title="Info Barang Sekarang" class="btn btn-success" data-tombol="view" data-tombol-id="'+v.code+'"><i class="fa fa-joomla"></i></button></td></tr>';
								});
								c += '</tbody></table></div>';
							}
							opsi_extra.tgl_mulai=b.tgl_mulai_a ; opsi_extra.tgl_akhir=b.tgl_akhir_a ;
							$('#tempat-table-crud').html(c);  
						}
						else{
							$('#tempat-table-crud').html(' <h3 style="text-align:center;"> Data Tidak Ditemukan </h3> '); 
						}
				} });
			}				
				break;
			case 'tanggal-list': 
				$(this).datepicker({dateFormat: 'yy-mm-dd'}); $(this).datepicker("show");
				//if (!$(this).hasClass("hasDatepicker")) { }
				break;
			case 'detail':
				if(typeof $(this).attr('data-tombol-id') === 'undefined')break;
				var a= $(this); buat_modal('modalnya-bro'); var b = opsi_extra[ $(this).attr('data-tombol-id') ] ; 
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title ">Detail Pergerakan :  <span class="label label-info">( '+b.code+' )</span> '+ b.nama +' </h4><p></p><p style="text-align:center;"> Dari tanggal : '+ opsi_extra.tgl_mulai +' Sampai Dengan : '+ opsi_extra.tgl_akhir +'</p>' );
				$('#modalnya-bro .modal-body').html('<div style="text-align:center;"><img src="'+helmi.asset+'loading.gif"  /></div>');
				$('#modalnya-bro .modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				$.ajax({
					url:helmi.current+'ajax',type:'POST',data:{controller:helmi.controller,mode:'detail',code:b.code,tgl_mulai:opsi_extra.tgl_mulai,tgl_akhir:opsi_extra.tgl_akhir},dateType:'json'
					,success:function(b){
						if(b.berhasil){
							var c='',cc=0;
							$.each(b.berhasil ,function(k,v){
								c += '<tr><td>'+(++cc)+'</td><td>'+v.tanggal_e+'</td><td>'+v.pendapatan+'</td><td>'+v.pengeluaran+'</td></tr>';
							});
							c = '<div class="table-responsive"><table class="table"><thead><tr><th>No</th><th>Tanggal</th><th>Penjualan (-) </th><th>Pembelian (+)</th></tr></thead><tbody>'+c+'</tbody></table></div><p>*** Detail Pergerakan Maksimal menampilkan untuk 50 hari , jadi batasi range tanggal laporan barang anda .</p>';
							$('#modalnya-bro .modal-body').html(c);
							$('#modalnya-bro').modal('handleUpdate');
						}
					}
				});
				break;
			case 'view':
				if(typeof $(this).attr('data-tombol-id') !== 'undefined' ){
					buat_modal('modalnya-bro'); 
					$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Detail informasi dari <span class="label label-info">'+ $(this).attr('data-tombol-id') +' </span></h4>');
					$('#modalnya-bro .modal-body').html('<div style="text-align:center; min-height:150px;"><img src="'+helmi.asset+'loading.gif" /></div>');
					$('#modalnya-bro .modal-footer').html(' <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
					$('#modalnya-bro').modal({show:true});
					$.ajax({
						url:helmi.current+'ajax',type:'POST',data:{mode:'detail',code: $(this).attr('data-tombol-id') ,controller:'data-barang' },dataType:'json'
						,success:function(data){
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
			case 'simpan-modal':
				$('#modalnya-bro form').trigger('submit');
				break; 
			default: break;
		}
	});
	
	
	
	$(document).on('submit','#modalnya-bro form',function(e){
		e.preventDefault(); 
	});
	
});