<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\CardDetail;
use App\PaymentDetail;
use App\PriceCalculator;
use Stripe;
use DataTables;
use Image;
use App\User;
use App\Garment;
use App\RejectionReason;
use App\Order;
use App\States;
use App\Coupon;
use App\OrderImage;
use DateTime;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Payments\AuthorizationsCaptureRequest;
use PayPalCheckoutSdk\Payments\AuthorizationsReauthorizeRequest;
use PayPalCheckoutSdk\Payments\AuthorizationsVoidRequest;
use PayPalCheckoutSdk\Orders\OrdersAuthorizeRequest;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;
use Carbon\Carbon;

class EmbroidererController extends Controller
{
    /**
     * Embroiderer dashboard..
     */
    public function dashboard(Request $request){
        return view('embroiderer.dashboard');
    } 

    public function confirmationPage(Request $request,$id){


        if($id){
              $isExist =   Order::select("*")->where("order_group_id", $id)->exists();
              
               if($isExist) {
                $allOrder = Order::select("order_unique_id")->where(['order_group_id' =>$id ])->orderBy('id', 'desc')->get();
                 foreach ($allOrder as $key => $allOrder_ids) { 
                   $orderIds[] = array('order_id' => $allOrder_ids->order_unique_id); 
                 }
                return view('embroiderer.orderConfirmation',compact('orderIds'));
                }
         
                return view('embroiderer.orderConfirmation');
        }
    } 

    /**
    * Checkout Method For Embroiderer
    */
    public function checkoutPayment(Request $request){
        if($request->isMethod('get')){
        	$finaleTaxsNames='';
            $allOrder = Order::with('garment')->where(['user_id' => Auth::user()->id , 'status' => 5])->orderBy('id', 'desc')->get();
              $cardDetail = CardDetail::where(['user_id' => Auth::user()->id])->get(); 
              $taxsForThisUsers = $this->getAlltaxsforstates();
              $taxs = $this->getAlltaxsforstates();
              if($taxsForThisUsers['total_percentage'] > 0 ){ 
				foreach ($taxsForThisUsers as $key => $taxsValues) {
							if($key == "total_percentage") {
							  unset($taxsForThisUsers[$key]); 
							}else{
								 $taxsNames[] = $key;								  
							} 
				} 
                if(!empty($taxsNames))
                {
               	$finaleTaxsNames = implode("+",$taxsNames);
               }
                      
             } 
            return view('embroiderer.checkoutPayment',compact('allOrder','cardDetail','finaleTaxsNames','taxs'));
        }
    }

    /**
    * Create Order Paypal
    */
    public function createOrderPaypal(Request $request){
        if($request->isMethod('post')){
            try{     
                $userDetail = User::find(Auth::user()->id, ['first_name', 'last_name', 'email','stripe_id','id']);
                $taxsForThisUsers = $this->getAlltaxsforstates(); 
                $allOrder = Order::where(['user_id' => $userDetail->id , 'status' => '5'])->get();
                $data = $request->except(['_token','authorization','coupon_id']);                
                $order_group_id = $this->generateRandomString();
                foreach ($allOrder as $key => $order) {
                    $amt = 0;
                    $allDone = false;    
                   $cCheck=false;
                    if(!empty($request->coupon_id)){
                        $cCheck = true;
                        $coupenData = Coupon::where('coupon_id',$request->coupon_id)->first();
                        if($coupenData->amount_off){                         
                          if($taxsForThisUsers['total_percentage'] > 0 ){	 
                            $amt = ($order->amount)-($coupenData->amount_off);  
                            $amount_after_coupon = $amt;                      
							$percentage = $taxsForThisUsers['total_percentage'];
							$amt += $amt*($percentage/100);
							$totalAmount = round($amt, 2);
                         }else{
                         	$amt = ($order->amount)-($coupenData->amount_off);
                         	$amount_after_coupon = $amt;
                         }  
                        }elseif($percentage = $coupenData->percent_off){
                          if($taxsForThisUsers['total_percentage'] > 0 ){	 
                            $final_amount = ($percentage / 100) * $order->amount;
                            $amt = ($order->amount)-($final_amount);                           
                            $amount_after_coupon = $amt; 
                            $percentage = $taxsForThisUsers['total_percentage'];
							$amt += $amt*($percentage/100);
							$totalAmount = round($amt, 2);
                           }else{
                           	 $final_amount = ($percentage / 100) * $order->amount;
                             $amt = ($order->amount)-($final_amount);
                             $amount_after_coupon = $amt;
                           }
                        } 
                    }else{                                                                          
                          if($taxsForThisUsers['total_percentage'] > 0 ){
	                        $amt = $order->amount;
							$percentage = $taxsForThisUsers['total_percentage'];
							$amt += $amt*($percentage/100);
							$totalAmount = round($amt, 2);
                         }else{
                         	$amt = $order->amount;
                         	$totalAmount = round($amt, 2);
                         } 
                    }
                    $amt = floor($amt); 

                    if($cCheck){
                    	$updateOrder = Order::where(['id' => $order->id])->update(['order_group_id' => $order_group_id , 'status' => '1' , 'coupon_id' => $request->coupon_id , 'amount_after_coupon' => $amount_after_coupon,'total_amount'=>$totalAmount,'created_at'=>now()]);
                     }else{
                       $amount_after_coupon = 0;
                     	$updateOrder = Order::where(['id' => $order->id])->update(['order_group_id' => $order_group_id , 'status' => '1' , 'coupon_id' => $request->coupon_id , 'amount_after_coupon' => $amount_after_coupon,'total_amount'=>$totalAmount,'created_at'=>now()]);
                     }
 
                    $allDone = true;
                }
                if($allDone){
                    $authArray = $request['authorization']['purchase_units'][0]['payments']['authorizations'][0];
                    $data['status'] = $authArray['status'];
                    $data['pay_authorization_id'] = $authArray['id'];
                    $data['pay_order_id'] = $request['authorization']['id'];
                    $data['user_id'] = Auth::user()->id;
                    $data['order_group_id'] = $order_group_id;
                    $data['currency'] = 'usd';
                    $data['amount'] = $authArray['amount']['value'];
                    $userAdmin = User::where(['user_role' => 1])->first();

                    $userdigitizerManager = User::where(['user_role' => 2])->first();
                    $paymentDone = PaymentDetail::create($data);  
                    $data['order_id'] = $order->order_unique_id;
                    $data['fullname'] = Auth::user()->first_name .' '. Auth::user()->last_name; 
                    $data['subject'] = 'New order placed successfully';
                    $sendEmail = mail::to([$userDetail->email, $userAdmin->email,$userdigitizerManager->email])->send( new SendMail($data,'newOrderPlaced'));

                  /*  $sendEmail = mail::to([$userDetail->email, 'userregister317@yopmail.com',$userAdmin->email,$userdigitizerManager->email])->send( new SendMail($data,'newOrderPlaced'));*/
                    return response()->json([
                        'message' => 'Your order placed successfully', 
                        'isSucceeded' => TRUE,
                        'order_group_id' => $order_group_id,
                    ]);
                }        
            }catch(\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage(), 
                    'isSucceeded' => FALSE
                ]);
            }
        } 
    } 

    public function authorizeOrder(Request $request,$qrCode=null){
        if($request->isMethod('get') && ($qrCode == Session::get('paymentCheck'))){
            session()->forget('paymentCheck');
            $environment = new SandboxEnvironment(config('services.paypal.client_id'), config('services.paypal.client_secret'));
            $client = new PayPalHttpClient($environment);
            $request = new OrdersAuthorizeRequest($request->token);
            $request->prefer('return=representation');
            try {
                // Call API with your client and get a response for your call
                $response = $client->execute($request);                
                // If call returns body in response, you can get the deserialized version from the result attribute of the response
              //  echo "<pre>"; print_r($response);
                $data = [];
                if($response->statusCode == 201){
                    $data['intent'] = 'AUTHORIZE';
                    $data['status'] = 'COMPLETED';
                    $data['user_id'] = Auth::user()->id;
                    $data['order_id'] = $response->result->id;
                    $data['amount'] = $response->result->purchase_units[0]->payments->authorizations[0]->amount->value;
                    $data['currency_code'] = $response->result->purchase_units[0]->payments->authorizations[0]->amount->currency_code;
                    $data['authorization_id'] = $response->result->purchase_units[0]->payments->authorizations[0]->id;
                    $data['expiration_time'] = $response->result->purchase_units[0]->payments->authorizations[0]->expiration_time;
                }
                echo "<pre>";
                print_r($data);
                die;
            }catch (HttpException $ex) { 
                echo "<pre>";
                echo $ex->statusCode;
                print_r($ex->getMessage());
                die;
            }
        }else{
            echo "Your token expired,please visit the website store again";
        }
    }


    public function captureAuthrizeRequest(Request $request){
        if($request->isMethod('get')){
            $environment = new SandboxEnvironment(config('services.paypal.client_id'), config('services.paypal.client_secret'));
            $client = new PayPalHttpClient($environment);
            $request = new AuthorizationsCaptureRequest('0V320414F1101540L');
            $request->body = [
                    "amount" => [
                        "value" => "1.00",
                        "currency_code" => "USD"
                    ],
                    "is_final_capture" => false
            ];
            $request->prefer('return=representation');
            try {
                // Call API with your client and get a response for your call
                $response = $client->execute($request);
                
                // If call returns body in response, you can get the deserialized version from the result attribute of the response
                echo "<pre>";
                print_r($response);
                die;
            }catch (HttpException $ex) { 
                echo "<pre>";
                echo $ex->statusCode;
                print_r($ex->getMessage());
                die;
            }
        }
    }


    public function reauthrizeRequest(Request $request,$authorization_id=null)
    {
        if(!empty($authorization_id) && $request->isMethod('get')){
            $environment = new SandboxEnvironment(config('services.paypal.client_id'), config('services.paypal.client_secret'));
            $client = new PayPalHttpClient($environment);
            $request = new AuthorizationsReauthorizeRequest($authorization_id);
            $request->prefer('return=representation');
            try {
                // Call API with your client and get a response for your call
                $response = $client->execute($request);
                
                // If call returns body in response, you can get the deserialized version from the result attribute of the response
                echo "<pre>";
                print_r($response);
                die;
            }catch (HttpException $ex) { 
                echo "<pre>";
                echo $ex->statusCode;
                print_r($ex->getMessage());
                die;
            }
        }
    }


    public function returnAuthorizePayment(Request $request,$authorization_id=null){
        if(!empty($authorization_id) && $request->isMethod('get')){
            $environment = new SandboxEnvironment(config('services.paypal.client_id'), config('services.paypal.client_secret'));
            $client = new PayPalHttpClient($environment);
            $request = new AuthorizationsVoidRequest('0V320414F1101540L');
            //$request->prefer('return=representation');
            try {
                // Call API with your client and get a response for your call
                $response = $client->execute($request);
                
                // If call returns body in response, you can get the deserialized version from the result attribute of the response
                echo "<pre>";
                print_r($response);
                die;
            }catch (HttpException $ex) { 
                echo "<pre>";
                echo $ex->statusCode;
                print_r($ex->getMessage());
                die;
            }
        }
    }

    /**
    * Order form for embroider
    */
    public function orderForm(Request $request){
        $userDetail = User::where(['id' => Auth::user()->id])->first();
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $garments = Garment::all();
        $priceCalculator = PriceCalculator::all();
        $inch = 0 ; $centimeter = 0;
        if(count($priceCalculator)){        
            $priceCalculator = $priceCalculator->toArray();
            $inch = $priceCalculator[0]['desired_price']; 
            $centimeter = $priceCalculator[1]['desired_price'];
        }
        return view('embroiderer.orderForm',compact('garments','userDetail','inch','centimeter'));
    }

    /**
    * Cancel Order By Embroiderer
    */
    public function cancelOrder(Request $request){        
        if($request->isMethod('post')){            
            
            if($request->payment_intent_id){
                try{
                    $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                    $refundCheck = $stripe->paymentIntents->cancel($request->payment_intent_id);
                    if($refundCheck->id){                         
                        $st = '';
                        if($refundCheck->status == 'succeeded'){
                            $st = '6';
                        }elseif($refundCheck->status == 'pending'){
                            $st = '7';
                        }elseif($refundCheck->status == 'failed'){
                            $st = '8';
                        }elseif($refundCheck->status == 'canceled'){
                            $st = '9';
                        }  
                        $checkOrderUp = Order::where(['id' => $request->cancel_order_id])->update(['refund_id' => $refundCheck->id , 'status' => $st]);
                        if($checkOrderUp){
                           return redirect()->route('embroiderer-order-management')->with(['alert-type'=>'success','message'=>'Order canceled successfully.']);;

                            // return response()->json([
                            //     "message"       => 'Order canceled successfully.',
                            //     "isSucceeded"   => TRUE
                            // ]);   

                        }
                        
                    }
                }catch(\Exception $e){
                    return response()->json([
                        "message"       => $e->getMessage(),
                        "isSucceeded"   => FALSE
                    ]); 
                }
            }
        }
    }


    /**
    * Download Image Using Image Path
    */
    public function downloadImage($feature_image){
        if(!empty($feature_image)){
            $pathToFile = public_path('orders/').$feature_image;
            return response()->download($pathToFile);    
        }        
    }

     /**
    * Create Order By Embroiderer
    */
    public function createOrder(Request $request){
        if($request->isMethod('post')){
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
            try{
                //$allDataFromRequest = $request->except(['_token', ]);
                $data = $request->except(['_token', ]);
                $data['order_date'] = date('Y-m-d h:i:s');
                $data['user_id'] = Auth::user()->id;
                $data['status'] = '5';
                $data['amount'] = $request->cost_calculate;
                $clickbtn = $request->all();              
                if($request->has('file')){ 
                    $img =$data['file'];
                    $folderPath = public_path().'/orders/';
                    $image_parts = explode(";base64,", $img);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = uniqid().'.'.$image_type;
                    $file = $folderPath.$fileName;
                    $getData = file_put_contents($file, $image_base64);  
                    // $imgName = time().$originalImage->getClientOriginalName(); 
                    $data['feature_image'] = $fileName;  
                } 
                if(isset($data['height_in'])){
                        $data['measurement'] = 1;
                 }elseif(isset($data['height_cm'])){
                        $data['measurement'] = 2;
                    }
                $data['order_unique_id'] = time() . Auth::user()->id;
                $taxs = $this->getAlltaxsforstates(); 
                if($taxs){
                   $userTaxes = array_change_key_case ($taxs ,CASE_LOWER );
                   $userTaxes['total_taxes']=$userTaxes['total_percentage'];
                   unset($userTaxes['total_percentage']); 
                }else{
                    $userTaxes=[]; 
                }
                $alldata = array_merge($data, $userTaxes); 
                //when coupon id exist

                // if($request->coupon_id){                   
                //     $coupenData = Coupon::where('coupon_id',$request->coupon_id)->first();
                //     if($coupenData->amount_off){
                //       $data['amount'] = $data['amount']-$coupenData->amount_off;
                //     }elseif($percentage = $coupenData->percent_off){  
                //         $Finale_amount = ($percentage / 100) * $data['amount'];
                //         $data['amount'] = $data['amount']-$Finale_amount;
                //     }                    
                // }
                $orderCheck = Order::create($alldata);
                if($orderCheck){
                    if(isset($data['height_in'])){
                        $data['measurement'] = 'Inches';
                    }elseif(isset($data['height_cm'])){
                        $data['measurement'] = 'Centimeter';
                    }
                    $data['fullname'] = Auth::user()->first_name .' '. Auth::user()->last_name;
                    $data['garment_name'] = Garment::where('id',$request->garment_id)->value('name');
                    $data['subject'] = 'New Order Received';
                     $sendEmail = mail::to(['netqommain@gmail.com','netqommanager1@gmail.com'])->send( new SendMail($data,'newOrderCreated'));


                    return response()->json([
                        'message' => 'Your order added into cart successfully.',
                        'isSucceeded' => TRUE,
                        'redirect' => $clickbtn['clickbtn'],
                    ]);
                } 
            } catch(\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'isSucceeded' => FALSE
                ]);
            }    
        }
    }

   
   public function reOrder(Request $request){
    if($request->isMethod('post')){ 
            if($request->reorder_id){
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
            try{
                $data = $request->except(['_token', ]);                
                $data['order_date'] = date('Y-m-d h:i:s');
                $data['user_id'] = Auth::user()->id;
                $data['status'] = '5';
                $data['amount'] = $request->cost_calculate;
                //$data['delivery_date'] = DateTime::createFromFormat('m-d-Y', $request->delivery_date)->format('Y-m-d');          
                if(isset($data['height_in'])){
                        $data['measurement'] = 1;
                    }elseif(isset($data['height_cm'])){
                        $data['measurement'] = 2;
                    }
                if(!empty($request->file)){
                    $img = $data['file'];
                    $folderPath = public_path().'/orders/';
                    $image_parts = explode(";base64,", $img);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = uniqid().'.'.$image_type;
                    $file = $folderPath.$fileName;
                    $getData = file_put_contents($file, $image_base64);  
                    // $imgName = time().$originalImage->getClientOriginalName(); 
                    $data['feature_image'] = $fileName;  
                }else{
                    $data['feature_image'] = $request->order_name;  
                }  
                $data['order_unique_id'] = time() . Auth::user()->id;
                $taxs = $this->getAlltaxsforstates(); 
                if($taxs){
                   $userTaxes = array_change_key_case ($taxs ,CASE_LOWER );
                   $userTaxes['total_taxes']=$userTaxes['total_percentage'];
                   unset($userTaxes['total_percentage']); 
                }else{
                    $userTaxes=[]; 
                }
                $alldata = array_merge($data, $userTaxes); 
                //when coupon id exist 
                // if($request->coupon_id){                   
                //     $coupenData = Coupon::where('coupon_id',$request->coupon_id)->first();
                //     if($coupenData->amount_off){
                //       $data['amount'] = $data['amount']-$coupenData->amount_off;
                //     }elseif($percentage = $coupenData->percent_off){  
                //         $Finale_amount = ($percentage / 100) * $data['amount'];
                //         $data['amount'] = $data['amount']-$Finale_amount;
                //     }                    
                // } 
                $orderCheck = Order::find($request->reorder_id)->update($alldata);
                if($orderCheck){
                    if(isset($data['height_in'])){
                        $data['measurement'] = 'Inches';
                    }elseif(isset($data['height_cm'])){
                        $data['measurement'] = 'Centimeter';
                    }
                    $data['fullname'] = Auth::user()->first_name .' '. Auth::user()->last_name;
                    $data['garment_name'] = Garment::where('id',$request->garment_id)->value('name');
                    $data['subject'] = 'New Order Received';
                    $sendEmail = Mail::to(['netqommain@gmail.com','netqommanager1@gmail.com'])->send( new SendMail($data,'newOrderCreated'));
                    return response()->json([
                        'message' => 'Your order added into cart successfully.',
                        'isSucceeded' => TRUE,
                        'redirect' => $request->clickbtn,
                    ]);
                } 
            } catch(\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'isSucceeded' => FALSE
                ]);
            }    

            }
            $priceCalculator = PriceCalculator::all();
            $inch = 0 ; $centimeter = 0;
            if(count($priceCalculator)){        
                $priceCalculator = $priceCalculator->toArray();
                $inch = $priceCalculator[0]['desired_price']; 
                $centimeter = $priceCalculator[1]['desired_price'];
            }  
            return view('embroiderer.reloadOrder',compact('inch','centimeter')); 
        }
 
   } 

    public function checkCoupon(Request $request){
        if($request->isMethod('post')){               
            $coupan_exist = ''; 
            $coupon =  Coupon::where(['coupon_id'=>$request->coupon,'valid' => '1'])->first();             
            $today = date("Y-m-d");   
            if($coupon){  
            if ($today <= $coupon->end_date) {
                $data = array();
                $cartOrderDetails =  Order::where(['user_id' => Auth::user()->id , 'status' => 5])->orderBy('id', 'desc')->get();
                  $addTaxsParcentages = $this->getAlltaxsforstates(); 
                  $sumtotalAmt = 0;
                  $i = 1;
                  $data['subtotaldiscount']=0;
                  $data['afterCouponSubtotal'] =0;
                foreach ($cartOrderDetails as $key => $cartOrderValue) {   
                         $sumtotalAmt =   $sumtotalAmt + $cartOrderValue->amount;  
                         if($coupon->amount_off){
                         $data[$cartOrderValue->id]['discount']   = round($coupon->amount_off, 2); 
                         $afterDiscount  = $cartOrderValue->amount-$coupon->amount_off; 
                         $percentage = $addTaxsParcentages['total_percentage'];  
                         $data[$cartOrderValue->id]['taxs'] = max(round($afterDiscount*($percentage/100), 2), 0);  
                         $afterDiscount  +=  $afterDiscount*($percentage/100);
                         $data[$cartOrderValue->id]['total']  = max(round($afterDiscount, 2), 0); 
                         //subtotalDiscount  
                         if($coupon->amount_off >= $cartOrderValue->amount ){  
                            $data[$cartOrderValue->id]['orderamount'] = 0;
                           }    
                         $CouponID = $coupon->amount_off;
                         $afterDiscountCoupon = $CouponID*$i;
                         $data['afterCouponSubtotal'] = max($sumtotalAmt-$afterDiscountCoupon, 0);
                         $data['subtotaldiscount'] = max($sumtotalAmt-$data['afterCouponSubtotal'], 0) ;


                        }elseif($percentage  = $coupon->percent_off){  
                         $Finale_amount  = ($coupon->percent_off / 100) * $cartOrderValue->amount;
                         $data[$cartOrderValue->id]['discount']  = round($Finale_amount, 2);
                         $afterDiscount  = $cartOrderValue->amount-$Finale_amount; 
                         $percentage = $addTaxsParcentages['total_percentage'];
                         $data[$cartOrderValue->id]['taxs'] = max(round($afterDiscount*($percentage/100), 2), 0);
                         $afterDiscount +=   $afterDiscount*($percentage/100);
                         $data[$cartOrderValue->id]['total']  = max(round($afterDiscount, 2), 0); 
                         //subtotalDiscount      
                       // $data['afterCouponSubtotal'] = max($sumtotalAmt-round($Finale_amount, 2), 0); 
                         $data['subtotaldiscount'] += round($Finale_amount, 2);
                         $data['afterCouponSubtotal'] = max($sumtotalAmt-round($data['subtotaldiscount'], 2), 0);

                    }  
                    $i++; 
                 }  
                 if($addTaxsParcentages['total_percentage'] != 0){
                    array_pop($addTaxsParcentages);
                     $taxtotal = 0;
                     // $data['alltaxs']= '';
                    foreach ($addTaxsParcentages as $key => $taxsParcentageValues) { 
                              $totaltaxs = round($data['afterCouponSubtotal']*($taxsParcentageValues/100),2);
                              $taxtotal = $taxtotal + $totaltaxs; 
                              $data['alltaxs'][$key.' '.$taxsParcentageValues] = $totaltaxs;
                              $data['afterCouponFinalTotal'] = round($data['afterCouponSubtotal'],2) + $taxtotal; 
                                   } 
                   

                    $data['html'] = '<ul class="list-unstyled p-0 m-0">
                    <li><span>Sub Total</span> <b>$'.$data["afterCouponSubtotal"].'</b></li>
                    <li class="subtotalDiscount"><span>Discount</span><b>$'.$data["subtotaldiscount"].'</b></li>';
                    foreach ($data['alltaxs'] as $key => $alltaxsValue) {  
                      $data['html'] .= '<li><span>'.$key.'%</span> <b>$'.$alltaxsValue.'</b></li>';
                     }
                    $data['html'] .= '<li><span>Total</span> <b>$'.$data['afterCouponFinalTotal'].'</b></li>
                    </ul>'; 
                     
                     }else{
                        $data['html'] = '<ul class="list-unstyled p-0 m-0">
                    <li><span>Sub Total</span> <b>$'.$data["afterCouponSubtotal"].'</b></li>
                    <li class="subtotalDiscount"><span>Discount</span><b>$'.$data["subtotaldiscount"].'</b></li>';
                     
                    $data['html'] .= '<li><span>Total</span> <b>$'.$data["afterCouponSubtotal"].'</b></li>
                    </ul>'; 
                     
                     }

                     $data['coupan_exist'] = 1;
                     if($coupon->amount_off){
                     $data['coupan_price'] = '$'.$coupon->amount_off;
                    }else{
                        $data['coupan_price'] = $coupon->percent_off.'%';
                    }

               
                   } else{
                     $data['coupan_exist'] = 2;
                   }                   
                }else{
                    $data['coupan_exist'] = 0;
                }
            
               return $data;
        }
    }


    /**
    * Embr create zero charge
    */
    public function embroidererCreateZeroCharge(Request $request){
          //echo "<pre>"; echo "hi"; print_r($request->all());die;
        if($request->isMethod('post')){
            try{
                //$stripe = new \Stripe\StripeClient(config('services.stripe.secret'));           
                $userDetail = User::find(Auth::user()->id, ['first_name', 'last_name', 'email','stripe_id','id','state','country']);
                $taxsForThisUsers = $this->getAlltaxsforstates(); 
                $allOrder = Order::where(['user_id' => $userDetail->id , 'status' => '5'])->get();
                $card_id = '';
                $coupenData = '';                      
                foreach ($allOrder as $key => $order) {
                    $amt = 0;
                    $totalAmount = 0;
                    $amount_after_coupon = 0;
                    $allDone = false;
                    $order_group_id = $this->generateRandomString();
                    $cCheck=false;
                    if(!empty($request->coupon_id)){
                        $cCheck = true;
                        $coupenData = Coupon::where('coupon_id',$request->coupon_id)->first();
                        if($coupenData->amount_off){                         
                          if($taxsForThisUsers['total_percentage'] > 0 ){    
                            $amt = ($order->amount)-($coupenData->amount_off);  
                            $amount_after_coupon = $amt;                      
                            $percentage = $taxsForThisUsers['total_percentage'];
                            $amt += $amt*($percentage/100);
                            $totalAmount = round($amt, 2);;
                         }else{
                            $amt = ($order->amount)-($coupenData->amount_off);
                            $amount_after_coupon = $amt;
                         }  
                        }elseif($percentage = $coupenData->percent_off){
                          if($taxsForThisUsers['total_percentage'] > 0 ){    
                            $final_amount = ($percentage / 100) * $order->amount;
                            $amt = ($order->amount)-($final_amount);                           
                            $amount_after_coupon = $amt; 
                            $percentage = $taxsForThisUsers['total_percentage'];
                            $amt += $amt*($percentage/100);
                            $totalAmount = round($amt, 2);
                           }else{
                             $final_amount = ($percentage / 100) * $order->amount;
                             $amt = ($order->amount)-($final_amount);
                             $amount_after_coupon = $amt;
                           }
                        } 
                    }else{                                                                          
                          if($taxsForThisUsers['total_percentage'] > 0 ){
                            $amt = $order->amount;
                            $percentage = $taxsForThisUsers['total_percentage'];
                            $amt += $amt*($percentage/100);
                            $totalAmount = round($amt, 2);;
                         }else{
                            $amt = $order->amount;
                            $totalAmount = round($amt, 2);
                         } 
                    } 
                    $amt = ceil($amt); 
                        if($cCheck){
                            $updateOrder = Order::where(['id' => $order->id])->update(['order_group_id' => $order_group_id , 'status' => '1' , 'coupon_id' => $request->coupon_id , 'amount_after_coupon' => $amount_after_coupon,'total_amount' => 0]);    
                        }else{ 
                            $amount_after_coupon = 0;
                            $updateOrder = Order::where(['id' => $order->id])->update(['order_group_id' => $order_group_id , 'status' => '1' , 'amount_after_coupon' => $amount_after_coupon,'total_amount'=>0]);
                        }
                        if($coupenData)  {
                            $times_redeemed = $coupenData->times_redeemed + 1; 
                            $updateCoupone = Coupon::where('coupon_id',$request->coupon_id)->update(['redeem_by'=>date('Y/m/d H:i:s'),'times_redeemed'=>$times_redeemed]);
                        }                
                    $allDone = true;
                }
                if($allDone){
                    return response()->json([
                        'message' => 'Your order is placed successfully', 
                        'isSucceeded' => TRUE,
                        'order_group_id' => $order_group_id,
                    ]);
                }        
            }catch(\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage(), 
                    'isSucceeded' => FALSE
                ]);
            }
        } 
    }
    /**
    * Create charge from embroiderer side
    */
    public function createPaymentIntent(Request $request){
        
        if($request->isMethod('post')){
            try{
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));           
                $userDetail = User::find(Auth::user()->id, ['first_name', 'last_name', 'email','stripe_id','id','state','country']);
                $taxsForThisUsers = $this->getAlltaxsforstates(); 
                $stripeCustomerId = $userDetail->stripe_id;
                if (empty($stripeCustomerId) ) { 
                    //Create customer if not before created               
                    $stripeCustomer = $stripe->customers->create([ "email"  => $userDetail->email, 'name' => $userDetail->first_name.' '.$userDetail->last_name ]); 
                    $stripeCustomerId = $stripeCustomer->id;
                    $updateCus = User::where(['id' => Auth::user()->id])->update(['stripe_id' => $stripeCustomerId]);
                }
                $allOrder = Order::where(['user_id' => $userDetail->id , 'status' => '5'])->get();
                $card_id = '';
                $coupenData = '';
                if($request->paymentMethod == 'stripe'){
                    $card_id = $request['token']['card']['id'];
                    if($request->saveMethod){
                        $attachCustomer = $stripe->customers->createSource($stripeCustomerId,['source' => $request['token']['id']]);
                        $this->saveMethod($attachCustomer);                         
                    }else{

                        $attachCustomer = $stripe->customers->createSource($stripeCustomerId,['source' => $request['token']['id']]);
                    }
                }elseif ($request->paymentMethod != 'paypal') {
                    $card_id = $request->paymentMethod;
                }                      
                foreach ($allOrder as $key => $order) {
                    $amt = 0;
                    $totalAmount = 0;
                    $amount_after_coupon = 0;
                    $allDone = false;
                    $order_group_id = $this->generateRandomString();
                    $cCheck=false;
                    if(!empty($request->coupon_id)){
                        $cCheck = true;
                        $coupenData = Coupon::where('coupon_id',$request->coupon_id)->first();
                        if($coupenData->amount_off){                         
                          if($taxsForThisUsers['total_percentage'] > 0 ){	 
                            $amt = ($order->amount)-($coupenData->amount_off);  
                            $amount_after_coupon = $amt;                      
							$percentage = $taxsForThisUsers['total_percentage'];
							$amt += $amt*($percentage/100);
							$totalAmount = round($amt, 2);;
                         }else{
                         	$amt = ($order->amount)-($coupenData->amount_off);
                         	$amount_after_coupon = $amt;
                         }  
                        }elseif($percentage = $coupenData->percent_off){
                          if($taxsForThisUsers['total_percentage'] > 0 ){	 
                            $final_amount = ($percentage / 100) * $order->amount;
                            $amt = ($order->amount)-($final_amount);                           
                            $amount_after_coupon = $amt; 
                            $percentage = $taxsForThisUsers['total_percentage'];
							$amt += $amt*($percentage/100);
							$totalAmount = round($amt, 2);
                           }else{
                           	 $final_amount = ($percentage / 100) * $order->amount;
                             $amt = ($order->amount)-($final_amount);
                             $amount_after_coupon = $amt;
                           }
                        } 
                    }else{                                                                          
                          if($taxsForThisUsers['total_percentage'] > 0 ){
	                        $amt = $order->amount;
							$percentage = $taxsForThisUsers['total_percentage'];
							$amt += $amt*($percentage/100);
							$totalAmount = round($amt, 2);;
                         }else{
                         	$amt = $order->amount;
                         	$totalAmount = round($amt, 2);;
                         } 
                    } 
                    $amt = ceil($amt);                     
                    $createPaymentIntent = $stripe->paymentIntents->create([
                        'amount' => $amt * 100,
                        'currency' => 'usd',
                        'payment_method_types' => ['card'],
                        'customer' => $stripeCustomerId,
                        'payment_method' => $card_id,
                        'capture_method' => 'manual',
                    ]);
                    if($createPaymentIntent->status == 'requires_confirmation'){
                        //Confirm intent one line code
                        $confirmPaymentIntent = $stripe->paymentIntents->confirm($createPaymentIntent->id,[]);                    
                        $paymentDone = $this->savePaymentDetail($confirmPaymentIntent,$order_group_id);
                        if($paymentDone){
                            if($cCheck){
                                $updateOrder = Order::where(['id' => $order->id])->update(['order_group_id' => $order_group_id , 'status' => '1' , 'coupon_id' => $request->coupon_id , 'amount_after_coupon' => $amount_after_coupon,'total_amount' => $totalAmount]);    
                            }else{ 
                            	$amount_after_coupon = 0;
                                $updateOrder = Order::where(['id' => $order->id])->update(['order_group_id' => $order_group_id , 'status' => '1' , 'amount_after_coupon' => $amount_after_coupon,'total_amount'=>$totalAmount]);
                            }  
                            if($coupenData)  {
                                $times_redeemed = $coupenData->times_redeemed + 1; 
                                $updateCoupone = Coupon::where('coupon_id',$request->coupon_id)->update(['redeem_by'=>date('Y/m/d H:i:s'),'times_redeemed'=>$times_redeemed]);
                            }                       
                             
                        }
                    }
                    $allDone = true;
                }
                if($allDone){
                    return response()->json([
                        'message' => 'Your order is placed successfully', 
                        'isSucceeded' => TRUE
                    ]);
                }        
            }catch(\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage(), 
                    'isSucceeded' => FALSE
                ]);
            }
        }            
    }
/*
  Invoice
*/
public function paymentInvoices(Request $request){
             if($request->isMethod('post')){
            try{       
                 return response()->json([
                    'message' => 'Invoice Id created', 
                    'isSucceeded' => true,
                ]);
            }catch(\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage(), 
                    'isSucceeded' => FALSE
                ]);
            }

              
        }
    }
    /*
    * Save payment detail
    */
    private function savePaymentDetail($confirmPaymentIntent,$order_group_id){
        $data=[];
        $data['st_payment_intent_id'] = $confirmPaymentIntent->id;
        $data['st_amount_capturable'] = $confirmPaymentIntent->amount_capturable/100;
        $data['st_amount_received'] = $confirmPaymentIntent->amount_received/100;
        $data['st_charge_id'] = $confirmPaymentIntent->charges->data[0]->id;                    
        $data['st_payment_method'] = $confirmPaymentIntent->payment_method;
        if($confirmPaymentIntent->status == 'requires_capture'){
            $data['st_status'] = '2';
        }elseif($confirmPaymentIntent->status == 'requires_confirmation'){
            $data['st_status'] = '1';    
        }
        $data['invoice'] = $confirmPaymentIntent->invoice;
        $data['billing_country'] = $confirmPaymentIntent->charges->data[0]->billing_details->address->country;
        $data['billing_name'] = $confirmPaymentIntent->charges->data[0]->billing_details->name;
        $data['amount'] =    $confirmPaymentIntent->amount/100;
        $data['currency'] = $confirmPaymentIntent->currency;
        $data['created'] = date('Y-m-d H:i:s', $confirmPaymentIntent->created);
        $data['order_group_id'] = $order_group_id;
        $data['user_id'] = Auth::user()->id;
        $paymentDone = PaymentDetail::create($data); //save detail to payment table
        if($paymentDone){
            return '1';
        }
        return '0';
    } 

    /*
    * During payment Save Method as well
    */
    private  function saveMethod($attachCustomer){
        $data['last4'] = $attachCustomer->last4;
        $data['exp_month'] = $attachCustomer->exp_month;
        $data['exp_year'] = $attachCustomer->exp_year;
        $data['card_id'] = $attachCustomer->id;
        $data['user_id'] = Auth::user()->id;
        $data['brand'] = $attachCustomer->brand;
        $data['funding'] = $attachCustomer->funding;
        $data['type'] = 'card';
        $userHasCard = CardDetail::create($data);
        if($userHasCard){


            return '1';
        }
        return '0';
    }

    /**
    * Order List Cards Management
    */
    public function orderManagement(Request $request){
        if($request->isMethod('get')){
            $priceCalculator = PriceCalculator::all();
            $inch = 0 ; $centimeter = 0;
            if(count($priceCalculator)){        
                $priceCalculator = $priceCalculator->toArray();
                $inch = $priceCalculator[0]['desired_price']; 
                $centimeter = $priceCalculator[1]['desired_price'];
            }  
            return view('embroiderer.ordersManagement',compact('inch','centimeter'));      
        }
    }
   public function createNew(Request $request){
        if($request->isMethod('get')){
            $priceCalculator = PriceCalculator::all();
            $inch = 0 ; $centimeter = 0;
            if(count($priceCalculator)){        
                $priceCalculator = $priceCalculator->toArray();
                $inch = $priceCalculator[0]['desired_price']; 
                $centimeter = $priceCalculator[1]['desired_price'];
            }  
            return view('embroiderer.CreateNewOrderPage',compact('inch','centimeter'));      
        }
    }

    public function test(Request $request){
        return view('embroiderer.test');
    }

    /*
    * Experience filter method
    */
    public function orderRepresent(Request $request){
        //echo "<pre>"; print_r($request->all());die;
         $user = Auth::user();
        if($request->ajax()){            
            $conditions[]=['status','!=', 5];     
            $conditions[]=['user_id','=', $user->id];   
             $filterData = false; 
            if (!empty($request->maximumDate) && !empty($request->minimumDate)) {
                $startDate = Carbon::createFromFormat('m/d/Y', $request->minimumDate)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('m/d/Y', $request->maximumDate)->format('Y-m-d');
                $conditions[]=['created_at','>=', $startDate];
                $conditions[]=['created_at','<=', $endDate];
                $filterData = true;
            }
            $orderList = '';
            if(!empty($request->desired_output)){
                $conditions[]=['desired_output','=', $request->desired_output];
                $filterData = true;
            }if(!empty($request->status)){
                $conditions[]=['status','=', $request->status];   
                $filterData = true;  
            }   
            $orderList = Order::with(['garment','payment_details','digitizer','rejection_reason'])->where($conditions)->orderBy('id', 'DESC');   
            $orderList = $orderList->paginate(9);
            $digitizerList = User::where(['user_role' => '3'])->get();              
            $rejectionReason = RejectionReason::all(); 
            $garmentType = Garment::all();
            $priceCalculator = PriceCalculator::all();       
                $inch = 0 ; $centimeter = 0;
                if(count($priceCalculator)){        
                    $priceCalculator = $priceCalculator->toArray();
                    $inch = $priceCalculator[0]['desired_price']; 
                    $centimeter = $priceCalculator[1]['desired_price'];
                }
            $html = View::make('embroiderer.orderRepresent',compact('orderList','user','digitizerList','rejectionReason','inch','centimeter','garmentType','priceCalculator'))->render();

            if(count($orderList)){
                return response()->json([
                    "message"       => 'Experiences get successfully.',
                    "isSucceeded"   => TRUE,
                    "data"          => $html,
                ]);
            }else{
                if($filterData == true){
                $html = '<div class="col-lg-12">
                    <div class="exp-box" style="text-align: center;font-weight: 500;">
                        There is no data related to this filter.
                    </div>
                </div>';
                    }else{
                       $html = '<div class="col-lg-12">
                    <div class="orders_empty" style="text-align: center;font-weight: 500;">
                        <h3> Your order history is empty Yet.</h3>
                        <p style="color: #708da8;">Upload your first image and place an </br>order to see the story here</p>
                    </div>
                </div>';
                    }
                return response()->json([
                    "message"       => 'Your order history is empty yet.',
                    "isSucceeded"   => FALSE,
                    "data"          => $html
                ]);
            }
        }
    }

    /**
    * Order Image Update On Rejected Case
    */
    public function orderImage(Request $request){
        if($request->isMethod('post')){
            $folderPath = public_path().'/orders/';
            $imageName = '';
            $originalImage = $request->feature_image;
            $thumbnailImage = Image::make($originalImage);
            $imgName = time().$originalImage->getClientOriginalName();         
            $imageName = $thumbnailImage->save($folderPath.$imgName);
            if(!empty($imageName)){
                $updateOrder = Order::where(['id' => $request->o_id])->update(['status' => '1','feature_image' => $imgName]);
                return response()->json([
                    'message'       => 'Order image uploaded successfully.',
                    'isSucceeded'   => TRUE
                ]);
            }else{
                return response()->json([
                    'message'       => 'Image not uploaded',
                    'isSucceeded'   => FALSE
                ]);
            }
        }
    }

    /**
    * Order Detail Page
    */
    // public function embroidererOrderDetail(Request $request, $id=null){
    //     $order = Order::with(['user'])->where(['id' => base64_decode($id)])->first();
    //     $garmentType = Garment::all();
    //     $priceCalculator = PriceCalculator::all();
    //     $orderImages = OrderImage::where(['order_id' => base64_decode($id)])->get(); 
    //     return view('embroiderer.orderDetail',compact('order','garmentType','priceCalculator','orderImages'));
    // }

    public function completedImagesDetail(Request $request){
        if($request->isMethod('get')){
            $allOrder = '';
            $orderImages = '';
            $html = '';
            if($request->order_id){
              $allOrder = Order::with(['user','digitizer','rejection_reason','payment_details','order_images'])
                                ->where(['id' => $request->order_id])->first(); 

               $orderImages = OrderImage::where(['order_id' => $request->order_id])->get();
                if($allOrder->status == 4) {
                         $html = '<h5 class="completed_files">Submitted Files<div class="order_btns"></h5>'; 
                    foreach ($orderImages as $allImages) {
                        $html .= '<div class="ftr-modal-box">';
                         $html .= '<div class="ftr-dwnld-left"> 
                           <img class="img-submitted" src="'.url('/public/orders').'/'.$allImages->order_image.'" height="85px" width="100px" /></div>
                            <div class="ftr-dwnld-btn">
                            <a class="btn downloardButton" href="'.route("embroiderer-download-image", $allImages->order_image).'">Download</a> 
                            </div>';  
                            $html .= '</div>';                        
                    }
                            
                }
                  return response()->json([                   
                        "isSucceeded"   => true,
                        "data"          => $html,
                         
                     ]);                 
            }
             
        }

    }

    public function cancelingIntent(Request $request){
        if($request->isMethod('get')){
            try{
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                $cancellationReason = 'duplicate';
                $t = $stripe->paymentIntents->confirm('pi_1I6x7mJtMGvAFFxtTurSzDcs',['cancellation_reason' => $cancellationReason]);
                echo "<pre>";
                print_r($t);
            }catch(\Exception $e){
                echo "<pre>"; print_r($e->getMessage());die;
            }
        }
    }

    /**
    * Add Card To Customer Stripe Account and Save it Database As Well
    */
    public function addCard(Request $request){
        $customer = Auth::user();
        if( $request->isMethod('post') ) {
            $dataAll = $request->all();
            try{
                $paymentMethod = $request->paymentMethod;
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                $stripeCustomerId = Auth::user()->stripe_id;
                if ( empty($stripeCustomerId) ) {                
                    $stripeCustomer = $stripe->customers->create([ "email"  => $customer->email, 'name' => Auth::user()->first_name.' '.Auth::user()->last_name]); 
                    $stripeCustomerId = $stripeCustomer->id;
                }
                if( $stripeCustomerId ){
                    $attachCustomer = $stripe->customers->createSource($stripeCustomerId,['source' => $dataAll['token']['id']]);
                    if($attachCustomer->id){
                        $data['last4'] = $attachCustomer->last4;
                        $data['exp_month'] = $attachCustomer->exp_month;
                        $data['exp_year'] = $attachCustomer->exp_year;
                        $data['card_id'] = $attachCustomer->id;
                        $data['user_id'] = Auth::user()->id;
                        $data['brand'] = $attachCustomer->brand;
                        $data['funding'] = $attachCustomer->funding;
                        $data['type'] = $dataAll['token']['type'];
                        $userHasCard = CardDetail::where(['user_id' => Auth::user()->id])->first();
                        $data['status'] = $userHasCard ? '0' : '1';
                        $newCardCreateCheck = CardDetail::create($data);
                        if($newCardCreateCheck){
                            $updateCus = User::where(['id' => Auth::user()->id])->update(['stripe_id' => $stripeCustomerId]);
                            $data['subject'] = 'New order created.';
                            $numberOfCard = CardDetail::where(['user_id' => Auth::user()->id])->count();
                            $sendEmail = Mail::to([Auth::user()->id])->send( new SendMail($data,'newOrderCreated'));
                            $html = '<div class="card-option check_'.$attachCustomer->id.'">
                                        <h4 class="checkCount">Payment Method #'.$numberOfCard.'</h4>
                                        <div class="payment-option-box">
                                            <div class="card-number"> <img src="'.asset('backend-images/master-card-icon.png').'" /> <span class="number">**** '.$attachCustomer->last4.'</span> </div>
                                            <button class="edit-payment-option" card_id="'.$attachCustomer->id.'">Remove</button>
                                        </div>
                                    </div>';
                            return response()->json([
                                "message"       => 'You have successfully added your payment method.',
                                "isSucceeded"   => TRUE,
                                "data"          => $attachCustomer,
                                "htmlpass"      => $html
                            ]);
                        }else{
                            return response()->json([
                                "message" => 'Your card does not create.',
                                "isSucceeded" => FALSE,
                            ]);    
                        }  
                    }  
                }                     
                
            } catch(\Stripe\Exception\CardException $e) {
                return response()->json([
                    "message" => $e->getError()->message,
                    "isSucceeded" => FALSE
                ]);
            }         
        }
    }

    /**
    * Card List Management 
    */
    public function cardsManagement(Request $request){
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $dataCheck = CardDetail::where(['user_id' => Auth::user()->id])->first();
        if ($request->ajax()) {
            $data = CardDetail::where(['user_id' => Auth::user()->id])->orderBy('id', 'desc')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        return '<a href="" class="edit btn btn-danger btn-sm mb-enabl action-card-btn" style="margin-left: 2px;margin-top: 2px;" card_id="'.base64_encode($row->card_id).'" ><i data-toggle="tooltip" data-placement="top" title="Delete Card" class="fa fa-trash" aria-hidden="true"></i></a>';
                        
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('edit-profile',['dataCheck' => $dataCheck]);
    }



    /**
    * Delete Card functinality
    */
    public function deleteCard(Request $request)
    {   
        if($request->isMethod('post')){              
            try {
                $crdId = $request['card_id'];
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                $detachCheck = $stripe->customers->deleteSource(Auth::user()->stripe_id,$crdId,[]);
                if($detachCheck->deleted){
                    CardDetail::where(['user_id' => Auth::user()->id , 'card_id' => $crdId])->delete();
                    return response()->json([
                        "message"       => 'Your card removed successfully.',
                        "isSucceeded"   => TRUE,
                    ]);
                }else{
                    return response()->json([
                        "message"       => 'Your card does not remove.',
                        "isSucceeded"   => FALSE
                    ]);    
                }      
            } catch(\Stripe\Exception\CardException $e) {
                return response()->json([
                    "message"       => $e->getError()->message,
                    "isSucceeded"   => FALSE
                ]);
            }   
        }
    }

    /**
    * Set Card as default for customer functinality
    */
    public function setDefaultCard(Request $request)
    {
        if($request->isMethod('post')){
            try {
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                $setdefaultCheck =  $stripe->customers->update( Auth::user()->stripe_id, ['default_source' => $request->card_id ]); 
                if($setdefaultCheck->id){
                    CardDetail::where(['status' => '1'])->update(['status' => '0']);
                    CardDetail::where(['user_id' => Auth::user()->id , 'card_id' => $request->card_id])->update(['status' => '1']);
                    return response()->json([
                        "message"     => 'Your card set as default payment methods successfully.',
                        "isSucceeded" => TRUE,
                        "data"        => CardDetail::where(['user_id' => Auth::user()->id , 'card_id' => $request->card_id])->first()
                    ]);
                }else{
                    return response()->json([
                        "message"     => 'Your card does not set as default payment method.',
                        "isSucceeded" => FALSE,
                        "data"        => []
                    ]);    
                }     
            } catch(\Stripe\Exception\CardException $e) {
                return response()->json([
                    "message" => $e->getError()->message,
                    "isSucceeded" => FALSE
                ]);
            }  
        }
    }

    /**
    * card list customer functinality
    */
    public function cardList(Request $request)
    {
        if($request->isMethod('get')){
            $cards = CardDetail::where(['user_id' => Auth::user()->id , 'status' => '0'])->get();
            return response()->json([
                "message"     => 'Card list get successfully.',
                "isSucceeded" => TRUE,
                "data"        => $cards
            ]);
        }else{
            return response()->json([
                "message"       => 'There is no card.',
                "isSucceeded"   => FALSE,
                "data"          => []
            ]);    
        }     
    }

    /**
    * Search order functionality
    */
    public function searchOrder(Request $request){
        if($request->isMethod('get')){
            $priceCalculator = PriceCalculator::all();
            $inch = 0 ; $centimeter = 0;
            if(count($priceCalculator)){         
                $priceCalculator = $priceCalculator->toArray();
                $inch = $priceCalculator[0]['desired_price']; 
                $centimeter = $priceCalculator[1]['desired_price'];
            }  
            return view('embroiderer.searchOrder',compact('inch','centimeter'));      
        }
    }


    /*
    * Experience filter method
    */
    public function searchOrderRepresent(Request $request){
        
        $user = Auth::user();
        if($request->ajax()){            
            $conditions[]=['user_id','=',Auth::user()->id ];            
            $conditions2=[];            
            if (!empty($request->maximumDate) && !empty($request->minimumDate)) {
                $startDate = Carbon::createFromFormat('m/d/Y', $request->minimumDate)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('m/d/Y', $request->maximumDate)->format('Y-m-d');
                $conditions[]=['created_at','>=', $startDate];
                $conditions[]=['created_at','<=', $endDate];
            }
            if(!empty($request->desired_output)){
                $conditions[]=['desired_output','=', $request->desired_output];
            }
            if(!empty($request->status)){
                $conditions[]=['status','=', $request->status];
            }
            if ($request->filled('searchParam')) {
                $conditions[]=['order_name','like', '%'.$request->searchParam.'%'];
            }
            if ($request->filled('searchParam')) {
                $conditions2[]=['order_unique_id','=', $request->searchParam];
            }
            $orderList = Order::with(['garment','payment_details'])->where($conditions)->orWhere($conditions2);
            $orderList = $orderList->paginate(10);
            $html = View::make('embroiderer.orderRepresent',compact('orderList','user'))->render();
            if(count($orderList)){
                return response()->json([
                    "message"       => 'Experiences get successfully.',
                    "isSucceeded"   => TRUE,
                    "data"          => $html,
                ]);
            }else{
                $html = '<div class="col-lg-12">
                    <div class="exp-box" style="text-align: center;font-weight: 500;">
                        There is no data related to this filter.
                    </div>
                </div>';
                return response()->json([
                    "message"       => 'There is no order found.',
                    "isSucceeded"   => FALSE,
                    "data"          => $html
                ]);
            }
        }
    }


    /**
    * Embroider Checkout Functionality
    */
    public function cart(Request $request){
        $data =  Order::with('garment')->where(['user_id' => Auth::user()->id , 'status' => 5])->orderBy('id', 'desc')->get();        

        $garmentType = Garment::all();
        $priceCalculator = PriceCalculator::all();
        $inch = 0 ; $centimeter = 0;
        if(count($priceCalculator)){        
            $priceCalculator = $priceCalculator->toArray();
            $inch = $priceCalculator[0]['desired_price']; 
            $centimeter = $priceCalculator[1]['desired_price'];
        }    
        if ($request->ajax()) {             
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return $actionBtn = '<a href="javascript:void(0)" class="btn btn-outline-danger delete-btn delete-item-from-shopping-cart" order_amt="'.$row->amount.'" order_id="'.base64_encode($row->id).'"><i class="far fa-trash-alt"></i> </a>
                    <a id="edit-order-btn"  href="javascript:void(0)" act-name="edit-order" order_id="'.base64_encode($row->id).'" class="completed-tag editBtn action_order float-right" data-dismiss="modal" aria-label="Close" style=""  ><i class="fa fa-edit"></i> </a>
 

                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $allOrder = $data;
        return view('embroiderer.cart',compact('allOrder','garmentType','priceCalculator','inch','centimeter'));
    }
   

     /**
    * Update Order Function
    */
    public function updateCartOrder(Request $request){
      
        if($request->isMethod('post')){ 
            if($request->editOrder_id){              
            try{
                $data = $request->except(['_token', ]);
                $data['order_date'] = date('Y-m-d h:i:s'); 
                $data['amount'] = $request->cost_calculate;                       
                if(isset($data['height_in'])){
                        $data['measurement'] = 1;
                    }elseif(isset($data['height_cm'])){
                        $data['measurement'] = 2;
                    }
                if(!empty($request->file)){
                    $img = $data['file'];
                    $folderPath = public_path().'/orders/';
                    $image_parts = explode(";base64,", $img);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = uniqid().'.'.$image_type;
                    $file = $folderPath.$fileName;
                    $getData = file_put_contents($file, $image_base64);              
                    $data['feature_image'] = $fileName;  
                }else{
                    $data['feature_image'] = $request->order_name;  
                }  
                $data['order_unique_id'] = time() . Auth::user()->id;
                $taxs = $this->getAlltaxsforstates(); 
                if($taxs){
                   $userTaxes = array_change_key_case ($taxs ,CASE_LOWER );
                   $userTaxes['total_taxes']=$userTaxes['total_percentage'];
                   unset($userTaxes['total_percentage']); 
                }else{
                    $userTaxes=[]; 
                }
                $alldata = array_merge($data, $userTaxes);                
                $orderCheck = Order::find($request->editOrder_id)->update($alldata);
                if($orderCheck){                    
                    return response()->json([
                        'message' => 'Your order updated into cart successfully.',
                        'isSucceeded' => TRUE,
                        'redirect' => $request->clickbtn,
                    ]);
                } 
            } catch(\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'isSucceeded' => FALSE
                ]);
            }    

            }
 
        }
 
  
    }


     /**
    * Update Order Function
    */
    public function getCartOrder(Request $request){
        if($request->isMethod('post')){           
            if($request->order_id){
                   $getOrder = Order::where(['id' => base64_decode($request->order_id)])->first();
                   return response()->json([
                    "isSucceeded"   => TRUE,
                    'orders' => $getOrder
                ]);
            }
        }
    }
    /**
    * Remove order from cart
    */
    public function removeItem(Request $request){
        if($request->isMethod('post')){
            $checkOrderDelete = Order::where(['id' => base64_decode($request->order_id)])->delete();
            if (empty($checkOrders)) {
                return response()->json([
                    "isSucceeded"   => TRUE,
                    'message' => 'Item removed from cart successfully.'
                ]);
            }else{
                return response()->json([
                    "isSucceeded"   => FALSE,
                    'message' => 'Oops something went wrong.'
                ]);
            }            
        }
    }

    /**
    * Clear cart from embroiderer side
    */
    public function clearCart(){
        $checkCartEmpty = Order::where(['user_id' => Auth::user()->id , 'status' => 5])->delete();
        $checkOrders = Order::where(['user_id' => Auth::user()->id , 'status' => 5])->first();
        if(empty($checkOrders)){
            return redirect()->route('embroiderer-order-form')->with(['alert-type'=>'success','message'=>'Your cart empty successfully.']);    
        }else{
            return redirect()->back()->with(['alert-type' => 'error','message' => 'Opps,some problem occur to clear the cart,please try again.']);
        }        
    }

    /**
    * Generate random string
    */
    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
      /**
    * Get All taxs
    */
	public function getAlltaxsforstates() {
		      $taxNamesAndValues = [];
			  $userDetail = User::find(Auth::user()->id, ['first_name', 'last_name', 'email','stripe_id','id','state','country']);
		      if($userDetail->country == 38){
	                $canadaStatesTaxs = States::where('country_id',$userDetail->country)->get();
	            	foreach ($canadaStatesTaxs as $key => $taxStates) {                		
	        		   if($userDetail->state == $taxStates->id && $userDetail->country == $taxStates->country_id ){   
	        		      if($taxStates->type){   
	                        $taxsTypes = explode(",",$taxStates->type);
	                        foreach ($taxsTypes as $key => $taxs) {	                      	
	                      	 $taxNamesAndValues[$taxs]  = $taxStates->$taxs;  
	                        } 
                          } 
	        		    }              		 
	        	   }
	        	   $taxsValues = array_values($taxNamesAndValues); 
	        	   $total = array_sum( $taxsValues);
	        	   $taxNamesAndValues['total_percentage'] = $total;
	        	   return $taxNamesAndValues; 
	          }else{

	          	$taxNamesAndValues['total_percentage'] = 0;
	        	   return $taxNamesAndValues; 
	          }
	    }
    
   
}
