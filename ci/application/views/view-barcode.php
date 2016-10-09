<html moznomarginboxes mozdisallowselectionprint>
    <head>
        <title> Barcode : <?php echo isset($core['code']) ? $core['code'] : ''; ?> </title>
		<style>body{margin:0;} 
			@page {
				size: A4;
				margin: 0;
			}
			@media print {
				.page {
					margin: 0;
					border: initial;
					border-radius: initial;
					width: initial;
					min-height: initial;
					box-shadow: initial;
					background: initial;
					page-break-after: always;
				}
			}
		</style>
    </head>
    <body onload="window.print();"> 
<?php
	$nama = strtoupper(str_replace(array('<','>'),array('&lt;','&gt;'), $core['nama']) ) ;
	$home = base_url();
	//$nama =substr($nama,0,21);
	for($i=0;$i<12;$i++){
		echo '<div style="width:327px; float:left;padding:3px;">
			<div  style="border:1px solid green; margin:7px; padding:7 0px; text-align:center;">
				<div style="font-weight:bold; ">'. $nama .'</div>
				<div ><img style="width:250px; height:70px;" src="'.$home.'helmi-barcode/'.$core['code'].'"></div>
				<div >'.$core['code'].'</div>
				<div >'.$home.' </div>
			</div>
		</div>';
	}
?>  
    </body>
</html>