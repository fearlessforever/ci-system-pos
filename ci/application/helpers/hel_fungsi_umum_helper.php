<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function hel_script_ga(){
		return "
		<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-56939563-1', 'auto');
			ga('send', 'pageview');
		</script>
		";
	}
	function hel_xhtml_highlight($str) {
		$str = highlight_string($str, true);
		//replace <code><font color=""></font></code>
		$str = preg_replace('#<font color="([^\']*)">([^\']*)</font>#', '<span style="color: \\1">\\2</span>', $str);
		//replace other <font> elements
		return preg_replace('#<font color="([^\']*)">([^\']*)</font>#U', '<span style="color: \\1">\\2</span>', $str);
	}
	function hel_keamanan_csrf(){
		return uniqid(md5(microtime()), true);		
	}
	function hel_buat_link( $string_j='' ){
		//$judul = strtolower(preg_replace("/\s/","9a9z9",$string_j));
		//$judul = preg_replace('#\W#', '', $judul);
		$judul = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $string_j));
		$judul =trim($judul,'-');
		//$judul = str_replace("9a9z9","-",$judul); 
		return $judul;
		// $str = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $str), '-'));
	}
	// regex = "<((?!pre|code|textarea))>([^<]+)</\1>"  regex untuk baca data diantara tag dimaksud

/* End of file hel_fungsi_umum_helper.php */
/* Location: ./application/helpers/url_helper.php */