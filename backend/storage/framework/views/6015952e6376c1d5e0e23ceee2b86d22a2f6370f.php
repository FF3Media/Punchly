<!-- need to remove -->

<?php

use Illuminate\Support\Facades\Auth;

$user = Auth::user();
$user_role = isset($user['user_role']) ? $user['user_role'] : 4;
$email_verified_at = isset($user['email_verified_at']) ?? 0;
?>

<?php if($user_role == 1): ?>
<li class="nav-item has-treeview <?php echo e(request()->is('admin/order-management') || request()->is('admin/submitted-work') || request()->is('admin/order-detail*') ? 'menu-open' : 'menu-open'); ?>">
    <a href="#" class="nav-link <?php echo e(request()->is('admin/order-management') || request()->is('admin/submitted-work') || request()->is('admin/order-detail*') ? 'active' : ''); ?>">
        <!--  <img src="<?php echo e(asset('front-end/create-order.png')); ?>" height="20px" width="20px" /> -->
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
        <p>
            Order
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?php echo e(route('admin-order-management')); ?>" class="nav-link <?php echo e(request()->is('admin/order-management')  ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>Awaiting approval</p>
            </a>
        </li>
        <!-- <li class="nav-item">
            <a href="<?php echo e(route('admin-submitted-work-management')); ?>" class="nav-link <?php echo e(request()->is('admin/submitted-work') ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>For Review</p>
            </a>
        </li> -->
        <li class="nav-item">
            <a href="<?php echo e(route('admin-in-progress-management')); ?>" class="nav-link <?php echo e(request()->is('admin/in-progress') ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>In Progress</p>
            </a>
        </li>

         <li class="nav-item">
            <a href="<?php echo e(route('admin-review-work-management')); ?>" class="nav-link <?php echo e(request()->is('admin/review-work') ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>For Review</p>
            </a>
        </li>
         <li class="nav-item">
            <a href="<?php echo e(route('admin-reject-work-management')); ?>"
                class="nav-link <?php echo e(request()->is('admin/reject-work') ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>Rejected</p>
            </a>
        </li> 
       
        <li class="nav-item">
            <a href="<?php echo e(route('admin-reworking-work-management')); ?>"
                class="nav-link <?php echo e(request()->is('admin/reworking-work') ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>Reworking</p>
            </a>
        </li> 
        <li class="nav-item">
            <a href="<?php echo e(route('admin-completed-work-management')); ?>"
                class="nav-link <?php echo e(request()->is('admin/completed-work') ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>Completed</p>
            </a>
        </li> 
        
    </ul>
</li>
<li class="nav-item">
    <a href="<?php echo e(route('admin-users-list')); ?>" class="nav-link <?php echo e(request()->is('admin/users-list')  ? 'active' : ''); ?>">
        <i class="fas fa-users"></i>
        <p>Users</p>
        <i class="right fas"></i>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo e(route('admin-coupons-list')); ?>" class="nav-link <?php echo e(request()->is('admin/coupons-list')  ? 'active' : ''); ?>">
        <i class="nav-icon fas fa-receipt"></i>
        <p>Coupons</p>
        <i class="right fas"></i>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo e(route('admin-manage-price')); ?>" class="nav-link <?php echo e(request()->is('admin/manage-price')  ? 'active' : ''); ?>">
        <i class="fas fa-money-bill-wave nav-icon"></i>
        <p>Pricing</p>
        <i class="right fas"></i>
    </a>
</li>
<li class="nav-item <?php echo e(request()->is('admin/edit-home-page/MQ==') || request()->is('admin/about-us/Mw==') || request()->is('admin/contact-us/Mg==') || request()->is('admin/privacy-policy/NA==') || request()->is('admin/return-policy/NQ==') || request()->is('admin/term-and-condtion/Ng==') ? 'menu-open' : ''); ?>">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
            CMS
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?php echo e(route('admin-edit-home-page',['id'=> base64_encode(1)])); ?>" class="nav-link <?php echo e(request()->is('admin/edit-home-page/MQ==')  ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>Home Page</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo e(route('admin-about-us',['id'=> base64_encode(3)])); ?>" class="nav-link <?php echo e(request()->is('admin/about-us/Mw==')  ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-danger"></i>
                <p>About Us</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo e(route('admin-contact-us',['id'=> base64_encode(2)])); ?>" class="nav-link <?php echo e(request()->is('admin/contact-us/Mg==')  ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-danger"></i>
                <p>Contact Us </p>
            </a>
        </li>
        <!-- <li class="nav-item">
            <a href="<?php echo e(route('admin-general-setting',['id'=> base64_encode(7)])); ?>" class="nav-link <?php echo e(request()->is('admin/general-setting/Nw==')  ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-danger"></i>
                <p>General Setting </p>
            </a>
        </li> -->
        <li class="nav-item">
            <a href="<?php echo e(route('admin-privacy-policy',['id'=> base64_encode(4)])); ?>" class="nav-link <?php echo e(request()->is('admin/privacy-policy/NA==')  ? 'active' : ''); ?>">
                <i class=" nav-icon far fa-circle text-success"></i>
                <p>Privacy Policy </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo e(route('admin-return-policy',['id'=> base64_encode(5)])); ?>" class="nav-link <?php echo e(request()->is('admin/return-policy/NQ==')  ? 'active' : ''); ?>">
                <i class=" nav-icon far fa-circle text-success"></i>
                <p>Return Policy </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo e(route('admin-term-and-condtion',['id'=> base64_encode(6)])); ?>" class="nav-link <?php echo e(request()->is('admin/term-and-condtion/Ng==')  ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-warning"></i>
                <p>Terms and Condition</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="<?php echo e(route('admin-service-list')); ?>" class="nav-link <?php echo e(request()->is('/cms/service/categories')  ? 'active' : ''); ?>">
        <i class='fas fa-blog'></i>
        <p>Service Categories</p>
        <i class="right fas"></i>
    </a>
</li>
<li class="nav-item has-treeview <?php echo e(request()->is('admin/cms') || request()->is('admin/cms/blog-management') || request()->is('admin/cms/categories-management*') || request()->is('admin/cms//blog-management/blog-form*') ? 'menu-open' : ''); ?>">
    <a href="#" class="nav-link <?php echo e(request()->is('admin/cms/blog-management') || request()->is('admin/cms/categories-management')  ? 'active' : ''); ?>">
        <i class='fas fa-blog'></i>
        <p>
            Blog
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?php echo e(route('admin-blog-list')); ?>" class="nav-link <?php echo e(request()->is('admin/cms/blog-management')  ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>Blogs</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo e(route('admin-categories-management')); ?>" class="nav-link <?php echo e(request()->is('admin/cms/categories-management') ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>Categories</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item has-treeview">
    <a href="<?php echo e(route('profile-edit')); ?>" class="nav-link <?php echo e(request()->is('profile-edit')  ? 'active' : ''); ?>">
        <i class="fa fa-user" aria-hidden="true"></i>
        <p>Profile</p>
        <i class="right fas"></i>
    </a>
</li>
<li class="nav-item has-treeview <?php echo e(request()->is('admin/customer-reports') || request()->is('admin/sales-reports')  ? 'menu-open' : ''); ?>">
    <a href="#" class="nav-link <?php echo e(request()->is('admin/customer-reports') || request()->is('admin/sales-reports')   ? 'active' : ''); ?>">
        <i class='fas fa-blog'></i>
        <p>
            Reports
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?php echo e(route('customer-reports')); ?>" class="nav-link <?php echo e(request()->is('admin/customer-reports') ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>Customer Report</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo e(route('sales-reports')); ?>" class="nav-link <?php echo e(request()->is('admin/sales-reports')  ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>Sales Report</p>
            </a>
        </li>
    </ul>
</li>
<?php endif; ?>

<?php if($user_role == 2): ?>
<li class="nav-item has-treeview <?php echo e(request()->is('digitizer-manager/order-management') || request()->is('digitizer-manager/submitted-work') || request()->is('digitizer-manager/order-detail*') ? 'menu-open' : 'menu-open'); ?>">
    <a href="#" class="nav-link <?php echo e(request()->is('digitizer-manager/order-management') || request()->is('digitizer-manager/submitted-work') || request()->is('digitizer-manager/order-detail*') ? 'active' : ''); ?>">
        <!--  <img src="<?php echo e(asset('front-end/create-order.png')); ?>" height="20px" width="20px" /> -->
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
        <p>
            Orders
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?php echo e(route('digitizer-manager-order-management')); ?>" class="nav-link <?php echo e(request()->is('digitizer-manager/order-management')  ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>Awaiting approval</p>
            </a>
        </li>
        <!-- <li class="nav-item">
            <a href="<?php echo e(route('digitizer-manager-submitted-work-management')); ?>" class="nav-link <?php echo e(request()->is('digitizer-manager/submitted-work') ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>Submitted</p>
            </a>
        </li> -->
        <li class="nav-item">
            <a href="<?php echo e(route('digitizer-manager-in-progress-management')); ?>" class="nav-link <?php echo e(request()->is('digitizer-manager/in-progress') ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>In Progress</p>
            </a>
        </li>

      

         <li class="nav-item">
            <a href="<?php echo e(route('digitizer-manager-review-work-management')); ?>" class="nav-link <?php echo e(request()->is('digitizer-manager/review-work') ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>For Review</p>
            </a>
        </li>
         <li class="nav-item">
            <a href="<?php echo e(route('digitizer-manager-reject-work-management')); ?>"
                class="nav-link <?php echo e(request()->is('digitizer-manager/reject-work') ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>Rejected</p>
            </a>
        </li> 
        
        <li class="nav-item">
            <a href="<?php echo e(route('digitizer-manager-reworking-work-management')); ?>"
                class="nav-link <?php echo e(request()->is('digitizer-manager/reworking-work') ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>Reworking</p>
            </a>
        </li> 
        <li class="nav-item">
            <a href="<?php echo e(route('digitizer-manager-in-self-assign')); ?>" class="nav-link <?php echo e(request()->is('digitizer-manager/self-assign') ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>Self Assigned</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo e(route('digitizer-manager-completed-work-management')); ?>"
                class="nav-link <?php echo e(request()->is('digitizer-manager/completed-work') ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>Completed</p>
            </a>
        </li> 
    </ul>
</li>

<li class="nav-item has-treeview">
    <a href="<?php echo e(route('profile-edit')); ?>" class="nav-link <?php echo e(request()->is('profile-edit')  ? 'active' : ''); ?>">
        <i class="fa fa-user" aria-hidden="true"></i>
        <p>Profile</p>
        <i class="right fas"></i>
    </a>
</li>
<?php endif; ?>

<?php if($user_role == 3): ?>
<li class="nav-item has-treeview <?php echo e(request()->is('digitizer/order-management') || request()->is('digitizer/order-history') ? 'menu-open' : ''); ?>">
    <a href="#" class="nav-link <?php echo e(request()->is('digitizer/order-management') || request()->is('digitizer/order-history') ? 'active' : ''); ?>">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
        <p>
            Orders
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?php echo e(route('digitizer-order-management')); ?>" class="nav-link <?php echo e(request()->is('digitizer/order-management')  ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>Order List</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo e(route('digitizer-order-history')); ?>" class="nav-link <?php echo e(request()->is('digitizer/order-history') ? 'active' : ''); ?>">
                <i class="nav-icon far fa-circle text-success"></i>
                <p>Order History</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="<?php echo e(route('profile-edit')); ?>" class="nav-link <?php echo e(request()->is('profile-edit')  ? 'active' : ''); ?>">
        <i class="fa fa-user" aria-hidden="true"></i>
        <p>Profile</p>
        <i class="right fas"></i>
    </a>
</li>
<?php endif; ?>


<?php if($user_role == 4): ?>
<?php if($email_verified_at): ?>
<li class="nav-item">
    <a href="javascript:void(0)" data-toggle="modal" data-target="#create_new_orders" class="nav-link">
        <i class="fa fa-plus-circle" aria-hidden="true"></i>
        <p>Create new</p>
    </a>
</li>
<?php else: ?>
<li class="nav-item has-treeview">
    <a href="<?php echo e(url('/email/verify')); ?>" class="nav-link <?php echo e(request()->is('profile-edit')  ? 'active' : ''); ?>">
    <i class="fa fa-plus-circle" aria-hidden="true"></i>
        <p>Create new</p>
    </a>
</li>
<?php endif; ?>
<?php if($email_verified_at): ?>
<li class="nav-item">
    <a href="<?php echo e(route('embroiderer-order-management')); ?>" class="nav-link <?php echo e(request()->is('embroiderer/order-management')  ? 'active' : ''); ?>">
        <i class="fa fa-home" aria-hidden="true"></i>
        <p>Order history</p>
    </a>
</li>
<?php else: ?>
<li class="nav-item has-treeview">
    <a href="<?php echo e(url('/email/verify')); ?>" class="nav-link <?php echo e(request()->is('profile-edit')  ? 'active' : ''); ?>">
        <i class="fa fa-user" aria-hidden="true"></i>
        <p>Order history</p>
        <i class="right fas"></i>
    </a>
</li>
<?php endif; ?>

<?php if($email_verified_at): ?>
<li class="nav-item has-treeview">
    <a href="<?php echo e(route('profile-edit')); ?>" class="nav-link <?php echo e(request()->is('profile-edit')  ? 'active' : ''); ?>">
        <i class="fa fa-user" aria-hidden="true"></i>
        <p>Profile</p>
        <i class="right fas"></i>
    </a>
</li>
<?php else: ?>
<li class="nav-item has-treeview">
    <a href="<?php echo e(url('/email/verify')); ?>" class="nav-link <?php echo e(request()->is('profile-edit')  ? 'active' : ''); ?>">
        <i class="fa fa-user" aria-hidden="true"></i>
        <p>Profile</p>
        <i class="right fas"></i>
    </a>
</li>
<?php endif; ?>

<li class="nav-item">
    <a href="<?php echo e(route('embroiderer-cart')); ?>" class="nav-link <?php echo e(request()->is('embroiderer/profile-edit')  ? 'active' : ''); ?>">
        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
        <p>Cart</p>
    </a>
</li>
<?php endif; ?><?php /**PATH /var/www/punchly/backend/resources/views/layouts/menu.blade.php ENDPATH**/ ?>