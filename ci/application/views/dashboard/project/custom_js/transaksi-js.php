<?php
/*$( "#exampleInputEmail1" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
            //dataType: "json",
            type : 'Get',
            url: '<?php echo $home?>user/ajax/autocomplete',
            success: function(data) {
              $('#exampleInputEmail1').removeClass('ui-autocomplete-loading');  // hide loading image

            response( $.map( data, function(item) {
                // your operation on data
            }));
          },
          error: function(data) {
              $('#exampleInputEmail1').removeClass('ui-autocomplete-loading');  
          }
        });
      },
      minLength: 3,
      /*open: function() {

      },
      close: function() {

      },
      focus:function(event,ui) {

      },
      select: function( event, ui ) {
			
      }
    });*/

/*
source: function( request, response ) {
    $.ajax({
        url: "fill_id.php",
        data: {term: request.term},
        dataType: "json",
        success: function( data ) {
            response( $.map( data.myData, function( item ) {
                return {
                    label: item.title,
                    value: item.turninId
                }
            }));
        }
    });
}

source: function( request, response ) {
        $.ajax({
            //dataType: "json",
            type : 'Get',
            url: '<?php echo $home?>user/ajax/autocomplete',
            success: function(data) {
              $('#namaBarangT').removeClass('ui-autocomplete-loading');  // hide loading image
			  response( $.map( data, function(item) {
				alert( item.nama );
				}));
          },
          error: function(data) {
              $('#namaBarangT').removeClass('ui-autocomplete-loading');  
          }
        });
      },
*/
?>
$(function() {
function log( message ) {
$( "<div>" ).text( message ).prependTo( "#log" );
$( "#log" ).scrollTop( 0 );
}
function tuliskode( kodeb  ){
	$( "input#kodeBarangT" ).val( kodeb.kode );
	$('div.profile-box-header').html( '<img class="barang-img img-responsive center-block" src="'+kodeb.gambar +'" /><h2>'+ kodeb.label +'</h2><div class="job-position">'+ kodeb.tipe +'</div>');
	$('div.profile-box-footer').html('<a href="#"><span class="value">'+ kodeb.jml +'</span> <span class="label">Stock</span> </a><a href="#"><span class="value">'+ kodeb.harga +'</span> <span class="label">Harga</span> </a>');
}
$( "#namaBarangT" ).autocomplete({
	source: "<?php echo $home?>user/ajax/autocomplete?by=name",
	select:function(event, ui) {
            var url = ui.item;
			tuliskode( url);  $('.jml-beli').fadeIn("slow");
			$('input#hargabarang').val( ui.item.harga );
			$('input#namabarang').val( ui.item.value );
			$('input#jumlahbarang').focus();
        },
	minLength: 2/*,
	select: function( event, ui ) {
		log( ui.item ?
		"Selected: " + ui.item.value + " aka " + ui.item.id :
		"Nothing selected, input was " + this.value );
		}*/
});
$( "#kodeBarangT" ).autocomplete({
	source: "<?php echo $home?>user/ajax/autocomplete?by=code",
	select:function(event, ui) {
            var url = ui.item.kode,gambar =  ui.item.gambar;
			tuliskode( url , gambar);
			$('input#jumlahbarang').focus();
        },
	minLength: 2
});


});
var jml_id_belanja =0; var total_belanja = 0

$('input#jumlahbarang').keypress(function(e){
	if(e.keyCode == 13){
	var jml_belanja = $('input#jumlahbarang').val();
	var _harga = $('input#hargabarang').val(), _nama = $('input#namabarang').val();
	if( jml_belanja > 0 && _harga > 0){
	var _total_blnja = jml_belanja * _harga;
	total_belanja += _total_blnja;
	$('div.jml-belanja').html( 'Total Belanja : <span class="label label-danger">'+ total_belanja +'</span>' );
	//$('.table-responsive').fadeOut("slow" );
	$('div#pembelian').fadeIn("slow" );  jml_id_belanja +=  1;
	$('#tabelpembelian').append('<tr class="transaksi_'+ jml_id_belanja +'"> <td> <a href="#">#'+ jml_id_belanja +'</a> </td> <td> '+ jml_belanja +' </td> <td> <a href="#">'+ _nama +'</a> </td> <td class="text-center"> <span class="label label-success transaksi_'+ jml_id_belanja +'">'+ _total_blnja +'</span> </td> <td class="text-right"> &dollar; '+ _harga +' </td> <td class="text-center" style="width: 15%;"> <a href="#" onClick="hapus_transaksi( \'transaksi_'+ jml_id_belanja +'\')" class="table-link"> <span class="fa-stack"> <i class="fa fa-square fa-stack-2x"></i> <i class="fa fa-search-plus fa-stack-1x fa-inverse"></i> </span> </a> </td> </tr>');
	}
	}
});   
function hapus_transaksi( id ){
	var idnya='tr.'+id,kurang=0;
	var spa_ny ='span.'+id;
	var tes = $(spa_ny).text();
	if(tes > 0 && total_belanja > 0){
		total_belanja -= tes;
		$('div.jml-belanja').html( 'Total Belanja : <span class="label label-danger">'+ total_belanja +'</span>' );
		$(idnya).remove();
	}
}
$('a.pembayaran').click(function(){
	var tes = $('input#pembayaran').val(),kembalian;
	if(tes > 0 && total_belanja > 0){
		if(tes < total_belanja)alert('Maaf ... jumlah pembayaran kurang dari total perbelanjaan');
		else{
			kembalian = tes - total_belanja;
			alert('Terima Kasih Sudah berbelanja Di Sini \n Lebih pembayaran '+kembalian);
		}
	}
});

$('.infographic-box .value .timer').countTo({});