   <?php $__env->startSection('content'); ?>
<style type="text/css">
.read-only {
    background-color: '#dedada' !important;
}
</style>
<script src="https://js.stripe.com/v3/"></script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <!--h1 class="col-sm-3">Edit Profile</h1-->
            <div class="error-div col-sm-9"> <?php if(session()->has('password_error')): ?>
                <div class="alert alert-danger cus-msg-cls" style="text-align: left;"> <?php echo e(session()->get('password_error')); ?> </div> <?php endif; ?> <?php if($errors->any()): ?>
                <div class="alert alert-danger cus-msg-cls">
                    <ul> <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </ul>
                </div> <?php endif; ?> </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row pb-4 align-items-start">
            <div class="col-md-4 position-sticky" style="top:152px;">
                <!-- Profile Image -->
                <div class="card card-primary m-0 h-100 custom-shadow">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <?php $userImage = asset('users-image/user.png');
                if (strpos(Auth::user()->avatar, 'http') !== false) {
                    $userImage = Auth::user()->avatar;
                }else{                            
                    if(!empty(Auth::user()->avatar)){
                        $userImage = asset('users-image/'.Auth::user()->avatar);    
                    }                            
                } ?>
                            <img class="profile-user-img img-fluid img-circle"
                     src="<?php   echo $userImage; ?>"
                     alt="User profile picture"> 
                                <!--div class="profile-name"><span><?php //echo substr($userData->first_name,0,1); echo substr($userData->last_name,0,1); ?></span></div-->
                        </div>
                        <h3 class="profile-username text-center"><?php echo e($userData->first_name .' '.$userData->last_name); ?> </h3>
                        <p class="text-center"><?php echo e($userData->email); ?></p>
                        <!-- <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>First Name</b> <p class="float-right mb-0"><a><?php echo e($userData->first_name ? $userData->first_name : 'NA'); ?></a> <a><?php echo e($userData->last_name ? $userData->last_name : 'NA'); ?></a></p>
                </li> -->
                        <!--li class="list-group-item">
                  <b>Last Name</b> <a class="float-right"><?php echo e($userData->last_name ? $userData->last_name : 'NA'); ?></a>
                </li-->
                        <!--  <li class="list-group-item">
                  <b>Mobile No.</b> <a class="float-right"><?php echo e($userData->mobile ? $userData->mobile : 'NA'); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Address</b> <a class="float-right"><?php echo e($userData->address ? $userData->address : 'NA'); ?></a>
                </li>
              </ul> -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-8 pl-md-4">
                <div class="card card-primary card-tabs mb-0 custom-shadow">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="Profileform" id="activity">
                                <!--begin::Form-->
                                <form id="edit-user-profile" class="form" method="post" action="<?php echo e(route('profile-update')); ?>" enctype="multipart/form-data"> <?php echo csrf_field(); ?>
                                    <div class="card-body p-0 account-setting-cls">
                                        <div class="form-group row">
                                            <div class="col-lg-12 form-heading">
                                                <h3>Account settings</h3> </div>
                                            <div class="col-lg-6 my-error">
                                                <label>First Name</label>
                                                <input type="text" name="first_name" value="<?php echo e(isset($userData) ? $userData->first_name : ''); ?>" class="form-control" placeholder="Enter first name" /> </div>
                                            <div class="col-lg-6 my-error">
                                                <label>Last Name</label>
                                                <input type="text" name="last_name" value="<?php echo e(isset($userData) ? $userData->last_name : ''); ?>" class="form-control" placeholder="Enter last name" /> </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12 my-error">
                                                <label>Email</label>
                                                <input type="email" name="email" <?php echo e(isset($userData) ? "readonly" : ""); ?> value="<?php echo e(isset($userData) ? $userData->email : ''); ?>" class="form-control <?php echo e(isset($userData) ? 'read-only' : ''); ?>" placeholder="Enter your email address" /> </div>
                                        </div>

                                        <div class="col-lg-12 my-error">                                       
                                            <label>Profile Image</label>
                                            <div class="custom-file">
                                            <input type="file" class="form-control custom-file-input" id="avatar_image" name="avatar">           
                                            <label class="custom-file-label" for="avatar_image"  ><?php echo e(isset($userData) ? $userData->avatar : ''); ?></label>
                                        </div>                          
                                    
                                      </div>
                                       
                                        
                                        <div class="form-group row"> 
                                                <label>Country</label>
                                                 <?php
                                                $countries = getCounties();
                                               ?>
                                               
                                        <select class="form-control" name="country" id="country">
                                            <option value="">Select Country</option>
                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                                <option  value="<?php echo e($country->id); ?>" <?php echo e(($country->id ==$userData->country)?'selected':''); ?> ><?php echo e($country->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select> 
                                        </div>

                                          <div class="form-group row">
                                               <label for="first-name">State</label>
                                                <select class="form-control" name="state" id="state">
                                                 </select>
                                                 
                                          </div>
 
                                        <div class="form-group row">
                                            <div class="col-lg-12 my-error">
                                                <label>City</label>
                                                <input type="text" id="city" name="city" value="<?php echo e(isset($userData) ? $userData->city : ''); ?>" class="form-control" placeholder="Enter your city" /> </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-lg-12 my-error">
                                                <label>Postcode</label>
                                                <input type="text" name="postcode" value="<?php echo e(isset($userData) ? $userData->postcode : ''); ?>" class="form-control" placeholder="Enter your postcode" /> </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12 my-error">
                                                <label>Address</label>
                                                <input type="text" name="address" value="<?php echo e(isset($userData) ? $userData->address : ''); ?>" class="form-control" placeholder="Enter your address" /> </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12 my-error">
                                                <label>Company Name</label>
                                                <input type="text" id="company_name" name="company_name" value="<?php echo e(isset($userData) ? $userData->company_name : ''); ?>" class="form-control" placeholder="Enter your Company Name" /> </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12 my-error">
                                                <label>Password</label>
                                                <button type="button" class="btn btn-sm btn-primary float-right action-blog-edit-btn chnge-pass-btn" blog-cat-id="" page-name="" act-name="edit-blog-cat" data-toggle="modal" data-target="#add-bog-cat-modal" data-id="0">Change</button>
                                                <input type="password" class="form-control" placeholder="********" /> </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12 my-error">
                                                <label>Mobile</label>
                                                <input type="tel" id="mobile" name="mobile" value="<?php echo e(isset($userData) ? $userData->mobile : ''); ?>" class="form-control" placeholder="Enter your mobile number" /> </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-primary float-right update-btn">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <div class="change-password_section" id="timeline">
                                <!-- /.modal -->
                                <div class="modal fade" id="add-bog-cat-modal">
                                    <div class="modal-dialog common-width-popup">
                                        <form class="form-common-class" class="form-horizontal" id="change-password-form" method="POST" action="<?php echo e(route('change-password')); ?>">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title scout-title">Change password</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input name="_token" type="hidden" value="<?php echo e(csrf_token()); ?>" />
                                                    <div class="card-body">
                                                        <div class="form-group row">
                                                            <div class="col-lg-12 my-error">
                                                                <label>Enter Current Password</label>
                                                                <div class="edit-pw">
                                                                <input id="current_password" type="password" class="form-control" name="current_password"> 
                                                                <span toggle="#current_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                            </div>
                                                            </div>
                                                            <p class="forgot-password">Forgot your password? <a href="<?php echo e(route('password.request')); ?>">No panic!</a></p>
                                                            <div class="col-lg-12 my-error">
                                                                <label>Create a New Password</label>
                                                                <div class="edit-pw">
                                                                <input id="new_password" type="password" class="form-control" name="new_password"> 
                                                                <span toggle="#new_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                            </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- /.card-body -->
                                        </form>
                                    </div>
                                </div>
                                <!-- /.modal -->
                            </div>
                            <!-- /.tab-pane -->
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <?php    if(Auth::user()->user_role == 4) { ?>
                    <!-- Main content -->
                    <div class="card card-primary card-tabs mb-0 custom-shadow mt-4">
                        <div class="card-body">
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <!-- left column -->
                                        <div class="col-md-12"> <?php if(session('success')): ?>
                                            <div class="alert alert-success cus-msg-cls "> <?php echo e(session('success')); ?> </div> <?php elseif(session('failure')): ?>
                                            <div class="alert alert-danger cus-msg-cls"> <?php echo e(session('failure')); ?> </div> <?php endif; ?>
                                            <!-- jquery validation -->
                                            <div class="card card-custom box-shadow-remove">
                                                <div class="card-header">
                                                    <div class="card-title"> <span class="card-icon">
                                                                    <i class="flaticon2-supermarket text-primary"></i>
                                                                </span>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <h3 class="card-label">Payment methods</h3> </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.card-header -->
                                                <!-- <div class="card-body"> -->
                                                <div class="card-body p-0 all-card-body"> 
                                                    <?php $__empty_1 = true; $__currentLoopData = $cardDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cardDetailList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <div class="card-option <?php echo e('check_'.$cardDetailList->card_id); ?>">
                                                        <h4 class="checkCount">Payment Method #<?php echo e($key+1); ?></h4>
                                                        <div class="payment-option-box">
                                                            <div class="card-number"> <img src="<?php echo e(asset('backend-images/master-card-icon.png')); ?>" /> <span class="number">**** <?php echo e($cardDetailList->last4); ?></span> </div>
                                                            <button class="edit-payment-option" card_id="<?php echo e($cardDetailList->card_id); ?>">Remove</button>
                                                        </div>
                                                    </div> 
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <div class="noCard">There is no card</div> 
                                                    <?php endif; ?> </div>
                                                <div class="modal fade" id="edit-payment-method">
                                                    <div class="modal-dialog common-width-popup">
                                                        <form class="form-common-class" class="form-horizontal" id="edit-payment-method-form" method="POST" action="<?php echo e(route('change-password')); ?>">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title scout-title">Edit payment method</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input name="_token" type="hidden" value="<?php echo e(csrf_token()); ?>" />
                                                                    <div class="card-body">
                                                                        <div class="form-group row">
                                                                            <div class="col-lg-12 my-error">
                                                                                <label class="w-100">Type payment method</label>
                                                                                <select class="js-example-programmatic">
                                                                                    <option value="card">Credit or debit card</option>
                                                                                    <option value="paypal">Paypal</option>
                                                                                    <option class="optionGroup" disabled>Parent Tag</option>
                                                                                    <option value="AK">*****4444</option>
                                                                                    <option value="HI">*****3333</option>
                                                                                </select>
                                                                                <ul>
                                                                                    <li></li>
                                                                                    <li></li>
                                                                                    <li></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer justify-content-between">
                                                                    <button type="button" class="btn btn-outline-light btn-secondary">Save</button>
                                                                    <button type="button">Delete payment method</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 p-0 mt-3"> <a href="javascript:void(0)" id="add-card" class="update-btn float-right">Add New</a> </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.container-fluid -->
                                <!----------------- Dummy Modal--> 
                                <!-- /.modal -->
                                <div class="modal fade" id="paymentModals">
                                    <div class="modal-dialog common-width-popup">
                                        <div class="form-common-class">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title user-modal-title">Edit payment method</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="loading-bar-spinner" class="spinner" style="display: none;">
                                                    <div class="spinner-icon"></div>
                                                </div>
                                            <form action="//httpbin.org/post" method="POST" id="castle">
                                                <input type="hidden" name="token" />
                                                <div class="group">
                                                  <label class="common-label-card card-number">
                                                    <span>Card number</span>
                                                    <div id="card-number-element" class="field"></div>
                                                    <span class="brand"><i class="pf pf-credit-card" id="brand-icon"></i></span>
                                                  </label>
                                                  <label class="common-label-card expiry-date">
                                                    <span>Expiry date</span>
                                                    <div id="card-expiry-element" class="field"></div>
                                                  </label>
                                                  <label class="common-label-card cvc-class">
                                                    <span>CVV/CVC</span>
                                                    <div id="card-cvc-element" class="field"></div>
                                                  </label>
                                                  <label style="display: none;">
                                                    <span>Postal code</span>
                                                    <input id="postal-code" name="postal_code" class="field" placeholder="90210" />
                                                  </label>
                                                </div>
                                                <button type="submit" id="add-card-submit">Save</button>
                                                <div class="outcome">
                                                  <div class="error"></div>
                                                  <div class="success" style="display: none;">
                                                    Success! Your Stripe token is <span class="token"></span>
                                                  </div>
                                                </div>
                                              </form>
                                          </div>
                                        </div>
                                         </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <!-- /.content -->
                    <!-- /.tab-pane -->
                    <?php } ?>
                        <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->


    <!-- modal for message -->
    <div class="modal message-popup" id="meesage-pop-up" style=";">
        <div class="modal-dialog common-width-popup">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group row" >
                                <span class="icon-circle"><i class="fas fa-check"></i></span>
                                <h4 class="title" id="dynMessage">You have successfully edited your payment method</h4>
                                <p>Now you can use it to pay for orders</p>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Back to profile</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <!-- /.modal -->

 <!-- modal for error -->
    <div class="modal message-popup error-message" id="error-meesage-pop-up" style="">
        <div class="modal-dialog common-width-popup">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group row">
                                <span class="icon-circle"><i class="fas fa-exclamation"></i></span>
                                <h4 class="title">Oops!<br> Something went wrong</h4>
                                <p>We’ll take you back to checkout so can try again</p>
                                <button type="button" class="btn btn-secondary btn-purple" data-dismiss="modal">Back to profile page</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <!-- /.modal -->


    <!-- modal for delete -->
    <div class="modal message-popup delete-message" id="delete-pop-up" style="">
        <div class="modal-dialog common-width-popup">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group row" >
                                <span class="icon-circle"><i class="far fa-trash-alt"></i></span>
                                <h4 class="title" id="dynMessageEr">Delete Message Goes Here</h4>
                                <p>We’ll take you back to checkout so can try again</p>
                                <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal">Back to profile page</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <!-- /.modal -->

</div> <?php $__env->stopSection(); ?>  <?php $__env->startSection('third_party_scripts'); ?>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-XSRF-TOKEN': decodeURIComponent(/XSRF-Token=([^;]*)/ig.exec(document.cookie)[1])
        }
    });
    $(document).ready(function() {
        var old_user_img = `<?php echo e($userData->avatar); ?>`;
        var userId = `<?php echo e($userData->id); ?>`;
        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, 'File size must be less than {0}');
        $.validator.addMethod("notEqual", function(value, element, param) {
            return this.optional(element) || value != $(param).val();
        }, "Please specify a different value");
        $('#edit-user-profile').validate({
            submitHandler: function(form) {
                // do other things for a valid form
                form.submit();
            },
            rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                address: {
                    required: true
                },
                mobile: {
                   // required: true,
                    digits: true, 
                    remote: {
                        url: `<?php echo e(route('check-mobile-exist')); ?>`,
                        data: {
                            'checkAction': 'profile-edit',
                            id: function() {
                                return userId;
                            }
                        },
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                },
                avatar: {
                    required: function() {
                        if(old_user_img != '') {
                            return false;
                        } else {
                            return true;
                        }
                    },
                    extension: "jpg,jpeg,png",
                    filesize: 2 * 1024 * 1024,
                },
            },
            messages: {
                first_name: {
                    required: "Please enter your first name",
                },
                last_name: {
                    required: "Please enter your last name",
                },
                address: {
                    required: "Please enter your address",
                },
                email: {
                    required: "Please enter your email address",
                },
                mobile: {
                  //  required: "Please enter your mobile number",
                    remote: "This mobile number already exist"
                },
                avatar: {
                    required: "Please select the image",
                    extension: "Please select jpg,jpeg and png image",
                    filesize: "File size must be less than 2MB",
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.my-error').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
        $('#change-password-form').validate({
            submitHandler: function(form) {
                // do other things for a valid form
                form.submit();
            },
            rules: {
                current_password: {
                    required: true,
                    minlength: 8,
                    maxlength: 16,
                },
                new_password: {
                    required: true,
                    notEqual: "#current_password",
                    minlength: 8,
                    maxlength: 16,
                },
            },
            messages: {
                current_password: {
                    required: "Please enter your current password",
                },
                new_password: {
                    required: "Please enter your new password",
                    notEqual: "Please choose a different password other than current"
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.my-error').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
    $('body').on('click', '.default-card', function() {
        var card_id = $(this).attr('card_id');
        if(card_id != '') {
            swal({
                title: "Are you sure?",
                text: "You want to set this card default for your account.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28b351",
                confirmButtonText: "Yes!",
                closeOnConfirm: false,
            }, function(isConfirm) {
                if(!isConfirm) return;
                $.ajax({
                    url: `<?php echo e(route('embroiderer-set-default-card')); ?>`,
                    type: "POST",
                    data: {
                        card_id: card_id
                    },
                    dataType: "Json",
                    success: function(data) {
                        toastr.options.timeOut = 3000;
                        if(data.isSucceeded) {
                            swal.close();
                            toastr.success(data.message);
                            table.ajax.reload();
                        } else {
                            $('#error-meesage-pop-up').modal('toggle');
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal.close();
                        $('#error-meesage-pop-up').modal('toggle');
                    }
                });
            });
        }
    });
    /**********************Capital First Letter**********/
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    /**********************Start Stripe Working**********/

    $('body').on('click', '.edit-payment-option', function() {
        var card_id = $(this).attr('card_id');
        if(card_id != '') {
            swal({
                title: "Are you sure?",
                text: "You want to delete this card.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28b351",
                confirmButtonText: "Yes!",
                closeOnConfirm: false,
            }, function(isConfirm) {
                if(!isConfirm) return;
                $.ajax({
                    url: `<?php echo e(route('embroiderer-delete-card')); ?>`,
                    type: "POST",
                    data: { card_id: card_id  },
                    dataType: "Json",
                    success: function(data) {
                        swal.close();
                        if(data.isSucceeded) {                            
                            $('#delete-pop-up').modal('toggle');
                            $('#dynMessageEr').html(data.message);
                            $('.check_'+card_id).remove();
                            var fields = $('.checkCount');
                            var count = 1;
                            $.each(fields, function() {
                                $(this).html('Payment Method #'+count);
                                count++;
                            });
                        } else {
                            $('#error-meesage-pop-up').modal('toggle');
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal.close();
                        $('#error-meesage-pop-up').modal('toggle');
                    }
                });
            });
        }
    });

    function escapeHtml(text) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.toString().replace(/[&<>"']/g, function(m) {
            return map[m];
        });
    }

    //Add Payment Method
    $('#add-card').click(function(){
        $('#paymentModals').modal('toggle');
    });


    var stripe = Stripe('pk_test_51GvculJtMGvAFFxtLw6Gd6YfbBp84V0uskWhEVuVtFi35hcqq9hTjYhtZFdSrCYzUZEaY9uynFvDPZ6Xl9s46qrn00S3BlzwnU');
    var elements = stripe.elements();

    var style = {
      base: {
        iconColor: '#666EE8',
        color: '#31325F',
        lineHeight: '40px',
        fontWeight: 300,
        fontFamily: 'Helvetica Neue',
        fontSize: '15px',

        '::placeholder': {
          color: '#CFD7E0',
        },
      },
    };

    var cardNumberElement = elements.create('cardNumber', {
      style: style
    });
    cardNumberElement.mount('#card-number-element');

    var cardExpiryElement = elements.create('cardExpiry', {
      style: style
    });
    cardExpiryElement.mount('#card-expiry-element');

    var cardCvcElement = elements.create('cardCvc', {
      style: style
    });
    cardCvcElement.mount('#card-cvc-element');


    function setOutcome(result) {
      var successElement = document.querySelector('.success');
      var errorElement = document.querySelector('.error');
      successElement.classList.remove('visible');
      errorElement.classList.remove('visible');

      if (result.token) {
        $('.spinner').show();
        $('#add-card-submit').prop('disabled', true);
        $.ajax({
            url: '<?php echo e(route("embroiderer-add-card")); ?>',
            type: 'POST',
            data: { token: result.token  },
            success: function(response) {
                setTimeout(function() {
                    $('.spinner').hide();
                    $('#paymentModals').modal('toggle');
                    $('#add-card-submit').prop('disabled', false);
                    if(response.isSucceeded) {
                        $('#meesage-pop-up').modal('toggle');
                        $('#dynMessage').html(response.message);
                        $('.all-card-body').append(response.htmlpass);
                    } else {
                        $('#error-meesage-pop-up').modal('toggle');
                    }
                }, 2000);
            }
        });
      } else if (result.error) {
        errorElement.textContent = result.error.message;
        errorElement.classList.add('visible');
      }
    }

    var cardBrandToPfClass = {
      'visa': 'pf-visa',
      'mastercard': 'pf-mastercard',
      'amex': 'pf-american-express',
      'discover': 'pf-discover',
      'diners': 'pf-diners',
      'jcb': 'pf-jcb',
      'unknown': 'pf-credit-card',
    }

    function setBrandIcon(brand) {
        var brandIconElement = document.getElementById('brand-icon');
      var pfClass = 'pf-credit-card';
      if (brand in cardBrandToPfClass) {
        pfClass = cardBrandToPfClass[brand];
      }
      for (var i = brandIconElement.classList.length - 1; i >= 0; i--) {
        brandIconElement.classList.remove(brandIconElement.classList[i]);
      }
      brandIconElement.classList.add('pf');
      brandIconElement.classList.add(pfClass);
    }

    cardNumberElement.on('change', function(event) {
        // Switch brand logo
        if (event.brand) {
        setBrandIcon(event.brand);
      }

        setOutcome(event);
    });

    document.querySelector('#castle').addEventListener('submit', function(e) {
      e.preventDefault();
      var options = {
        address_zip: document.getElementById('postal-code').value,
      };
      stripe.createToken(cardNumberElement, options).then(setOutcome);
    });
    
    $('.modal').on('hidden.bs.modal', function() {
        $('#st-err').html('');
        cardNumberElement.clear();
        cardExpiryElement.clear();
        cardCvcElement.clear();
        $('.error').html('');
        $('.success').html('');
    });

    </script>

<script type="text/javascript">
    
    $(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
 $(document).ready(function () {
    stateget(<?php echo e($userData->country); ?>);
$('#country').change(function(){
     
        var cid = $(this).val();
        stateget(cid);   
    });
  });
 function stateget(cid) {
    var state=<?php echo e($userData->state); ?>;
     if(cid){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
           type:"get",
           url:"<?php echo e(url('/getStates')); ?>"+"/"+cid,  
           success:function(res)
           {       
                if(res)
                {
                    $("#state").empty();
                    $("#city").empty();
                    $("#state").append('<option>Select State</option>');
                    $.each(res,function(key,value){
                        var sel='';
                        if(key==state){
                            sel='selected';
                        }
                        $("#state").append('<option '+sel+' value="'+key+'">'+value+'</option>');
                    });
                }
           }

        });
        }
 }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/punchly/backend/resources/views/edit-profile.blade.php ENDPATH**/ ?>