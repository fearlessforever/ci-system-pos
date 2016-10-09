<link type="image/x-icon" href="<?php echo $asset; ?>/favicon.png" rel="shortcut icon"/>
<style>
<!--
.total_jml { width:100%; margin-top:5px; float:left; font-size:27px; font-weight:bold; text-align:right; background-color:#000; color:#FF0; padding:10px ; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; -moz-box-shadow:0px 0px 3px #aaa; -webkit-box-shadow:0px 0px 3px #aaa; box-shadow:0px 0px 3px #aaa; font-family:"Courier New", Courier, monospace; }
-->
</style>
<div class="row" style="min-height:750px;">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Laporan</a></li>
					<li class="active"><span>List Nota </span></li>
				</ol>
			<h1>Nota Transaksi Pendapatan & Pengeluaran</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 main-box"> 
				<header class="main-box-header clearfix">
					<h2 class="pull-left">List Nota Yang Ada </h2>
					<!-- <div class="filter-block pull-right">
						<a href="#" class="btn btn-primary pull-right" data-tombol="tambah"> <i class="fa fa-plus-circle fa-lg"></i> Tambah Retur </a>
					</div> -->
				</header>
				<div class="main-box-body">
					<p> Tampilkan List 
						<div class="form-inline "> 
						<div class="form-group"><label> Dari : </label> <input placeholder="Tanggal Mulai" class="form-control" type="text" name="tgl_mulai" data-tombol="tanggal-list" />  </div>
						<div class="form-group"><label> Sampai : </label> <input placeholder="Tanggal Akhir" class="form-control" type="text" name="tgl_akhir" data-tombol="tanggal-list" /> </div>
						<button class="btn btn-success" data-tombol="get-list">GET</button>
						</div>
					</p>
					<p>Halaman ini menampilkan nota terbaru tanpa pilihan tampilan List berdasarkan Tanggal</p>
				</div>
				<div id="tempat-total-table" class="main-box-body clearfix"></div>
				<div class="main-box-body"><div id="tempat-table-crud" class="table-responsive"><div style="text-align:center; min-height:150px;"><img src="<?php echo $asset; ?>loading.gif" /></div></div> </div> 
			</div>
		</div>
		
		
</div></div>
<script>
var __list_crud='';
helmi.controller ='<?php echo isset($__controller)?$__controller:''; ?>';

loadCSS("<?php echo $asset ?>plugins/jquery-ui/css/jquery-ui-1.10.4.min.css");
loadCSS("<?php echo $asset ?>plugins/datatables/css/datatables.css");
//loadCSS("<?php echo $asset ?>plugins/datatables/css/dataTables.fixedHeader.css");
//loadCSS("<?php echo $asset ?>plugins/datatables/css/dataTables.tableTools.css");
loadJS([
	"<?php echo $asset ?>plugins/datatables/js/jquery.dataTables.min.js"
	,"<?php echo $asset ?>plugins/datatables/js/dataTables.bootstrap.min.js"
	,"<?php echo $asset ?>plugins/jquery-ui/js/jquery-ui-1.10.4.min.js"
],'<?php echo $asset ?>js/nota-list.js','content-wrapper');


</script>