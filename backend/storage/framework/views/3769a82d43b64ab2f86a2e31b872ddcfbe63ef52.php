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
<aside class="main-sidebar sidebar-dark-primary elevation-4 <?php echo e($user_role == 4 ? 'embroiderer-cls' : ''); ?>">
    <a href="<?php echo e(url('../')); ?>" class="brand-link">
        <img src="<?php echo e(asset('backend-images/sidebar-logo.png')); ?>" />
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php echo $__env->make('layouts.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </ul>
        </nav>
    </div>

    <div class="copyright-box">
        <a href="/terms-of-sale/">Terms & Conditions</a>
        <a href="/return-policy/">Return Policy</a>
        <p>© Punchly <?php echo e(date('Y')); ?>.<br>
            All rights reserved.</p>
    </div>

</aside><?php /**PATH /var/www/punchly/backend/resources/views/layouts/sidebar.blade.php ENDPATH**/ ?>