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
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body class="hold-transition login-page">
<div class="login-box forgot-box">
    <div class="login-logo">
        <a href="{{ url('/home') }}"> <img src="{{ asset('backend-images/sidebar-logo.png') }}" /></a>
    </div>

    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg hideAfterSend">Enter your email below and we will send you a link to reset your password.</p>

            @if (session('status'))
                <div style="text-align: center;" class="alert alert-success">
                    {{ session('status') }}
                </div>
                <script type="text/javascript"> 
                        jQuery(document).ready(function() {
                           jQuery('.hideAfterSend').hide();

                        });
                </script>
            @endif

            <form action="{{ route('password.email') }}" method="post" class="hideAfterSend">
                @csrf 
                <div class="input-group mb-3">
                    <input type="email"
                           name="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                    @if($errors->has('email'))
                      <span style="margin: 0px auto;" class="error invalid-feedback">{{ $errors->first('email') }}</span>  
                    @endif
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Send Password Reset Link</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

           <div class="links-bottom"> <p class="link-p">
                <a href="{{ route("login") }}">Login</a>
            </p>
            <p class="link-p">
                <a href="{{ route("register") }}" class="text-center">Sign up</a>
            </p>
        </div>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<script src="{{ asset('js/app.js') }}" defer></script>

</body>
</html>
