<link type="image/x-icon" href="<?php echo $asset; ?>/favicon.png" rel="shortcut icon"/>
<script>
	helmi.controller ='<?php echo isset($__controller)?$__controller:''; ?>';
	
	loadCSS("<?php echo $asset ?>/real/css/climacons-font.css");
	loadCSS("<?php echo $asset ?>/real/plugins/jquery-ui/css/jquery-ui-1.10.4.min.css");
	loadCSS("<?php echo $asset ?>/real/plugins/morris/css/morris.css");
	loadCSS("<?php echo $asset ?>/real/plugins/jvectormap/css/jquery-jvectormap-1.2.2.css");
	loadCSS("<?php echo $asset ?>/real/plugins/daterangepicker/css/daterangepicker-bs3.css");
	
	var requireJS = [
		//"<?php echo $asset ?>plugins/jquery-ui/js/jquery-ui-1.10.4.min.js", 
		//"<?php echo $asset ?>plugins/moment/moment.min.js", 
		//"<?php echo $asset ?>plugins/flot/jquery.flot.min.js", 
		//"<?php echo $asset ?>plugins/flot/jquery.flot.resize.min.js", 
		//"<?php echo $asset ?>plugins/flot/jquery.flot.time.min.js", 
		//"<?php echo $asset ?>plugins/flot/jquery.flot.spline.min.js",
		//"<?php echo $asset ?>plugins/autosize/jquery.autosize.min.js", 
		//"<?php echo $asset ?>plugins/placeholder/jquery.placeholder.min.js", 
		//"<?php echo $asset ?>plugins/datatables/js/jquery.dataTables.min.js", 
		//"<?php echo $asset ?>plugins/datatables/js/dataTables.bootstrap.min.js", 
		"<?php echo $asset ?>plugins/raphael/raphael.min.js", 
		"<?php echo $asset ?>plugins/morris/js/morris.min.js", 
		
		"<?php echo $asset ?>plugins/gauge/gauge.min.js",
		"<?php echo $asset ?>plugins/daterangepicker/js/daterangepicker.min.js",
		
		"<?php echo $asset ?>sentor/js/jquery.countTo.js",		
		"<?php echo $asset ?>sentor/js/jquery-ui.custom.min.js",
		"<?php echo $asset ?>sentor/js/fullcalendar.min.js"
		//,
		//"<?php echo $asset ?>sentor/js/jquery.slimscroll.min.js" ,
		//"<?php echo $asset ?>plugins/jvectormap/js/jquery-jvectormap-1.2.2.min.js", 
		//"<?php echo $asset ?>plugins/jvectormap/js/jquery-jvectormap-world-mill-en.js", 
		//"<?php echo $asset ?>plugins/jvectormap/js/gdp-data.js",
		//"<?php echo $asset ?>sentor/js/jquery-jvectormap-world-merc-en.js"
	]; 
	
	loadJS(requireJS,"<?php echo $asset ?>js/dashboard.js",'content-wrapper');
	
	/*loadCSS("<?php echo $asset ?>plugins/gritter/css/jquery.gritter.css");
	loadCSS("<?php echo $asset ?>plugins/gritter/css/aku-gritter.css");
	
	var requireJS = [
		"<?php echo $asset ?>plugins/gritter/js/jquery.gritter.min.js"
	]; */
	
	//loadJSS(requireJS, "<?php echo $home ?>/user/autojs/pemberitahuan");
	
</script>

<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li class="active"><span>Dashboard</span></li>
				</ol>
			<h1>Dashboard</h1>
			</div>
		</div>
		<div class="row" id="dash-bulan-ini">
			<div class="col-lg-3 col-sm-6 col-xs-12">
				<div class="main-box infographic-box" style="text-align:center;">
					<img src="<?php echo $asset; ?>loading.gif">
				</div>
			</div>
			<div class="col-lg-3 col-sm-6 col-xs-12">
				<div class="main-box infographic-box" style="text-align:center;">
					<img src="<?php echo $asset; ?>loading.gif">
				</div>
			</div>
			<div class="col-lg-3 col-sm-6 col-xs-12">
				<div class="main-box infographic-box" style="text-align:center;">
					<img src="<?php echo $asset; ?>loading.gif">
				</div>
			</div>
			<div class="col-lg-3 col-sm-6 col-xs-12">
				<div class="main-box infographic-box" style="text-align:center;">
					<img src="<?php echo $asset; ?>loading.gif">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-9 col-lg-10">
				<div class="main-box">
					<div class="row">
						<div class="col-md-9">
						<div class="graph-box emerald-bg">
						<h2>Penjualan Barang Minggu Ini </h2>
						<div class="graph" id="dash-graph-line" style="max-height: 335px;"><div style="text-align:center;"> <img src="<?php echo $asset; ?>loading.gif"> </div></div>
						</div>
						</div>
					<div class="col-md-3" > 
					</div>
					</div>
				</div>
			</div>
		<div class="col-md-3 col-lg-2">
		<div class="social-box-wrapper" id="dash-info-data">
			<div class="social-box col-md-12 col-sm-4 facebook">
				<div style="text-align:center;"> <img src="<?php echo $asset; ?>loading.gif"> </div>
			</div>
				<div class="social-box col-md-12 col-sm-4 twitter">
				<div style="text-align:center;"> <img src="<?php echo $asset; ?>loading.gif"> </div>
				</div>
			<div class="social-box col-md-12 col-sm-4 google">
			<div style="text-align:center;"> <img src="<?php echo $asset; ?>loading.gif"> </div>
			</div>
		</div>
		</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="main-box clearfix">
					<header class="main-box-header clearfix">
						<h2 class="pull-left">Transaksi Terakhir </h2>
					<div class="filter-block pull-right">
						<div class="form-group pull-left">
							<input type="text" class="form-control" placeholder="Search...">
							<i class="fa fa-search search-icon"></i>
						</div>
					<a href="#" data-klik="list-nota.html" class="btn btn-primary pull-right">
						<i class="fa fa-eye fa-lg"></i> Liat Semua ransaksi
					</a>
					</div>
					</header>
				<div class="main-box-body clearfix">
				<div class="table-responsive clearfix" id="dash-latest">
					<div style="text-align:center;"> <img src="<?php echo $asset; ?>loading.gif"> </div>
				</div>
				</div>
				</div>
			</div>
		</div>
		<?php
		/*
		<div class="row">
			<div class="col-md-4 col-sm-6 col-xs-12">
				<div class="main-box small-graph-box red-bg">
				<span class="value">2.562</span>
				<span class="headline">Users</span>
					<div class="progress">
						<div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar">
						<span class="sr-only">60% Complete</span>
						</div>
					</div>
				<span class="subinfo">
					<i class="fa fa-arrow-circle-o-up"></i> 10% higher than last week
				</span>
				<span class="subinfo">
					<i class="fa fa-users"></i> 29 new users
				</span>
				</div>
			</div>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<div class="main-box small-graph-box emerald-bg">
				<span class="value">69.600</span>
				<span class="headline">Visits</span>
					<div class="progress">
						<div style="width: 84%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="84" role="progressbar" class="progress-bar">
						<span class="sr-only">84% Complete</span>
						</div>
					</div>
				<span class="subinfo">
					<i class="fa fa-arrow-circle-o-down"></i> 22% less than last week
				</span>
				<span class="subinfo">
					<i class="fa fa-globe"></i> 84.912 last week
				</span>
				</div>
			</div>
			<div class="col-md-4 col-sm-6 col-xs-12 hidden-sm">
				<div class="main-box small-graph-box green-bg">
				<span class="value">923</span>
				<span class="headline">Orders</span>
					<div class="progress">
						<div style="width: 42%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="42" role="progressbar" class="progress-bar">
						<span class="sr-only">42% Complete</span>
						</div>
					</div>
				<span class="subinfo">
					<i class="fa fa-arrow-circle-o-up"></i> 15% higher than last week
				</span>
				<span class="subinfo">
					<i class="fa fa-shopping-cart"></i> 8 new orders
				</span>
				</div>
			</div>
		</div>
		*/
		?>
		
		<div class="row">
			<div class="col-md-6">
				<div class="main-box">
					<div class="main-box-body clearfix"> <div id="calendar"></div> </div>
				</div>
			</div>
			<!-- <div class="col-md-6">
				<div class="main-box">
					<header class="main-box-header clearfix">
					<h2 class="pull-left">Visitors location</h2>
					<div class="icon-box pull-right"> <a href="#" class="btn pull-left"> <i class="fa fa-refresh"></i> </a> <a href="#" class="btn pull-left"> <i class="fa fa-cog"></i> </a> </div>
					</header>
				<div class="main-box-body clearfix">
					<div id="world-map" style="width: 100%; height: 400px"></div>
				</div>
				</div>
			</div> -->
		</div>
	</div>
</div>