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
					<li class="active"><span> User Profile </span></li>
				</ol>
			<h1>User Profile </h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 "> 
				<div class="col-lg-4">
					<div id="user-profile" class="main-box clearfix">
						<div style="min-height:200px; margin: 100px 50%;"><img src="<?php echo $asset; ?>loading.gif" /></div>
					</div>
				</div>
				<div class="col-lg-8"> 
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#tab-preview">Umum</a></li> 
					</ul>
					<div class="tab-content tab-content-body main-box clearfix" >
						<div id="tab-preview" class="tab-pane fade in active">
							<div style="min-height:200px; margin: 100px 50%;"><img src="<?php echo $asset; ?>loading.gif" /></div>
						</div>
					</div> 
				</div>
			</div>
		</div>
		
		
</div></div>
<script>
var __list_crud='';
helmi.controller ='<?php echo isset($__controller)?$__controller:''; ?>'; 

loadCSS("<?php echo $asset ?>plugins/datatables/css/datatables.css");
//loadCSS("<?php echo $asset ?>plugins/datatables/css/dataTables.fixedHeader.css");
//loadCSS("<?php echo $asset ?>plugins/datatables/css/dataTables.tableTools.css");
loadJS([
	"<?php echo $asset ?>plugins/datatables/js/jquery.dataTables.min.js"
	,"<?php echo $asset ?>plugins/datatables/js/dataTables.bootstrap.min.js"
],'<?php echo $asset ?>js/user-profile.js','content-wrapper');


</script>