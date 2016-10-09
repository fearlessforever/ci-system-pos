<link type="image/x-icon" href="<?php echo $asset; ?>/favicon.png" rel="shortcut icon"/>
<style>
<!--
.total_jml {
	width:100%;
	margin-top:5px;
	float:left;
	font-size:50px;
	font-weight:bold;
	text-align:right;
	background-color:#000;
	color:#FF0;
	padding:10px ;
	-moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
	-moz-box-shadow:0px 0px 3px #aaa;
    -webkit-box-shadow:0px 0px 3px #aaa;
    box-shadow:0px 0px 3px #aaa;
	font-family:"Courier New", Courier, monospace;
}
-->
</style>
<script>
	var jml_id_belanja =0; var total_belanja = 0;
	
	loadCSS("<?php echo $asset ?>plugins/jquery-ui/css/jquery-ui-1.10.4.min.css");
	//loadCSS("<?php echo $asset ?>/real/plugins/jquery-ui/css/jquery-ui-1.10.4.min.css");
	//loadCSS("<?php echo $asset ?>/real/plugins/morris/css/morris.css");
	//loadCSS("<?php echo $asset ?>/real/plugins/jvectormap/css/jquery-jvectormap-1.2.2.css");
	//loadCSS("<?php echo $asset ?>/real/plugins/daterangepicker/css/daterangepicker-bs3.css");
	
	var requireJS = [
		"<?php echo $asset ?>sentor/js/jquery.countTo.js",
		"<?php echo $asset ?>plugins/jquery-ui/js/jquery-ui-1.10.4.min.js"
	]; 
	
	loadJS(requireJS,"<?php echo $asset ?>sentor/js/jadi/transaksi.js",'content-wrapper');
	
</script>

<div class="row" style="min-height:750px;">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li class="active"><span>Transaksi</span></li>
				</ol>
			<h1>Penjualan / Pendapatan / Pemasukan</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3 col-sm-6 col-xs-12">
				<div class="main-box infographic-box">
					<i class="fa fa-user red-bg"></i>
					<span class="headline">Pembeli</span>
					<span class="value">
					<span class="timer" data-from="120" data-to="2562" data-speed="1000" data-refresh-interval="50"> 
					</span>
					</span>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6 col-xs-12">
				<div class="main-box infographic-box">
					<i class="fa fa-shopping-cart emerald-bg"></i>
					<span class="headline">Penjualan</span>
					<span class="value">
					<span class="timer" data-from="30" data-to="658" data-speed="800" data-refresh-interval="30"> 
					</span>
					</span>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6 col-xs-12">
				<div class="main-box infographic-box">
					<i class="fa fa-money green-bg"></i>
					<span class="headline">Pemasukan</span>
					<span class="value">
					&#36;<span class="timer" data-from="83" data-to="8400" data-speed="900" data-refresh-interval="60"> 
					</span>
					</span>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6 col-xs-12">
				<div class="main-box infographic-box">
					<i class="fa fa-eye yellow-bg"></i>
					<span class="headline">Beli Bulanan</span>
					<span class="value">
					<span class="timer" data-from="539" data-to="12526" data-speed="1100"> 
					</span>
					</span>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-4 col-sm-5 col-xs-12">
				<div class="main-box">
					<header class="main-box-header clearfix">
					<h2>Basic elements</h2>
					</header>
			<div class="main-box-body clearfix">
			<form role="form" id="transaksi">
				<div class="form-group">
				<label for="namaBarangT">Nama Barang / Jasa</label>
				<input type="text" class="form-control ui-autocomplete-input" id="namaBarangT" placeholder="auto complete">
				</div>
			<div class="form-group">
			<label for="kodeBarangT">Kode Barang / Jasa</label>
			<input type="text" class="form-control" id="kodeBarangT" placeholder="Kode Barang">
			</div>
			<div class="form-group jml-beli" style="display:none;">
				<label for="kodeBarangT">Jumlah</label>
				<input type="hidden" id="hargabarang" >
				<input type="hidden" id="namabarang" >
				<input type="text" class="form-control" id="jumlahbarang" value="1">
			</div>			
			<!--<div class="form-group">
			<label for="exampleAutocompleteSimple">Autocomplete</label>
			<input type="text" class="form-control" id="exampleAutocompleteSimple" placeholder="countries">
			</div>
				<div class="form-group example-twitter-oss">
				<label for="exampleAutocomplete">Autocomplete with templating</label>
				<input type="text" class="form-control" id="exampleAutocomplete" placeholder="open source projects by Twitter">
				</div>
			<div class="form-group">
			<label for="examplePwdMeter">Password strength meter (start typing...)</label>
			<input type="password" class="form-control" id="examplePwdMeter" placeholder="Enter password" data-indicator="pwindicator">
			<div id="pwindicator" class="pwdindicator">
			<div class="bar"></div>
			<div class="pwdstrength-label"></div>
			</div>-->
			</div>
			</form> 
				</div>
			</div>
			<div class="col-md-8 col-sm-7 col-xs-12">
				<div class="tabs-wrapper tabs-no-header">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#tab-preview">Preview</a></li>
						<li><a data-toggle="tab" href="#tab-detail-list">Detail List</a></li>
					</ul>
					<div class="tab-content tab-content-body clearfix">
						<div id="tab-preview" class="tab-pane fade in active">
						<div class="total_jml" style="margin:0px 0px 10px 0px;"> <label >Rp. 0,-</label> </div>
							<div class="main-box clearfix profile-box">
								<div class="main-box-body clearfix">
									<div class="profile-box-header">
										<img src="<?php echo $asset ?>sentor/img/samples/tahiti-3.jpg" alt="" class="barang-img img-responsive center-block"/>
										<h2>No Data</h2>
									<div class="job-position">
										No Data
									</div>
									</div>
								<div class="profile-box-footer clearfix">
									<a href="#">
									<span class="value">854</span>
									<span class="label">Followers</span>
									</a>
									<a href="#">
									<span class="value">72</span>
									<span class="label">Following</span>
									</a>
									<a href="#">
									<span class="value">128</span>
									<span class="label">Friends</span>
									</a>
								</div>
							</div>
							</div>
						</div>
						<div id="tab-detail-list" class="tab-pane fade">
							<header class="main-box-header clearfix">
								<h2 class="pull-left">Daftar Pendapatan</h2>
							<div class="filter-block pull-right">
								<div class="form-group pull-left">
									<input id="pembayaran" type="text" class="form-control" placeholder="Pembayaran...">
									<i class="fa fa-search search-icon"></i>
								</div>
							<a href="#" class="btn btn-primary pull-right pembayaran">
								<i class="fa fa-eye fa-lg"></i> Cetak
							</a> 
							<div class="jml-belanja pull-right filter-block"></div>
							</div>
							</header>
							<div class="main-box ">
							<div class="main-box-body clearfix">
								<div class="table-responsive clearfix">
								<table id="tabelpembelian" class="table table-hover">
									<thead>
									<tr>
										<th><a href="#"><span>Order ID</span></a></th>
										<th><a href="#" class="desc"><span>Jumlah Barang</span></a></th>
										<th><a href="#" class="asc"><span>Nama Barang</span></a></th>
										<th class="text-right"><span>Harga Satuan</span></th>
										<th class="text-center"><span>Harga Akumulasi</span></th>
										<th>Batal</th>
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
				
			</div></div>
		</div> 
				
	</div>
</div>