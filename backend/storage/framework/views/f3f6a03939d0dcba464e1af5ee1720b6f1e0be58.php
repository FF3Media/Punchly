<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12" style="margin: auto;">
            <?php if(session()->has('success')): ?>
            <div class="alert alert-success cus-msg-cls" style="text-align: left;">
                <?php echo e(session()->get('success')); ?>

            </div>
            <?php elseif(session()->has('failure')): ?>
            <div class="alert alert-danger cus-msg-cls" style="text-align: left;">
                <?php echo e(session()->get('failure')); ?>

            </div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
            <div class="alert alert-danger cus-msg-cls">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>
            <!-- jquery validation -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Change Password</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="<?php echo e(route('change-password')); ?>">
                    <input name="_token" type="hidden" value="<?php echo e(csrf_token()); ?>"/>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Current Password:</label>
                                <input id="current-password" type="password" class="form-control" name="current-password">
                            </div>
                            <div class="col-lg-6">
                                <label>New Password:</label>
                                <input id="new-password" type="password" class="form-control" name="new-password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Confirm New Password:</label>
                                <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('third_party_scripts'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/punchly/backend/resources/views/changePassword.blade.php ENDPATH**/ ?>