<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
            integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
            crossorigin="anonymous"/>
            <link rel="icon" href="{{ asset('images/favicon.png') }}"/>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">        
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">        
        <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
        <link href="{{ asset('css/image-uploader.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/summernote.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link href="{{ asset('css/common.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
        <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '301172744685648');
  fbq('track', 'PageView');
</script>
<!-- End Facebook Pixel Code -->

<script type="text/javascript">
    adroll_adv_id = "7FPFZ5JOMNA3BAS4XN4HI6";
    adroll_pix_id = "VNMU3QMLZREFDFDVQYIVFL";
    adroll_version = "2.0";

    (function(w, d, e, o, a) {
        w.__adroll_loaded = true;
        w.adroll = w.adroll || [];
        w.adroll.f = [ 'setProperties', 'identify', 'track' ];
        var roundtripUrl = "https://s.adroll.com/j/" + adroll_adv_id
                + "/roundtrip.js";
        for (a = 0; a < w.adroll.f.length; a++) {
            w.adroll[w.adroll.f[a]] = w.adroll[w.adroll.f[a]] || (function(n) {
                return function() {
                    w.adroll.push([ n, arguments ])
                }
            })(w.adroll.f[a])
        }

        e = d.createElement('script');
        o = d.getElementsByTagName('script')[0];
        e.async = 1;
        e.src = roundtripUrl;
        o.parentNode.insertBefore(e, o);
    })(window, document);
    adroll.track("pageView");
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-190636315-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

gtag('config', 'UA-190636315-1');
</script>
        @yield('third_party_stylesheets')
        @stack('page_css')
    </head>
    <body class="hold-transition sidebar-mini <?php if(Auth::user()->user_role == 1){echo 'admin-logged-in';} ?>">
 

<noscript>
  <img height="1" width="1" style="display:none" 
       src="https://www.facebook.com/tr?id=301172744685648&ev=PageView&noscript=1"/>
</noscript>
        <script>var HOST_URL = "{{ route('/') }}";</script>
        <div class="wrapper">
            <!-- Main Header -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
              
                <!-- Left navbar links -->
                @php 
                    $newRoute = '';
                    if(Auth::user()->user_role == 1){
                        $newRoute = 'admin-search-order';
                    }elseif(Auth::user()->user_role == 2){
                        $newRoute = 'digitizer-manager-search-order';
                    }elseif(Auth::user()->user_role == 3){
                        $newRoute = 'digitizer-search-order';
                    }elseif(Auth::user()->user_role == 4){
                        $newRoute = 'embroiderer-search-order';
                    }
                @endphp
				<form action="{{ route($newRoute) }}" method="get" class="sidebar-form header-search-form">
                    <div class="input-group">
                		<span class="input-group-btn">
                            <button type="submit" id="search-btn" class="btn btn-flat">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                        <input type="text" name="search" class="form-control" value="{{request()->query('search')}}" placeholder="Search by Order ID">
                    </div>
                </form>
                <ul class="navbar-nav ml-auto">
                    @if(Auth::user()->user_role == 4)
                    <!-- <li class="nav-item">
                        <a href="{{ route('embroiderer-cart') }}" class="icontext">
                            <div class="icon-wrap icon-xs bg2 round text-secondary"><i
                                    class="fa fa-shopping-cart"></i></div>
                            <div class="text-wrap">
                                <small>{{ $cartCount }} items</small>
                            </div>
                        </a>
                    </li> -->
                    @endif
                    
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <?php $userImage = asset('users-image/user.png');
                        if (strpos(Auth::user()->avatar, 'http') !== false) {
                            $userImage = Auth::user()->avatar;
                        }else{                            
                            if(!empty(Auth::user()->avatar)){
                                $userImage = asset('users-image/'.Auth::user()->avatar);    
                            }                            
                        } ?>
                     <img src="<?php echo $userImage; ?>" class="user-image img-circle elevation-2" alt=""> 
                        <span class="d-md-inline">{{ Auth::user()->first_name .' '. Auth::user()->last_name  }} <i class="fas fa-angle-down"></i></span>

                       <!--  <div  class="profile-name-header">
                                <span> <?php // echo substr(Auth::user()->first_name,0,1);echo substr( Auth::user()->last_name,0,1);
                                        ?>                            
                                </span>
                                 </div> -->
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <!-- User image -->
                            <li class="user-header bg-primary">
                               <!--  <img src="<?php //echo $userImage; ?>" class="img-circle elevation-2" alt=""> -->
                               <div  class="profile-name">
                                 <img src="<?php echo $userImage; ?>" class="user-image img-circle elevation-2" alt=""> 
                                <!--span> <?php echo substr(Auth::user()->first_name,0,1);echo substr( Auth::user()->last_name,0,1);
                                        ?>                            
                                </span-->
                                 </div>
                                <p>
                                    {{ Auth::user()->first_name .' '. Auth::user()->last_name}}
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                               <!--  <a href="{{ route('profile-edit') }}" class="btn btn-default btn-flat">Profile</a> -->
                                <!-- <a href="{{ route('change-password-form') }}" class="btn btn-default btn-flat">Change Password</a> -->
                                 <a href="{{url('../')}}" class="btn btn-default btn-flat">Home</a>
                                 @if(Auth::user()->user_role != 3)
                                  <a href="{{url('../blog')}}" class="btn btn-default btn-flat">Blog</a>
                                  @endif
                                  @if(Auth::user()->user_role == 4)
                                   <a href="{{url('../contact-us')}}" class="btn btn-default btn-flat">Contact Us</a>
                     
                                  @endif
                                

                                 <a href="#" class="btn btn-default btn-flat float-right"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Sign out
                                </a>

                                <form id="logout-form" action="{{ route('logoutall') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>

                        </ul>
                    </li>
                    @if(Auth::user()->user_role == 4 && Auth::user())
                    <li class="cart-top-head">
                        <a href="{{ route('embroiderer-cart') }}">
                            <i class="fas fa-shopping-bag"></i>
                            <span id="cartCount" class="count">@if($shareData['getcartItems']) {{ @count($shareData['getcartItems']) }} @else 0 @endif</span>
                        </a>
                    </li> 
                     
                     @endif

                       <li class="nav-item hamburger-menu-icon">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
                 
                </ul>
            </nav>
            <!-- Left side column. contains the logo and sidebar -->
            @include('layouts.sidebar')
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <section class="content m-0 pt-4">
                    @yield('content')
                    <div class="loader"></div>
                </section>
            </div>
            <!-- Main Footer -->
            <!--footer class="main-footer">
                <strong>Copyright &copy; 2014-2020 <a href="{{ route('/') }}">myfileshosting.com</a>.</strong> All rights
                reserved.
            </footer-->


        </div>

          
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
        <script src="{{ asset('js/image-uploader.min.js') }}"></script>
        <script src="{{ asset('js/summernote.min.js') }}"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>	
        <script src="{{ asset('js/bundle.js') }}"></script>
        <script src="{{ asset('js/dropzone.js') }}"></script>         
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
        
        <script type="text/javascript">
             

            $(document).ready(function(){
                setTimeout(function(){ $('.cus-msg-cls').fadeOut(2000); }, 10000);   
                jQuery('.loader').fadeOut(1000); 
            }); 
            //This code for showing messages
            @if (Session::has('message'))
                var type = "{{ Session::get('alert-type', 'info') }}"
                switch(type){
                    case 'success':

                    toastr.options.timeOut = 10000;
                    toastr.success("{{Session::get('message')}}");
                    break;
                    case 'warning':

                    toastr.options.timeOut = 10000;
                    toastr.warning("{{Session::get('message')}}");


                    break;
                    case 'error':

                    toastr.options.timeOut = 10000;
                    toastr.error("{{Session::get('message')}}");

                    break;
                }
            @endif 
            //This code for showing messages
            $('#chooseFile').bind('change', function () {
                var filename = $("#chooseFile").val();
                if (/^\s*$/.test(filename)) {
                    $(".file-upload").removeClass('active');
                    $("#noFile").text("No file chosen..."); 
                }else{
                    $(".file-upload").addClass('active');
                    $("#noFile").text(filename.replace("C:\\fakepath\\", "")); 
                }
            });
            // This code for tooltip
            $( document ).ajaxComplete(function() {
                $('[data-toggle="tooltip"]').tooltip({
                    "html": true,
                    "delay": {"show": 300, "hide": 0},
                });
            });   

            
 (function($) {
  var $window = $(window),
    $grid = $('#grid');
    $html = $('.view-group');

  $window.resize(function resize() {
    if ($window.width() < 767) {
        $html.removeClass('list-group-item');
        $grid.trigger('click');
        return   $html.addClass('grid-group-item');

    } 
    $html.removeClass('grid-group-item');
  }).trigger('resize');
})(jQuery);
        </script>

        @yield('third_party_scripts')
        @stack('page_scripts')
          @if(Auth::user()->user_role == 4)

         @include('embroiderer.CreateNewOrderPopup')
         @include('embroiderer.reloadOrder')
         

         @endif

        
    </body>
</html>
