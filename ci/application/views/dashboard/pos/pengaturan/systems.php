<link type="image/x-icon" href="<?php echo $asset; ?>/favicon.png" rel="shortcut icon"/>
<style>
<!--
.total_jml { width:100%; margin-top:5px; float:left; font-size:27px; font-weight:bold; text-align:right; background-color:#000; color:#FFF; padding:10px ; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; -moz-box-shadow:0px 0px 3px #aaa; -webkit-box-shadow:0px 0px 3px #aaa; box-shadow:0px 0px 3px #aaa; font-family:"Courier New", Courier, monospace; }
-->
</style>
<div class="row" style="min-height:750px;">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Pengaturan</a></li>
					<li class="active"><span> Systems</span></li>
				</ol>
			<h1>Pengaturan System </h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 "> 
				<div class="main-box clearfix">
					<header class="main-box-header clearfix">
						<h2 class="pull-left">Settingan Systems</h2> 
					</header>
				<div class="main-box-body">
					<form id="settingan-system">
						<div class="form-group"><label> Alamat : </label><input class="form-control" type="text" name="alamat" value="<?php echo $alamat['isi1']; ?>" /></div>	
						<div class="form-group"><label> Nama System : </label><input class="form-control" type="text" name="title" value="<?php echo $title['isi1']; ?>" /></div>	
						<div class="form-group"><div class="input-group"><span class="input-group-addon"> <input type="checkbox" name="hapus_boleh" <?php echo ($boleh_hapus['isi1'] == 1) ? 'checked' : '' ; ?> /> </span> <input class="form-control" value="Izinkan untuk Hapus Data  " disabled /> </div></div>
						<div class="form-group"><div class="input-group"><span class="input-group-addon"> <input type="checkbox" name="debug_db" <?php echo ($debug_db == 1) ? 'checked' : '' ; ?> /> </span> <input class="form-control" value="Debug DB Error " disabled /> </div></div>
						<input type="hidden" name="controller" value="<?php echo isset($__controller)?$__controller:''; ?>" />
						<input type="hidden" name="mode" value="simpan" />
					</form>
						<button class="btn btn-info" data-tombol="simpan">SIMPAN</button>
						<button class="btn btn-danger" data-tombol="set-photo-profile">Set Background Image</button>
				</div>
					
				</div>
			</div>
		</div>
		
		
</div></div>

<script>
var __list_crud='';
helmi.controller ='<?php echo isset($__controller)?$__controller:''; ?>'; 

//loadCSS("<?php echo $asset ?>plugins/datatables/css/datatables.css");

loadJS([
	//"<?php echo $asset ?>plugins/datatables/js/jquery.dataTables.min.js"
	//,"<?php echo $asset ?>plugins/datatables/js/dataTables.bootstrap.min.js"
],'<?php echo $asset ?>js/systems.js','content-wrapper');


</script>