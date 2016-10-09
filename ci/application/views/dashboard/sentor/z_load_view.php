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
	
		if(!isset($halaman_sendiri) ){
			/* <!-- start: Header --> */
			include 'body.1.theme.wrapper.header.php';
			/*	<!-- end: Header -->*/
			
			
	/* <!-- start: theme wrapper --> */				
		echo '<div id="theme-wrapper">';
			
			echo '<div id="page-wrapper" class="container"><div class="row">';
			//navigation sidebar
			include 'body.2.theme.wrapper.sidebar.menu.php';
			/*  <!-- start: Content --> */
			echo '<div id="content-wrapper" class="main"></div>';
			/*	<!-- end: Content --> */
			echo '</div></div>';
		echo '</div>';
		}else{
			echo $halaman_sendiri;
		}
	/* <!-- end: theme wrapper -->  */
	
	
	/* <!-- start: Header --> */
		//include 'body.2.header.php';		
	/*	<!-- end: Header -->*/
	
	
	/*  <!-- start: Main Menu -->  */
		include 'body.3.config.php';
	/*	<!-- end: Main Menu --> */
		include 'body.4.footer.php';
	
	/*  <!-- start: JavaScript-->  */
	if(isset($halaman_js))
		echo $halaman_js;
	else
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
		<script src="'.$assets.'/real/plugins/jquery-cookie/jquery.cookie.min.js"></script>
		<!--<script src="'.$assets.'/real/js/demo.min.js"></script>-->
		
		<script src="'.$assets.'/sentor/js/demo-rtl.js"></script>
		<script src="'.$assets.'/sentor/js/demo-skin-changer.js"></script>
		<script src="'.$assets.'/sentor/js/jquery.nanoscroller.min.js"></script>
		<script src="'.$assets.'/sentor/js/demo.js"></script>
		<script src="'.$assets.'/sentor/js/scripts.js"></script>
		<script src="'.$assets.'/sentor/plugins/gritter/js/jquery.gritter.min.js"></script>
		<script src="'.$home.'/user/autojs/helmi"></script>
	';
	
	
	/*  <!-- end: JavaScript-->  */
	echo '</body>';
?>
</html>