<link type="image/x-icon" href="<?php echo $asset; ?>/favicon.png" rel="shortcut icon"/>
<div class="row" style="min-height:750px;">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li class="active"><span>Gambar dari Barang / Jasa</span></li>
				</ol>
			<h1>Daftar Gambar Telah Disimpan</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 main-box"> 
				<header class="main-box-header clearfix">
					<h2 class="pull-left">Barang / Jasa </h2>
					<div class="filter-block pull-right">
					<a href="#" class="btn btn-primary pull-right" data-tombol="tambah">
						<i class="fa fa-plus-circle fa-lg"></i> Tambah Gambar Barang / Jasa
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
loadCSS("<?php echo $asset ?>plugins/datatables/css/datatables.css");

loadJS([
	"<?php echo $asset ?>plugins/datatables/js/jquery.dataTables.min.js"
	,"<?php echo $asset ?>plugins/datatables/js/dataTables.bootstrap.min.js"
],'<?php echo $asset ?>js/barang-image.js','content-wrapper');
/* 
//loadCSS("<?php echo $asset ?>plugins/jquery-ui/css/jquery-ui-1.10.4.min.css");
loadCSS("<?php echo $asset ?>plugins/plupload/jquery.ui.plupload/css/jquery.ui.plupload.css");
loadCSS("<?php echo $asset ?>plugins/datatables/css/datatables.css");
//loadCSS("<?php echo $asset ?>plugins/datatables/css/dataTables.fixedHeader.css");
//loadCSS("<?php echo $asset ?>plugins/datatables/css/dataTables.tableTools.css");
loadJS([
	"<?php echo $asset ?>plugins/plupload/plupload.full.min.js"
	,"<?php echo $asset ?>plugins/jquery-ui/js/jquery-ui-1.10.4.min.js"
	,
	"<?php echo $asset ?>plugins/datatables/js/jquery.dataTables.min.js"
	,"<?php echo $asset ?>plugins/datatables/js/dataTables.bootstrap.min.js"
	
],'','content-wrapper');

$(document).ready(function(){
	

	var test =window.location.href.split('/member-area/')[0];
	$("#uploader").plupload({
		// General settings
		runtimes : 'html5,flash,silverlight,html4',
		url :  helmi.current+'ajax',
		file_data_name : 'tgpinang',

		// User can upload no more then 20 files in one go (sets multiple_queues to false)
		max_file_count: 3,
		
		chunk_size: '1mb',

		// Resize images on clientside if we can
		resize : {
			width : 1000, 
			//height : 200, 
			//quality : 90,
			//crop: true // crop to exact dimensions
		},
		
		filters : {
			// Maximum file size
			max_file_size : '10mb',
			// Specify what files to browse for
			mime_types: [
				{title : "Image files", extensions : "jpg,gif,png"} 
			]
		},

		// Rename files by clicking on their titles
		rename: true,
		
		// Sort files
		sortable: true,

		// Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
		dragdrop: true,

		// Views to activate
		views: {
			list: true,
			thumbs: true, // Show thumbs
			active: 'thumbs'
		},

		// Flash settings
		flash_swf_url : '../plugins/plupload/Moxie.swf',

		// Silverlight settings
		silverlight_xap_url : '../plugins/plupload/Moxie.xap'
	});
}); */

</script>