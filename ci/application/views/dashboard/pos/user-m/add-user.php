<link type="image/x-icon" href="<?php echo $asset; ?>/favicon.png" rel="shortcut icon"/>
<div class="row" style="min-height:750px;">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">User Management</a></li>
					<li class="active"><span>Add User</span></li>
				</ol>
			<h1>Tambahkan User</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 main-box"> 
				<header class="main-box-header clearfix">
					<h2 class="pull-left">Menu untuk menambah User yang bisa login ke system </h2>
					<div class="filter-block pull-right">
					<a href="#" class="btn btn-primary pull-right" data-tombol="tambah">
						<i class="fa fa-plus-circle fa-lg"></i> Tambahkan User
					</a>
					</div>
				</header>
				<div class="main-box-body clearfix">
				<p> Halaman ini untuk menambah user selain ADMIN </p></div>
				<div class="main-box-body"><div id="tempat-table-crud"><div style="text-align:center; min-height:150px;"><img src="<?php echo $asset; ?>loading.gif" /></div></div> </div> 
			</div>
		</div>
		
		
</div></div>
<script>
var __list_crud='';
helmi.controller ='<?php echo isset($__controller)?$__controller:''; ?>';

loadJS([ ],'<?php echo $asset ?>js/user-m-add.js','content-wrapper');

</script>