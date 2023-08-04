<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;
use App\CardDetail;
use App\PaymentDetail;
use App\PriceCalculator;
use Stripe;
use DataTables;
use Image;
use App\User;
use App\Garment;
use App\Order;
use App\Coupon;
use App\OrderImage;
use DateTime;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;
use Carbon\Carbon;

class FrontendController extends Controller
{

    /**
    * HomePage
    */
    public function homePage(Request $request){
      
        $page_title = 'Welcome';
        return view('welcome',compact('page_title'));
    }

    /**
    *  Test
    */
    public function test(){
        $data['first_name'] = 'Tester';
        $data['last_name'] = 'User';
        $data['email'] = 'test@yopmail.com';
        $data['mobile'] = '9865321470';
        $data['user_role'] = 'Embroiderer';
        $page_title = 'test';
        return view('embroiderer.test',compact('data','page_title'));
    }


    /**
     * Check the email exist
     */
    public function checkEmailExist(Request $request)
    {
        if ($request->isMethod('post')) {
            $emailExist = User::where(['email' => $request->email])->first();
            echo $emailExist ? 'false' : 'true';
        }
    }

    public function afterRegisterConfirmationPage(){
        
        return view('afterRegisterConfirmation');

    }

    /**
     * Check mobile number exist
     */
    public function checkMobileExist(Request $request)
    {

        if ($request->isMethod('post')) {
            $mobileExist = User::where(['mobile' => $request->mobile])->first();
            if($request->checkAction == 'register'){
                $mobileExist = User::where(['mobile' => $request->mobile])->first();
            }else{
                $mobileExist = User::where(['mobile' => $request->mobile])->where('id', '!=' , $request->id)->first();
            }
            echo $mobileExist ? 'false' : 'true';
        }
    }
    /**
    * privacy Policy page Create
    */
    public function privacy(){
        $page_title = 'Privacy Policy';
        return view('privacy-policy',compact('page_title'));
    }

    /**
    * Common function for all logged in users edit profile
    */
    public function editProfile(Request $request){
        if($request->isMethod('get')){
           
            if (Auth::user()) {
                $page_title = 'Update Profile';
                
                if(Auth::user()->user_role == 1){
                    $homeLink = route('admin-dashboard');
                }elseif(Auth::user()->user_role == 2){
                    $homeLink = route('digitizer-dashboard');
                }elseif(Auth::user()->user_role == 3){
                    $homeLink = route('digitizer-manager-dashboard');
                }elseif(Auth::user()->user_role == 4){
                    $homeLink = route('embroiderer-dashboard');
                }
                $userData = User::find(Auth::user()->id);
                $cardDetail =  CardDetail::where('user_id',Auth::user()->id)->get();



                return view('edit-profile',compact('userData','page_title','homeLink','cardDetail'));
            }else{
                return redirect()->route('login');
            }
        }
    }





    /**
    * Common function for all logged in users profile update
    */
    public function updateProfile(Request $request){
        $data = $request->except(['_token','avatar']);

        if($request->hasFile('avatar')) {
            $folderPath= "users-image/";
            if ((file_exists(public_path('/users-image/'. Auth::user()->avatar)) && Auth::user()->avatar)) {
                unlink(public_path('/users-image/'. Auth::user()->avatar));
            }
            $data['avatar'] = $this->imageUpload($request,$folderPath,'avatar');
        }else{
            $data['avatar']= Auth::user()->avatar;
        }

        $user = User::where(['id' => Auth::user()->id])->update($data);
        if($user){
            return redirect()->back()->with(['alert-type'=>'success','message'=>'Profile Updated Successfully.']);
        }else{
            return redirect()->back()->with(['error'=>'failure','message'=>'Opps,Something went wrong,please try again.']);
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
    *   Change Password Form
    */
    public function changePasswordForm(Request $request){
        if (Auth::user()) {
            $header = 'Change Password Form';
            if(Auth::user()->user_role == 1){
                $homeLink = route('admin-dashboard');
            }elseif(Auth::user()->user_role == 2){
                $homeLink = route('digitizer-dashboard');
            }elseif(Auth::user()->user_role == 3){
                $homeLink = route('digitizer-manager-dashboard');
            }elseif(Auth::user()->user_role == 4){
                $homeLink = route('embroiderer-dashboard');
            }
            return view('changePassword',compact('header','homeLink'));
        }else{
            return redirect()->route('login');
        }
    }




    /**
    *   Change password functionality
    */
    public function changePassword(Request $request){
        if($request->isMethod('post') && Auth::user()->id){
            $validatedData = $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|string|min:8',
            ]);
            if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
                return back()->with(["alert-type"=>"password_error","message"=>"Your current password does not matches with the password you provided. Please try again."]);
            }
            if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
                return redirect()->back()->with(["message"=>"New Password cannot be same as your current password. Please choose a different password.","alert-type" => "error"]);
            }
            //Change Password
            $user = Auth::user();
            $user->password = bcrypt($request->get('new_password'));
            $user->save();
            return redirect()->back()->with(["alert-type"=>"success","message"=>"Password changed successfully."]);
        }
    }
        //For fetching states
        public  function getStates($id)
        {
            $states = DB::table("states")->where("country_id",$id)->pluck("name","id");
            return response()->json($states);
        }

        //For fetching cities
        public  function getCities($id)
        {
            $cities= DB::table("cities")->where("state_id",$id)->pluck("name","id");
            return response()->json($cities);
        }

}