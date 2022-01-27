<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }} | Registration Page</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
            integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
            crossorigin="anonymous"/>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">  
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">		
        <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">  
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

	
    <style type="text/css">
    .login-register-text {
    padding: 60px;
    height: 100%;
    background-size: cover;
    display: flex;
    align-items: center;
    position: fixed;
    width: 50%;
    justify-content: center;
    }
    </style>  

    </head>
    <body class="hold-transition register-page">
	<section class="login-register-section">
<div class="container-fluid p-0">
    <div class="row no-gutters">
	
	
	<div class="col-lg-6 col-md-6 col-sm-12 col-12">
    
    <div class="login-register-text">
        
        <a class="logo-a"  href="{{ url('../') }}"><img src="{{ asset('backend-images/logo.svg') }}" /></a>

        <div class="left-login-regietr-text">
            
            <h2>Welcome to the best solution for embroiders!</h2>
            <p>Register for free and start using right now! Our product will greatly help you and increase your efficiency.</p>

        </div>

    </div>


    </div>
	
	
	<div class="col-lg-6 col-md-6 col-sm-12 col-12">
	
	<div class="register-form-box">  
	 <p class="register-link">Already have an account? <a href="{{ route('login') }}" class="text-center">Login</a></p>
	
        <div class="register-box">
		<h3>Register</h3>
           
            <div class="card">
                <div class="card-body register-card-body">
                   
                    <form method="post" action="{{ route('register') }}" id="reg-user">
                        @csrf
                       
					   <div class="row">
					   <div class="col-lg-6 col-md-6 col-sm-12 col-12">
					   <div class="input-group mb-3 my-error">
					    <label for="first-name">First name</label>
                            <input type="text"  name="first_name"  class="form-control @error('first_name') is-invalid @enderror"   value="{{ old('first_name') }}"  placeholder="First name">
                            
                            @error('first_name')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
						</div>
                        
						 <div class="col-lg-6 col-md-6 col-sm-12 col-12">
						<div class="input-group mb-3 my-error">
											    <label for="last-name">Last name</label>
                            <input type="text"  name="last_name"  class="form-control @error('last_name') is-invalid @enderror"   value="{{ old('last_name') }}"  placeholder="Last name">
                           
                            @error('last_name')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
						</div>
						
						</div>
						
						
                        <div class="input-group mb-3 my-error">
						<label for="mobile">Mobile number</label>
                            <input type="text"  name="mobile" class="form-control @error('mobile') is-invalid @enderror"   value="{{ old('mobile') }}"  placeholder="Mobile">
                            
                            @error('mobile')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3 my-error">
						<label for="first-name">Enter email address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                            
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                         <div class="input-group mb-3 my-error">
                           <label for="first-name">Countries</label>
                           @php
                            $countries = getCounties();
                           @endphp
                            <select class="form-control" name="country" id="country">
                                <option value="">Select Country</option>
                                @foreach ($countries as $country) 
                                    <option value="{{$country->id}}">
                                     {{$country->name}}
                                    </option>
                                @endforeach
                            </select>
                            
                            @error('country')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="input-group mb-3 my-error">
                           <label for="first-name">State</label>
                            <select class="form-control" name="state" id="state">
                             </select>
                            
                            @error('state')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                         <div class="input-group mb-3 my-error">
                           <label for="first-name">City</label> 
                             <input type="text" name="city" value="{{ old('city') }}" class="form-control @error('city') is-invalid @enderror" placeholder="City">
                            
                            @error('city')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3 my-error">
                           <label for="first-name">Postcode</label>
                            <input type="number"  class="form-control" name="postcode" id="postcode"/> 
                            
                            @error('postcode')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                         <div class="input-group mb-3 my-error">
                           <label for="first-name">Address</label>
                            <input type="text"  class="form-control" name="address" id="address"/> 
                            
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3 my-error">
						<label for="password">Create password</label>
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                            
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3 my-error">
						<label for="password">Repeat password</label>
                            <input type="password" name="password_confirmation" class="form-control"  placeholder="Repeat password">
                            
                        </div>
                        <div class="input-group mb-3 my-error">
                        <label for="password">Enter a Company Name(optional)</label>
                            <input type="text" name="company_name" id="company_name" class="form-control"  placeholder="Company Name">
                            
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="icheck-primary my-error agree">
                                    <input type="checkbox" id="agreeTerms" name="terms" value="">
                                    <label for="agreeTerms">
                                    I agree to the <a target='_blank' href="/terms-of-sale/">terms</a>
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-12">
                                <input type="submit" class="btn btn-primary btn-block" value="Register" />
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                    <div class="social-auth-links text-center">
                        <p class="or"><span>or</span></p>
                        <a href="{{ route('social.oauth', 'facebook') }}" class="btn btn-block btn-primary">
                            <i class="fab fa-facebook mr-2"></i>
                            Sign up using Facebook
                        </a>
                        <a href="{{ route('social.oauth', 'google') }}" class="btn btn-block btn-danger">
                            <i class="fab fa-google mr-2"></i>
                            Sign up using Google
                        </a>
                    </div>
                   
                </div>
                <!-- /.form-box -->
            </div>
            <!-- /.card -->
            <!-- /.form-box -->
        </div>
		
		</div>
		
		</div>
        <!-- /.register-box -->
		
		
		</div>
		</div>
		</section>
		
        <script src="{{ asset('js/app.js') }}"></script>    
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#reg-user').validate({
                    submitHandler: function(form) {
                    // do other things for a valid form
                    form.submit();
                    },
                    rules: {
                        first_name: {
                            required: true
                        },
                        last_name: {
                            required: true,
                        },
                        email:{
                            required: true,
                            email: true,
                            remote: {
                                url: `{{ route('check-email-exist') }}`,
                                type: "post",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            },
                            
                        },
                        country:{
                         required: true,
                        },
                        state:{
                         required: true,
                        },
                        city:{
                         required: true,
                        },
                        postcode:{
                         required: true,
                        },
                        address:{
                         required: true,
                        },
                        mobile:{
                            required: true,
                            digits: true,
                            minlength: 10,
                            maxlength: 10,
                            remote: {
                                url: `{{ route('check-mobile-exist') }}`,
                                type: "post",
                                data: {'checkAction':'register'},
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            },
                        },
                        password:{
                            required: true,
                            minlength: 8,
                            maxlength: 16
                        },
                        password_confirmation: {
                            required: true,
                            equalTo: '#password',
                            minlength: 8,
                            maxlength: 16
                        },
                        terms:{
                            required : true,
                        }
                    },
                    

                    messages: {
                        first_name: {
                            required: "Please enter your first name",
                        },  
                        last_name: {                 
                            required : "Please enter your last name",
                        },
                        mobile: {
                            required : "Please enter your mobile number",
                            remote: "This mobile number already exists"
                        },
                        email: {
                            required : "Please enter your email address",
                            remote: "This email already exists"
                        },
                        country: {
                           required : "Please Select your country",

                        },
                        state:{
                           required : "Please Select your state",
                        },
                        city:{
                           required : "Please Select your city",
                        },
                        postcode:{
                           required : "Please Select your postcode",
                        },
                        address:{
                           required : "Please enter your  address",
                        },
                        password:{
                            required : "Please enter your password",
                        },
                        password_confirmation:{
                            required : "Please enter your confirm password",
                            equalTo: "Your password and confirmation password do not match",
                        },
                        terms:{
                            required : "Please check the checkbox of terms",
                        }
                        
                    },
                    errorElement: 'span',           
                    errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.my-error').append(error);
                    },
                    highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                    },
                    unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    }
                });
            });

 $(document).ready(function () {
$('#country').change(function(){
     
        var cid = $(this).val();
        if(cid){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
           type:"get",
           url:"{{url('/getStates')}}"+"/"+cid,  
           success:function(res)
           {       
                if(res)
                {
                    $("#state").empty();
                    $("#city").empty();
                    $("#state").append('<option>Select State</option>');
                    $.each(res,function(key,value){
                        $("#state").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
           }

        });
        }
    });
  });
 /* $('#state').change(function(){
        var sid = $(this).val();
        if(sid){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
           type:"get",            
           url:"{{url('/getCities')}}"+"/"+sid,
           success:function(res)
           {       
                if(res)
                {
                    $("#city").empty();
                    $("#city").append('<option>Select City</option>');
                    $.each(res,function(key,value){
                        $("#city").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
           }

        });
        }
    }); */
        </script>
 
    </body>
</html>