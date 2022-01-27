<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Url;
use App\User;
use App\Blog;
use App\Cms_services;
use App\Coupon;
use App\BlogCategory;
use DataTables;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\ContentManagementSystem; 
use App\CardDetail;
use App\PaymentDetail;
use App\PriceCalculator;
use Stripe; 
use Image;
use App\RejectionReason;
use App\Garment;
use App\Order;
use App\Cms;
use App\CmsMeta;
use App\OrderImage;
use App\State;
use DateTime;
use View;
use DB;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Payments\AuthorizationsCaptureRequest;
use PayPalCheckoutSdk\Payments\AuthorizationsReauthorizeRequest;
use PayPalCheckoutSdk\Payments\AuthorizationsVoidRequest;
use PayPalCheckoutSdk\Orders\OrdersAuthorizeRequest;
use Illuminate\Support\Facades\Redirect;
use Session;

class AdminController extends Controller
{
    /**
     * Admin dashboard.
     */
    public function dashboard(Request $request)
    {
        return view('admin.dashboard');
    }

    /**
    * List of all users here
    */
    public function  usersList(Request $request){       
        $header = 'List Of Users';
        $homeLink = route('admin-users-list');      
        if ($request->ajax()) {
            $data = User::where('id', '!=' , Auth::user()->id)->get();
        /*    $data = User::where('id', '!=' , Auth::user()->id)->where('user_role', '!=' , 4)->get();*/
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="action-user-cls btn btn-success btn-sm" user-data="'.htmlspecialchars(json_encode($row)).'" user-id="'.base64_encode($row->id).'" action="edit-user">Edit</a> <a href="javascript:void(0)"  action="delete-user" user-id="'.base64_encode($row->id).'" class="action-user-cls btn btn-danger btn-sm action-scout-btn">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])    
                ->make(true);
        }
        return view('admin.usersList',compact('header','homeLink'));
    }

    /*
    * Edit form open for particular user
    */
    public function changeUserStatus(Request $request){     
        if($request->isMethod('post')){
            $data = $request->except(['id']);
            $msg = $request->status == 1 ? 'Scout approve successfully.' : 'Scout rejected successfully.';
            $userData = User::where(['id' => base64_decode($request->id)])->update($data); 
            if($userData){
                return response()->json([
                    'isSucceeded' => TRUE,
                    'message'     => $msg           
                ]);
            }else{
                return response()->json([
                    'isSucceeded' => FALSE,
                    'message'     => $msg
                ]);
            }
             
        }
    }

    /**
    * Edit Home Page
    */
    public function editHomePage(Request $request , $id = null){
        if($request->isMethod('get')){
            if(!empty($id)){
                 $homepage = Cms::where(['id' => base64_decode($id)])->first();
                 $CmsMeta  = CmsMeta::where(['id' => base64_decode($id)])->first(); 

                $banner_content = Cms::with(['cmsmeta' => function($q){
                    $q->where('meta_key','=','banner_content');
                }])->where(['id' => base64_decode($id)])->first();
                return view('admin.cms.editHomepage',['cmsmeta'=>$CmsMeta,'homepage' => $homepage, 'banner_content' => $banner_content]);    
            }
        }
    }
/**
    * Update Home Page Content
    */
  
    public function updateHomePage(Request $request , $id = null){
        if($request->isMethod('post')){
            //$folderPath = public_path('/pages/homePage/');             
            $folderPath = 'pages/homePage/';
            if(!empty($id)){

               // echo "<pre>"; print_r($request->all());
               // die();
                $id = base64_decode($id);
                foreach($request['banner_title'] as $key=>$res){  

                    if(!empty($request->file('banner_image')[$key])) {    
                        $banner_image = $this->bannerMultiImageUpload($request->file('banner_image')[$key],$folderPath,'banner_image');                         
                    }else{
                        $banner_image= $request['old_banner_image'][$key];
                    }
                    if(!empty($request->file('front_image')[$key])) {                     
                        $front_image = $this->bannerMultiImageUpload($request->file('front_image')[$key],$folderPath,'front_image');

                    }else{
                        $front_image= $request['old_front_image'][$key];
                    }
                    if(!empty($request->file('section_three_right_image')[$key])) {                     
                        $section_three_right_image = $this->bannerMultiImageUpload($request->file('section_three_right_image')[$key],$folderPath,'section_three_right_image');

                    }else{
                        $section_three_right_image = $request['old_section_three_right_image'][$key];
                    }
                    if(!empty($request->file('section_four_image')[$key])) {                     
                        $section_four_image = $this->bannerMultiImageUpload($request->file('section_four_image')[$key],$folderPath,'section_four_image');

                    }else{
                        $section_four_image = $request['old_section_four_image'][$key];
                    }
                    if(!empty($request->file('section_five_image')[$key])) {                     
                        $section_five_image = $this->bannerMultiImageUpload($request->file('section_five_image')[$key],$folderPath,'section_five_image');

                    }else{
                        $section_five_image = $request['old_section_five_image'][$key];
                    }
                    if(!empty($request->file('section_six_image')[$key])) {                     
                        $section_six_image = $this->bannerMultiImageUpload($request->file('section_six_image')[$key],$folderPath,'section_six_image');

                    }else{
                        $section_six_image = $request['old_section_six_image'][$key];
                    }
                    if(!empty($request->file('section_seven_image')[$key])) {                     
                        $section_seven_image = $this->bannerMultiImageUpload($request->file('section_seven_image')[$key],$folderPath,'section_seven_image');

                    }else{
                        //$section_seven_image = $request['old_section_seven_image'][$key];
                        $section_seven_image = $request['old_section_seven_image'][$key];
                    }
                    if(!empty($request->file('section_eight_image')[$key])) {                     
                        $section_eight_image = $this->bannerMultiImageUpload($request->file('section_eight_image')[$key],$folderPath,'section_eight_image');

                    }else{
                       $section_eight_image = $request['old_section_eight_image'][$key];
                        
                    }
                    if(!empty($request->file('section_9_image')[$key])) {                     
                        $section_9_image = $this->bannerMultiImageUpload($request->file('section_9_image')[$key],$folderPath,'section_9_image');

                    }else{
                        $section_9_image = $request['old_section_9_image'][$key];
                       
                    }
                    if(!empty($request->file('section_10_image')[$key])) {                     
                        $section_10_image = $this->bannerMultiImageUpload($request->file('section_10_image')[$key],$folderPath,'section_10_image');

                    }else{
                         $section_10_image = $request['old_section_10_image'][$key];
                       
                    }
                    if(!empty($request->file('section_11_image')[$key])) {                     
                        $section_11_image = $this->bannerMultiImageUpload($request->file('section_11_image')[$key],$folderPath,'section_11_image');

                    }else{
                         $section_11_image = $request['old_section_11_image'][$key];
                       
                    }
                    if(!empty($request->file('section_12_image')[$key])) {                     
                        $section_12_image = $this->bannerMultiImageUpload($request->file('section_12_image')[$key],$folderPath,'section_12_image');

                    }else{
                        $section_12_image = $request['old_section_12_image'][$key];
                        
                    }
                    if(!empty($request->file('section_13_image')[$key])) {                     
                        $section_13_image = $this->bannerMultiImageUpload($request->file('section_13_image')[$key],$folderPath,'section_13_image');

                    }else{
                       $section_13_image = $request['old_section_13_image'][$key];
                        
                    }
                    if(!empty($request->file('section_14_image')[$key])) {                     
                        $section_14_image = $this->bannerMultiImageUpload($request->file('section_14_image')[$key],$folderPath,'section_14_image');

                    }else{
                        $section_14_image = $request['old_section_14_image'][$key];
                        
                    }
                    if(!empty($request->file('section_15_image')[$key])) {                     
                        $section_15_image = $this->bannerMultiImageUpload($request->file('section_15_image')[$key],$folderPath,'section_15_image');

                    }else{
                        $section_15_image = $request['old_section_15_image'][$key];
                        
                    }
                     if(!empty($request->file('section_16_image')[$key])) {                     
                        $section_16_image = $this->bannerMultiImageUpload($request->file('section_16_image')[$key],$folderPath,'section_16_image');

                    }else{
                        $section_16_image = $request['old_section_16_image'][$key];
                        
                    } if(!empty($request->file('section_17_image')[$key])) {                     
                        $section_17_image = $this->bannerMultiImageUpload($request->file('section_17_image')[$key],$folderPath,'section_17_image');

                    }else{
                        $section_17_image = $request['old_section_17_image'][$key];
                        
                    }if(!empty($request->file('section_18_image')[$key])) {                     
                        $section_18_image = $this->bannerMultiImageUpload($request->file('section_18_image')[$key],$folderPath,'section_18_image');

                    }else{
                        $section_18_image = $request['old_section_18_image'][$key];
                        
                    }if(!empty($request->file('section_19_image')[$key])) {                     
                        $section_19_image = $this->bannerMultiImageUpload($request->file('section_19_image')[$key],$folderPath,'section_19_image');

                    }else{
                        $section_19_image = $request['old_section_19_image'][$key];
                        
                    }if(!empty($request->file('section_20_image')[$key])) {                     
                        $section_20_image = $this->bannerMultiImageUpload($request->file('section_20_image')[$key],$folderPath,'section_20_image');

                    }else{
                        $section_20_image = $request['old_section_20_image'][$key];
                        
                    }if(!empty($request->file('section_21_image')[$key])) {                     
                        $section_21_image = $this->bannerMultiImageUpload($request->file('section_21_image')[$key],$folderPath,'section_21_image');

                    }else{
                        $section_21_image = $request['old_section_21_image'][$key];
                        
                    } 





  $bannerContent[]=[
                        "banner_title"                    =>$request['banner_title'][$key],
                        "alt_banner_tag"                  =>$request['alt_banner_tag'][$key],
                        "alt_step_1_tag"                  =>$request['alt_step_1_tag'][$key],
                        "alt_step_2_tag"                  =>$request['alt_step_2_tag'][$key],
                        "alt_step_3_tag"                  =>$request['alt_step_3_tag'][$key],
                        "alt_step_4_tag"                  =>$request['alt_step_4_tag'][$key],
                        "alt_step_5_tag"                  =>$request['alt_step_5_tag'][$key],
                        "alt_step_6_tag"                  =>$request['alt_step_6_tag'][$key],
                        "alt_step_7_tag"                  =>$request['alt_step_7_tag'][$key],
                        "alt_step_8_tag"                  =>$request['alt_step_8_tag'][$key],
                        "alt_step_9_tag"                  =>$request['alt_step_9_tag'][$key],
                        "alt_step_10_tag"                  =>$request['alt_step_10_tag'][$key],
                        "alt_step_11_tag"                  =>$request['alt_step_11_tag'][$key],
                        "alt_step_111_tag"                  =>$request['alt_step_111_tag'][$key],
                        "alt_step_12_tag"                  =>$request['alt_step_12_tag'][$key],
                        "alt_step_13_tag"                  =>$request['alt_step_13_tag'][$key],
                        "alt_step_14_tag"                  =>$request['alt_step_14_tag'][$key],
                        "alt_step_15_tag"                  =>$request['alt_step_15_tag'][$key],
                        "alt_step_16_tag"                  =>$request['alt_step_16_tag'][$key],
                        "alt_step_17_tag"                  =>$request['alt_step_17_tag'][$key],
                        
                        
                        "banner_description"              =>$request['banner_description'][$key],
                        "banner_button_name"              =>$request['banner_button_name'][$key],
                        "banner_button_link"              =>$request['banner_button_link'][$key],
                        "section_two_description"         =>$request['section_two_description'],
                        "section_three_left_description"  =>$request['section_three_left_description'],
                        "section_four_description"        =>$request['section_four_description'],
                        "section_five_description"        =>$request['section_five_description'],
                        "section_six_description"         =>$request['section_six_description'],
                        "section_seven_description"       =>$request['section_seven_description'],
                        "section_eight_description"       =>$request['section_eight_description'],
                        "section_9_description"       =>$request['section_9_description'],
                        "section_10_description"       =>$request['section_10_description'],
                        "section_11_description"       =>$request['section_11_description'],
                        "section_12_description"       =>$request['section_12_description'],
                        "section_13_description"       =>$request['section_13_description'],
                        "section_14_description"       =>$request['section_14_description'],
                        "section_15_description"       =>$request['section_15_description'],
                        "section_16_description"       =>$request['section_16_description'],
                        "section_17_description"       =>$request['section_17_description'],
                        "section_18_description"       =>$request['section_18_description'],
                        "section_19_description"       =>$request['section_19_description'],
                        "section_20_description"       =>$request['section_20_description'],
                        "section_21_description"       =>$request['section_21_description'],
                        "steps_main_heading"           =>$request['steps_main_heading'],
                        "alt_img_tag"                  =>$request['alt_img_tag'][$key],
                        "banner_image"                    =>$banner_image,
                        "front_image"                     =>$front_image,
                        "section_three_right_image"       =>$section_three_right_image,
                        "section_four_image"              =>$section_four_image,
                        "section_five_image"              =>$section_five_image,
                        "section_six_image"               =>$section_six_image,
                        "section_seven_image"             =>$section_seven_image,
                        "section_eight_image"             =>$section_eight_image,
                        "section_9_image"                 =>$section_9_image,
                        "section_10_image"                =>$section_10_image,
                        "section_11_image"                =>$section_11_image,
                        "section_12_image"                =>$section_12_image,
                        "section_13_image"                =>$section_13_image,
                        "section_14_image"                =>$section_14_image,
                        "section_15_image"                =>$section_15_image,
                        "section_16_image"                =>$section_16_image,
                        "section_17_image"                =>$section_17_image,
                        "section_18_image"                =>$section_18_image,
                        "section_19_image"                =>$section_19_image,
                        "section_20_image"                =>$section_20_image,
                        "section_21_image"                =>$section_21_image,
                    ];
                }

                $updateCms = Cms::find($id);
                if(!empty($updateCms)){
                    $updateCms->meta_description = $request->general_info['meta_description'];           
                    $updateCms->meta_title = $request->general_info['meta_title'];
                    $updateCms->title = $request->general_info['title'];
                    $updateCms = $updateCms->save();
                    /*query save banner content*/
                    $updateCmsMetav = CmsMeta::where(['cms_id' => $id, 'meta_key' => 'banner_content'])->update([ 'slug'=>$request['slug'], 'meta_value' => json_encode($bannerContent)]);
                }
                if( $updateCms || $updateCmsMetav){
                    return redirect()->route('admin-edit-home-page',['id' => base64_encode($id)])->with('success','Content successfully updated.');
                }else{
                    return redirect()->route('admin-edit-home-page',['id' => base64_encode($id)])->with('failure','Sorry,Something went wrong.');
                }
            }
        }
    } 
    /**
    * Banner Multiple Upload Image function
    */
    public function bannerMultiImageUpload($request,$folderPath,$imageName){
        $realImageName = '';
        if($request) {
            $originName = $request->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->getClientOriginalExtension();
            $fileName = $fileName.'.'.$extension;            
            if($request->move(public_path($folderPath), $originName)){
                $realImageName = $fileName;
            }
            //die($fileName);
            return  $fileName;       
        }
    } 
    /**
    * Edit user by admin 
    */
    public function editUser(Request $request){
        if($request->isMethod('post')){
            if(!empty($request->u_id)){
                $data = $request->except(['_token','u_id']);
                if(isset($request->avatar)){
                    $folderPath= "users-image/";
                    $data['avatar'] = $this->imageUpload($request,$folderPath,'avatar');
                }
                $updateUser = User::where(['id' => json_decode($request->u_id)])->update($data);
                if($updateUser){
                    return response()->json([
                        'isSuccess' => TRUE,
                        'message'      => 'User profile updated successfully.'
                    ]);        
                }else{
                    return response()->json([
                        'isSuccess' => FALSE,
                        'message'      => 'Opps,something wrong in the profile,please try after some time.'
                    ]);
                }
            }
            
        }
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
            return view('admin.ordersManagement',compact('inch','centimeter'));      
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
            $html = View::make('admin.orderRepresent',compact('orderList','user','digitizerList','rejectionReason','inch','centimeter','garmentType','priceCalculator'))->render();
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
            return view('admin.searchOrder',compact('inch','centimeter'));      
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
            $orderList = $orderList->paginate(9);
            $html = View::make('admin.searchOrderRepresent',compact('orderList','user','digitizerList','rejectionReason','inch','centimeter','garmentType','priceCalculator'))->render();
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
            
            $html = View::make('admin.orderRepresentSubmitted',compact('orderList','user','digitizerList','rejectionReason'))->render();
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
                        $html .= '<div class="ftr-modal-box  imgbox-'.$allImages->id.'">';
                         $html .= '<div class="ftr-dwnld-left"> 
                           <img class="img-submitted" src="'.url('/public/orders').'/'.$allImages->order_image.'" height="85px" width="100px" /><span id="sub-img">'.$allImages->order_image.'</span></div>
                            <div class="ftr-dwnld-btn">
                            <span class="btn rejectBtn  deleteimg" data-id="'.$allImages->id.'" >Delete</span> 
                            <a class="btn downloardButton" href="'.route("admin-download-image", $allImages->order_image).'">Download</a> 
                            </div>';  
                            $html .= '</div>';                        
                    }    
                }
                  return response()->json([                   
                        "isSucceeded"   => true,
                        "data"          => $html,
                         
                     ]);                 
            }
             return view('admin.submittedWorkManagement');
        }

    }

    /**
    * Delete user by admin function
    */
    public function deleteUser(Request $request){
        if($request->isMethod('post')){
            if($request->id){
                $user = User::where('id',$request->id)->first();
                if($user->delete()){
                    return response()->json([
                        'isSuccess' => TRUE,
                        'message'      => 'User deleted successfully.'
                    ]);
                }else{
                    return response()->json([
                        'isSuccess' => FALSE,
                        'message'      => 'Opps,something wrong in the profile,please try after some time.'
                    ]);
                }
            }
        }
    }


    /**
     * Admin add User form.
     */
    public function userForm(Request $request){
        if($request->isMethod('get')){
            $header = 'Add Users';
            $homeLink = route('admin-users-list');     
            return view('admin.addNewUser',compact('header','homeLink'));
        }                
    }

    /**
    * Admin add User functionality.
    */
    public function addUser(Request $request){
        if($request->isMethod('post')){
            $data = $request->except(['_token']);
            if(isset($request->avatar)){
                $folderPath= "users-image/";
                $data['avatar'] = $this->imageUpload($request,$folderPath,'avatar');
             } 
             $data['status'] = 1;
             $data['password'] = Hash::make($data['password']);
             if($user = User::create($data)){
                 $userId = $user->id;
                 $user_data = DB::table('users')->where('id', '=', $userId)->first();
                 //Check if the user exists
                 // if(count($userId) < 1){
                 //       return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
                 //    }
                 //Create Password Reset Token
                 $tokenString = Str::random(60);
                 $token = Hash::make($tokenString);
                 DB::table('password_resets')->insert([
                          'email' => $user_data->email,
                          'token' => $token,
                          'created_at' => Carbon::now()
                 ]);
                 $tokenData = DB::table('password_resets')->where('email',$user_data->email)->first();
                 $link = 'https://punchly.io/backend/password/reset/' . $tokenString . '?email=' . urlencode($user_data->email);

                 $data['subject'] = "Welcome to Punchly.io";   
                 $data['password_link'] = $link;
                 $data['designation'] = ($data['user_role'] == 1) ? 'Admin' : 'Digitizer Manager'; 
                 $sendEmail = Mail::to([$data['email']])->send( new SendMail($data,'newUser'));

                return redirect()->route('admin-users-list')->with('success','User created successfully');                
             }else{
                return redirect()->route('admin-users-list')->with('success','User does not created');
             }
        }
    }


    /**
    *Upload Image function
    */
    public function imageUpload($request,$folderPath,$imageName){
        $fName = '';
        if($request->hasFile($imageName)){
            $originName = $request->file($imageName)->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file($imageName)->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;            
            if($request->file($imageName)->move(public_path($folderPath), $fileName)){
                $fName = $fileName;
            }
            return $fName;
        }
        return $fName;       
    }


     /**
    * Order Detail Page
    */
    public function orderDetail(Request $request, $id=null){
        $order = Order::with(['user','digitizer','rejection_reason','payment_details'])->where(['id' => base64_decode($id)])->first();
        $garmentType = Garment::all();
        $priceCalculator = PriceCalculator::all();
        $orderImages = OrderImage::where(['order_id' => base64_decode($id)])->get();        
        $rejectionReason = RejectionReason::all();        
        $inch = 0 ; $centimeter = 0;
        if(count($priceCalculator)){        
            $priceCalculator = $priceCalculator->toArray();
            $inch = $priceCalculator[0]['desired_price']; 
            $centimeter = $priceCalculator[1]['desired_price'];
        }

       // echo '<pre>'; print_r($order->toArray()); echo '</pre>';
       

        $digitizerList = User::where(['user_role' => '3'])->get();

        return view('admin.orderDetail',compact('order','inch','centimeter','garmentType','priceCalculator','digitizerList','orderImages','rejectionReason'));
    }
 
    /**
    *Upload Image function
    */
    // public function imageUpload($request,$folderPath,$imageName,$imageMethod){
    //     $fName = '';
    //     if($imageMethod == 'drag-drop'){
    //         $originalImage = $request[$imageName][0];    
    //     }else{
    //         $originalImage = $request[$imageName];
    //     }            
    //     $thumbnailImage = Image::make($originalImage);
    //     $imgName = time().$originalImage->getClientOriginalName();      
    //     if($thumbnailImage->save($folderPath.$imgName)){
    //         $fName = $imgName;
    //     }
    //     return $fName;     
    // }

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
    * Delete Oder image by admin function
    */
    public function deleteOrderImage(Request $request){
        if($request->isMethod('post')){
            if($request->id){
                $user = OrderImage::where('id',$request->id)->first();
                if($user->delete()){
                    return response()->json([
                        'isSucceeded' => TRUE,
                        'message'      => 'Image deleted successfully.'
                    ]);
                }else{
                    return response()->json([
                        'isSucceeded' => FALSE,
                        'message'      => 'Opps,something wrong in the profile,please try after some time.'
                    ]);
                }
            }
        }
    }

    /**
    * Re-Assign digitizer by admin
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
    // public function approveOrder(Request $request){
    //     if($request->isMethod('post')){
    //         try{
    //             $data = $request->except(['_token','approve_or_id','payment_method']);
    //             $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
    //             $capturePaymentIntent = $stripe->paymentIntents->capture($request->payment_method,[]);
    //             if($capturePaymentIntent->status == 'succeeded' ){
    //                 $data['status'] = '2';
    //                 $approveOrder = Order::where(['id' => $request->approve_or_id])->update($data);
    //                 $updatePaymentDetail = PaymentDetail::where(['order_group_id' => $request->order_group_id])->update(['st_amount_received' => $capturePaymentIntent->amount_received / 100 , 'st_status' => '3']);
    //             }
    //             return redirect()->back()->with(['alert-type' => 'success' , 'message' => 'Order updated successfully.']);
    //         }catch(\Exception $e){
    //             return redirect()->back()->with(['alert-type' => 'error' , 'message' => $e->getMessage()]);
    //         } 
    //     }
    // }

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
                    $sendEmail = Mail::to([$orderDetails->user->email])->send( new SendMail($orderDetails,'paymentInvoice'));
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
                                $data = array();
                                $data['order_name'] = $orderDetails->order_name;                                 
                                $data['user_name'] = $orderDetails->user->first_name;                                 
                                $data['order_unique_id'] = $orderDetails->order_unique_id;
                                $data['subject'] = 'We’re Getting Started On Your Order';

                        $sendEmail = Mail::to([$orderDetails->user->email])->send( new SendMail($orderDetails,'paymentInvoice')); 
                        $sendEmail2 = Mail::to([$orderDetails->user->email])->send( new SendMail($data,'orderAccepted')); 
                        } 
                        // If call returns body in response, you can get the deserialized version from the result attribute of the response
                       return redirect()->back()->with(['alert-type' => 'success' , 'message' => 'Order updated successfully.']);
                    }catch (HttpException $ex) { 
                         return redirect()->back()->with(['alert-type' => 'error' , 'message' => $ex->getMessage()]);
                    }


                   
               }else{ 

                    $data['status'] = '2';
                    $approveOrder = Order::where(['id' => $request->approve_or_id])->update($data);        
                    //$updatePaymentDetail = PaymentDetail::where(['order_group_id' => $request->order_group_id])->update(['st_amount_received' => 0 , 'st_status' => '3']);
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
                    $sendEmail = Mail::to([$orderDetails->user->email])->send( new SendMail($orderDetails,'paymentInvoice'));

                     return redirect()->back()->with(['alert-type' => 'success' , 'message' => 'Order updated successfully.']); 

               }
           
            }catch(\Exception $e){
                return redirect()->back()->with(['alert-type' => 'error' , 'message' => $e->getMessage()]);
            } 
        }
    }

    public function acceptWorkFromManager(Request $request){
        if($request->isMethod('post')){            

            $data['status'] = '4';

            $approveOrder = Order::where(['id' => $request->accept_order_id])->update($data); 
            if($approveOrder){
                 $data = Order::with('user')->where(['id' => $request->accept_order_id])->first(); 
                 $data['subject'] = 'Your order is Completed';               
                 $sendEmail = Mail::to([$data->user->email])->send( new SendMail($data,'orderCompleted'));


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
                $folderPath= "/orders/";
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
              if($request->reject_or_id){
                  try{   
                   $rfID=null;   
                    if($request->payment_intent_id){              
                     $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                     $refundCheck = $stripe->paymentIntents->cancel($request->payment_intent_id);
                     $rfID=$refundCheck->id;
                     } 
                            $data = $request->except(['_token','reject_or_id','payment_intent_id']);
                            $data['status'] = '3';                      
                            $data['refund_id'] =  $rfID; 
                            $rejectOrder = Order::where(['id' => $request->reject_or_id])->update($data);
                            if($rejectOrder){
                                $orderAndUserDetail = Order::with(['user','rejection_reason'])->where(['id' => $request->reject_or_id])->first();
                                
                                $data['email'] = $orderAndUserDetail->user->email;
                                $data['subject'] = 'Your order is rejected';
                                $data['order_name'] = $orderAndUserDetail->order_name;
                                $data['user_name'] = $orderAndUserDetail->user->first_name;
                                $data['reject_reason'] = $orderAndUserDetail->rejection_reason->reason;
                                $data['reject_comment'] = $request->comment;    
                                $data['order_unique_id'] = $orderAndUserDetail->order_unique_id;
                                $sendEmail = Mail::to([$orderDetails->user->email])->send( new SendMail($data,'orderRejected'));
                                return redirect()->back()->with(['alert-type' => 'success' , 'message' => 'Order rejected successfully.']);                               
                            }
                           
                    
                }catch(\Exception $e){
                    return redirect()->back()->with(['alert-type' => 'error' , 'message' => $e->getMessage()]); 
                }
            }else{ 

                            $data = $request->except(['_token','reject_or_id','payment_intent_id']);
                            $data['status'] = '3';                      
                            $data['refund_id'] =  null; 
                            $rejectOrder = Order::where(['id' => $request->reject_or_id])->update($data);
                            if($rejectOrder){
                                $orderAndUserDetail = Order::with(['user'])->where(['id' => $request->reject_or_id])->first(); 
                                $data['subject'] = 'Your order is rejected';
                                $data['order_name'] = $orderAndUserDetail->order_name;
                                $data['user_name'] = $orderAndUserDetail->user->first_name;
                                $data['reason'] = $orderAndUserDetail->rejection_reason->reason;
                                $data['reject_comment'] = $request->comment;

                                $data['order_unique_id'] = $orderAndUserDetail->order_unique_id;
                              $sendEmail = Mail::to([$orderDetails->user->email])->send( new SendMail($data,'orderRejected'));
                                return redirect()->back()->with(['alert-type' => 'success' , 'message' => 'Order rejected successfully.']);                               
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


     /*********CMS**********/



    // public function blogManagement(Request $request){
 
    //     $page_title = 'Blog';
    //     $page_description = 'Some description for the page';
    //     $PageData = Blog::find(1);
    //     return view('admin.cms.blogManagement.addBlogForm', compact('page_title', 'page_description', 'PageData')); 

    // }


    public function customerReports(Request $request){
        $header = 'Customer Reprots';
        $homeLink = route('customer-reports');      
        if ($request->ajax()) {
            $data = User::with('get_country','get_state', 'get_city')->whereHas('payment_total', function($q){
                $q->where('st_amount_received','>',0.00)->orWhere('pay_amount_received','>',0.00);
            })->where('user_role', 4)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function($row){
                    return date('M d, Y', strtotime($row->created_at));
                })
                ->addColumn('total_orders', function($row){                 
                   return PaymentDetail::groupBy('user_id')->where('st_amount_received','>',0.00)->orWhere('pay_amount_received','>',0.00)->count();                
                })
                ->addColumn('total_spent', function($row){
                    return PaymentDetail::groupBy('user_id')->where('st_amount_received','>',0.00)->orWhere('pay_amount_received','>', 0.00)->sum(\DB::raw('st_amount_received + pay_amount_received'));
                })
                ->addColumn('country', function($row){
                    return $row->get_country->name;
                })
                ->addColumn('state', function($row){
                    return $row->get_state->name;
                })
                ->addColumn('city', function($row){
                    return $row->city;
                })
                ->rawColumns(['total_spent','total_orders'])
                ->make(true);
        }
        return view('admin.customerReports',compact('header','homeLink'));

    }

    public function salesReports(Request $request){
        $header = 'Sales Reprots';
        $homeLink = route('customer-reports');      
        if ($request->ajax()) {

            $filters=[];
            $statusArr = [2,4,10,11,12,13]; //2 = In process, 4 = Completed ,10 = Work Submitted By Digitizer,11 = Accept Submitted Work, 12 = Reject Submitted Work ,13 = Reworking
            if($request->filled('start_date') && $request->filled('end_date')){
                $startDate = Carbon::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('m/d/Y', $request->end_date);
                $endDateval=$endDate->addDays('1')->format('Y-m-d') ;
                $data = Order::with('user')->whereHas('payment_details')->whereBetween('created_at', [$startDate, $endDateval])->whereIn('status', $statusArr)->get();
            }else{
                $data = Order::with('user')->whereHas('payment_details')->whereIn('status', $statusArr)->get();
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('first_name', function($row){                 
                   return $row->user->first_name;
                })
                ->addColumn('last_name', function($row){                 
                   return $row->user->last_name;
                })
                ->addColumn('created_at', function($row){
                    return date('M d, Y', strtotime($row->created_at));
                })
                ->addColumn('currency', function($row){                 
                   return strtoupper($row->payment_details->currency);
                })
                ->addColumn('first_name', function($row){                 
                    return $row->user->first_name.' '.$row->user->last_name;
                 })
                 ->addColumn('email', function($row){                 
                    return $row->user->email;
                 })
                 ->addColumn('payment_method', function($row){                 
                    return 'Visa';
                 })
                 ->addColumn('payment_processor', function($row){  
                     if(isset($row->payment_details->st_payment_intent_id) && $row->payment_details->st_payment_intent_id != NULL){
                        return 'Stripe';
                     }else{
                        return 'Paypal';
                     }   
                    
                 })
                 ->addColumn('country', function($row){
                     if(!empty($row->user->country)){
                        return $row->user->get_country->name;
                     }else{
                         return 'N/A';
                     }
                 })
                 ->addColumn('address', function($row){                 
                    return $row->user->address;
                 })
                 ->addColumn('city', function($row){                 
                    return $row->user->city;
                 })
                 ->addColumn('state', function($row){                 
                    return $row->user->get_state->name;
                 })
                 ->addColumn('postcode', function($row){                 
                    return $row->user->postcode;
                 })
                 ->addColumn('type', function($row){                 
                    return 'Digitizaion';
                 })
                 ->addColumn('price', function($row){
                    return $row->amount;
                })
                ->addColumn('discount', function($row){
                   
                   if($row->amount_after_coupon==0.00){
                    return '0.0';
                   }
                   else{
                       return $row->amount - $row->amount_after_coupon;
                   }
                }) 
                ->addColumn('total', function($row){
                   
                   if($row->amount_after_coupon==0.00){
                    return $row->amount + $row->amount_after_coupon;
                   }
                   else{
                    return $row->amount_after_coupon;
                   }
                    
                 })
                ->addColumn('transaction_fee', function($row){
                    return '0.00';                    
                 })

                ->rawColumns(['currency'])
                ->make(true);
        }
        return view('admin.salesReports',compact('header','homeLink'));
    }

    public function addBlogForm(Request $request,$id=null){
         $page_title = 'Add Blog';
         $page_description = 'Some description for the page';
         $blogCategories = BlogCategory::all();
         if($request->isMethod('get') && $id==null){
           return view('admin.cms.blogManagement.addBlogForm',compact('page_title','page_description','blogCategories'));
        }else{
             $resData = Blog::where(['id' => base64_decode($id)])->first(); 
            return view('admin.cms.blogManagement.addBlogForm',compact('page_title','page_description','blogCategories','resData'));
        }
     
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function ckeditorUpload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
        
            $request->file('upload')->move(public_path('images'), $fileName);
    
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('pages/blogs/editor'.$fileName); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
               
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }

    public function addUpdateBlog(Request $request)
    {
        
        if($request->isMethod('post')){
            $data = $request->except(['_token','blog_id','files']);
           $data['blog_slug']= Str::slug($request['blog_title'], '-');
           $data['created_by']= Auth::user()->id;
           $folderPath = 'pages/blogs'; 
           if($request->hasFile('feature_image')) {                 
                $data['feature_image'] = $this->imageUpload($request,$folderPath,'feature_image');
            }
           if($request['blog_id']!=0) {
               $blogCat=  Blog::where('id', '=', $request['blog_id'])->update($data);
               $msg="Blog updated successfully";
            }else{
                 $blogCat = Blog::create($data);
                $msg="Blog created successfully";
            }
             if($blogCat)
                 {
                     return redirect()->route('admin-blog-list')->with('success',$msg);
                 }else{
                return redirect()->route('admin-blog-list')->with('failure','Opps,something wrong,please try after some time.');
            }

        }

    }

     public function blogList(Request $request){
       $page_title = 'List of Blog';
        $page_description = 'Some description for the page';
        if ($request->ajax()) {
            $data = Blog::with('blogCat')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'. route('admin-edit-blog',['id' => base64_encode($row->id)]) .'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)"  blog-id="'.base64_encode($row->id).'" class="delete btn btn-danger btn-sm action-blog-delete-btn">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
      
        return view('admin.cms.blogManagement.blogList',compact('page_title','page_description'));
    }

    /******services*****/

    public function servicesList(Request $request){
       $page_title = 'Services List';
        $page_description = 'Some description for the page';
        if ($request->ajax()) {
            $data = Cms_services::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'. route('admin-edit-service',['id' => base64_encode($row->id)]) .'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)"  service-id="'.base64_encode($row->id).'" class="delete btn btn-danger btn-sm action-service-delete-btn">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
      
        return view('admin.cms.serviceCategories.servicesList',compact('page_title','page_description'));
    }


      public function addServiceForm(Request $request,$id=null){
         $page_title = 'Add Services';
         $page_description = 'Some description for the page'; 
         if($request->isMethod('get') && $id==null){
           return view('admin.cms.serviceCategories.addServiceForm',compact('page_title','page_description'));
        }else{
             $resData = Cms_services::where(['id' => base64_decode($id)])->first(); 
            return view('admin.cms.serviceCategories.addServiceForm',compact('page_title','page_description','resData'));
        }
     
    }
    public function deleteServices(Request $request){
        if($request->isMethod('post')){
            if(!empty($request->service_id)){
                $del = Cms_services::where(['id' => base64_decode($request->service_id)])->delete();
                if($del){
                    return response()->json([
                        'isSucceeded' => TRUE,
                        'message'=>"Services successfully Deleted."
                    ]);
                }else{
                    return response()->json([
                        'isSucceeded' => FALSE,
                        'message'=>"Something went wrong."
                    ]);
                }    
            }
        }
     
    }

    public function addUpdateService(Request $request)
    {
        
        if($request->isMethod('post')){
            $data = $request->except(['_token','service_id','files']);
           $data['created_by']= Auth::user()->id;
           $folderPath = 'pages/blogs'; 
           if($request->hasFile('feature_image')) {                 
                $data['feature_image'] = $this->imageUpload($request,$folderPath,'feature_image');
            }
           if($request['service_id']!=0) {
               $blogCat=  Cms_services::where('id', '=', $request['service_id'])->update($data);
               $msg="Service updated successfully";
            }else{

                 $data['service_slug']= Str::slug($request['service_title'], '-');
                 $blogCat = Cms_services::create($data);
                $msg="Service created successfully";
            }
             if($blogCat)
                 {
                     return redirect()->route('admin-service-list')->with('success',$msg);
                 }else{
                return redirect()->route('admin-service-list')->with('failure','Opps,something wrong,please try after some time.');
            }

        }

    }
      
/*******************End Srvices**********************/



     public function categoriesManagement(Request $request){
          $page_title = 'List of Blog';
        $PageData = BlogCategory::find(1);    
       
        return view('admin.cms.categoriesManagement.edit_blog_page', compact('PageData','page_title')); 

      }



        /*
    * view Blog Page Controls
    */
    

       /*
    *  Blog Category list Controls
    */

    public function blogCategoryList(Request $request)    
    {
        if ($request->ajax()) {
            $data = BlogCategory::all();
           
             
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="modal" data-target="#add-bog-cat-modal" blog-cat-id="'.base64_encode($row->id).'" page-name="'.$row->name.'" act-name="edit-blog-cat" class="edit btn btn-success btn-sm action-blog-edit-btn">Edit</a> <a href="javascript:void(0)" blog-cat-id="'.base64_encode($row->id).'" class="delete btn btn-danger btn-sm action-blog-cat-delete-btn">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    } 

    public function deleteBlog(Request $request){
        if($request->isMethod('post')){
            if(!empty($request->blog_id)){
                $del = Blog::where(['id' => base64_decode($request->blog_id)])->delete();
                if($del){
                    return response()->json([
                        'isSucceeded' => TRUE,
                        'message'=>"Blog successfully Deleted."
                    ]);
                }else{
                    return response()->json([
                        'isSucceeded' => FALSE,
                        'message'=>"Something went wrong."
                    ]);
                }    
            }
        }
     
    }
/*********Contact Us*******/
   public function contactUsPage(Request $request , $id = null){
     if($request->isMethod('get')){   
            if(!empty($id)){
                $Conatactpage = Cms::where(['id' => base64_decode($id)])->first();
                $CmsMeta      = CmsMeta::where(['id' => base64_decode($id)])->first(); 
                $contact_us_content = Cms::with(['cmsmeta' => function($q){
                    $q->where('meta_key','=','contact_content');
                }])->where(['id' => base64_decode($id)])->first();
                return view('admin.cms.editContactUs',['cmsmeta'=>$CmsMeta,'contact' => $Conatactpage,'contact_us_content' => $contact_us_content]);    
            }
        }

    }
    public function updateContactUsPage(Request $request , $id = null){
        if($request->isMethod('post')){
            //$folderPath = public_path('/pages/homePage/');             
            $folderPath = 'pages/homePage/';
            if(!empty($id)){
                $id = base64_decode($id); 
                foreach($request['title'] as $key=>$res){  

                    if(!empty($request->file('banner_image')[$key])) {                 
                        $banner_image = $this->bannerMultiImageUpload($request->file('banner_image')[$key],$folderPath,'banner_image');                         
                    }else{
                        $banner_image= $request['old_banner_image'][$key];
                    } 
                    $bannerContent[]=[
                        "title"          =>$request['title'][$key],                       
                        "sub_heading"    =>$request['sub_heading'][$key],                       
                        "alt_banner_tag"    =>$request['alt_banner_tag'][$key],                       
                        "description"    =>$request['description'], 
                        "contact_info"    =>$request['contact_info'][$key], 
                        "email"          =>$request['email'][$key], 
                        "address"        =>$request['address'][$key], 
                        "facebook"        =>$request['facebook'][$key], 
                        "twitter"        =>$request['twitter'][$key], 
                        "instagram"        =>$request['instagram'][$key],                        
                        "banner_image"   =>$banner_image
                       
                        
                    ];
                }
                $updateCms = Cms::find($id);
                if(!empty($updateCms)){
                    $updateCms->meta_description = $request->general_info['meta_description']; 
                    $updateCms->meta_title = $request->general_info['meta_title'];
                    $updateCms->title = $request->general_info['title'];
                    $updateCms = $updateCms->save();
                    /*query save banner content*/
                    $updateCmsMetav = CmsMeta::where(['cms_id' => $id, 'meta_key' => 'contact_content'])->update([ 'slug'=>$request['slug'], 'meta_value' => json_encode($bannerContent)]);
                }
                if( $updateCms || $updateCmsMetav){
                    return redirect()->route('admin-contact-us',['id' => base64_encode($id)])->with('success','Content successfully updated.');
                }else{
                    return redirect()->route('admin-contact-us',['id' => base64_encode($id)])->with('failure','Sorry,Something went wrong.');
                }
            }
        }
    }
/****** About us*************/
public function aboutUsPage(Request $request , $id = null){
     if($request->isMethod('get')){             
            if(!empty($id)){
                $about_us = Cms::where(['id' => base64_decode($id)])->first();
                $CmsMeta  = CmsMeta::where(['id' => base64_decode($id)])->first();
                $about_us_content = Cms::with(['cmsmeta' => function($q){
                    $q->where('meta_key','=','about_us_content');
                }])->where(['id' => base64_decode($id)])->first();
                return view('admin.cms.editAbout',['cmsmeta'=>$CmsMeta,'aboutUs' => $about_us,'about_us_content' => $about_us_content]);    
            }
        }

    }
    public function updateAboutUsPage(Request $request , $id = null){
        if($request->isMethod('post')){
            //$folderPath = public_path('/pages/homePage/');             
            $folderPath = 'pages/homePage/';
            if(!empty($id)){
                $id = base64_decode($id); 
                foreach($request['title'] as $key=>$res){  
                    if(!empty($request->file('banner_image')[$key])) {                 
                        $banner_image = $this->bannerMultiImageUpload($request->file('banner_image')[$key],$folderPath,'banner_image');                         
                    }else{
                        $banner_image= $request['old_banner_image'][$key];
                    }
                    if(!empty($request->file('right_image')[$key])) {                 
                        $right_image = $this->bannerMultiImageUpload($request->file('right_image')[$key],$folderPath,'right_image');                         
                    }else{
                        $right_image= $request['old_right_image'][$key];
                    } 
                    $bannerContent[]=[
                       "title"          =>$request['title'][$key],                        
                       "alt_banner_tag" =>$request['alt_banner_tag'][$key],                        
                       "Alt_right_image_tag" =>$request['Alt_right_image_tag'][$key],                        
                       "description"    =>$request['description'],   
                       "leftcontent"    =>$request['leftcontent'], 
                       "banner_image"   =>$banner_image,               
                       "right_image"    =>$right_image  
                    ];
                }
                $updateCms = Cms::find($id);
                if(!empty($updateCms)){
                    $updateCms->meta_description = $request->general_info['meta_description'];           
                    $updateCms->meta_title = $request->general_info['meta_title'];
                    $updateCms->title = $request->general_info['title'];
                    $updateCms = $updateCms->save();
                    /*query save banner content*/
                    $updateCmsMetav = CmsMeta::where(['cms_id' => $id, 'meta_key' => 'about_us_content'])->update([ 'slug'=>$request['slug'],'meta_value' => json_encode($bannerContent)]);
                }
                if( $updateCms || $updateCmsMetav){
                    return redirect()->route('admin-about-us',['id' => base64_encode($id)])->with('success','Content successfully updated.');
                }else{
                    return redirect()->route('admin-about-us',['id' => base64_encode($id)])->with('failure','Sorry,Something went wrong.');
                }
            }
        }
    }

/****** Privacy Policy Page*************/
public function privacyPolicyPage(Request $request , $id = null){
     if($request->isMethod('get')){             
            if(!empty($id)){
                $privacyPolicy = Cms::where(['id' => base64_decode($id)])->first();
                $CmsMeta      = CmsMeta::where(['id' => base64_decode($id)])->first();
                $privacy_policy_content = Cms::with(['cmsmeta' => function($q){
                    $q->where('meta_key','=','privacy_policy_content');
                }])->where(['id' => base64_decode($id)])->first();

                return view('admin.cms.privacy-policy',['cmsmeta'=>$CmsMeta,'privacyPolicy' => $privacyPolicy,'privacy_policy_content' => $privacy_policy_content]);    
            }
        }

    }
    public function updatePrivacyPolicyPage(Request $request , $id = null){
        if($request->isMethod('post')){
            //$folderPath = public_path('/pages/homePage/');             
            $folderPath = 'pages/homePage/';
            if(!empty($id)){
                $id = base64_decode($id); 
                foreach($request['title'] as $key=>$res){  
                    if(!empty($request->file('banner_image')[$key])) {                 
                        $banner_image = $this->bannerMultiImageUpload($request->file('banner_image')[$key],$folderPath,'banner_image');                         
                    }else{
                        $banner_image= $request['old_banner_image'][$key];
                    }                      
                    $bannerContent[]=[
                        "title"         =>$request['title'][$key], 
                        "alt_banner_tag"         =>$request['alt_banner_tag'][$key], 
                        "banner_image"   =>$banner_image,                       
                        "content"       =>$request['content'],                                   
                        
                    ];
                }
                $updateCms = Cms::find($id);
                if(!empty($updateCms)){
                    $updateCms->meta_description = $request->general_info['meta_description'];           
                    $updateCms->meta_title = $request->general_info['meta_title'];
                    $updateCms->title = $request->general_info['title'];
                    $updateCms = $updateCms->save();
                    /*query save banner content*/
                    $updateCmsMetav = CmsMeta::where(['cms_id' => $id, 'meta_key' => 'privacy_policy_content'])->update([ 'slug'=>$request['slug'],'meta_value' => json_encode($bannerContent)]);
                }
                if( $updateCms || $updateCmsMetav){
                    return redirect()->route('admin-privacy-policy',['id' => base64_encode($id)])->with('success','Content successfully updated.');
                }else{
                    return redirect()->route('admin-privacy-policy',['id' => base64_encode($id)])->with('failure','Sorry,Something went wrong.');
                }
            }
        }
    }
/****** Return Policy Page*************/
public function returnPolicyPage(Request $request , $id = null){
     if($request->isMethod('get')){             
            if(!empty($id)){
                 $returnPolicy = Cms::where(['id' => base64_decode($id)])->first();
                 $CmsMeta      = CmsMeta::where(['id' => base64_decode($id)])->first();  
                 $return_policy_content = Cms::with(['cmsmeta' => function($q){
                    $q->where('meta_key','=','return_policy_content');
                }])->where(['id' => base64_decode($id)])->first();
                return view('admin.cms.return-policy',['slug'=>$request['slug'],'cmsmeta'=>$CmsMeta,'returnPolicy' => $returnPolicy,'return_policy_content' => $return_policy_content]);    
            }
        }

    }
    public function updateReturnPolicyPage(Request $request , $id = null){
        if($request->isMethod('post')){
            //$folderPath = public_path('/pages/homePage/');             
            $folderPath = 'pages/homePage/';
            if(!empty($id)){
                $id = base64_decode($id); 
                foreach($request['title'] as $key=>$res){
                    if(!empty($request->file('banner_image')[$key])) {                 
                        $banner_image = $this->bannerMultiImageUpload($request->file('banner_image')[$key],$folderPath,'banner_image');                         
                    }else{
                        $banner_image= $request['old_banner_image'][$key];
                    }                                       
                    $bannerContent[]=[
                        "title"          =>$request['title'][$key],  
                        "alt_banner_tag"  =>$request['alt_banner_tag'][$key],  
                        "banner_image"   =>$banner_image,                     
                        "content"    =>$request['content'],  
                    ];
                }
                $updateCms = Cms::find($id);
                if(!empty($updateCms)){
                    $updateCms->meta_description = $request->general_info['meta_description'];            
                    $updateCms->meta_title = $request->general_info['meta_title'];
                    $updateCms->title = $request->general_info['title'];
                    $updateCms = $updateCms->save();
                    /*query save banner content*/
                    $updateCmsMetav = CmsMeta::where(['cms_id' => $id, 'meta_key' => 'return_policy_content'])->update(['slug'=>$request['slug'], 'meta_value' => json_encode($bannerContent)]);
                }
                if( $updateCms || $updateCmsMetav){
                    return redirect()->route('admin-return-policy',['id' => base64_encode($id)])->with('success','Content successfully updated.');
                }else{
                    return redirect()->route('admin-return-policy',['id' => base64_encode($id)])->with('failure','Sorry,Something went wrong.');
                }
            }
        }
    }
    /****** Term and Condition Page*************/
public function termConditionPage(Request $request , $id = null){
     if($request->isMethod('get')){             
            if(!empty($id)){
                $termCondtion = Cms::where(['id' => base64_decode($id)])->first();
                $terms_condions_content = Cms::with(['cmsmeta' => function($q){
                    $q->where('meta_key','=','terms_condions_content');
                }])->where(['id' => base64_decode($id)])->first();
                return view('admin.cms.term-condtion',['termCondtion' => $termCondtion,'terms_condions_content' => $terms_condions_content]);    
            }
        }

    }
    public function updateTermCondition(Request $request , $id = null){
        if($request->isMethod('post')){
            //$folderPath = public_path('/pages/homePage/');             
            $folderPath = 'pages/homePage/';
            if(!empty($id)){
                $id = base64_decode($id); 
                foreach($request['title'] as $key=>$res){  
                    if(!empty($request->file('banner_image')[$key])) {                 
                        $banner_image = $this->bannerMultiImageUpload($request->file('banner_image')[$key],$folderPath,'banner_image');                         
                    }else{
                        $banner_image= $request['old_banner_image'][$key];
                    }
                                        
                    $bannerContent[]=[
                        "title"          =>$request['title'][$key],  
                        "alt_banner_tag"          =>$request['alt_banner_tag'][$key],  
                        "banner_image"   =>$banner_image,                          
                        "content"    =>$request['content'],                                       
                        
                    ];
                }
                $updateCms = Cms::find($id);
                if(!empty($updateCms)){
                    $updateCms->meta_description = $request->general_info['meta_description'];           
                    $updateCms->meta_title = $request->general_info['meta_title'];
                    $updateCms->title = $request->general_info['title'];
                    $updateCms = $updateCms->save();
                    /*query save banner content*/
                    $updateCmsMetav = CmsMeta::where(['cms_id' => $id, 'meta_key' => 'terms_condions_content'])->update([ 'meta_value' => json_encode($bannerContent)]);
                }
                if( $updateCms || $updateCmsMetav){
                    return redirect()->route('admin-term-and-condtion',['id' => base64_encode($id)])->with('success','Content successfully updated.');
                }else{
                    return redirect()->route('admin-term-and-condtion',['id' => base64_encode($id)])->with('failure','Sorry,Something went wrong.');
                }
            }
        }
    }

    /****** Genral Setting*************/
public function generalSetting(Request $request , $id = null){
     if($request->isMethod('get')){             
            if(!empty($id)){
                $generalSetting = Cms::where(['id' => base64_decode($id)])->first();
                $general_setting_content = Cms::with(['cmsmeta' => function($q){
                    $q->where('meta_key','=','general_setting_content');
                }])->where(['id' => base64_decode($id)])->first();
                return view('admin.cms.generalSetting',['generalSetting' => $generalSetting,'general_setting_content' => $general_setting_content]);    
            }
        }

    }
    public function updateGeneralSetting(Request $request , $id = null){
        if($request->isMethod('post')){
            //$folderPath = public_path('/pages/homePage/');             
            $folderPath = 'pages/homePage/';
            if(!empty($id)){
                $id = base64_decode($id); 
                foreach($request['title'] as $key=>$res){  
                    if(!empty($request->file('banner_image')[$key])) {                 
                        $banner_image = $this->bannerMultiImageUpload($request->file('banner_image')[$key],$folderPath,'banner_image');                         
                    }else{
                        $banner_image= $request['old_banner_image'][$key];
                    }
                    if(!empty($request->file('footerlogo')[$key])) {                 
                        $footerlogo = $this->bannerMultiImageUpload($request->file('footerlogo')[$key],$folderPath,'footerlogo');                         
                    }else{
                        $footerlogo= $request['old_footerlogo'][$key];
                    }
                                        
                    $bannerContent[]=[
                        "title"          =>$request['title'][$key],  
                        "banner_image"   =>$banner_image,                                            
                        "description"    =>$request['description'],
                        "footerlogo"     =>$footerlogo, 
                        "copyright"    =>$request['copyright'],                                           
                        
                    ];
                }
                $updateCms = Cms::find($id);
                if(!empty($updateCms)){
                    $updateCms->meta_description = $request->general_info['meta_description'];           
                    $updateCms->meta_title = $request->general_info['meta_title'];
                    $updateCms->title = $request->general_info['title'];
                    $updateCms = $updateCms->save();
                    /*query save banner content*/
                    $updateCmsMetav = CmsMeta::where(['cms_id' => $id, 'meta_key' => 'general_setting_content'])->update([ 'meta_value' => json_encode($bannerContent)]);
                }
                if( $updateCms || $updateCmsMetav){
                    return redirect()->route('admin-general-setting',['id' => base64_encode($id)])->with('success','Content successfully updated.');
                }else{
                    return redirect()->route('admin-general-setting',['id' => base64_encode($id)])->with('failure','Sorry,Something went wrong.');
                }
            }
        }
    }

     

    /*
    * add blog category Controls
    */
    public function addBlogCategory(Request $request){ 


       if($request->isMethod('post')){           

            $data = $request->except(['_token','blog_cat_id']);
            $data['slug']= Str::slug($request['name'], '-');

           if($request['blog_cat_id']!='') {
               $blogCat=  BlogCategory::where('id', '=', base64_decode($request['blog_cat_id']))->update($data);
               $msg="Blog Category updated successfully";
            }else{
                 $blogCat = BlogCategory::create($data);
                $msg="Blog Category created successfully";
            }
             if($blogCat)
                 {
                     return redirect()->route('admin-categories-management')->with('success',$msg);
                 }else{
                return redirect()->route('admin-categories-management')->with('failure','Opps,something wrong,please try after some time.');
            }

        }
    }
public function checkSlug(Request $request){  
       if($request->isMethod('post')){    
        $slug_exist = '';   
        $slug =  BlogCategory::where('name', '=', $request->name)->exists();            
             if ($slug) {
                $slug_exist = 1;
                }else{
                  $slug_exist = 0;
               }
               return $slug_exist;

        }
    }


public function deleteBlogCategory(Request $request){
       if($request->isMethod('post')){
            if(!empty($request->blog_cat_id)){
            $del = BlogCategory::where(['id' => base64_decode($request->blog_cat_id)])->delete();
                if($del){
                    return response()->json([
                        'isSucceeded' => TRUE,
                        'message'=>"Category successfully Deleted."
                    ]);
                }else{
                    return response()->json([
                        'isSucceeded' => FALSE,
                        'message'=>"Something went wrong."
                    ]);
                }      
            }
        }
    } 
    
    /***************coupons******************/
      /**
    *Create coupons for customers
    */
    public function createCoupon(Request $request){         
        if ($request->isMethod('post')) { 
            $inputAll = $request->except(['_token','discount_type']);            
 
            if($inputAll){
                $inputAll['coupon_id'] = $this->generateRandomString();
                $inputAll['publish'] = '0';
                $inputAll['currency'] = 'USD';
                $inputAll['start_date'] = DateTime::createFromFormat('m-d-Y', $request->start_date)->format('Y-m-d');
                $inputAll['end_date'] = DateTime::createFromFormat('m-d-Y', $request->end_date)->format('Y-m-d');
                $couponSave = Coupon::create($inputAll);
                return redirect()->route('admin-coupons-list')->with('success','Coupon created successfully.');
            }else{
                return redirect()->rout('admin-coupons-list')->with('failure','Oops,Sorry there is a problem to create coupon.');
            }
        }
    }

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
    *Get the details of the coupons
    */
    public function couponsList(Request $request){
        if ($request->ajax()) {
            $data = Coupon::all();             
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $couponCheck = 'Publish';
                        $couponClass = 'success';
                        $enableButton = '';
                        $disableButton = 'none';
                        if($row->publish == 1){
                            $couponCheck = 'Unpublish';
                            $couponClass = 'primary';
                            $enableButton = 'none';
                            $disableButton = '';
                        }
                        return '<button type="button" class="mybtn btn-danger action-coup-btn" act-name="del" cp-id="'.$row->coupon_id.'" data-toggle="modal" data-target="#modal-info"> <i  data-toggle="tooltip" data-placement="top" title="Delete" class="fa fa-trash" aria-hidden="true"></i></button>
                        <a href="'.route("admin-send-data-to-coupon-form",['id' => base64_encode($row->id)]).'"       class="edit btn btn-success btn-sm action-blog-edit-btn">Edit</a>'; 
                    })

                    // <button type="button" class="btn-cpn-last-btn btn-danger action-coup-btn mybtn btn-'.$couponClass.'" act-name="pub" pub-val="'.$row->publish.'" cp-id="'.$row->coupon_id.'" data-toggle="modal" data-target="#modal-info" style="margin-left: 2px;margin-top: 2px;display:'.$enableButton.'"><i  data-toggle="tooltip" data-placement="top" title="'.$couponCheck.'" class="fas fa-eye-slash"></i> </button>
                        
                    //     <button type="button" class="btn-cpn-last-btn btn-success action-coup-btn mybtn btn-'.$couponClass.'" act-name="pub" pub-val="'.$row->publish.'" cp-id="'.$row->coupon_id.'" data-toggle="modal" data-target="#modal-info" style="margin-left: 2px;margin-top: 2px;display:'.$disableButton.'"> <i  data-toggle="tooltip" data-placement="top" title="'.$couponCheck.'" class="fas fa-eye"></i></button>


                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.coupons.couponsList');
    }

    public function sendDataToCouponForm(Request $request){      

         $data = Coupon::where('id',base64_decode($request->id))->first();        
     
         return view('admin.coupons.editCouponForm',compact('data'));
      
     }

     public function editCouponForm(Request $request){       

           if ($request->isMethod('post')) {
              $data = $request->except(['_token','c_id','discount_type']);        
               
                  if($data){
                      $updateCoupon = Coupon::where(['id' => $request->c_id])->update($data);
                      return redirect()->route('admin-coupons-list')->with('success','Coupon created successfully.');
                  }else{
                    return redirect()->rout('admin-coupons-list')->with('failure','Oops,Sorry there is a problem to create coupon.');
                   }

           }
      
     }


     /**
    * Show form to create coupon
    */
    public function couponForm(){
        $currency = $this->countriesGet();
        return view('admin.coupons.couponForm',['currency' => $currency]);
    }

    /**
    *Delete coupons for coustomer
    */
    public function deleteCoupon(Request $request){
        if ($request->isMethod('post')) {
            // $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
            // $delCoupon = $stripe->coupons->delete($request->couponId, []);
            if( $request->couponId){
                $delCouponFroDataBase = Coupon::where(['coupon_id' => $request->couponId]);
                $delCouponFroDataBase->delete();
                return redirect()->route('admin-coupons-list')->with('success','Coupon deleted successfully');   
            }else{
                return redirect()->route('admin-coupons-list')->with('failure','Coupon does not deleted.');
            }
        }
    }
    /**
    *Publish coupon for customer
    */
    public function publishCoupon(Request $request){
        if ($request->isMethod('post')) {
            $msg = '';
            $updatedCouon = '';
            if($request->publish){
                $msg = 'hide';
                $updatedCouon = '0';
            }else{
                $msg = 'published';
                $updatedCouon = '1';
            }
            $pubCoupon = Coupon::where(['coupon_id' => $request->couponId])->update(array('publish' => $updatedCouon));
            if($pubCoupon){
                return redirect()->route('admin-coupons-list')->with('success','Coupon '.$msg.' successfully');   
            }else{
                return redirect()->route('admin-coupons-list')->with('failure','Coupon does not '.$msg.'.');
            }
        }
    }

    public function countriesGet(){
            return array ('ALL' => 'Albania Lek','AFN' => 'Afghanistan Afghani','ARS' => 'Argentina Peso','AWG' => 'Aruba Guilder','AUD' => 'Australia Dollar','AZN' => 'Azerbaijan New Manat','BSD' => 'Bahamas Dollar','BBD' => 'Barbados Dollar','BDT' => 'Bangladeshi taka','BYR' => 'Belarus Ruble','BZD' => 'Belize Dollar','BMD' => 'Bermuda Dollar','BOB' => 'Bolivia Boliviano','BAM' => 'Bosnia and Herzegovina Convertible Marka','BWP' => 'Botswana Pula','BGN' => 'Bulgaria Lev','BRL' => 'Brazil Real','BND' => 'Brunei Darussalam Dollar','KHR' => 'Cambodia Riel','CAD' => 'Canada Dollar','KYD' => 'Cayman Islands Dollar','CLP' => 'Chile Peso','CNY' => 'China Yuan Renminbi','COP' => 'Colombia Peso','CRC' => 'Costa Rica Colon','HRK' => 'Croatia Kuna','CUP' => 'Cuba Peso','CZK' => 'Czech Republic Koruna','DKK' => 'Denmark Krone','DOP' => 'Dominican Republic Peso','XCD' => 'East Caribbean Dollar','EGP' => 'Egypt Pound','SVC' => 'El Salvador Colon','EEK' => 'Estonia Kroon','EUR' => 'Euro Member Countries','FKP' => 'Falkland Islands (Malvinas) Pound','FJD' => 'Fiji Dollar','GHC' => 'Ghana Cedis','GIP' => 'Gibraltar Pound','GTQ' => 'Guatemala Quetzal','GGP' => 'Guernsey Pound','GYD' => 'Guyana Dollar','HNL' => 'Honduras Lempira','HKD' => 'Hong Kong Dollar','HUF' => 'Hungary Forint','ISK' => 'Iceland Krona','INR' => 'India Rupee','IDR' => 'Indonesia Rupiah','IRR' => 'Iran Rial','IMP' => 'Isle of Man Pound','ILS' => 'Israel Shekel','JMD' => 'Jamaica Dollar','JPY' => 'Japan Yen','JEP' => 'Jersey Pound','KZT' => 'Kazakhstan Tenge','KPW' => 'Korea (North) Won','KRW' => 'Korea (South) Won','KGS' => 'Kyrgyzstan Som','LAK' => 'Laos Kip','LVL' => 'Latvia Lat','LBP' => 'Lebanon Pound','LRD' => 'Liberia Dollar','LTL' => 'Lithuania Litas','MKD' => 'Macedonia Denar','MYR' => 'Malaysia Ringgit','MUR' => 'Mauritius Rupee','MXN' => 'Mexico Peso','MNT' => 'Mongolia Tughrik','MZN' => 'Mozambique Metical','NAD' => 'Namibia Dollar','NPR' => 'Nepal Rupee','ANG' => 'Netherlands Antilles Guilder','NZD' => 'New Zealand Dollar','NIO' => 'Nicaragua Cordoba','NGN' => 'Nigeria Naira','NOK' => 'Norway Krone','OMR' => 'Oman Rial','PKR' => 'Pakistan Rupee','PAB' => 'Panama Balboa','PYG' => 'Paraguay Guarani','PEN' => 'Peru Nuevo Sol','PHP' => 'Philippines Peso','PLN' => 'Poland Zloty','QAR' => 'Qatar Riyal','RON' => 'Romania New Leu','RUB' => 'Russia Ruble','SHP' => 'Saint Helena Pound','SAR' => 'Saudi Arabia Riyal','RSD' => 'Serbia Dinar','SCR' => 'Seychelles Rupee','SGD' => 'Singapore Dollar','SBD' => 'Solomon Islands Dollar','SOS' => 'Somalia Shilling','ZAR' => 'South Africa Rand','LKR' => 'Sri Lanka Rupee','SEK' => 'Sweden Krona','CHF' => 'Switzerland Franc','SRD' => 'Suriname Dollar','SYP' => 'Syria Pound','TWD' => 'Taiwan New Dollar','THB' => 'Thailand Baht','TTD' => 'Trinidad and Tobago Dollar','TRY' => 'Turkey Lira','TRL' => 'Turkey Lira','TVD' => 'Tuvalu Dollar','UAH' => 'Ukraine Hryvna','GBP' => 'United Kingdom Pound','USD' => 'United States Dollar','UYU' => 'Uruguay Peso','UZS' => 'Uzbekistan Som','VEF' => 'Venezuela Bolivar','VND' => 'Viet Nam Dong','YER' => 'Yemen Rial','ZWD' => 'Zimbabwe Dollar'
            ); 
        }


/*******Manage Priceing*****/

public function managePrice(Request $request){  

              $priceCalculator = PriceCalculator::all();
              $data = $priceCalculator->toArray();

              $inch = $data[0]['desired_price']; 
              $centimeter = $data[1]['desired_price'];              

             return view('admin.managePriceing',compact('inch','centimeter'));
 
     }
     public function managePriceForm(Request $request){         

             if ($request->isMethod('post')) {                             
                if($request->centimeter_price){
                 $CentimeterPriceUpdate = PriceCalculator::where('id',2)->update(['desired_price'=>trim($request->centimeter_price,'$')]);
                 }
                 if($request->inch_price){
                  $PriceUpdate = PriceCalculator::where('id',1)->update(['desired_price'=>trim($request->inch_price,'$')]);
                  if($PriceUpdate){
                       return redirect()->route('admin-manage-price')->with('success','Price  Updated  successfully');   
                  }else{
                        return redirect()->route('admin-manage-price')->with('failure','Price does not Updated');
                   }
                 }

             }
          
     }
    public function saveEditorImage(Request $request){
        if ($request->ajax()) { 
            $folderPath= "pages/blogs/editor/";
            $imageName = $this->imageUpload($request,$folderPath,'file');
            echo asset('pages/blogs/editor/'.$imageName);
            die;
           
        }
    }

    public function saveHomePageEditer(Request $request){
        if ($request->ajax()) { 

            $folderPath= "pages/homePage/editor";
            $imageName = $this->imageUpload($request,$folderPath,'file');
            echo asset('pages/homePage/editor/'.$imageName);
            die;
           
        }
    }
    public function sendMail2(Request $request) {
        $data = $request->all();
    echo "Herllo";
        $messageBody =' hi dear student';
    
        Mail::raw($messageBody, function ($message) {
            $message->from('yourEmail@domain.com', 'Learning Laravel');
            $message->to('netqommain@gmail.com');
            $message->subject('Learning Laravel   email');
        });
    
        // check for failures
        if (Mail::failures()) {
          echo "not send";
        }else{
            echo " send";  
        }
    
        // otherwise everything is okay ...
        //return redirect()->back();
    }
 
}
