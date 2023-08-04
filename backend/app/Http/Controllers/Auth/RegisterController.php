<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register-successfully';
   // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mobile' => ['required',  'unique:users'],
        ],[
            'last_name.required' => 'The last name field is required.',
            'first_name.required' => 'The first name field is required.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
 
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'mobile' => $data['mobile'],

            'postcode' => $data['postcode'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country'],
            'address' => $data['address'],
            'company_name' => $data['company_name'],
            'user_role' => 4,
            'status' => 1
        ]);
    }


//     protected function redirectTo()
// {
//     // if (auth()->user()->role_id == 1) {
//     //     return '/admin';
//     // }
//     return ;
// }


    /**
    *Disable auto login after registration using override this method
    */
    public function register(Request $request)
    {
         
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        //$this->guard()->login($user);
        if($user){
            $data = $request->all();
           
            $data['subject'] = 'Your Punchly account';
            $data['user_role'] = 'Embroiderer';
            $sendEmail = Mail::to([$data['email'],'admin@punchli.io'])->send( new SendMail($data,'newUser'));
        }
        return $this->registered($request, $user)
        ?: redirect($this->redirectPath());
    }


}
