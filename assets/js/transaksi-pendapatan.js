var __ajax_p=false,opsi_extra=[];
$(document).off('click','[data-tombol]');
$(document).off('submit','#modalnya-bro form'); $('#transaksi input').off();
opsi_extra.select =false;
opsi_extra.id_itung =0;
opsi_extra.total =0;
opsi_extra.list =[];

$(document).ready(function() {
	$(document).on('click','[data-tombol]',function(e){
		e.preventDefault();
		switch($(this).attr('data-tombol')){
			case 'tambah' :
				buat_modal('modalnya-bro');
				$('#modalnya-bro .modal-header').html('<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Tambah Gambar dari Barang / Jasa</h4>');
				$('#modalnya-bro .modal-body').html('<form role="form"><div class="form-inline form-inline-box"><div class="form-group"><label >Pilih Id Barang </label> <select class="form-control pilihan-barang" name="code"><option value="1">-</option></select></div> <label class="btn btn-success" data-tombol="load-select" data-s="barang"> Pilihan Lain <i class="fa fa-history"></i></label></div> <input type="hidden" name="mode" value="upload_barang_t"> <input type="hidden" name="controller" value="'+helmi.controller+'" /> </form>');
				$('#modalnya-bro .modal-footer').html('<button class="btn btn-info" data-tombol="simpan-modal">Simpan</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
				$('#modalnya-bro').modal({show:true});
				break;
			case 'hapus':
				var a = $(this).parents('tr');
				if(typeof a.attr('data-view') !== 'undefined'){
					if(typeof opsi_extra.list[ a.attr('data-view') ] !== 'undefined' ){
						var b = opsi_extra.list[ a.attr('data-view') ] ;
						opsi_extra.list.splice( a.attr('data-view') , 1);
						
						opsi_extra.total -= b.total_harga;
						$('div.total_jml label').html( 'Total : Rp. '+ opsi_extra.total.nomornya(0,3,'.') +',- ' );
						a.remove();
						//alert(  JSON.stringify(opsi_extra.list) ); // JSON.stringify(opsi_extra.list)
					}
					
				}
				break;
			case 'reset-pembayaran':
				opsi_extra.select =false;
				opsi_extra.id_itung =0;
				opsi_extra.total =0;
				opsi_extra.list =[]; $('#transaksi input').val('').removeAttr('disabled');
				$('div.total_jml label').html( 'Rp. 0,-' );
				$('#tabelpembelian tbody').html('');$('#log-nota').html('');
				break;
			case 'simpan-bayar':
				//var a=$(this);
				var tes = $('input#pembayaran').val(),kembalian;
				if(tes > 0 && opsi_extra.total > 0){
					if(tes < opsi_extra.total){
					var b = opsi_extra.total - tes ;
						helmi.form_e($('input#pembayaran') , 'Jumlah pembayaran kurang ~ '+ b.nomornya(0,3,'.') );
					}
					else{
						tes = parseInt(tes);
						kembalian = tes - opsi_extra.total;
						helmi.form_o($('input#pembayaran') );
						$.ajax({
							url:helmi.current+'ajax',type:'POST',dataType:'json'
							,data:{'mode':'okelah','controller':helmi.controller,'list':JSON.stringify(opsi_extra.list),'bayar':tes,'kembali':kembalian,total:opsi_extra.total},
							success:function(data){
								if(data.berhasil){
									$('#log-nota').append('<h1><div class="alert alert-success"><strong>Success : </strong> <a target="_blank" href="'+helmi.home+'print-nota/'+data.berhasil.nota+'/'+data.berhasil.tanggal +'"> Nota '+data.berhasil.nota+' Tanggal '+data.berhasil.tanggal+' </a></div></h1>');
									//a.parents('header')
									$('#log-nota').append('<div ><button class="btn btn-danger" data-tombol="reset-pembayaran">RESET</button></div>');
									$('#transaksi input').attr('disabled','disabled');
									opsi_extra.total =0;
								}else if(data.error){
									$('#log-nota').append('<h1><div class="alert alert-danger"><strong>ERROR : </strong> '+data.error+' <button class="close" data-dismiss="alert">&times</button></div></h1>');
								}
							}
						});
						$('div.total_jml label').html( 'Total : Rp. '+ opsi_extra.total.nomornya(0,3,'.') +',- <br/> Bayar : Rp. '+tes.nomornya(0,3,'.')+',- <hr> Kembali : Rp. '+kembalian.nomornya(0,3,'.')+',-' );
					}
				}else{
					helmi.form_e($('input#pembayaran') , 'Input ini harus berupa Angka Dan Total Pembayaran tidak boleh ~ 0');
				}
				break;
			default: break;
		}
	});
	
	$( "#transaksi input#nama_barang" ).autocomplete({
		source:function(a,b){
			$.ajax({
				url:helmi.current+'ajax',type:'POST',dataType:'json',data:{controller:'data-barang',code:a.term,mode:'autocomplete'}
				,success:function(data){
					if(data.berhasil){
						$.each(data.berhasil ,function(k,v){
							v.label=v.nama;
						});
						b(data.berhasil);
					}
				}
			});
		},
		select:function(event, ui) {
				var url = ui.item;
				$("#transaksi input#code").val( url.id_barang );
				$('#transaksi div.profile-box-header').html( ( (typeof url.gambar_fol !== 'undefined' && url.gambar_fol)? '<img class="barang-img img-responsive center-block" src="'+helmi.asset+url.gambar_fol+url.gambar_fil +'" /><h2>' : '' ) + url.label +'</h2><div class="job-position">Tipe : '+ url.tipe_k +'</div>');
				$('#transaksi div.profile-box-footer').html('<a href="#"><span class="value">'+ url.jumlah +'</span> <span class="label">Stock</span> </a><a href="#"><span class="value">'+ url.harga +'</span> <span class="label">Harga</span> </a><a href="#"><span class="value">'+ url.satuan_k +'</span> <span class="label">Satuan</span> </a><a href="#"><span class="value">'+ url.ukuran_k +'</span> <span class="label">Ukuran</span> </a><a href="#"><span class="value">'+ url.supplier_n +'</span> <span class="label">Supplier</span> </a>');
				$('.jml-beli').fadeIn("slow");
				opsi_extra.select = url;
				$('#transaksi input#jumlahbarang').focus();
			},
		minLength: 3
	});
	$( "#transaksi input#code" ).autocomplete({
		source:function(a,b){
			$.ajax({
				url:helmi.current+'ajax',type:'POST',dataType:'json',data:{controller:'data-barang',code:a.term,mode:'detail'}
				,success:function(data){
					if(data.berhasil){
						data.berhasil.label = data.berhasil.id_barang;
						b( [data.berhasil] );
					}
				}
			});
		},
		select:function(event, ui) {
				var url = ui.item;
				$("#transaksi input#nama_barang").val( url.nama );
				//$("#transaksi input#code").val( url.id_barang );
				$('#transaksi div.profile-box-header').html( ( (typeof url.gambar_fol !== 'undefined' && url.gambar_fol)? '<img class="barang-img img-responsive center-block" src="'+helmi.asset+url.gambar_fol+url.gambar_fil +'" /><h2>' : '' ) + url.label +'</h2><div class="job-position">Tipe : '+ url.tipe_k +'</div>');
				$('#transaksi div.profile-box-footer').html('<a href="#"><span class="value">'+ url.jumlah +'</span> <span class="label">Stock</span> </a><a href="#"><span class="value">'+ url.harga +'</span> <span class="label">Harga</span> </a><a href="#"><span class="value">'+ url.satuan_k +'</span> <span class="label">Satuan</span> </a><a href="#"><span class="value">'+ url.ukuran_k +'</span> <span class="label">Ukuran</span> </a><a href="#"><span class="value">'+ url.supplier_n +'</span> <span class="label">Supplier</span> </a>');
				$('.jml-beli').fadeIn("slow");
				opsi_extra.select = url;
				$('#transaksi input#jumlahbarang').focus();
			},
		minLength: 2
	});
	
	//
	
	$('#transaksi input#jumlahbarang').keypress(function(e){
		if(e.keyCode == 13 && (typeof opsi_extra.select !== 'undefined') && opsi_extra.select != null ){
			var jml_belanja = $('input#jumlahbarang').val();
			var _harga = opsi_extra.select.harga,_nama = opsi_extra.select.nama;
			if( jml_belanja > 0 && _harga > 0){
			var _total_blnja = jml_belanja * _harga;
			opsi_extra.total += _total_blnja;
			//$('div.jml-belanja').html( 'Total Belanja : <span class="label label-danger">Rp. '+ opsi_extra.total.nomornya(0,3,'.') +',-</span>' );
			$('div.total_jml label').html( 'Total : Rp. '+ opsi_extra.total.nomornya(0,3,'.') +',- ' );
			//$('.table-responsive').fadeOut("slow" );
			$('div#pembelian').fadeIn("slow" );  
			var b = {};
			b.total_harga = _total_blnja ; b.id_barang = opsi_extra.select.id_barang ; b.harga = opsi_extra.select.harga ; b.total = jml_belanja ;
			opsi_extra.list[ opsi_extra.id_itung ]=b;
			//b = JSON.stringify(b) ; b = helmi.amankan(b);
			$('#tabelpembelian').append('<tr data-view="'+opsi_extra.id_itung+'"> <td> <a href="#">#'+ (opsi_extra.id_itung+1) +'</a> </td><td> <a href="#">'+ _nama +'</a> </td> <td> '+ jml_belanja +' </td> <td class="text-right">'+ _harga +' </td><td class="text-center"><span class="label label-success">'+ _total_blnja.nomornya(0,3,'.') +'</span></td><td class="text-center" style="width: 15%;"> <span data-tombol="hapus" class="btn btn-danger">Batal <i class="fa fa-joomla"></i></span> </td> </tr>');
			opsi_extra.id_itung +=  1;
			opsi_extra.select=null;
			}
			$('#transaksi form').find('input[type="text"]').each(function(){$(this).val('');});
			$(this).val(1); $('.jml-beli').fadeOut("slow");
		}
	});

});



$('.infographic-box .value .timer').countTo({});