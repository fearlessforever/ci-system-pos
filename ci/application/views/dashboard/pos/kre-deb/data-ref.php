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
					<li><a href="#">Debit / Kredit</a></li>
					<li class="active"><span> Data Ref / Akun </span></li>
				</ol>
			<h1>Data Ref / Akun </h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 main-box"> 
				<header class="main-box-header clearfix">
					<h2 class="pull-left">List Ref / Kode Akun </h2>
					<div class="filter-block pull-right">
					<a href="#" class="btn btn-primary pull-right" data-tombol="tambah">
						<i class="fa fa-plus-circle fa-lg"></i> Tambah Ref / Nomor Akun
					</a>
					</div>
				</header>
				<div class="main-box-body">
					<p> 
<?php 
	$core = $this->db->query("SELECT CONCAT(tipe,id) as id,judul,keterangan FROM z_info WHERE id=? AND tipe=? LIMIT 1",array(2,'help') )->row_array();
	if(isset($core['id'])):
?>
						<div class="panel-group accordion" id="accordion2">
							<div class="panel panel-default">
							<div class="panel-heading"> <h4 class="panel-title">
							<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2"> <?php echo $core['judul']; ?> </a> </h4> </div>
							<div id="collapseOne2" class="panel-collapse collapse"> <div class="panel-body"> <?php echo $core['keterangan']; ?> </div> </div>
							</div>
						</div>
<?php endif; ?>
					</p>
				</div>
				<div class="main-box-body">
					<div id="tempat-total-table" > </div>
					<div id="tempat-table-crud" ><div style="text-align:center; min-height:150px;"><img src="<?php echo $asset; ?>loading.gif" /></div></div>
				</div> 
			</div>
		</div>
		
		
</div></div>
<script>
var __list_crud='';
helmi.controller ='<?php echo isset($__controller)?$__controller:''; ?>';

loadJS([],'<?php echo $asset ?>js/data-ref.js','content-wrapper');


</script>