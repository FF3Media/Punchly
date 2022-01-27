<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - LFZ</title>

    <style type="text/css">
        @page  {
            margin: 0px;
        }
        body {
            margin: 0px;
            font-size: 20px;
        }
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        a {
            color: #fff;
            text-decoration: none;
        }
        table {
            font-size: x-small;
        }
        tfoot tr td {
            font-weight: bold;
            font-size: x-small; 
        }
        td { 
            font-size: 16px;
             color: #2c2e35;
        }
        .invoice table {
            margin: 15px;
        }
        .invoice h3 {
            margin-left: 15px;
        }
        .information {
            background-color: #fff;
            color: #2c2e35;
        }
        .information .logo {
            margin: 5px;
        }
        .information table {
            padding: 10px;
        }
        .bgGray {
               background-color: #f4f4f4;
			    font-size: 16px;
			    padding: 26px 20px; 
			    border-radius: 8px;
			    margin: 40px 0 0 0;
        }

       .invoice td ,   .invoice th { 
			    font-size: 16px;
			    padding: 22px 16px; 
			    border-radius: 8px;
			    margin: 40px 0 0 0;
        }
        .invoice-foot {
        	    font-size: 26.67px;
                font-weight: 500;
                display: block;
            }
        .logo{
            width:100%;
        }
    </style>

</head>
<body>
 
<div class="information">
    <table width="100%">
        <tr>
            <td align="left" style="width: 40%;">
             <img style="width:150px;" src="<?php echo e(asset('backend-images/sidebar-logo.png')); ?>" alt="Logo"   class="logo"/>

            </td>

            <td align="center" style="width: 20%;">
               <span><h2>Invoice</h2></span>

            </td>
            
            <td align="right" style="width: 40%;">
  
             
            <span style="display:block;float:left;width:100%;margin:20px 0 0;">
               <!--  <b> Tax ID:</b> 14056887<br> 
                <b>Registration No.:</b> 8714207000</p> -->
            </span>
                 
            </td>
        </tr>

    </table>
</div>
<div class="information" style="margin:20px 0 0;">
    <table width="100%">
        <tr>
            <td align="left" style="width: 40%;">
                 <!-- <b>Customer invoice No: </b>949494944<br/><b>Reservation code:</b> 8714207000<br/> -->
    				<b>Date: </b><?php echo e($completed_date); ?><br/>
    			 <p style="font-size: 20px;font-weight: 400;margin: 30px 0 0 0;"> 123 Street 2174 City</p>
           </td>
            
            <td align="right" style="width: 40%;">
             
                <table width="100%" style="padding:0;">
                
                <tr>
                    <td align="right" style="padding:20px 0 0;">
                        <b>Punchuly Contact: </b> +0123 2542 2546 <br/>
                        <b>Punchuly Email: </b>hello@punchly.com<br/>
                   </td>
                </tr>
                </table>
                 
            </td>
        </tr>

    </table>
</div>


<br/>

<div class="invoice"> 
    <table width="100%">
      
        <tbody>        
        <tr>
            <th align="left" >Order Id: </th>
            <td align="right" ><?php echo e($order_id); ?></td> 
        </tr>
        <tr class='bgGray'>
            <th align="left" >Amount: </th>
            <td align="right"><?php echo e($amount); ?></td> 
        </tr>
        <tr>
            <th align="left" >Discount: </th>
            <td align="right"><?php echo e($discount); ?></td> 
        </tr>
        
        </tbody>

        <tfoot>
        <tr> 
            <td align="center" colspan="2">Total</td> 
        </tr> 
          <tr  class='bgGray'> 
            <td align="left" style="margin: 0;font-weight: 400;font-size: 16.67px;" ><b style="font-size: 26.67px;font-weight: 500;display: block;" >Total amount:</b></td>
            <td align="right" class="gray" style="margin: 0;font-weight: 400;font-size: 16.67px;"><b style="font-size: 26.67px;font-weight: 500;display: block;">USD  <?php echo e($total); ?></b></td>
        </tr>
     
        </tfoot>
    </table>
</div>
 
</body>
</html><?php /**PATH /var/www/punchly/backend/resources/views/Invoices/pdf.blade.php ENDPATH**/ ?>