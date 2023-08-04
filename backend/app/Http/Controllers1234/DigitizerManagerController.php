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
use App\RejectionReason;
use App\Garment;
use App\Order;
use App\OrderImage;
use DateTime;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use View;
use Carbon\Carbon;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Payments\AuthorizationsCaptureRequest;
use PayPalCheckoutSdk\Payments\AuthorizationsReauthorizeRequest;
use PayPalCheckoutSdk\Payments\AuthorizationsVoidRequest;
use PayPalCheckoutSdk\Orders\OrdersAuthorizeRequest;
use Illuminate\Support\Facades\Redirect;
use Session;

class DigitizerManagerController extends Controller
{
    /**
     * Digitizer manager dashboard.
     */
    public function dashboard(Request $request)
    {
        return view('digitizer_manager.dashboard');
    }

    /**
    *	Change Password Form
    */
    public function changePasswordForm(Request $request){
        return view('digitizer_manager.changePassword');
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
            return view('digitizer_manager.ordersManagement',compact('inch','centimeter'));      
        }
    }

     /*
    * Experience filter method
    */
    public function orderRepresent(Request $request){
        //echo "<pre>"; print_r($request->all());die;
        $user = Auth::user();
        if($request->ajax()){      
            $filterData = false;      
            $conditions=[];        
            if (!empty($request->maximumDate) && !empty($request->minimumDate)) {
                $startDate = Carbon::createFromFormat('m/d/Y', $request->minimumDate)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('m/d/Y', $request->maximumDate)->format('Y-m-d');
                $conditions[]=['created_at','>=', $startDate];
                $conditions[]=['created_at','<=', $endDate];
            }
            $orderList = '';
            if(!empty($request->desired_output)){
                $conditions[]=['desired_output','=', $request->desired_output];
            }if(!empty($request->status)){
                $conditions[]=['status','=', $request->status];
                $orderList = Order::with(['garment','payment_details','digitizer','rejection_reason'])->where($conditions)->orderBy('id', 'DESC');          
            }else{
               $orderList = Order::with(['garment','payment_details','digitizer','rejection_reason'])->where($conditions)->whereIn('status',[1,2,3,6,9])->orderBy('id', 'DESC');
            }
            if(!empty($request->maximumDate) && !empty($request->minimumDate) || !empty($request->desired_output) || !empty($request->status)){

                 $filterData = true;
             }             
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
            $html = View::make('digitizer_manager.orderRepresent',compact('orderList','user','digitizerList','rejectionReason','inch','centimeter','garmentType','priceCalculator'))->render();
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
                        <h3> Your new order list is empty Yet.</h3>
                        <p style="color: #708da8;"></p>
                    </div>
                    </div>';
                }
                return response()->json([
                    "message"       => 'There is no order found.',
                    "isSucceeded"   => FALSE,
                    "data"          => $html
                ]);
            }
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
            return view('digitizer_manager.searchOrder',compact('inch','centimeter'));      
        }
    }


    /*
    * Experience filter method
    */
    public function searchOrderRepresent(Request $request){
        //echo "<pre>"; print_r($request->all());die;
        $user = Auth::user();
        if($request->ajax()){            
            $conditions[]=['status','!=',5 ];            
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
            if ($request->filled('searchParam')) {
                $conditions[]=['order_name','like', '%'.$request->searchParam.'%'];
            }
            if ($request->filled('searchParam')) {
                $conditions2[]=['order_unique_id','=', $request->searchParam];
            }
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
            if(!empty($request->status)){
                $conditions[]=['status','=', $request->status];
                $orderList = Order::with(['garment','payment_details','digitizer','rejection_reason'])->where($conditions)->orWhere($conditions2);          
            }else{
               $orderList = Order::with(['garment','payment_details','digitizer','rejection_reason'])->where($conditions)->orWhere($conditions2)->whereIn('status',[1,2,3,6,9,4,10,11,12,13]);
            }
            $orderList = $orderList->paginate(10);
            $html = View::make('digitizer_manager.searchOrderRepresent',compact('orderList','user','digitizerList','rejectionReason','inch','centimeter','garmentType','priceCalculator'))->render();
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


    public function submittedWorkManagement(Request $request){       
         $user = Auth::user();
        if($request->ajax()){  
        $filterData = false;     
        $conditions=[];     
            if (!empty($request->maximumDate) && !empty($request->minimumDate)) {
                $startDate = Carbon::createFromFormat('m/d/Y', $request->minimumDate)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('m/d/Y', $request->maximumDate)->format('Y-m-d');
                $conditions[]=['created_at','>=', $startDate];
                $conditions[]=['created_at','<=', $endDate];
            }
            if(!empty($request->desired_output)){
                $conditions[]=['desired_output','=', $request->desired_output];
            }
            $orderList='';
            if(!empty($request->status)){
                $conditions[]=['status','=', $request->status];
                $orderList = Order::with(['garment','payment_details','digitizer','rejection_reason'])->where($conditions)->orderBy('id', 'DESC');          
            }else{

               $orderList = Order::with(['garment','payment_details','digitizer','rejection_reason'])->where($conditions)->whereIn('status',[4,10,11,12,13])->orderBy('id', 'DESC');
            }
            if(!empty($request->maximumDate) && !empty($request->minimumDate) || !empty($request->desired_output) || !empty($request->status)){

                 $filterData = true;
             }

            $orderList = $orderList->paginate(6);
            $digitizerList = User::where(['user_role' => '3'])->get();  
            $rejectionReason = RejectionReason::all();            
            
            $html = View::make('digitizer_manager.orderRepresentSubmitted',compact('orderList','user','digitizerList','rejectionReason'))->render();
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
                        <h3> Your Submitted orders list is empty Yet.</h3>
                        <p style="color: #708da8;"></p>
                    </div>
                   </div>';
                }
                return response()->json([
                    "message"       => 'There is no order2 found.',
                    "isSucceeded"   => FALSE,
                    "data"          => $html
                ]);
            }
        }
          
    }

     /**
    * Order Detail Page
    */
    public function submittedOrderDetail(Request $request){
        if($request->isMethod('get')){
            $allOrder = '';
            $orderImages = '';
            if($request->order_id){
              $allOrder = Order::with(['user','digitizer','rejection_reason','payment_details','order_images'])
                                ->where(['id' => $request->order_id])->first(); 

               $orderImages = OrderImage::where(['order_id' => $request->order_id])->get();
                if($allOrder->status == 10 || $allOrder->status == 13 || $allOrder->status == 11 || $allOrder->status == 4) {                      

                    $html = ''; 
                    foreach ($orderImages as $allImages) {
                        $html .= '<div class="ftr-modal-box">';
                         $html .= '<div class="ftr-dwnld-left"> 
                           <img class="img-submitted" src="'.url('/public/orders').'/'.$allImages->order_image.'" height="85px" width="100px" /><span id="sub-img">'.$allImages->order_image.'</span></div>
                            <div class="ftr-dwnld-btn">
                            <a class="btn downloardButton" href="'.route("digitizer-manager-download-image", $allImages->order_image).'">Download</a> 
                            </div>';  
                            $html .= '</div>';                        
                    } 
                }
                  return response()->json([                   
                        "isSucceeded"   => true,
                        "data"          => $html,
                         
                     ]);                 
            }
             return view('digitizer_manager.submittedWorkManagement');
        }

    }
 
    /**
    *Upload Image function
    */
    public function imageUpload($request,$folderPath,$imageName,$imageMethod){
        $fName = '';
        if($imageMethod == 'drag-drop'){
            $originalImage = $request[$imageName][0];    
        }else{
            $originalImage = $request[$imageName];
        }            
        $thumbnailImage = Image::make($originalImage);
        $imgName = time().$originalImage->getClientOriginalName();      
        if($thumbnailImage->save($folderPath.$imgName)){
            $fName = $imgName;
        }
        return $fName;     
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
    * Re-Assign digitizer by manager
    */
    public function reassignDigitizer(Request $request){
        if($request->isMethod('post')){
            $data = $request->except(['_token','approve_or_id',]);
            $approveOrder = Order::where(['id' => $request->approve_or_id])->update($data); 
            if($approveOrder){
                return redirect()->back()->with(['alert-type' => 'success' , 'message' => 'Digitizer reassign successfully.']);
            }else{
                return redirect()->back()->with(['alert-type' => 'error' , 'message' => 'Digitizer does not reassign.']);
            }
        }
    }

    public function capturingIntent(Request $request){
        if($request->isMethod('get')){
            try{
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                $capturePaymentIntent = $stripe->paymentIntents->capture('pi_1I6x7mJtMGvAFFxtTurSzDcs',[]);
                echo "<pre>";
                print_r($capturePaymentIntent);
            }catch(\Exception $e){
                echo "<pre>"; print_r($e->getMessage());die;
            }
        }
    }

    /**
    * Approve order by manager
    */
    public function approveOrder(Request $request){
        if($request->isMethod('post')){
            try{
                $data = $request->except(['_token','approve_or_id','payment_method','pay_authorization_id','order_amount']);                
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                if($request->payment_method){
                 $capturePaymentIntent = $stripe->paymentIntents->capture($request->payment_method,[]); 
                                  
                 if($capturePaymentIntent->status == 'succeeded' ){ 
                    $data['status'] = '2';
                    $approveOrder = Order::where(['id' => $request->approve_or_id])->update($data);                      
                    $updatePaymentDetail = PaymentDetail::where(['order_group_id' => $request->order_group_id])->update(['st_amount_received' => $capturePaymentIntent->amount_received / 100 , 'st_status' => '3']);
                    /*Send Invoice*/
                    $orderDetails = Order::with('user','payment_details','coupon')->where(['id' => $request->approve_or_id])->first();
                    $orderDetails['subject'] = 'Order Invoice';
                    $orderDetails['discount'] = '';
                    $orderDetails['completed_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $orderDetails['updated_at'])->format('F-d-y');
                    if(isset($orderDetails->coupon)){
                        if(!empty($orderDetails->coupon->percent_off)){
                        $orderDetails['discount'] = $orderDetails->coupon->percent_off.'%';
                        }else{
                        $orderDetails['discount'] = '$'.$orderDetails->coupon->amount_off;
                        }
                    } 
                    $sendEmail = Mail::to(['gurwinder@yopmail.com'])->send( new SendMail($orderDetails,'paymentInvoice'));
                }

                return redirect()->back()->with(['alert-type' => 'success' , 'message' => 'Order updated successfully.']);
               }elseif ($request->pay_authorization_id){                
                        $environment = new SandboxEnvironment(config('services.paypal.client_id'), config('services.paypal.client_secret'));
                         $client = new PayPalHttpClient($environment);
                         $request2 = new AuthorizationsCaptureRequest($request->pay_authorization_id);
                            $request2->body = [
                                "amount" => [
                                "value" => $request->order_amount,
                                "currency_code" => "USD"
                            ],
                               "is_final_capture" => false
                            ]; 
                            $request2->prefer('return=representation');                        
                  
                    try {
                        // Call API with your client and get a response for your call
                        $response = $client->execute($request2);        
                        // $ReAuthorizations = new AuthorizationsReauthorizeRequest($request->pay_authorization_id);
                        // $ReAuthorizations->prefer('return=representation');  
                        // $ReAuthorizationsResponse = $client->execute($ReAuthorizations);
                        // echo '<pre>'; print_r($ReAuthorizationsResponse); echo '</pre>';
                        // die;

                        if($response->statusCode == 201){
                             $paypalOrderdetals = Order::where('id',$request->approve_or_id)->first(); 
                             $data['status'] = '2';
                             $approveOrder = Order::where(['id' => $request->approve_or_id])->update($data); 
                             $PaymentDetail = PaymentDetail::where('order_group_id',$paypalOrderdetals->order_group_id)
                                                             ->update(['paypal_captured_id'=>$response->result->id,'pay_amount_captured'=>$response->result->seller_receivable_breakdown->gross_amount->value,'pay_amount_received'=>$response->result->seller_receivable_breakdown->net_amount->value,'paypal_fee'=>$response->result->seller_receivable_breakdown->paypal_fee->value]);

                            $orderDetails = Order::with('user','payment_details','coupon')->where(['id' => $request->approve_or_id])->first();
                            $orderDetails['subject'] = 'Order Invoice';
                            $orderDetails['discount'] = '';
                            $orderDetails['completed_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $orderDetails['updated_at'])->format('F-d-y');
                        if(isset($orderDetails->coupon)){
                            if(!empty($orderDetails->coupon->percent_off)){
                               $orderDetails['discount'] = $orderDetails->coupon->percent_off.'%';
                            }else{
                               $orderDetails['discount'] = '$'.$orderDetails->coupon->amount_off;
                              }
                        } 
                        $sendEmail = Mail::to(['gurwinder@yopmail.com'])->send( new SendMail($orderDetails,'paymentInvoice')); 
                        }

                        // If call returns body in response, you can get the deserialized version from the result attribute of the response
                       return redirect()->back()->with(['alert-type' => 'success' , 'message' => 'Order updated successfully.']);
                    }catch (HttpException $ex) { 
                         return redirect()->back()->with(['alert-type' => 'error' , 'message' => $ex->getMessage()]);
                    }


                   
               }
                


            }catch(\Exception $e){
                return redirect()->back()->with(['alert-type' => 'error' , 'message' => $e->getMessage()]);
            } 
        }
    }


    public function acceptWorkFromManager(Request $request){
        if($request->isMethod('post')){            

            $data['status'] = '4';

            $approveOrder = Order::where(['id' => $request->accept_order_id])->update($data)
            ; 
            if($approveOrder){
                return redirect()->back()->with(['alert-type' => 'success' , 'message' => 'Order updated successfully.']);
            }else{
                return redirect()->back()->with(['alert-type' => 'error' , 'message' => 'Order does not approve.']);
            }
        }
    }   

    /**
    * Update Order Function
    */
    public function updateOrder(Request $request){
        if($request->isMethod('post')){
             $request->validate([
            'order_message' => 'required',
            'garment_id' => 'required',
                ]);            
            if($request->o_id){
                $folderPath= public_path()."/orders/";
                $data = $request->except(['_token','o_id','cost_calculate','old_order_image']);
                $data['amount'] = $request->cost_calculate;
                if(isset($request->manual_override)){
                    $oldOrderData = Order::where(['id' => $request->o_id])->first(['desired_width','desired_height']);
                    if($request->desired_width != $oldOrderData->desired_width || $request->desired_height != $oldOrderData->desired_height ){
                        $data['desired_old_width'] = $oldOrderData->desired_width;
                        $data['desired_old_height'] = $oldOrderData->desired_height;
                        $data['manual_override'] = 1;    
                    }                    
                }
                if($request->hasFile('feature_image')){
                    $data['feature_image'] = $this->imageUpload($request,$folderPath,'feature_image','single');  
                }else{
                     $data['feature_image'] = $request->old_order_image; 
                }               
                $updateOrder = Order::where(['id' => $request->o_id])->update($data);
                if($updateOrder){
                    return redirect()->back()->with(['alert-type' => 'success' , 'message' => 'Order updated successfully.']);
                }else{
                    return redirect()->back()->with(['alert-type' => 'error' , 'message' => 'Order does not update.']);
                }   
            }
        }
    } 

    /**
    * Reject Order Functions
    */
    public function rejectOrder(Request $request){

       // $orderAndUserDetail = Order::with(['user'])->where(['id' => $request->reject_or_id])->first();
        if($request->isMethod('post')){  
              if($request->payment_intent_id && $request->reject_or_id){
                try{
                   
                     $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                     $refundCheck = $stripe->paymentIntents->cancel($request->payment_intent_id);
                     if($refundCheck->id){ 
                            $data = $request->except(['_token','reject_or_id','payment_intent_id']);
                            $data['status'] = '3';                      
                            $data['refund_id'] = $refundCheck->id; 
                            $rejectOrder = Order::where(['id' => $request->reject_or_id])->update($data);
                            if($rejectOrder){
                                $orderAndUserDetail = Order::with(['user'])->where(['id' => $request->reject_or_id])->first();
                                $data['email'] = $orderAndUserDetail->user->email;
                                $data['subject'] = 'Your order is rejected';
                                $data['order_name'] = $orderAndUserDetail->order_name;
                                $data['reason'] = $request->reason;
                                $data['order_unique_id'] = $orderAndUserDetail->order_unique_id;
                               $sendEmail = Mail::to([$data['email']])->send( new SendMail($data,'orderRejected'));
                                return redirect()->back()->with(['alert-type' => 'success' , 'message' => 'Order rejected successfully.']);                               
                            }
                                                    
                        } 
 
                    
                }catch(\Exception $e){
                    return redirect()->back()->with(['alert-type' => 'error' , 'message' => $e->getMessage()]); 
                }
            }
        }
    }

   

    public function rejectSubmittedWork(Request $request){
        if($request->isMethod('post')){
            if($request->reject_order_id){
                $data = $request->except(['_token','reject_order_id']);
                $data['status'] = '13';                      
                $rejectOrder = Order::where(['id' => $request->reject_order_id])->update($data);
                if($rejectOrder){
                    $orderAndUserDetail = Order::with(['digitizer'])->where(['id' => $request->reject_order_id])->first();
                    OrderImage::where('order_id',$request->reject_order_id)->update(['status'=>'2']);
                    $data['subject'] = 'Your Submitted work  is rejected';
                    $data['order_name'] = $orderAndUserDetail->order_name;
                    $data['reason'] = $request->reason;
                    $data['order_unique_id'] = $orderAndUserDetail->order_unique_id;
                     $sendEmail = Mail::to([$orderAndUserDetail->digitizer->email])->send( new SendMail($data,'orderRejected'));
                    return redirect()->back()->with(['alert-type' => 'success' , 'message' => 'Order rejected successfully.']);
                }else{
                    return redirect()->back()->with(['alert-type' => 'error' , 'message' => 'Order does not reject.']);
                }   
            }
        }
    }


    /**
    * Cancel Order By Embroiderer
    */
    public function cancelOrder(Request $request){
        if($request->isMethod('post')){
            if($request->charge_id){
                try{
                    $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                    $refundCheck = $stripe->refunds->create(['charge' => $request->charge_id , 'amount' => floor($request->order_amount * 100)]);
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
                        $checkOrderUp = Order::where(['id' => $request->order_id])->update(['refund_id' => $refundCheck->id , 'status' => $st]);
                        if($checkOrderUp){
                            return response()->json([
                                "message"       => 'Order canceled successfully.',
                                "isSucceeded"   => TRUE
                            ]);     
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
}
