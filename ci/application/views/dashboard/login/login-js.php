		<!--[if !IE]>-->

				<script src="<?php echo $asset; ?>sentor/js/jquery-2.1.1.min.js"></script>

		<!--<![endif]-->

		<!--[if IE]>

			<script src="<?php echo $asset; ?>sentor/js/jquery-1.11.1.min.js"></script>

		<![endif]-->

		<!--[if !IE]>-->

			<script type="text/javascript">
				window.jQuery || document.write("<script src=\'<?php echo $asset; ?>sentor/js/jquery-2.1.1.min.js\'>"+"<"+"/script>");
			</script>

		<!--<![endif]-->

		<!--[if IE]>

			<script type="text/javascript">
		 	window.jQuery || document.write("<script src=\'<?php echo $asset; ?>sentor/js/jquery-1.11.1.min.js\'>"+"<"+"/script>");
			</script>

		<![endif]-->
		<script src="<?php echo $asset; ?>sentor/js/jquery-migrate-1.2.1.min.js"></script>
		<script src="<?php echo $asset; ?>sentor/js/bootstrap.min.js"></script>	

		<!-- theme scripts -->
		<script src="<?php echo $asset; ?>sentor/plugins/pace/pace.min.js"></script>
		<script src="<?php echo $asset; ?>sentor/js/jquery.mmenu.min.js"></script> 
		<script src="<?php echo $asset; ?>sentor/plugins/jquery-cookie/jquery.cookie.min.js"></script>
		<!--<script src="<?php echo $asset; ?>sentor/js/demo.min.js"></script>-->
		
		<script src="<?php echo $asset; ?>sentor/js/demo-rtl.js"></script>
		<script src="<?php echo $asset; ?>sentor/js/demo-skin-changer.js"></script>
		<script src="<?php echo $asset; ?>sentor/js/jquery.nanoscroller.min.js"></script>
		<script src="<?php echo $asset; ?>sentor/js/demo.js"></script>
		<script src="<?php echo $asset; ?>sentor/js/scripts.js"></script> 
		<script> 
	$('button.btn-success').click(function( ){   
		var email	= $("#loginmail").val();
		var password	= $("#loginpass").val(); 
		if(email.length > 1){
		$.ajax({
			type		: "POST",
			url			: "index.html",
			data		: "email="+email+"&password="+password ,
			timeout		: 17000,
			beforeSend	: function(){		
				  $(".social-text").html("<img src='<?php echo $asset; ?>sentor/img/select2-spinner.gif' />");			
			  },				  
			success	: function(data){
				$(".social-text").html(data);
				//cariSMT();
			  }
			});
		}else{
			$("#loginmail").focus();
			if(password.length < 1)$("#loginpass").focus();
			alert('Email & password form can\'t be blank');
		}
		
	}); 
	$(document).keypress(function(e ){
		var email	= $("#loginmail").val();
		var password	= $("#loginpass").val();
		if(e.keyCode == 13)
		if(email.length > 1  ){
		$.ajax({
			type		: "POST",
			url			: "index.html",
			data		: "email="+email+"&password="+password ,
			timeout		: 17000,
			beforeSend	: function(){		
				  $(".social-text").html("<img src='<?php echo $asset; ?>sentor/img/select2-spinner.gif' />");			
			  },				  
			success	: function(data){
				$(".social-text").html(data);
				//cariSMT();
			  }
			});
		}else{
			$("#loginmail").focus();
			if(password.length < 1)$("#loginpass").focus();
			alert('Email & password form can\'t be blank');
		}
		
	});
	var cek_login=location.hash.replace(/^#/,"");
	if(cek_login.length > 5)window.document.location='<?php echo $home.'index.html'; ?>';
</script>