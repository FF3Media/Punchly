<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>
          <link rel="icon" href="{{ asset('images/favicon.png') }}"/>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<style type="text/css">
  
  .hovercolor:hover{
 
    background-color: #B53DD7 !important;
  }
</style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/home') }}"><b><img src="{{asset('front_end/images/logo.png')}}" width="109" alt="Embroiderer Website"></b></a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>

            <form action="{{ route('password.update') }}" method="POST">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                  <div class="input-group mb-3"> <label style="width:100%" class="form-control-label text-muted">Email Address</label> 
                   <input style="border-right: 1px solid #ced4da;border-radius: 0.25rem;" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="E-Mail Address">
                   @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                  </div> 
                <div class="input-group mb-3">
                    <input type="password"
                           name="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                           placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                    @if ($errors->has('password'))
                        <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <div class="input-group mb-3">
                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           placeholder="Confirm Password">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <span class="error invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>

                <div class="row">
                    <div class="col-12">
                        <button  type="submit" class="btn btn-primary btn-block hovercolor">Reset Password</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p class="mt-3 mb-1">
                <a href="{{ route('login') }}">Login</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>

</div>

<script src="{{ asset('js/app.js') }}" defer></script>

</body>
</html>
