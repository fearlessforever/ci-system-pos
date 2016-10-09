<link type="image/x-icon" href="<?php echo $asset; ?>/favicon.png" rel="shortcut icon"/>
<div class="row" style="min-height:750px;">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li class="active"><span>Data Ukuran</span></li>
				</ol>
			<h1>Ukuran dari Barang / Jasa</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 main-box"> 
				<header class="main-box-header clearfix">
					<h2 class="pull-left">Ukuran / Size</h2>
					<div class="filter-block pull-right">
						<div class="form-group pull-left">
							<input type="text" class="form-control" placeholder="Search..."><i class="fa fa-search search-icon"></i>
						</div>
					<a href="#" class="btn btn-primary pull-right" data-tombol="tambah">
						<i class="fa fa-plus-circle fa-lg"></i> Tambah Ukuran
					</a>
					</div>
				</header>
				<div id="tempat-total-table" class="main-box-body clearfix"></div>
				<div class="main-box-body"><div id="tempat-table-crud"><div style="text-align:center; min-height:150px;"><img src="<?php echo $asset; ?>loading.gif" /></div></div></div> 
			</div>
		</div>
		
		
</div></div>
<script>
var __list_crud='';
helmi.controller ='<?php echo isset($__controller)?$__controller:''; ?>';
loadCSS("<?php echo $asset ?>plugins/datatables/css/datatables.css");
loadJS([
	"<?php echo $asset ?>plugins/datatables/js/jquery.dataTables.min.js"
	,"<?php echo $asset ?>plugins/datatables/js/dataTables.bootstrap.min.js"
],'<?php echo $asset ?>js/ukuran.js','content-wrapper');

</script>