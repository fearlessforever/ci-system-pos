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
					<li class="active"><span> Input Kredit Dan Debit</span></li>
				</ol>
			<h1>Input Kredit / Debit</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 main-box">
				<ul class="nav nav-tabs"> <li class="active"><a href="#tab1-kredeb" data-toggle="tab">Input Debit/Kredit</a></li> <li class=""><a href="#tab2-kredeb" data-toggle="tab">Jurnal Umum Dan Buku Besar</a></li> </ul>
				
				<div class="tab-content ">
					<div class="tab-pane active" id="tab1-kredeb">
						<header class="main-box-header clearfix">
							<h2 class="pull-left">Debit Kredit </h2>
							<div class="filter-block " style="clear:both;">
							<a href="#" class="btn btn-danger " data-tombol="tambah">
								<i class="fa fa-plus-circle fa-lg"></i> Tambahkan Debit / Kredit 
							</a>
							</div>
						</header>
						<div class="main-box-body">
							<p> 
		<?php 
			$core = $this->db->query("SELECT CONCAT(tipe,id) as id,judul,keterangan FROM z_info WHERE id=? AND tipe=? LIMIT 1",array(1,'help') )->row_array();
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
							<form >
								<h4>Pilihan tampilkan Data </h4>
								<div class="form-inline">
									<div class="form-group"><label>Mulai Dari : </label> <input placeholder="Tanggal Mulai" name="tglmulai" class="form-control" data-tombol="tanggal-list" /></div>
									<div class="form-group"><label>Sampai Dengan : </label> <input placeholder="Tanggal Batas" name="tglakhir" class="form-control" data-tombol="tanggal-list" /></div>
								</div>
								<input type="hidden" name="controller" value="<?php echo isset($__controller)?$__controller:''; ?>">
								<input type="hidden" name="mode" value="view">
								<div style="margin:9px 0 0;"><button class="btn btn-danger" data-tombol="view-tanggal">Tampilkan</button></div>
							</form>
							
							<div id="tempat-total-table" > </div>
							<div id="tempat-table-crud" class="table-responsive"><div style="text-align:center; min-height:150px;"><img src="<?php echo $asset; ?>loading.gif" /></div></div>
						</div> 
					</div>
					<div class="tab-pane " id="tab2-kredeb">
						<div class="main-box-body">
							<form >
								<h4>Tampilkan Jurnal Umum </h4>
								<p>*** Jurnal Umum Biasa ny Ditampilkan Data Untuk 1 Bulan, jadi pastikan laporan jurnal yang mau ditampilkan dari tanggal 1 sampai akhir bulan</p>
								<div class="form-inline">
									<div class="form-group"><label>Mulai Dari : </label> <input placeholder="Tanggal Mulai" name="tglmulai" class="form-control" data-tombol="tanggal-list" /></div>
									<div class="form-group"><label>Sampai Dengan : </label> <input placeholder="Tanggal Batas" name="tglakhir" class="form-control" data-tombol="tanggal-list" /></div>
								</div>
								<input type="hidden" name="controller" value="<?php echo isset($__controller)?$__controller:''; ?>">
								<input type="hidden" name="mode" value="jurnal">
								<div style="margin:9px 0 0;"><button class="btn btn-danger" data-tombol="view-jurnal">Tampilkan</button></div>
							</form>
							
							<div id="tempat-table-crud2" > </div>
						</div> 
					</div>
				</div>
				
			</div>
		</div>
		
		
</div></div>
<script>
var __list_crud='';
helmi.controller ='<?php echo isset($__controller)?$__controller:''; ?>';

loadCSS("<?php echo $asset ?>plugins/jquery-ui/css/jquery-ui-1.10.4.min.css");
loadJS([
	"<?php echo $asset ?>plugins/jquery-ui/js/jquery-ui-1.10.4.min.js"
],'<?php echo $asset ?>js/input-kre-deb.js','content-wrapper');


</script>