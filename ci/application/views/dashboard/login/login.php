<style>
<?php
echo (isset($sys_bg['isi1']) && isset($sys_bg['isi2'])) ?  'body{background:url('.$asset.$sys_bg['isi2'].$sys_bg['isi1'].') ; background-position: right top; background-attachment: fixed;}' : '';
?>
</style>
<div id="login-full-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div id="login-box">
					<div id="login-box-holder">
						<div class="row">
						<div class="col-xs-12">
						<header id="login-header">
						<div id="login-logo">
						<img alt="" src="<?php echo $asset; ?>sentor/img/logo.png">
						</div>
						</header>
						<div id="login-box-inner">
						<form action="index.html" role="form">
						<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input id="loginmail" type="text" placeholder="Email address" class="form-control">
						</div>
						<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-key"></i></span>
						<input id="loginpass" type="password" placeholder="Password" class="form-control">
						</div>
						<div id="remember-me-wrapper">
						<div class="row">
						<div class="col-xs-6">
						<div class="checkbox-nice">
						<input type="checkbox" id="remember-me">
						<label for="remember-me">
						Remember me
						</label>
						</div>
						</div>
						<a class="col-xs-6" id="login-forget-link" href="forgot-password.html">
						Forgot password?
						</a>
						</div>
						</div>
						</form>
						<div class="row">
						<div class="col-xs-12">
						<button class="btn btn-success col-xs-12" type="submit">Login</button>
						</div>
						</div> 
						<div class="row">
						<div class="col-xs-12">
						<p class="social-text">Or login with {memory_usage}</p>
						</div>
						</div>
						<div class="row">
						<div style="text-align:center;" class="col-xs-12 ">Support Hubungi ( Helmi ) : 0895700738289 <br> BBM : D0D76205</div>
						<div class="col-xs-12 col-sm-6">
						<a class="btn btn-primary col-xs-12 btn-facebook" target="_blank" href="http://www.facebook.com/fearlessforever">
						<i class="fa fa-facebook"></i> Facebook
						</a>
						</div>
						<div class="col-xs-12 col-sm-6">
						<a class="btn btn-primary col-xs-12 btn-twitter" target="_blank" href="http://www.facebook.com/fearlessforever">
						<i class="fa fa-twitter"></i> Twitter
						</a>
						</div>
						</div>
						
						</div>
						</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>