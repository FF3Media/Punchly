<?php
use Illuminate\Support\Facades\Auth;
$user = Auth::user();
$user_role = isset($user['user_role']) ? $user['user_role'] : 4;
$user_avatar = isset($user['avatar']) ? $user['avatar'] : '';

$userImage = asset('users-image/user.png');
if (strpos($user_avatar, 'http') !== false) {
    $userImage = $user_avatar;
} else {
    if (!empty($user_avatar)) {
        $userImage = asset('users-image/' . $user_avatar);
    }
} ?>
<aside class="main-sidebar sidebar-dark-primary elevation-4 {{$user_role == 4 ? 'embroiderer-cls' : '' }}">
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
        <p>© Punchly 2022.<br>
            All rights reserved.</p>
    </div>

</aside>