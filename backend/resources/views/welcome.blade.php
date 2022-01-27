<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
        .under-construction img {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            display: block;
        }
        .under-construction p {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
            background-color: #afc578;
            font-size: 37px;
            padding: 20px 0;
            color: #fff;
        }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ route('embroiderer-dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            <div class="under-construction">
                 <img src="{{ asset('front-end/img-under-construction.jpg') }}" />
               <p> Under Construction! </p>
            </div>
        </div>
    </body>
</html>
