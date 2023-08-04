<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use \Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    #protected $redirectTo = RouteServiceProvider::HOME;
    public function redirectTo() {
        $role = Auth::user()->user_role;
        $email_verified_at = Auth::user()->email_verified_at; 
        
        switch ($role) {
            case 1:

                return '/admin/order-management';
                break;
            case 3:
                return '/digitizer/order-management';
                break;
            case 2:
                return '/digitizer-manager/order-management';
                break;
            case 4:
                if($email_verified_at == null){
                    return '/email/verify';
                }
                return '/embroiderer/order-management';
                break;
            default:
                return '/login';
                break;
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
  protected function credentials(Request $request)
    {
       return ['email' => $request->{$this->username()}, 'password' => $request->password, 'status' => 1];
    }

    protected $providers = [
        'facebook','google','twitter'
    ];

    public function show()
    {
        return view('auth.login');
    }

    public function redirectToProvider($driver)
    {
        if( ! $this->isProviderAllowed($driver) ) {
            return $this->sendFailedResponse("{$driver} is not currently supported");
        }

        try {
            return Socialite::driver($driver)->redirect();
        } catch (Exception $e) {
            // You should show something simple fail message
            return $this->sendFailedResponse($e->getMessage());
        }
    }


    public function handleProviderCallback( $driver )
    {

        try {
            $user = Socialite::driver($driver)->user();

        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

        // check for email in returned user
        // return empty( $user->email )
        //     ? $this->sendFailedResponse("No email id returned from {$driver} provider.")
        //     : $this->loginOrCreateAccount($user, $driver);

        return empty( $user->email )
            ? $this->sendFailedResponseDueToEmailNull("No email address returned from {$driver} provider.")
            : $this->loginOrCreateAccount($user, $driver);
    }

    protected function sendSuccessResponse()
    {
        return redirect()->route('profile-edit');
    }

    protected function sendFailedResponse($msg = null)
    {
        return redirect()->route('login')
            ->withErrors(['msg' => $msg ? : 'Unable to login, try with another provider to login.']);
    }

    protected function sendFailedResponseDueToEmailNull($msg = null){
        return redirect()->route('login')->with(['failure' => $msg.' Unable to login, try with another provider to login.']);
    }

    protected function loginOrCreateAccount($providerUser, $driver) {
        // check for already has account
        if($driver=='facebook')
           {
             $firstName=$providerUser->user['name'];
             $lastName = '';
           }
           else{
             $firstName=$providerUser->user['given_name'];
             $lastName=$providerUser->user['family_name'];
           }
        $user = User::where('email', $providerUser->getEmail())->first();
        // if user already found
        if( $user ) {
            // update the avatar and provider that might have changed
            $user->update([
                'avatar' => $providerUser->avatar,
                'provider' => $driver,
                'provider_id' => $providerUser->id,
                'access_token' => $providerUser->token,
             ]);
        } else {
              if($providerUser->getEmail()){ //Check email exists or not. If exists create a new user
               $user = User::create([
                  'name' => $providerUser->getName(),
                  'first_name' => $firstName,
                  'last_name' => $lastName,
                  'email' => $providerUser->getEmail(),
                  'avatar' => $providerUser->getAvatar(),
                  'provider' => $driver,
                  'provider_id' => $providerUser->getId(),
                  'access_token' => $providerUser->token,
                  'password' => '',
                  'user_role' => 4,
                  'status' => 1,
                  'email_verified_at' => new \DateTime()
            ]);

             }else{

            //Show message here what you want to show

           }
        }

        // login the user
        if(isset($user)){
          $cookie_name = "user";
            $data['user']="loggedIn";
            $data['user_data']=$user->first_name;
            $data['user_cart']=0;
            setcookie($cookie_name,json_encode($data), time() + (60 * 180), "/"); // 86400 = 1 day
        }
        Auth::login($user, true);

        return $this->sendSuccessResponse();
    }
    public function logout(Request $request) {
            $id = Auth::user()->id;
            if($id) {
                $user = User::find($id);
                 $user->login_access = 0;
                 $user->save();
                 Auth::logout();
              //unset cooki for react app
              if (isset($_COOKIE['user']) || isset($_COOKIE['user_data'])) {
                unset($_COOKIE['user']);
                unset($_COOKIE['user_data']);
                setcookie('user', null, -1, '/');
                setcookie('user_data', null, -1, '/');

            }
             return redirect('../');
           }else{
             return redirect('../');
           }

    }

    public function authenticated(Request $request, $user)
        {
      			if($user->role == 4){
      			  return redirect()->route('/embroiderer/order-management') ;
      			}
            $cookie_name = "user";
            $data['user']="loggedIn";
            $data['user_data']=$user->first_name;
            $data['user_cart']=0;
            setcookie($cookie_name,json_encode($data), time() + (60 * 180), "/"); //  2 minus
            $user->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $request->getClientIp(),
                'login_access' =>   1,
            ]);

        }
    private function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }
}
