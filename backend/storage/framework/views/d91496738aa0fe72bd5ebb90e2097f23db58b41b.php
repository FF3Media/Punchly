<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <h1 class="text-black-50">Hello Digitizer Manager , You are logged in!</h1>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('third_party_scripts'); ?>
<script type="text/javascript">
    if (window.location.hash && window.location.hash == '#_=_') {
        window.location.hash = '';
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/punchly/backend/resources/views/digitizer_manager/dashboard.blade.php ENDPATH**/ ?>