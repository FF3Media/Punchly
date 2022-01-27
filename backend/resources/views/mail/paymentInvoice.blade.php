<!DOCTYPE html>
<html>
    <head>
        <title>Invoice Template</title>
        <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Pacifico&display=swap" rel="stylesheet">
    </head>
    <body style="background: #2bc0ba;margin:0;padding:0;font-family: 'Barlow', sans-serif;color:#2c2e35;">
      <?php
  $coupon_amount = '';
  $discount = '';
  // if($data['amount_after_coupon'] > 0 ){
  
  //  $coupon_amount = $data['amount_after_coupon'];
  //  $discount = $data['discount'];
  //  }else{    
  //   $coupon_amount = $data['amount'];   
  //   // $discount = "0";
  //  }
  ?>
        <div style="max-width: 855px;margin: 50px auto; background: #fff; padding: 25px">
            <div style="display: flex;justify-content: space-between;align-items: center;">
                <div>
                    <img src="{{ asset('backend-images/sidebar-logo.png') }}" />
                </div>
                <div>
                  <p  style="font-size: 20px;font-weight: 400;text-align: center;margin:0;">
                     <h2> {{ isset($data) ? $data['subject'] : '' }} </h2>
                       </p>
                  
                </div>
                <div>               
                    <p  style="font-size: 20px;font-weight: 400;text-align: right;margin:0;">
                      <!-- <b> Tax ID:</b> 14056887<br> 
                      <b>Registration No.:</b> 8714207000</p> -->
                </div>
            </div>
            <div style="display: flex;justify-content: space-between;align-items: flex-end;margin: 52px 0 0;">
                <div>
                   <!--  <p style="font-size: 20px;font-weight: 400;margin:0;"><b>Customer invoice No.</b> 21-0001</p> -->
                    
                    <p style="font-size: 20px;font-weight: 400;margin:0;"><b>Date:</b>{{$data['completed_date']}}</p>
                    <p style="font-size: 20px;font-weight: 400;margin: 30px 0 0 0;"> 123 Street 2174 City</p>
                </div>
                <div style="text-align: right;display: inline-flex;flex-flow: column;align-items: flex-end;">
                    <div style="width: 145px;text-align: center;"> 
                    </div>
                    <p style="font-size: 20px;font-weight: 400;margin:32px 0 0;text-align: right;"><b style="font-weight:600;">Punchuly Contact:</b> 0123 2542 2546</p>
                    <p style="font-size: 20px;font-weight: 400;margin:32px 0 0;text-align: right;"><b style="font-weight:600;">Punchuly Email:</b>  hello@punchly.com</p>
                    
                </div>
            </div>
             
            <div style="background-color: #ffffff;font-size: 20px;padding: 26px 20px;display: flex;justify-content: space-between;border-radius: 8px;">
                <p style="margin: 0;font-weight: 600;">Order Id:</p>
                <p style="margin: 0;">{{ isset($data) ? $data['order_unique_id'] : '' }}</p>
            </div>
            <div style="background-color: #f4f4f4;font-size: 20px;padding: 26px 20px;display: flex;justify-content: space-between;border-radius: 8px;">
                <p style="margin: 0;font-weight: 600;">Amount:</p>
                <p style="margin: 0;">{{ isset($data) ? $data['amount'] : '' }}</p>
            </div>
            <?php if($data['gst'] != 0.00 ) {   ?>
             <div style="background-color: #ffffff;font-size: 20px;padding: 26px 20px;display: flex;justify-content: space-between;border-radius: 8px;"> 
                <p style="margin: 0;font-weight: 600;">GST:</p>
                <p style="margin: 0;">{{ isset($data) ? round($data['gst'],0) : '' }}%</p> 
            </div>
            <?php  }   ?>

          <?php if($data['rst'] != 0.00 ) {   ?>
             <div style="background-color: #f4f4f4;font-size: 20px;padding: 26px 20px;display: flex;justify-content: space-between;border-radius: 8px;">
                <p style="margin: 0;font-weight: 600;">RST:</p>
                <p style="margin: 0;">{{ isset($data) ? round($data['rst'],0) : '' }}%</p>
            </div>
            <?php  }   ?>

             <?php if($data['qst'] != 0.00 ) {   ?>
             <div style="background-color: #ffffff;font-size: 20px;padding: 26px 20px;display: flex;justify-content: space-between;border-radius: 8px;"> 
                <p style="margin: 0;font-weight: 600;">QST:</p>
                <p style="margin: 0;">{{ isset($data) ? round($data['qst'],0) : '' }}%</p> 
            </div>
            <?php  }   ?>

            <?php if($data['pst'] != 0.00 ) {   ?>
             <div style="background-color: #f4f4f4;font-size: 20px;padding: 26px 20px;display: flex;justify-content: space-between;border-radius: 8px;">
                <p style="margin: 0;font-weight: 600;">PST:</p>
                <p style="margin: 0;">{{ isset($data) ? round($data['pst'],0): '' }}%</p>
            </div>
            <?php  }   ?>

            <?php if($data['hst'] != 0.00 ) {   ?>
             <div style="background-color: #ffffff;font-size: 20px;padding: 26px 20px;display: flex;justify-content: space-between;border-radius: 8px;"> 
                <p style="margin: 0;font-weight: 600;">HST:</p>
                <p style="margin: 0;">{{ isset($data) ? round($data['hst'],0) : '' }}%</p> 
            </div>
            <?php  }   ?>


            <?php
            if(!empty($discount)){
            ?>
            <div style="background-color: #ffffff;font-size: 20px;padding: 26px 20px;display: flex;justify-content: space-between;border-radius: 8px;">
                <p style="margin: 0;font-weight: 600;">Discount:</p>
                <p style="margin: 0;">{{$discount}}</p>
            </div>
           <?php
              }
            ?>
            <h3 style="text-align: center;font-size: 26.67px;margin: 35px 0 28px 0;">Total</h3>
            <div style="background-color: #f4f4f4;font-size: 20px;padding: 10px 20px;display: flex;justify-content: space-between;border-radius: 8px;">
                <p style="margin: 0;font-weight: 400;font-size: 16.67px;text-align: right;"><b style="font-size: 26.67px;font-weight: 500;display: block;">Total amount:</b></p>
                <p style="margin: 0;font-weight: 400;font-size: 16.67px;text-align: right;"><b style="font-size: 26.67px;font-weight: 500;display: block;">USD {{$data['total_amount']}}</b></p>
            </div>
            
        </div>
    </body>
</html>