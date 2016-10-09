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
				var a = $(this).parents('#laporan') , b=true , c={};
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
				c.retur = a.find('input[name="retur"]').is(':checked') ;
				$.ajax({url:helmi.current+'ajax',type:'POST',data:c
					,beforeSend:function(){
						$('#tempat-table-crud').html('<div style="text-align:center; min-height:150px;"><img src="'+ helmi.asset +'loading.gif" /></div>');
					},success:function(data){ 
						if(data.berhasil){
							var b =data.berhasil;
							b.pendapatan = parseInt(b.pendapatan); b.pengeluaran = parseInt(b.pengeluaran);
							var hasil = b.pendapatan - b.pengeluaran ;
							var c= '<div style="text-align:center;"><h1>Laporan Laba / Rugi </h1> <span class="label label-info">Dari Tanggal '+ b.tgl_mulai +' ~ '+ b.tgl_akhir +' </span></div>';
							c += '<br><div class="table-responsive"><table class="table table-bordered"><thead><tr><th>Keterangan</th><th>Pengeluaran</th><th>Pendapatan</th></tr></thead><tbody><tr><td>Total Pendapatan ( '+b.trans_pendapatan+' transaksi ) </td><td> - </td><td> Rp. '+ b.pendapatan.nomornya(0,3,'.') +',-</td></tr><tr><td>Total Pengeluaran ( '+b.trans_pengeluaran+' transaksi ) </td><td> Rp. '+ b.pengeluaran.nomornya(0,3,'.') +',- </td><td> - </td></tr></tbody></table></div><div ><label class="total_jml"> Pendapatan : Rp. '+ b.pendapatan.nomornya(0,3,'.') +',- <br> Pengeluaran : Rp. '+ b.pengeluaran.nomornya(0,3,'.') +',- <hr/> '+(hasil > 1 ? '<span class="label label-success">Laba</span> ' : '<span class="label label-danger">Rugi</span> ' )+' : Rp. '+ hasil.nomornya(0,3,'.') +',- </label></div> ';
							$('#tempat-table-crud').html(c);  
						}
						else{
							$('#tempat-table-crud').html(' <h3> Data Tidak Ditemukan </h3> '); 
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
			default: break;
		}
	});
	
	
	
	$(document).on('submit','#modalnya-bro form',function(e){
		e.preventDefault(); 
	});
	
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