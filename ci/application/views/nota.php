<html moznomarginboxes mozdisallowselectionprint>
    <head>
        <title> Nota : <?php echo isset($nota['code']) ? $nota['code'] : ''; ?> </title>
        <style type="text/css">
            html {
                font-family: "Verdana";
            }
            .content {
                width: 80mm;
                font-size: 12px;
                padding: 5px;
            }
            .content .title {
                text-align: center;
            }
            .content .head-desc {
                margin-top: 10px;
                display: table;
                width: 100%;
            }
            .content .head-desc > div {
                display: table-cell;
            }
            .content .head-desc .user {
                text-align: right;
            }
            .content .nota {
                text-align: center;
                margin-top: 5px;
                margin-bottom: 5px;
            }
            .content .separate {
                margin-top: 10px;
                margin-bottom: 15px;
                border-top: 1px dashed #000;
            }
            .content .transaction-table {
                width: 100%;
                font-size: 12px;
            }
            .content .transaction-table .name {
                width: 185px;
            }
            .content .transaction-table .qty {
                text-align: center;
            }
            .content .transaction-table .sell-price, .content .transaction-table .final-price {
                text-align: right;
                width: 65px;
            }
            .content .transaction-table tr td {
                vertical-align: top;
            }
            .content .transaction-table .price-tr td {
                padding-top: 7px;
                padding-bottom: 7px;
            }
            .content .transaction-table .discount-tr td {
                padding-top: 7px;
                padding-bottom: 7px;
            }
            .content .transaction-table .separate-line {
                height: 1px;
                border-top: 1px dashed #000;
            }
            .content .thanks {
                margin-top: 15px;
                text-align: center;
            }
            .content .akhir {
                margin-top:5px;
                text-align: center;
                font-size:10px;
            }
            @media print {
                @page  { 
                    width: 80mm;
                    margin: 0mm;
                }
            }

        </style>
    </head>
    <body onload="window.print();">
        <div class="content">
            <div class="title">  <?php echo isset($title['isi1']) ? $title['isi1'] : ''; ?><br><?php echo isset($alamat['isi1']) ? $alamat['isi1'] : ''; ?> </div>

            <div class="head-desc">
                <div class="date"> <?php echo isset($nota['waktu']) ? $nota['waktu'] : ''; ?> </div>
                <div class="user"> <?php echo isset($nota['nama']) ? substr($nota['nama'] ,0,17) : ''; ?> </div>
            </div>
            
            <div class="nota"><?php echo isset($nota['code']) ? $nota['code'] : ''; ?></div>
            <div class="nota"><?php echo isset($nota['tipe']) ? ($nota['tipe'] == 0 ? 'penjualan' : 'pembelian') : ''; ?></div>

            <div class="separate"></div>

            <div class="transaction">
                <table class="transaction-table" cellspacing="0" cellpadding="0">
					<?php if(isset($nota_list) && is_array($nota_list) ){
							$nota_list = json_js_array( json_encode($nota_list) );
							$nota_list = json_decode($nota_list,true); $nota['harga_total'] = 0;
							foreach($nota_list as $val){
								$__harga = $val['jumlah']*$val['harga'];
								$nota['harga_total'] += $__harga ;
								echo '<tr>  <td class="name">'.$val['nama'].'</td>  <td class="qty">'.$val['jumlah'].'</td>  <td class="sell-price">'. number_format($val['harga'] ,0,",",".") .'</td>  <td class="final-price">'.( number_format($__harga ,0,",",".") ) .'</td></tr>';
							}
					} ?>
					
					<tr class="price-tr"> <td colspan="4"> <div class="separate-line"></div> </td> </tr>
                    <tr>
                        <td colspan="3" class="final-price"> HARGA </td>
                        <td class="final-price"> <?php echo isset($nota['harga_total']) ? number_format($nota['harga_total'] ,0,",",".") : 0; ?> </td>
					</tr>
                    
                    <tr class="discount-tr"> <td colspan="4"> <div class="separate-line"></div> </td> </tr>
                    <tr>
                        <td colspan="3" class="final-price"> TOTAL </td>
                        <td class="final-price"> <?php echo isset($nota['harga_total']) ? number_format($nota['harga_total'] ,0,",",".") : 0; ?> </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="final-price"> BAYAR </td>
                        <td class="final-price"> <?php echo isset($nota['bayar']) ? number_format($nota['bayar'] ,0,",",".") : 0; ?> </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="final-price"> KEMBALI </td>
                        <td class="final-price"><?php echo isset($nota['kembali']) ? number_format($nota['kembali'] ,0,",",".") : 0; ?> </td>
                    </tr>
                </table>
            </div>
            <div class="thanks"> ~~~ Terima Kasih ~~~ </div>
            <div class="akhir"> <?php echo isset($home) ? $home : ''; ?></div>
        </div>
    </body>
</html>