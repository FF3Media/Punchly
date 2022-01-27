<aside class="main-sidebar sidebar-dark-primary elevation-4 {{Auth::user()->user_role == 4 ? 'embroiderer-cls' : '' }}">
    <?php $userImage = asset('users-image/user.png');
    if (strpos(Auth::user()->avatar, 'http') !== false) {
        $userImage = Auth::user()->avatar;
    }else{                            
        if(!empty(Auth::user()->avatar)){
            $userImage = asset('users-image/'.Auth::user()->avatar);    
        }                            
    } ?>
    <a href="{{url('../')}}" class="brand-link">
       <img src="{{ asset('backend-images/sidebar-logo.png') }}" />
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.menu')
            </ul>
        </nav>
    </div>
	
	<div class="copyright-box">
	<a href="/terms-of-sale/">Terms & Conditions</a>
	<a href="/return-policy/">Return Policy</a>
	<p>© Punchly 2021.<br>
All rights reserved.</p>
	</div>

</aside>
