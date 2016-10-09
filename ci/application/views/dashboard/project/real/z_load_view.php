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
	/* <!-- start: Layout Settings / remove this div from your project --> */
		include 'body.1.layout.settings.php';
	/* <!-- end: Layout Settings -->  */
	
	
	/* <!-- start: Header --> */
		include 'body.2.header.php';		
	/*	<!-- end: Header -->*/
	
	
	/*  <!-- start: Main Menu -->  */
		include 'body.3.sidebar.menu.php';
	/*	<!-- end: Main Menu --> */
	
	/*  <!-- start: Content --> */
		echo '<div class="main"> </div>';
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
	?>
	<script>
	$.ajaxLoad=!0;
	$.defaultPage="dashboard.html";
	$.subPagesDirectory="<?php echo $home?>user/ajax/";
	$.page404="<?php echo $home?>not_found/index.html";
	$.mainContent=$(".main");
	$.panelIconOpened="icon-arrow-up";
	$.panelIconClosed="icon-arrow-down";
	var cssArray={};
	if($.ajaxLoad){
	  paceOptions={elements:!1,restartOnRequestAfter:!1};
	  url=location.hash.replace(/^#/,"");
	  url!=""?setUpUrl(url):setUpUrl($.defaultPage);
	  $(document).on("click",'.nav a[href!="#"]',function(e){
	    if($(this).parent().parent().hasClass("nav-tabs")||$(this).parent().parent().hasClass("nav-pills"))
		 e.preventDefault();
		else if($(this).attr("target")=="_top"){
		 e.preventDefault();
		 $this=$(e.currentTarget);
		 window.location=$this.attr("href")
		}else if($(this).attr("target")=="_blank"){
		 e.preventDefault();
		 $this=$(e.currentTarget);
		 window.open($this.attr("href"))
		}else{
		 e.preventDefault();
		 var t=$(e.currentTarget);
		 setUpUrl(t.attr("href"))}});
		 $(document).on("click",'a[href="#"]',function(e){
		   e.preventDefault()})
	}
	$(document).ready(function(e){
	   e("body").hasClass("rtl")&&loadCSS("assets/css/bootstrap-rtl.min.css",loadCSS("assets/css/style.rtl.min.css",1,0));
	   e("#clock").length&&startTime();
	   e("ul.nav-sidebar").find("a").each(function(){
	     var t=String(window.location);
		 t.substr(t.length-1)=="#"&&(t=t.slice(0,-1));
		 if(e(e(this))[0].href==t){
		   e(this).parent().addClass("active");
		   e(this).parents("ul").add(this).each(function(){
		     e(this).show().parent().addClass("opened")})
			}
		});
	  e(".nav-sidebar").on("click","a",function(t){
	    e.ajaxLoad&&t.preventDefault();
		if(!e(this).parent().hasClass("hover"))
		 if(e(this).parent().find("ul").size()!=0){
		    e(this).parent().hasClass("opened")?e(this).parent().removeClass("opened"):e(this).parent().addClass("opened");
			e(this).parent().find("ul").first().slideToggle("slow",function(){dropSidebarShadow()});
			e(this).parent().parent().find("ul").each(function(){e(this).parent().hasClass("opened")||e(this).slideUp()});
			e(this).parent().parent().parent().hasClass("opened")||e(".nav a").not(this).parent().find("ul").slideUp("slow",function(){e(this).parent().removeClass("opened").find(".opened").each(function(){e(this).removeClass("opened")})})
		}else e(this).parent().parent().parent().hasClass("opened")||e(".nav a").not(this).parent().find("ul").slideUp("slow",function(){e(this).parent().removeClass("opened").find(".opened").each(function(){e(this).removeClass("opened")})})
	});
	e(".nav-sidebar > li").hover(
	  function(){e("body").hasClass("sidebar-minified")&&e(this).addClass("opened hover")},
	  function(){e("body").hasClass("sidebar-minified")&&e(this).removeClass("opened hover")}
	 );
	e("#main-menu-toggle").click(function(){
	 e("body").hasClass("sidebar-hidden")?e("body").removeClass("sidebar-hidden"):e("body").addClass("sidebar-hidden")}
	);
	e("#sidebar-menu").click(function(){e(".sidebar").trigger("open")});
	e("#sidebar-minify").click(function(){
	  if(e("body").hasClass("sidebar-minified")){
	      e("body").removeClass("sidebar-minified");
		  e("#sidebar-minify i").removeClass("fa-list").addClass("fa-ellipsis-v")
	 }else{
	      e("body").addClass("sidebar-minified");
		  e("#sidebar-minify i").removeClass("fa-ellipsis-v").addClass("fa-list")
	}});
	widthFunctions();
	dropSidebarShadow();
	init();
	e(".sidebar").mmenu();
	e('a[href="#"][data-top!=true]').click(function(e){e.preventDefault()})
	});
	</script>
	<?php
	
	/*  <!-- end: JavaScript-->  */
	echo '</body>';
?>
</html>