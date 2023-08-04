<!DOCTYPE html>
<html >
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
            <?php if(Route::has('login')): ?>
                <div class="top-right links">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('embroiderer-dashboard')); ?>">Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>">Login</a>

                        <?php if(Route::has('register')): ?>
                            <a href="<?php echo e(route('register')); ?>">Register</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="under-construction">
                 <img src="<?php echo e(asset('front-end/img-under-construction.jpg')); ?>" />
               <p> Under Construction! </p>
            </div>
        </div>
    </body>
</html>
<?php /**PATH /var/www/punchly/backend/resources/views/welcome.blade.php ENDPATH**/ ?>