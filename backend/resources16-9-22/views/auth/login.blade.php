<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/favicon.png') }}">  
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

</head>
<body class="hold-transition login-page">

<section class="login-register-section">
<div class="container-fluid p-0">
    <div class="row no-gutters">

    <div class="col-lg-6 col-md-12	 col-sm-12 col-12">
    
    <div class="login-register-text">
        
        <a class="logo-a"  href="{{ url('../') }}"><img src="{{ asset('backend-images/logo.svg') }}" /></a>

        <div class="left-login-regietr-text">
            
            <h2>Welcome to the best solution for embroiders!</h2>
            <p>Register for free and start using right now! Our product will greatly help you and increase your efficiency.</p>

        </div>

    </div>


    </div>

<div class="col-lg-6 col-md-12 col-sm-12 col-12">

<div class="login-form-box">  

  <p class="register-link">Don't have an account? <a href="{{ route('register') }}" class="text-center">Register</a></p>
<div class="login-box">
    <!--div class="login-logo">
        <a href="{{ url('/home') }}"><b>{{ config('app.name') }}</b></a>
    </div-->
    <!-- /.login-logo -->
    @php
    //unset cooki for react app
          if (isset($_COOKIE['user']) || isset($_COOKIE['user_data'])) {
          unset($_COOKIE['user']); 
          unset($_COOKIE['user_data']); 
          setcookie('user', null, -1, '/'); 
          setcookie('user_data', null, -1, '/'); 
          
          } 
    @endphp
<h3>Login</h3>

    @if (session('success'))
    <div class="alert alert-success cus-msg-cls" style="text-align: left;">
    {{ session('success') }}
    </div>
    @elseif(session('failure'))
    <div class="alert alert-danger cus-msg-cls" style="text-align: left;">
    {{ session('failure') }}
    </div>
    @endif
    <!-- /.login-box-body -->
    <div class="card">
        <div class="card-body login-card-body">
            <!--p class="login-box-msg">Sign in to start your session</p-->

            <form method="post" action="{{ url('/login') }}">
                @csrf

                <div class="input-group mb-3">
                    <label for="email">Enter email address</label>
                    <input type="email"name="email"value="{{ old('email') }}"placeholder="Email"class="form-control @error('email') is-invalid @enderror"> <div class="input-group-append">
                        
                    </div>
                    @error('email')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <label for="password">Enter password</label>
                    <input type="password"name="password"placeholder="Password"class="form-control @error('password') is-invalid @enderror"> <div class="input-group-append">
                        
                    </div>
                    @error('password')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror

                </div>

                 <p class="forgot-password"><a href="{{ route('password.request') }}">Forgot your password</a> </p>

                <div class="row">
                    <div class="col-12">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">Remember Me</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>

                </div>
            </form>

            <div class="social-auth-links text-center mb-3">
                <p class="or"><span>or</span></p>
                <a href="{{ route('social.oauth', 'facebook') }}" class="btn btn-block btn-primary">
                <i class="fab fa-facebook mr-2"></i> Continue with Facebook
                </a>
                <a href="{{ route('social.oauth', 'google') }}" class="btn btn-block btn-danger">
                <i class="fab fa-google mr-2"></i>Continue with Google
                </a>
            </div>
            <!-- /.social-auth-links -->

           
            
        </div>
        <!-- /.login-card-body -->
    </div>

</div>
<!-- /.login-box -->
</div>

</div>
<!-- /.col-6 -->

</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->

</section>
<!--/.login-register-section -->


<script src="{{ asset('js/app.js') }}" defer></script>
<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function(){ $('.cus-msg-cls').fadeOut(); }, 3000);    
    });  
    if (window.location.hash && window.location.hash == '#_=_') {
        window.location.hash = '';
    }
</script>
</body>
</html>
