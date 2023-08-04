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
use App\Order;
use App\RejectionReason;
use App\OrderImage;
use DateTime;
use App\Mail\SendMail;
use View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;


class DigitizerController extends Controller
{
    /**
     * Digitizer dashboard.
     */
    public function dashboard(Request $request)
    {
        $page_title = "Dashboard";  
        return view('digitizer.dashboard',compact('page_title'));
    }
    /**
    * Order List Management
    */ 
    public function orderManagement(Request $request){
        if($request->isMethod('get')){
            $priceCalculator = PriceCalculator::all();
            $inch = 0 ; $centimeter = 0;
            $page_title = "Orders Management";
            if(count($priceCalculator)){        
                $priceCalculator = $priceCalculator->toArray();
                $inch = $priceCalculator[0]['desired_price']; 
                $centimeter = $priceCalculator[1]['desired_price'];
            }  
            return view('digitizer.ordersManagement',compact('page_title','inch','centimeter'));      
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
            $conditions[]=['order_digitizer_id','=', Auth::user()->id];        
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
               $orderList = Order::with(['garment','payment_details','digitizer','rejection_reason'])->where($conditions)->whereIn('status',[2,10,13])->orderBy('id', 'DESC');
            }      
            if(!empty($request->maximumDate) && !empty($request->minimumDate) || !empty($request->desired_output) || !empty($request->status)){

                 $filterData = true;
             }
            $orderList = $orderList->paginate(6);
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
            $html = View::make('digitizer.orderRepresent',compact('orderList','user','digitizerList','rejectionReason','inch','centimeter','garmentType','priceCalculator'))->render();
            if(count($orderList)){
                return response()->json([
                    "message"       => 'Experiences get successfully.',
                    "isSucceeded"   => TRUE,
                    "data"          => $html,
                ]);
            }else{
                if($filterData == true){
                    $html = '<div class="col-lg-12"><div class="exp-box" style="text-align: center;font-weight: 500;">There is no data related to this filter.</div></div>';
                    }else{
                       $html = '<div class="col-lg-12"><div class="orders_empty" style="text-align: center;font-weight: 500;"><h3> Your new order list is empty Yet.</h3><p style="color: #708da8;"></p></div></div>';
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
            $page_title = "Search Order";
            $inch = 0 ; $centimeter = 0;
            if(count($priceCalculator)){         
                $priceCalculator = $priceCalculator->toArray();
                $inch = $priceCalculator[0]['desired_price']; 
                $centimeter = $priceCalculator[1]['desired_price'];
            }  
            return view('digitizer.searchOrder',compact('page_title','inch','centimeter'));      
        }
    }


    /*
    * Experience filter method
    */
    public function searchOrderRepresent(Request $request){
        
        $user = Auth::user();
        if($request->ajax()){            
            $conditions[]=['order_digitizer_id','=', Auth::user()->id];         
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
                $orderList = Order::with(['garment','payment_details','digitizer','rejection_reason'])->where($conditions)->orWhere($conditions2)->whereIn('status',[2,10,13,4]);
            }
            $orderList = $orderList->paginate(10);
            $html = View::make('digitizer.searchOrderRepresent',compact('orderList','user','digitizerList','rejectionReason','inch','centimeter','garmentType','priceCalculator'))->render();
            if(count($orderList)){
                return response()->json([
                    "message"       => 'Experiences get successfully.',
                    "isSucceeded"   => TRUE,
                    "data"          => $html,
                ]);
            }else{
                $html = '<div class="col-lg-12"><div class="exp-box" style="text-align: center;font-weight: 500;">There is no data related to this filter.</div></div>';
                return response()->json([
                    "message"       => 'There is no order found.',
                    "isSucceeded"   => FALSE,
                    "data"          => $html
                ]);
            }
        }
    }

    /**
    * Order History Show
    */
    public function orderHistory(Request $request){              
         $user = Auth::user();
         $page_title = "Orders History";
         if($request->ajax()){     
           $filterData = false;  
           $conditions[]=['order_digitizer_id','=', Auth::user()->id];   
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

               $orderList = Order::with(['garment','payment_details','digitizer','rejection_reason'])->where($conditions)->whereIn('status',[4])->orderBy('id', 'DESC');
            }
            if(!empty($request->maximumDate) && !empty($request->minimumDate) || !empty($request->desired_output) || !empty($request->status)){

                 $filterData = true;
             }            
            $orderList = $orderList->paginate(6);
            $digitizerList = User::where(['user_role' => '3'])->get();  
            $rejectionReason = RejectionReason::all();            
            
            $html = View::make('digitizer.orderHistoryRepresent',compact('orderList','user','digitizerList','rejectionReason'))->render();
            if(count($orderList)){
                return response()->json([
                    "message"       => 'Experiences get successfully.',
                    "isSucceeded"   => TRUE,
                    "data"          => $html,
                ]);
            }else{               
                if($filterData == true){
                $html = '<div class="col-lg-12"><div class="exp-box" style="text-align: center;font-weight: 500;">There is no data related to this filter.</div></div>';
                    }else{
                       $html = '<div class="col-lg-12">
                        <div class="orders_empty" style="text-align: center;font-weight: 500;">
                          <h3> Your order history is empty Yet.</h3>
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
          
    
         return view('digitizer.ordersHistory',compact('page_title'));
    }

    /**
    * Order Detail Page
    */
    // public function orderDetail(Request $request, $id=null){
    //     $order = Order::with(['user','digitizer','rejection_reason'])->where(['id' => base64_decode($id)])->first();
    //     $garmentType = Garment::all();
    //     $priceCalculator = PriceCalculator::all();
    //     $orderImages = OrderImage::where(['order_id' => base64_decode($id)])->get();   
    //     $inch = 0 ; $centimeter = 0;
    //     if(count($priceCalculator)){        
    //         $priceCalculator = $priceCalculator->toArray();
    //         $inch = $priceCalculator[0]['desired_price']; 
    //         $centimeter = $priceCalculator[1]['desired_price'];
    //     }
    //     return view('digitizer.orderDetail',compact('order','inch','centimeter','garmentType','priceCalculator','orderImages'));
    // }

    /**
    * Order Detail Page
    */
    public function submittedOrderDetail(Request $request){
        if($request->isMethod('get')){
            $allOrder = '';
            $orderImages = '';
            $html = '';
            if($request->order_id){
              $allOrder = Order::with(['user','digitizer','rejection_reason','payment_details','order_images'])
                                ->where(['id' => $request->order_id])->first(); 

               $orderImages = OrderImage::where(['order_id' => $request->order_id])->get();
                if($allOrder->status == 10 || $allOrder->status == 13 || $allOrder->status == 11 || $allOrder->status == 4) {                      
                         
                     
                        $html = '<h5 class="completed_files">Submitted Files<div class="order_btns"></h5>'; 
                    foreach ($orderImages as $allImages) { 
                        
                        $temp= explode('.',$allImages->order_image);
                        $extension = end($temp);
                       
                        if($extension == 'pdf' || $extension == 'EMB' || $extension == 'DST' || $extension == 'dst' || $extension == 'emb' ){

                            if($extension == 'DST' || $extension == 'dst'){
                                $ImageName = 'dst.png';
                            }elseif($extension == 'EMB' || $extension == 'emb'){

                                $ImageName = 'emb.png';
                            }else{

                                $ImageName = 'pdf.png';
                            }

                               
                        }else{
                            $ImageName = $allImages->order_image;

                        }
                        
                         $html .= '<div class="ftr-modal-box">';
                         $html .= '<div class="ftr-dwnld-left"> <img class="img-submitted" src="'.url('/public/orders').'/'.$ImageName.'" height="85px" width="100px" /><span id="sub-img">'.$allImages->order_image.'</span></div>
                            <div class="ftr-dwnld-btn"><a class="btn downloardButton" href="'.route("digitizer-download-image", $allImages->order_image).'">Download</a></div>';  
                            $html .= '</div>';                        
                    }   
                }

                  return response()->json([                   
                        "isSucceeded"   => true,
                        "data"          => $html,
                         
                     ]);                 
            }
            // return view('digitizer_manager.submittedWorkManagement');
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
    * Order Image Update On Rejected Case
    */
    public function submittedWork(Request $request){
        if($request->isMethod('post')){
            $imageName = '';
            $pdfMove = '';
            $originalImage = $request->file('order_image');
          

            // dd($ext);
            // $filename = time() . '.' . $request->file('order_image')->extension();
           // dd($originalImage);

            foreach ($originalImage as $key => $value) {
                  $folderPath = public_path().'/orders/'; 
              
                if($value->extension() == "pdf"){
                   
                    $pdfName = time().$value->getClientOriginalName();    
                    $pdfMove =  $value->move($folderPath, $pdfName); 
                    
                    $uploadedImages[] = ['order_id'  => $request->o_id ,'image_format'  => 'pdf','order_image'  => $pdfName];
               
                }elseif($value->extension() == "bin" || $value->getClientOriginalExtension() == "EMB" || $value->getClientOriginalExtension() == "emb"){

                     $imgName = time().$value->getClientOriginalName(); 
                     $fileMove = $value->move($folderPath, $imgName);
                     $uploadedImages[] = ['order_id'  => $request->o_id ,'image_format'  => $value->getClientOriginalExtension(),'order_image'  => $imgName];
                      
                }
                else{
                    $thumbnailImage = Image::make($value);
                    $imgName = time().$value->getClientOriginalName();         
                    $imageName = $thumbnailImage->save($folderPath.$imgName);
                    $uploadedImages[] = ['order_id'  => $request->o_id ,'image_format'  => $value->extension(),'order_image'  => $imgName];

                }
                
                
            } 

            
            if(!empty($imageName)){
                if ($request->order_status == 13) {
                    OrderImage::where('order_id', $request->o_id)->delete();                         
                }
                $updateOrderStatus = Order::where(['id' => $request->o_id])->update(['status' => '10']);
                $saveUplordedImage = OrderImage::insert($uploadedImages);                 
                if($saveUplordedImage && $updateOrderStatus){
                    $message = 'Work Submitted Uploaded Successfully.';
                    $isSucceeded = 'success';
                }else{
                    $message = 'Image does not uploaded';
                    $isSucceeded = 'error';
                }          
            }elseif(!empty($pdfMove)){

                if ($request->order_status == 13) {
                    OrderImage::where('order_id', $request->o_id)->delete();                         
                }
                $updateOrderStatus = Order::where(['id' => $request->o_id])->update(['status' => '10']);
                $saveUplordedImage = OrderImage::insert($uploadedImages);                 
                if($saveUplordedImage && $updateOrderStatus){
                    $message = 'Work Submitted Uploaded Successfully.';
                    $isSucceeded = 'success';
                }else{
                    $message = 'Image does not uploaded';
                    $isSucceeded = 'error';
                }          


            }elseif(!empty($fileMove)){

                if ($request->order_status == 13) {
                    OrderImage::where('order_id', $request->o_id)->delete();                         
                }
                $updateOrderStatus = Order::where(['id' => $request->o_id])->update(['status' => '10']);
                $saveUplordedImage = OrderImage::insert($uploadedImages);                 
                if($saveUplordedImage && $updateOrderStatus){
                    $message = 'Work Submitted Uploaded Successfully.';
                    $isSucceeded = 'success';
                }else{
                    $message = 'Image does not uploaded';
                    $isSucceeded = 'error';
                }          


            }else{
                $message = 'Image does not uploaded';
                $isSucceeded = 'error';
            }
            return redirect()->back()->with(['alert-type' => $isSucceeded , 'message' => $message]);
        }
    }


    
}
