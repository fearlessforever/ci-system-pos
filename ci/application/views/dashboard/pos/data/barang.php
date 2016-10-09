<link type="image/x-icon" href="<?php echo $asset; ?>/favicon.png" rel="shortcut icon"/>
<div class="row" style="min-height:750px;">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li class="active"><span>Data Barang / Jasa</span></li>
				</ol>
			<h1>Daftar Barang Yang Telah Disimpan</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 main-box"> 
				<header class="main-box-header clearfix">
					<h2 class="pull-left">Barang / Jasa </h2>
					<div class="filter-block pull-right">
					<a href="#" class="btn btn-primary pull-right" data-tombol="tambah">
						<i class="fa fa-plus-circle fa-lg"></i> Tambah Barang / Jasa
					</a>
					</div>
				</header>
				<div id="tempat-total-table" class="main-box-body clearfix"></div>
				<div class="main-box-body"><div id="tempat-table-crud" class="table-responsive"><div style="text-align:center; min-height:150px;"><img src="<?php echo $asset; ?>loading.gif" /></div></div> </div>
			</div>
		</div>
		
	</div>
</div>
<script>
var __list_crud='';
helmi.controller ='<?php echo isset($__controller)?$__controller:''; ?>';

//loadCSS("<?php echo $asset ?>plugins/jquery-ui/css/jquery-ui-1.10.4.min.css");
//loadCSS("<?php echo $asset ?>plugins/plupload/jquery.ui.plupload/css/jquery.ui.plupload.css");
loadCSS("<?php echo $asset ?>plugins/datatables/css/datatables.css");
//loadCSS("<?php echo $asset ?>plugins/datatables/css/dataTables.fixedHeader.css");
//loadCSS("<?php echo $asset ?>plugins/datatables/css/dataTables.tableTools.css");
loadJS([
	"<?php echo $asset ?>plugins/datatables/js/jquery.dataTables.min.js"
	,"<?php echo $asset ?>plugins/datatables/js/dataTables.bootstrap.min.js"
	//,"<?php echo $asset ?>plugins/plupload/plupload.full.min.js"
	//,"<?php echo $asset ?>plugins/jquery-ui/js/jquery-ui-1.10.4.min.js"
],'<?php echo $asset ?>js/barang.js','content-wrapper');

</script>