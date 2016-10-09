<!DOCTYPE html>
<html lang="en">
<?php
	// include header
	include 'header.php';
	
	/*
	<!-- BODY options, add following classes to body to change options

		1. 'sidebar-minified'     - Switch sidebar to minified version (width 50px)
		2. 'sidebar-hidden'		  - Hide sidebar
		3. 'rtl'				  - Switch to Right to Left Mode
		4. 'container'			  - Boxed layout
		5. 'static-sidebar'		  - Static Sidebar
		6. 'static-header'		  - Static Header
	-->
	*/
	//include body
	echo '<body>';
	
	/*  <!-- start: Content --> */
	?>
	<style>
	footer{ display:none;}
	</style>
	<div class="container-fluid content">
		<div class="row">
				<div id="content" class="col-sm-12 full">
			
			<div class="row box-error">
				
				<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3">
				
				<h1>404</h1>
				<h2>Oops! You're lost.</h2>
				<p>The page you are looking for was not found.</p>
				
				  <div class="input-prepend input-group">
					<span class="input-group-addon clear"><i class="fa fa-search"></i></span>
					<input id="prependedInput" class="form-control" size="16" type="text" placeholder="What are you looking for?">
					<span class="input-group-btn">
						<button class="btn btn-info" type="button">Search</button>
					</span>
				  </div>	
				
				</div><!--/col-->
				
			</div><!--/row-->
		
		</div><!--/content-->	
			
				</div><!--/row-->
		
		<footer>

			<div class="row">

				<div class="col-sm-5">
					&copy; 2014 creativeLabs. <a href="http://bootstrapmaster.com">Admin Templates</a> by BootstrapMaster
				</div><!--/.col-->

				<div class="col-sm-7 text-right">
					Powered by: <a href="http://bootstrapmaster.com/demo/real/" alt="Bootstrap Admin Templates">Real Admin</a> | Based on Bootstrap 3.3.2 | Built with Brix.io
				</div><!--/.col-->	

			</div><!--/.row-->	

		</footer>
		
	</div><!--/container-->
	
	<?php
	/*	<!-- end: Content --> */
	
		
		include 'body.4.footer.php';
	
	/*  <!-- start: JavaScript-->  */
	echo '
		<!--[if !IE]>-->

				<script src="'.$assets.'/real/js/jquery-2.1.1.min.js"></script>

		<!--<![endif]-->

		<!--[if IE]>

			<script src="'.$assets.'/real/js/jquery-1.11.1.min.js"></script>

		<![endif]-->

		<!--[if !IE]>-->

			<script type="text/javascript">
				window.jQuery || document.write("<script src='.$assets.'\'/real/js/jquery-2.1.1.min.js\'>"+"<"+"/script>");
			</script>

		<!--<![endif]-->

		<!--[if IE]>

			<script type="text/javascript">
		 	window.jQuery || document.write("<script src='.$assets.'\'/real/js/jquery-1.11.1.min.js\'>"+"<"+"/script>");
			</script>

		<![endif]-->
		<script src="'.$assets.'/real/js/jquery-migrate-1.2.1.min.js"></script>
		<script src="'.$assets.'/real/js/bootstrap.min.js"></script>	

		<!-- theme scripts -->
		<script src="'.$assets.'/real/plugins/pace/pace.min.js"></script>
		<script src="'.$assets.'/real/js/jquery.mmenu.min.js"></script>
		<script src="'.$assets.'/real/js/core.min.js"></script>
		<script src="'.$assets.'/real/plugins/jquery-cookie/jquery.cookie.min.js"></script>
		<script src="'.$assets.'/real/js/demo.min.js"></script>
	';
		
	/*  <!-- end: JavaScript-->  */
	echo '</body>';
?>
</html>