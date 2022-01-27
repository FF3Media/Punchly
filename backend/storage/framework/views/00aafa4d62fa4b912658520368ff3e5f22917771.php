<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary" style="margin: 6px !important">
                <?php if(session()->has('success')): ?>
                <div class="alert alert-success cus-msg-cls" style="text-align: left;">
                    <?php echo e(session()->get('success')); ?>

                </div>
                <?php elseif(session()->has('failure')): ?>
                <div class="alert alert-danger cus-msg-cls" style="text-align: left;">
                    <?php echo e(session()->get('failure')); ?>

                </div>
                <?php endif; ?>
                <div class="card-header">
                    <h3 class="card-title">Add User</h3>
                </div>
                <!--begin::Form-->
                <form id="edit-user-profile" class="form" method="post" action="<?php echo e(route('admin-add-user')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-6 my-error">
                                <label>First Name:</label>
                                <input type="text" name="first_name" value="" class="form-control" placeholder="Enter first name" />
                            </div>
                            <div class="col-lg-6 my-error">
                                <label>Last Name:</label>
                                <input type="text" name="last_name" value="" class="form-control" placeholder="Enter last name" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 my-error">
                                <label>Email:</label>
                                <input type="email" name="email" value="" class="form-control" placeholder="Enter your email address" />
                            </div>
                            <div class="col-lg-6 my-error">
                                <label>User Role:</label>
                                <select class="form-control" name="user_role">
                                  <option value="">Select User Role</option>
                                  <option value="1">Super Admin</option>
                                  <option value="2">Digitizer Manager</option>
                                  <option value="3">Digitizer</option>
                                  <option value="4">Embroiderer</option>
                                </select>
                            </div>                            
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 my-error">
                                <label>Mobile:</label>
                                <input type="tel" id="mobile" name="mobile" value="" class="form-control" placeholder="Enter your mobile number" />
                            </div>
                            <div class="col-lg-6 my-error">
                                <label>Image:</label>
                                <input type="file" name="avatar" value="" class="form-control" placeholder="Browse Image" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 my-error">
                                <label>Address:</label>
                                <input type="text" name="address" value="" class="form-control" placeholder="Enter your address" />
                            </div>
                          <div class="col-lg-6 my-error">
                             <label>Password:</label>
                             <input type="password" name="password" id="password" autocomplete="off" class="form-control" placeholder="" />
                          </div>
                        </div>
                        <div class="form-group row">
                           
                          <div class="col-lg-6 my-error">
                             <label>Confirm Password:</label>
                             <input type="password" name="confirm_password"  class="form-control" placeholder="" />
                          </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <input type="submit" class="btn btn-primary mr-2" value="Save" />
                                <a href="<?php echo e(route('admin-users-list')); ?>" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>                        
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('third_party_scripts'); ?>
<script type="text/javascript">
   // $.ajaxSetup({headers: {'X-XSRF-TOKEN': decodeURIComponent(/XSRF-Token=([^;]*)/ig.exec(document.cookie)[1])}}); 
    $(document).ready(function () {
    $.ajaxSetup({headers: {'X-XSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')}});
        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, 'File size must be less than {0}');
        $('#edit-user-profile').validate({
            submitHandler: function(form) {
              // do other things for a valid form
              form.submit();
            },
            rules: {
                user_role:{
                    required: true,
                },
                first_name: {
                    required: true
                },
                last_name: {
                    required: true,
                },
                email:{
                    required: true,
                },
                address:{
                    required: true
                },
                password:{
                    required: true,
                     
                },
                confirm_password:{
                    required: true,
                    equalTo: '#password'
                },
                mobile:{
                    required: true,
                    digits: true,
                   // minlength: 10,
                   // maxlength: 10,
                    remote: {
                        url: `<?php echo e(route('check-mobile-exist')); ?>`,
                        data: {
                            'checkAction':'register',
                            "_token": "<?php echo e(csrf_token()); ?>"
                        },
                        type: "post",
                    },
                },
                avatar:{
                   // required: true,
                    extension: "jpg,jpeg,png",
                    filesize: 2*1024*1024,
                }
            },
            messages: {
                user_role: {
                    required : "Please select user role",
                },
                first_name: {
                    required: "Please enter your first name",
                },  
                last_name: {                 
                    required : "Please enter your last name",
                },
                address: {
                    required : "Please enter your address",
                },
                email: {
                    required : "Please enter your email address",
                },
                confirm_password: {
                    required : "Please enter your confirm password",
                    equalTo: "password confirmmation does not macth"
                },
                password: {
                    required : "Please enter the password",
                },
                mobile: {
                    required : "Please enter your mobile number",
                    remote: "This mobile number already exist"
                },
                avatar:{
                    required: "Please select the image",
                    extension: "Please select jpg,jpeg and png image",
                    filesize: "File size must be less than 2MB",
                }
            },
            errorElement: 'span',           
            errorPlacement: function (error, element) {
              error.addClass('invalid-feedback');
              element.closest('.my-error').append(error);
            },
            highlight: function (element, errorClass, validClass) {
              $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
              $(element).removeClass('is-invalid');
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/punchly/backend/resources/views/admin/addNewUser.blade.php ENDPATH**/ ?>