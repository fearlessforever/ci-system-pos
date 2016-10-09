<link type="image/x-icon" href="<?php echo $asset; ?>/favicon.png" rel="shortcut icon"/>
<style>
<!--
.total_jml { width:100%; margin-top:5px; float:left; font-size:50px; font-weight:bold; text-align:right; background-color:#000; color:#FF0; padding:10px ; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; -moz-box-shadow:0px 0px 3px #aaa; -webkit-box-shadow:0px 0px 3px #aaa; box-shadow:0px 0px 3px #aaa; font-family:"Courier New", Courier, monospace; }
-->
</style>
<script>
helmi.controller ='<?php echo isset($__controller)?$__controller:''; ?>';
	//var jml_id_belanja =0; var total_belanja = 0;
	
	loadCSS("<?php echo $asset ?>plugins/jquery-ui/css/jquery-ui-1.10.4.min.css");
	//loadCSS("<?php echo $asset ?>/real/plugins/jquery-ui/css/jquery-ui-1.10.4.min.css");
	//loadCSS("<?php echo $asset ?>/real/plugins/morris/css/morris.css");
	//loadCSS("<?php echo $asset ?>/real/plugins/jvectormap/css/jquery-jvectormap-1.2.2.css");
	//loadCSS("<?php echo $asset ?>/real/plugins/daterangepicker/css/daterangepicker-bs3.css");
	
	var requireJS = [
		"<?php echo $asset ?>sentor/js/jquery.countTo.js",
		"<?php echo $asset ?>plugins/jquery-ui/js/jquery-ui-1.10.4.min.js"
	]; 
	
	loadJS(requireJS,"<?php echo $asset ?>js/transaksi-pendapatan.js",'content-wrapper');
	
</script>

<div class="row" style="min-height:750px;">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li ><span>Transaksi</span></li>
					<li class="active"><span>Penjualan / Pendapatan / Pemasukan</span></li>
				</ol>
			<!-- <h1>Penjualan / Pendapatan / Pemasukan</h1> -->
			</div>
		</div> 
		
		<div class="row">
			
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="tabs-wrapper tabs-no-header">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#tab-preview">Preview</a></li>
						<li><a data-toggle="tab" href="#tab-detail-list">Detail List</a></li>
					</ul>
					<div class="tab-content tab-content-body clearfix"  id="transaksi">
						<div id="tab-preview" class="tab-pane fade in active">
			
			<div class="col-md-4 col-sm-5 col-xs-12">
				<div class="main-box ">
					<header class="main-box-header clearfix"> <h2>Pendapatan / Penjualan</h2> </header>
			<div class="main-box-body clearfix">
				<form role="form">
					<div class="form-group">
						<label for="namaBarangT">Nama Barang / Jasa</label>
						<input type="text" class="form-control ui-autocomplete-input" id="nama_barang" placeholder="Ketik Nama Barang">
					</div>
					<div class="form-group">
						<label for="kodeBarangT">Kode Barang / Jasa</label>
						<input type="text" class="form-control" id="code" placeholder="Kode Barang">
					</div>
					<div class="form-group jml-beli" style="display:none;">
						<label for="kodeBarangT">Jumlah</label>
						<input type="text" class="form-control" id="jumlahbarang" value="1">
					</div>
				</form>
			</div>
				</div>
			</div>
			
					<div class="col-md-8 col-sm-12 col-xs-12">
						<div class="total_jml" style="margin:0px 0px 10px 0px;">
							<label >Rp. 0,-</label>
						</div>
						<div class="main-box clearfix profile-box">
							<div class="main-box-body clearfix">
								<div class="profile-box-header">
									<img src="<?php echo $asset ?>sentor/img/samples/tahiti-3.jpg" alt="" class="barang-img img-responsive center-block"/>
									<h2>No Data</h2>
								<div class="job-position"> No Data </div>
								</div>
								<div class="profile-box-footer clearfix">
									<a href="#"> <span class="value">0</span> <span class="label">No Data</span> </a>
									<a href="#"> <span class="value">0</span> <span class="label">No Data</span> </a>
									<a href="#"> <span class="value">0</span> <span class="label">No Data</span> </a>
								</div>
							</div>
							</div>
					</div>
					
						</div>
						<div id="tab-detail-list" class="tab-pane fade">
							<header class="main-box-header clearfix">
								<div class="total_jml" style="margin:0px 0px 10px 0px;"> <label >Rp. 0,-</label> </div>
							<div class="filter-block pull-right">
								<div class="form-group pull-left">
									<input id="pembayaran" type="text" class="form-control" placeholder="Pembayaran...">
									<i class="fa fa-search search-icon"></i>
								</div>
							<a href="#" class="btn btn-primary pull-right" data-tombol="simpan-bayar">
								<i class="fa fa-eye fa-lg"></i> Cetak
							</a> 
							<!-- <div class="jml-belanja pull-right filter-block">Total Belanja : <span class="label label-danger">Rp. 0,-</span></div> -->
							</div>
							<div id="log-nota"></div>
							</header>
							<div class="main-box ">
							<div class="main-box-body clearfix">
								<div class="table-responsive clearfix">
								<table id="tabelpembelian" class="table table-hover">
									<thead>
									<tr>
										<th><a href="#"><span>Order ID</span></a></th>
										<th><a href="#" class="asc"><span>Nama Barang</span></a></th>
										<th><a href="#" class="desc"><span>Jumlah Barang</span></a></th>
										<th class="text-right"><span>Harga Satuan</span></th>
										<th class="text-center"><span>Harga Akumulasi</span></th>
										<th>Action</th>
									</tr>
									</thead>
									<tbody>
									
									</tbody>
								</table>
								</div>
							</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		  </div>
		</div> 
				
	</div>
</div>