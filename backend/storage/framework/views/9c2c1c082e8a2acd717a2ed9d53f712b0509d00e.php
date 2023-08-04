<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
   
    <title> <?php echo e(isset($page_title) ?  $page_title  : ''); ?> </title>
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('/images/favicon.png')); ?>">  
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/custom.css')); ?>" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <link href="<?php echo e(asset('css/image-uploader.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/summernote.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="<?php echo e(asset('css/common.css')); ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <?php echo $__env->yieldContent('third_party_stylesheets'); ?>
    <?php echo $__env->yieldPushContent('page_css'); ?>
</head>
<?php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();
$user_role = isset($user['user_role']) ? $user['user_role'] : 4;
$user_avatar = isset($user['avatar']) ? $user['avatar'] : '';
$user_first_name = isset($user['first_name']) ? $user['first_name'] : 'Visitor';
$user_last_name = isset($user['last_name']) ? $user['last_name'] : '';
?>

<body class="hold-transition sidebar-mini <?php if ($user_role == 1) {
                                                echo 'admin-logged-in';
                                            } ?>">
    <script>
        var HOST_URL = "<?php echo e(route('/')); ?>";
    </script>
    <div class="wrapper">
        <!-- Main Header -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <!-- Left navbar links -->
            <?php
            $newRoute = '';
            if($user_role == 1){
            $newRoute = 'admin-search-order';
            }elseif($user_role == 2){
            $newRoute = 'digitizer-manager-search-order';
            }elseif($user_role == 3){
            $newRoute = 'digitizer-search-order';
            }else{
            $newRoute = 'embroiderer-search-order';
            }
            ?>
            <form action="<?php echo e(route($newRoute)); ?>" method="get" class="sidebar-form header-search-form">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button type="submit" id="search-btn" class="btn btn-flat">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                    <input type="text" name="search" class="form-control" value="<?php echo e(request()->query('search')); ?>" placeholder="Search by Order ID">
                </div>
            </form>
            <ul class="navbar-nav ml-auto">
                <?php if($user_role == 4): ?>
                <!-- <li class="nav-item">
                        <a href="<?php echo e(route('embroiderer-cart')); ?>" class="icontext">
                            <div class="icon-wrap icon-xs bg2 round text-secondary"><i
                                    class="fa fa-shopping-cart"></i></div>
                            <div class="text-wrap">
                                <small><?php echo e($cartCount); ?> items</small>
                            </div>
                        </a>
                    </li> -->
                <?php endif; ?>

                <li class="nav-item dropdown user-menu">

                    <?php if(isset($user)): ?>
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <?php $userImage = asset('users-image/user.png');
                        if (strpos($user_avatar, 'http') !== false) {
                            $userImage = $user_avatar;
                        } else {
                            if (!empty($user_avatar)) {
                                $userImage = asset('users-image/' . $user_avatar);
                            }
                        } ?>
                        <img src="<?php echo $userImage; ?>" class="user-image img-circle elevation-2" alt="">
                        <span class="d-md-inline"><?php echo e($user_first_name .' '. $user_last_name); ?> <i class="fas fa-angle-down"></i></span>

                        <!--  <div  class="profile-name-header">
                                <span> <?php // echo substr($user_first_name,0,1);echo substr( $user_last_name,0,1);
                                        ?>
                                </span>
                                 </div> -->
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <!--  <img src="<?php //echo $userImage;
                                            ?>" class="img-circle elevation-2" alt=""> -->
                            <div class="profile-name">
                                <img src="<?php echo $userImage; ?>" class="user-image img-circle elevation-2" alt="">
                                <!--span> <?php echo substr($user_first_name, 0, 1);
                                            echo substr($user_last_name, 0, 1);
                                            ?>
                                </span-->
                            </div>
                            <p>
                                <?php echo e($user_first_name .' '. $user_last_name); ?>

                            </p>
                        </li>
                        <!-- Menu Footer-->

                        <li class="user-footer">
                            <!--  <a href="<?php echo e(route('profile-edit')); ?>" class="btn btn-default btn-flat">Profile</a> -->
                            <!-- <a href="<?php echo e(route('change-password-form')); ?>" class="btn btn-default btn-flat">Change Password</a> -->
                            <a href="<?php echo e(url('../')); ?>" class="btn btn-default btn-flat">Home</a>
                            <?php if($user_role != 3): ?>
                            <a href="<?php echo e(url('../blog')); ?>" class="btn btn-default btn-flat">Blog</a>
                            <?php endif; ?>
                            <?php if($user_role == 4): ?>
                            <a href="<?php echo e(url('../contact-us')); ?>" class="btn btn-default btn-flat">Contact Us</a>

                            <?php endif; ?>


                            <a href="#" class="btn btn-default btn-flat float-right" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Sign out
                            </a>

                            <form id="logout-form" action="<?php echo e(route('logoutall')); ?>" method="POST" class="d-none">
                                <?php echo csrf_field(); ?>
                            </form>
                        </li>
                    </ul>
                    <?php endif; ?>
                </li>
                <?php if($user_role == 4 && $user): ?>
                <li class="cart-top-head">
                    <a href="<?php echo e(route('embroiderer-cart')); ?>">
                        <i class="fas fa-shopping-bag"></i>
                        <span id="cartCount" class="count"><?php if($shareData['getcartItems']): ?> <?php echo e(@count($shareData['getcartItems'])); ?> <?php else: ?> 0 <?php endif; ?></span>
                    </a>
                </li>

                <?php endif; ?>

                <li class="nav-item hamburger-menu-icon">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>

            </ul>
        </nav>
        <!-- Left side column. contains the logo and sidebar -->
        <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content m-0 pt-4">
                <?php echo $__env->yieldContent('content'); ?>
                <div class="loader"></div>
            </section>
        </div>
        <!-- Main Footer -->
        <!--footer class="main-footer">
                <strong>Copyright &copy; 2014-2020 <a href="<?php echo e(route('/')); ?>">myfileshosting.com</a>.</strong> All rights
                reserved.
            </footer-->


    </div>


    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script src="<?php echo e(asset('js/image-uploader.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/summernote.min.js')); ?>"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="<?php echo e(asset('js/bundle.js')); ?>"></script>
    <script src="<?php echo e(asset('js/dropzone.js')); ?>"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(function() {
                $('.cus-msg-cls').fadeOut(2000);
            }, 10000);
            jQuery('.loader').fadeOut(1000);
        });
        //This code for showing messages
        <?php if(Session::has('message')): ?>
        var type = "<?php echo e(Session::get('alert-type', 'info')); ?>"
        switch (type) {
            case 'success':

                toastr.options.timeOut = 10000;
                toastr.success("<?php echo e(Session::get('message')); ?>");
                break;
            case 'warning':

                toastr.options.timeOut = 10000;
                toastr.warning("<?php echo e(Session::get('message')); ?>");


                break;
            case 'error':

                toastr.options.timeOut = 10000;
                toastr.error("<?php echo e(Session::get('message')); ?>");

                break;
        }
        <?php endif; ?>
        //This code for showing messages
        $('#chooseFile').bind('change', function() {
            var filename = $("#chooseFile").val();
            if (/^\s*$/.test(filename)) {
                $(".file-upload").removeClass('active');
                $("#noFile").text("No file chosen...");
            } else {
                $(".file-upload").addClass('active');
                $("#noFile").text(filename.replace("C:\\fakepath\\", ""));
            }
        });
        // This code for tooltip
        $(document).ajaxComplete(function() {
            $('[data-toggle="tooltip"]').tooltip({
                "html": true,
                "delay": {
                    "show": 300,
                    "hide": 0
                },
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
                    return $html.addClass('grid-group-item');

                }
                $html.removeClass('grid-group-item');
            }).trigger('resize');
        })(jQuery);
    </script>

    <?php echo $__env->yieldContent('third_party_scripts'); ?>
    <?php echo $__env->yieldPushContent('page_scripts'); ?>
    <?php if($user_role == 4): ?>

    <?php echo $__env->make('embroiderer.CreateNewOrderPopup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('embroiderer.reloadOrder', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <?php endif; ?>


</body>

</html><?php /**PATH /var/www/punchly/backend/resources/views/layouts/app.blade.php ENDPATH**/ ?>