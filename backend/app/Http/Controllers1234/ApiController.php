<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Url;
use App\User;
use App\Blog;
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
use App\Cms_services;
use DateTime;
use View;
use Carbon\Carbon;

class ApiController extends Controller
{
    /*get all blogs*/
	public function getAllBlogs(Request $request) {	
		if($request->isMethod('get')){
			$data = Blog::with('blogCat')->get();
			foreach ($data as $key => $blog) {
			$data[$key]['feature_image'] = url('/public/pages/blogs').'/'.$blog->feature_image;
			} 
			return response()->json([
							'message' => 'success',
							'isSucceeded' => TRUE,
							'data' => $data,
						]);
		}
	}
    /*Get Blogs By Category*/
	public function getBlogsByCategory(Request $request) {	
		if($request->isMethod('get')){
			if($request->cat_id){
				$data = Blog::with('blogCat')->where('blog_category_id',$request->cat_id)->get();
				foreach ($data as $key => $blog) {
				$data[$key]['feature_image'] = url('/public/pages/blogs').'/'.$blog->feature_image;
				}
			} 
			return response()->json([
							'message' => 'success',
							'isSucceeded' => TRUE,
							'data' => $data,
						]);
		}
	} 
    /*Get single BLog*/
	public function singleBlog(Request $request){
		if($request->isMethod('get')){
	        $data = [];
			if($request->id){
				 $data = Blog::with('blogCat')->where('id', $request->id)->first();				  		 
				 $data->feature_image = url('/public/pages/blogs').'/'.$data->feature_image;
			}else{
				return response()->json([ 
				                'message' => 'Please select blog id',                       
		                        'isSucceeded' => false,
		                    ]);
			}
		        return response()->json([
		                        'message' => 'success',
		                        'isSucceeded' => TRUE,
		                        'data' => $data,
		                    ]);
        } 
    }
	/*****Cms Pages*******/
	public function allCmsPages(Request $request , $id){    
  

	       if($request->isMethod('get')){ 
	         if($id){	

	           $data = Cms::with('cmsmetaapi')->where('id',$id)->first(); 
	           if($data){
	           if($data->cmsmetaapi->meta_value){             
	              $data->cmsmetaapi->meta_value = json_decode($data->cmsmetaapi->meta_value);
	           }
	           $data->home_path = url('/public/pages/homePage'); 
	           }else{
	           return response()->json([
								'message' => 'fail',
								'isSucceeded' => TRUE,
								'data' =>'Page not found!',
							 ]); 
	          }
	          }else{
	          	return response()->json([
								'message' => 'fail',
								'isSucceeded' => TRUE,
								'data' =>'Page id require',
							 ]);
	          }             
	           return response()->json([
								'message' => 'success',
								'isSucceeded' => TRUE,
								'data' => $data,
							 ]);
	        } 
	}

	/*Send contact email*/
	public function contactSendMail(Request $request){
		if($request->isMethod('post')){               
               try{
                  $data = $request->all();	
                  $data['subject'] = 'Contact Us';                  
                  $sendEmail = Mail::to(['suneel@yopmail.com'])->send( new SendMail($data,'contactUs'));
                  return response()->json([
                        'message' => 'Contact mail sent.',
                        'isSucceeded' => TRUE,                        
                    ]);   

		          }catch(\Exception $e){
                       return response()->json([
                      'message' => $e->getMessage(),
                      'isSucceeded' => FALSE
                       ]);
		           }
                }	 

	} 

	/*Send Newsletter email*/
	public function newsletterSubscription(Request $request){
		if($request->isMethod('post')){               
               try{
                  $data = $request->all();	
                  $data['subject'] = 'Newsletter Subscription'; 
				  $data['message'] = $request->email.' Thank you for Subscription'; 
				  if($request->email){             
                  $sendEmail = Mail::to(['suneel@yopmail.com'])->send( new SendMail($data,'newsletterSubscription'));
                  return response()->json([
                        'message' => 'newslater mail sent.',
                        'isSucceeded' => TRUE,                        
				  ],200
				);   
				  }else{
					return response()->json([
                        'message' => 'email id is required',
                        'isSucceeded' => false,                        
                    ],404);   
				  }
		          }catch(\Exception $e){
                       return response()->json([
                      'message' => $e->getMessage(),
                      'isSucceeded' => FALSE
					   ],500);
		           }
                }	 

	} 

/*Send login access*/
	public function loginAccess(Request $request){
		if($request->isMethod('post')){               
               try{
                 $userDetails = User::where('login_access', 1)->get();
               $data = [];
                 if($userDetails){
                  foreach ($userDetails as $key => $users) {                  
                  	$ip = $users->last_login_ip;
                  	$login_access = $users->login_access;
                  	$data[] = ['ip' => $ip, 'login_access' => $login_access,'userdata' =>$users];                   
                  } 
				  $response = [
							'message'       => 'Your orders are canceled',
							'isSucceeded'   => TRUE,
							'data' =>  $data
							];  
				 return response()->json($response);
                 }else{
                 	$response = [
							'message'       => 'Your orders are canceled',
							'isSucceeded'   => false,
							'data' =>  'no data found'
							];  
				 return response()->json($response);
                 }
 
		          }catch(\Exception $e){
                       return response()->json([
                      'message' => $e->getMessage(),
                      'isSucceeded' => FALSE
					   ],500);
		           }
                }	 

	} 
 

	/*Send all Service Slug */
	public function serviceCateSlug(Request $request){
		if($request->isMethod('get')){               
               try{
				  $cmsServices = Cms_services::all(); 
				  $data = [];
				  if($cmsServices){
				   foreach ($cmsServices as $key => $Services) {                  
					   $service_slug = $Services->service_slug; 
					   $service_title = $Services->service_title; 
					   $service_description = $Services->service_description;  
					   $feature_image = url('/public/pages/blogs').'/'.$Services->feature_image;
					   $data[]= ['service_slug' => $service_slug ,
					           'service_title'=>$service_title,
							   'service_description'=>$service_slug,
							   'feature_image'=>$feature_image];                   
				   } 
				   $response = [
							 'message'       => 'Services slugs',
							 'isSucceeded'   => TRUE,
							 'data' =>  $data
							 ];  
				  return response()->json($response);
				  }else{
					  $response = [
							 'message'       => 'Services slugs',
							 'isSucceeded'   => false,
							 'data' =>  'no data found'
							 ];  
				  return response()->json($response);
				  }
  
		          }catch(\Exception $e){
                       return response()->json([
                      'message' => $e->getMessage(),
                      'isSucceeded' => FALSE
					   ],500);
		           }
                }	 

	} 

	/*Send all Service Slug */
	public function getServiceBySlug(Request $request,$id){
		if($request->isMethod('get')){               
               try{
				  $cmsServices = Cms_services::where('service_slug',$id)->first(); 
				  $data = [];
				  if($cmsServices){ 
					$service_slug = $cmsServices->service_slug; 
					$service_title = $cmsServices->service_title; 
					$service_description = $cmsServices->service_description;  
					$meta_tag = $cmsServices->meta_tag;  
					$meta_description = $cmsServices->meta_description;  

					$feature_image= url('/public/pages/blogs').'/'.$cmsServices->feature_image;
					$data[]= ['service_slug' => $service_slug ,
							  'service_title'=>$service_title,
							  'service_description'=>$service_description,
							  'feature_image'=>$feature_image,
							  'meta_tag'=>$meta_tag,
							  'meta_description'=>$meta_description,

						];           
						$response = [
									'message'       => 'Services slugs',
									'isSucceeded'   => TRUE,
									'data' =>  $data
									];  
				  return response()->json($response);
				  }else{
					  $response = [
							 'message'       => 'Services slugs',
							 'isSucceeded'   => false,
							 'data' =>  'no data found'
							 ];  
				  return response()->json($response);
				  }
  
		          }catch(\Exception $e){
                       return response()->json([
                      'message' => $e->getMessage(),
                      'isSucceeded' => FALSE
					   ],500);
		           }
                }	 

	} 

//end api's methord
// For cron
    public function statusUpdateAfterSevendays(Request $request){
		if($request->isMethod('get')){
			$ordersDetails = Order::whereHas('payment_details')->where('status', 1)->get();
			$response = [];
			foreach ($ordersDetails as $key => $orderData) {				 
				if($orderData->payment_details->st_payment_intent_id){
					$orderdate = $orderData->created_at;
					$order_id = $orderData->id;					
					$createdDate = new DateTime($orderdate);
					$dateformat = $createdDate->format('Y-m-d h:i');
					$plusSevenDay =  date('Y-m-d h:i', strtotime($dateformat. ' + 7 days'));
					$current = date("Y-m-d h:i"); 
					if($plusSevenDay <= $current){
						$updateOrder = 	Order::where('id',$order_id)->where('status', 1)->update(['status'=> 9,'stripe_after_7'=>"1"]);
						if($updateOrder){
							$response = [
							'message'       => 'Your orders are canceled',
							'isSucceeded'   => TRUE
							]; 		             	      	 	                      
				     	}				     	
					}else{
							$response = [
							'message'       => 'Your stripe orders are not cancel today',
							'isSucceeded'   => false
							];  
					    }
					}elseif($orderData->payment_details->pay_authorization_id){						               
	                    $paypalOrderdate = $orderData->created_at;
						$paypalOrder_id = $orderData->id;					
						$paypalCreatedDate = new DateTime($paypalOrderdate);
						$paypalDateformat = $paypalCreatedDate->format('Y-m-d h:i');
						$paypalPlus29 =  date('Y-m-d h:i', strtotime($paypalDateformat. ' + 29 days'));
						$paypalCurrent = date("Y-m-d h:i"); 						 
						if($paypalPlus29 <= $paypalCurrent){
							$paypalUpdateOrder = 	Order::where('id',$paypalOrder_id)->where('status', 1)->update(['status'=> 9,'stripe_after_7'=>"1"]);
							if($paypalUpdateOrder){
								$response = [
								'message'       => 'Your payapal orders are canceled',
								'isSucceeded'   => TRUE
								]; 		             	      	 	                      
					     	}					     	
						}else{
								$response = [
								'message'       => 'Your payapal orders are not cancel today',
								'isSucceeded'   => false
								];  
						    }   

					}else{ 
							$response = [
							'message'       => 'Not macth any stripe or paypal order today',
							'isSucceeded'   => false
							];  
					} 

			}
		                   return response()->json($response);	

		}	 

	}

//End Class
}