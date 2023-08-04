<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title>Email template</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <style type="text/css">
         @media  screen {
         @font-face {
         font-family: 'Source Sans Pro';
         font-style: normal;
         font-weight: 400;
         src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
         }
         @font-face {
         font-family: 'Source Sans Pro';
         font-style: normal;
         font-weight: 700;
         src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
         }
         }
         body {
         width: 100% !important;
         height: 100% !important;
         padding: 0 !important;
         margin: 0 !important;
         }
         img {
         height: auto;
         line-height: 100%;
         text-decoration: none;
         border: 0;
         outline: none;
         }
      </style>
   </head>
   <body style="background-color: #e9ecef;">
      <!-- start body -->
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
         <tr>
            <td align="center" >
               <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #fff;max-width:900px";>
                  <tr>
                     <td align="left" bgcolor="#e9ecef" style="height:20px;"> </td>
                  </tr>
                  <!-- start logo -->
                  <tr>
                     <td align="center">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                           <tr>
                              <td align="left" valign="top" style="background-color:#f6f6f6;padding: 20px 24px;border-bottom: 1px solid #d4dadf;">
                                 <a href="#" target="_blank" style="display: inline-block;">
                                 <img src="<?php echo e(asset('front_end/images/logo.png')); ?>"   border="0" style="display: block;">
                                 </a>
                              </td>
                           </tr>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                           <tr>
                              <!-- <td valign="top" align="left" style="padding: 10px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif;"> -->
                                 <!-- <h4 style="font-weight:500;margin-top:5px;"><strong>Invoice Number: </strong> <span>#12345678</span> </h4> -->
                              <!-- </td> -->
                              <td valign="top" align="right" style="padding:10px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif;">
                                 <h4 style="margin: 0;font-weight: 600;line-height: 24px;">Address</h4>
                                 <p style="font-size:15px;margin: 0;"><?php echo e(isset($data) ? $data['userAdress'] : ''); ?>

                                 </p>
                                 <h4 style="font-weight:500;margin-top:10px;"><strong>Order Date: </strong> <span><?php echo e(isset($data) ? $data['orderdate'] : ''); ?></span> </h4>
                              </td>
                           </tr>
                           <tr>
                              <td colspan="2" align="center" style="padding: 10px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; border-top:1px solid #d4dadf;">
                                 <h1 style="margin: 0; font-size: 25px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">Order Details</h1>
                              </td>
                           </tr>
                           <tr>
                              <td colspan="2" align="left" bgcolor="#ffffff" style="padding:24px; padding-top:0;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                                 <h4 style="font-weight:600;margin:0;">Embriodery </h4>
                              </td>
                           </tr>
                        </table>
                     </td>
                  </tr>
                  <!-- end logo -->
                  <!-- start block -->
				  <?php if(!empty($data['cartOrdres'])): ?>
				  <?php
				  $total =0;
              $amt=0;
				  ?>
				  <?php $__currentLoopData = $data['cartOrdres']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cartOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                     <td align="center" style="padding:0 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif;">
                        <table border="0" cellspacing="0" cellpadding="15" width="100%">
                           <thead style="background-color:#f7f7f7;">
                              <tr>
                                 <th align="left">Order Name</th>
                                 <th align="left">Desired Height</th>
                                 <th align="left">Desired Width</th>                                 
                                 <th align="left">Desired Output</th>								
                                 <th align="left">Discount</th>
                                 <th align="left">Amount</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td><?php echo e(isset($data) ? $cartOrder->order_name : ''); ?></td>
                                 <td><?php echo e(isset($data) ? $cartOrder->desired_height : ''); ?></td>
                                 <td><?php echo e(isset($data) ? $cartOrder->desired_width : ''); ?></td>                               
                                 <td><?php echo e(isset($data) ? $cartOrder->desired_output : ''); ?></td>
                                 <td><?php if($data['ccheck'] == 1): ?>
                                    <?php echo e(isset($data['amountDiscount']) ? '$'.$data['amountDiscount'] :  $data['discountPercentage'] .'%'); ?>

                                    <?php else: ?>
                                    0
                                     <?php endif; ?>
                                 </td>
                                 <?php if($data['ccheck'] == 1): ?>
                                    <?php if(isset($data['amountDiscount'])): ?>
                                       <?php 
                                             $amt = $cartOrder->amount -  $data['amountDiscount'];  
                                       ?>
                                      <td><?php echo e($amt); ?></td>
                                      <?php else: ?>
                                         <?php if(isset($data['discountPercentage']) ): ?>
                                          <?php 
                                             $final_amount = ($data['discountPercentage'] / 100) * $cartOrder->amount;
                                             $amt = $cartOrder->amount - $final_amount; 
                                          ?> 
                                          <td><?php echo e($amt); ?></td>
                                           
                                          <?php endif; ?>
                                     <?php endif; ?>
                                      <?php else: ?>
                                      <td><?php echo e(isset($data) ? $cartOrder->amount : ''); ?></td>
                                 <?php endif; ?>
                               
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
				  <?php

				  $total += $amt;
				  
				  ?>
              
				  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				  <?php endif; ?>
                  <!-- end block -->
                  <!-- start block -->
                  <tr>
                     <td align="right" text-align="right" style="border-top:1px solid #ccc;padding:0 24px; padding-top:20px;font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif;">
                        <table border="0" cellspacing="0" cellpadding="5" width="100%" style="max-width:350px;">
                           <!-- <tr> -->
                              <!-- <th align="left">Sub total</th> -->
                              <!-- <td>$60.00</td> -->
                           <!-- </tr> -->
                           <!-- <tr> -->
                              <!-- <th align="left">QST 9.97%</th> -->
                              <!-- <td>$90</td> -->
                           <!-- </tr> -->
                           <!-- <tr> -->
                              <!-- <th align="left">Canadian GST 9.97%</th> -->
                              <!-- <td>$1</td> -->
                           <!-- </tr> -->
                           <!-- <tr> -->
                              <!-- <th align="left">Shipping Canada - Standard Shipping</th> -->
                              <!-- <td>$10.00</td> -->
                           <!-- </tr> -->
                           <tr>
                              <th align="left">Total</th>
                              <?php if($data['ccheck'] == 1): ?>
                                    <?php if(isset($data['amountDiscount'])): ?>
                                       <?php 
                                             $amt = $total -  $data['amountDiscount'];  
                                       ?>
                                          <td><?php echo e('$'.$amt); ?></td>
                                      <?php else: ?>
                                         <?php if(isset($data['discountPercentage']) ): ?>
                                          <?php 
                                             $final_amount = ($data['discountPercentage'] / 100) * $cartOrder->amount;
                                             $amt = $total - $final_amount; 
                                          ?> 
                                          <td><?php echo e('$'.$amt); ?></td> 
                                          <?php endif; ?>
                                     <?php endif; ?>
                                      <?php else: ?>
                                      <td><?php echo e(isset($data) ? '$'.$total : ''); ?></td>
                                 <?php endif; ?>
                              <td></td>
                           </tr>
                        </table>
                     </td>
                  </tr>
                  <!-- end block -->
                  <tr>
                     <td colspan="2" align="left" bgcolor="#ffffff" style="padding-top:0;padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                        <h4 style="font-weight:500;margin-top:10px;margin-bottom:10px;"><strong>Payment Method: </strong> <span>Paypal</span> </h4>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2" align="center" style="padding: 10px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif;">
                        <h1 style="margin: 0; font-size: 20px; padding: 10px 24px; background-color:#743387;color:#fff;font-weight: 600; line-height: 48px;">Thanks For your Order</h1>
                     </td>
                  </tr>
                  <tr>
                     <td align="left" bgcolor="#e9ecef" style="height:20px;"> </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
      <!-- end body -->
   </body>
</html><?php /**PATH /var/www/punchly/backend/resources/views/mail/newOrderPlaced.blade.php ENDPATH**/ ?>