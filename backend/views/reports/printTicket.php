<?php

?>
<html>
    <head>
        <title>
            Imprimir Ticket
        </title>
        <link rel="stylesheet" type="text/css" media="print" >
    
 <style>
    body{
        color: #000;
        font-size: 9px!important;
    }
 /*   .invoice-box{
        max-width:200px;
        margin:auto;
        padding:30px;
        border:1px solid #eee;
        box-shadow:0 0 10px rgba(0, 0, 0, .15);
        font-size:10px;
        line-height:24px;
        font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color:#555;
    }
    */
    .invoice-box table{
        width:100%;
        line-height:inherit;
        text-align:left;
    }
    
    .invoice-box table td{
        padding-bottom: 2px;
        vertical-align:top;
    }
    
    .invoice-box table tr td:nth-child(2){
        text-align:right;
    }
    
    .invoice-box table tr.top table td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.top table td.title{
        font-size:9px!important;
        line-height:20px;
        color:#000;
    }
    
    .invoice-box table tr.information table td{
        padding-bottom:40px;
    }
    
    .invoice-box table tr.heading td{
        background:#eee;
        border-bottom:1px solid #ddd;
        font-weight:bold;
    }
    
    .invoice-box table tr.details td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom:1px solid #eee;
    }
    
    .invoice-box table tr.item.last td{
        border-bottom:none;
    }
    
    .invoice-box table tr.total td:nth-child(2){
        border-top:2px solid #eee;
        font-weight:bold;
    }
    /*
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td{
            width:100%;
            display:block;
            text-align:center;
        }
        
        .invoice-box table tr.information table td{
            width:100%;
            display:block;
            text-align:center;
        }
        
    }
    */
    </style>
       
    </head>
<body>
        <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2" style="text-align:center;font-size: 8pt;">
	    <?=$companyName?><br>
	    <?=$companyPhone?><br>
		<?=$companyAddress?><br>
        Ruc: <?=$companyRuc?><br><br>
		Entrada: <?=date("H:i:s d/m/Y",strtotime($in)) ?><br>	
		Salida: <?=date("H:i:s d/m/Y",strtotime($out))?><br><br>
		Dias: <?=$days?><br>	
		Horas: <?=$hours?><br>
		Minutos: <?=$minutes?><br>
		<br>
		<?php if($rateType == -1){ ?>
        Obs: Extravio de ticket
        <?php } ?>
        <br>
                </td>
            </tr>
            
            <tr class="information">
                <td  colspan="2" >
       

                </td>
            </tr>
            
            <tr class="heading" style="font-size: 8pt;">
                <td style="font-size: 8pt;">
                    Tarifa
                </td>
                
                <td style="font-size: 8pt;">
			        Total
                </td>
            </tr>
            
            <tr class="details" >
                <td style="font-size: 8pt;">
                    <?=$rate?>
                </td>
                
                <td style="font-size: 8pt;">
                    <?=$total?>
                </td>
            </tr>
            
            <tr class="top">
                <td colspan="2" style="text-align:center;font-size: 8pt;">
		Gracias por su visita<br>
		


                </td>
            </tr>
            
           
        </table>
    </div>
    
<script type="text/javascript">
window.onload = function () {
    window.print();
}

      
    </script>

</body>
</html>