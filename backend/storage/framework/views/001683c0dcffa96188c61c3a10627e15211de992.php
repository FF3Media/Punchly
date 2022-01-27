<?php $__env->startSection('content'); ?>
<style type="text/css">
  .new-digitizer-assign{
    cursor:pointer;
    color:blue;
    text-decoration:underline;
  }
</style>
<div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> Order Detail 
                    
                      <div class="order_btns">
                        <?php if($order->status == 1): ?> 
                          <button act-name="edit-order" class="btn btn-secondary btn-sm action_order">Edit</button>
                          <button act-name="reject_order" class="btn btn-danger btn-sm action_order">Reject</button>
                          <button act-name="approve_order" class="btn btn-success btn-sm action_order">Approve</button>
                          <?php endif; ?>  
                          <a href="<?php echo e(url()->previous()); ?>" class="btn btn-primary btn-sm action_order">Back To Order List</a> 
                      </div>
                    </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-8 invoice-col">
                  <address>
                   	<p><span class="order_index">Order Id:</span><span class="order_value"><?php echo e($order->order_unique_id); ?></span></p>
                          <p><span class="order_index">Width:</span><span class="order_value"><?php echo e($order->desired_width); ?></span></p>
                          <p><span class="order_index">Height:</span><span class="order_value"><?php echo e($order->desired_height); ?></span></p>
                          <p><span class="order_index">Status:</span><?php if($order->status == 1): ?>
                        <span class="badge badge-warning order_value">Waiting for Approval</span>
                        <?php endif; ?>
                        <?php if($order->status == 2): ?>
                        <span class="badge badge-info order_value">In progress</span>
                        <?php endif; ?>
                        <?php if($order->status == 3): ?>
                        <span class="badge badge-danger order_value">Rejected</span>
                        <?php endif; ?>
                        <?php if($order->status == 4): ?>
                        <span class="badge badge-success order_value">Completed</span>
                        <?php endif; ?>
                        <?php if($order->status == 10): ?>
                        <span class="badge badge-success order_value">Work Submitted By Digitizer</span>
                        <?php endif; ?>
                         <?php if($order->status == 13): ?>
                        <span class="badge badge-warning order_value">Reworking</span>
                        <?php endif; ?>
                        <?php if($order->status == 11): ?>
                        <span class="badge badge-success order_value">Accept Submitted Work</span>
                        <?php endif; ?>
                         </p>
                          <p><span class="order_index">Order Name:</span><span class="order_value"><?php echo e($order->order_name); ?></span></p>
                          <p><span class="order_index">Measurement:</span><?php if($order->measurement == 1): ?>
                        <span class="order_value">Inches</span>
                        <?php endif; ?>
                        <?php if($order->measurement == 2): ?>
                        <span class="order_value">Centimeter</span>
                        <?php endif; ?></p>
                        <p><span class="order_index">Garment Type:</span><span class="order_value"><?php echo e($order->garment->name); ?></span></p>
                        <p><span class="order_index">Order By:</span><span class="order_value"><?php echo e($order->user->first_name.' '.$order->user->last_name); ?></span></p>
                        <p><span class="order_index">Assigned Digitizer:</span><span class="order_value">
                          <?php if($order->order_digitizer_id != ''){
                            echo $order->digitizer->first_name.' '.$order->digitizer->last_name; ?>
                            <span class="new-digitizer-assign action_order" act-name="reassign-digitizer">(Reassign Digitizer)</span>
                          <?php }else{
                          echo  'Not assigned';
                        }?></span></p>
                        <p><span class="order_index">Order Due Date:</span><span class="order_value"><?php echo e($order->order_date ? date('m-d-Y',strtotime($order->order_date)) : 'NA'); ?></span></p>
                        <?php if($order->status == 3): ?>
                          <p>
                            <span class="order_index">Reason Rejection To Embroiderer:</span>
                            <span class="order_value"><?php echo e($order->rejection_reason->reason); ?></span>
                          </p>  
                          <p>
                            <span class="order_index">Comment:</span>
                            <span><?php echo e($order->comment); ?></span>                      
                          </p> 
                        <?php endif; ?> 
                        <?php if($order->status == 13): ?>
                          <p>
                            <span class="order_index">Reason Rejection To Digitizer:</span>
                            <span class="order_value"><?php echo e($order->rejection_reason->reason); ?></span>
                          </p>  
                          <p>
                            <span class="order_index">Comment:</span>
                            <span><?php echo e($order->comment); ?></span>                      
                          </p>   
                        <?php endif; ?>                         
                  </address>

                </div>               
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">                  
                   <strong>Sketch/Wireframe</strong><br>
                   <a href="<?php echo e(route('digitizer-manager-download-image', $order->feature_image)); ?>">Download Image</a>
                   <img class="img-fluid" src="<?php echo e(asset('orders/'.$order->feature_image)); ?>">
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
        <?php if($order->status == 10 || $order->status == 13 || $order->status == 11): ?>
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
             <div class="row">
                <div class="col-12">
                  <h4 class="files_digitizer">  Files Submitted By Digitizer 
                    <?php if($order->status == 10): ?>
                      <div class="order_btns">
                          <button act-name="reject_digitizer" class="btn btn-danger btn-sm action_order">Reject Submitted Work</button>
                          <button act-name="accept_digitizer" class="btn btn-success btn-sm action_order">Accept Submitted Work</button>  
                      </div>                    
                    <?php endif; ?>

                  </h4>
                </div>
                <!-- /.col -->
              </div>
               <div class="row">
                  <?php $__currentLoopData = $orderImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allImages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                    
                   <div class="col-sm-3 invoice-col">              
                       <!-- <strong>Sketch/Wireframe</strong><br> -->   
                        <img class="img-fluid" src="<?php echo e(asset('orders/'.$allImages->order_image)); ?>" height="85px" width="100px" />
                        <div class="imageformat"> <?php echo e($allImages->order_image); ?></div>
                       <a href="<?php echo e(route('digitizer-manager-download-image', $allImages->order_image)); ?>">Download Image</a>  
                    
                    </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
           </div>
          </div> 
          </div><!-- /.col -->
        </div><!-- /.row -->
        <?php endif; ?>

      </div><!-- /.container-fluid -->


      <!-- Modal For Re-assing digitizer-->
      <div class="modal fade" id="reassingDigitizer">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form id="reassing-digitizer-form" action="<?php echo e(route('digitizer-manager-reassign-digitizer')); ?>" enctype="multipart/form-data" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h4 class="modal-title user-modal-title">Reassign digitizer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body"> 
                    <div class="loading-bar-spinner" class="spinner" style="display: none;">
                      <div class="spinner-icon"></div>
                    </div> 
                    <input type="hidden" name="approve_or_id"  value="<?php echo e($order->id); ?>">  
                    <div class="form-group row">
                        <div class="col-lg-12 approve-error">
                            <label>Digitizer List</label>
                            <select name="order_digitizer_id" class="form-control">
                              <option value="">Select Digitizer</option>
                                <?php $__empty_1 = true; $__currentLoopData = $digitizerList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $digitizer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <option value="<?php echo e($digitizer->id); ?>"><?php echo e($digitizer->first_name.' '.$digitizer->last_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Reassign Digitizer" class="btn btn-success">
                </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Close Modal For Approve-->
 
      <!-- Modal For Approve-->
      <div class="modal fade" id="approveOrder">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form id="approve-order-form" action="<?php echo e(route('digitizer-manager-approve-order')); ?>" enctype="multipart/form-data" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h4 class="modal-title user-modal-title">Approve order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body"> 
                    <div class="loading-bar-spinner" class="spinner" style="display: none;">
                      <div class="spinner-icon"></div>
                    </div> 
                    <input type="hidden" name="approve_or_id"  value="<?php echo e($order->id); ?>" />  
                    <input type="hidden" name="payment_method"  value="<?php echo e($order->payment_details->st_payment_intent_id); ?>" />  
                    <input type="hidden" name="order_group_id"  value="<?php echo e($order->payment_details->order_group_id); ?>" />  
                    <div class="form-group row">
                        <div class="col-lg-12 approve-error">
                            <label>Assign Digitizer</label>
                            <select name="order_digitizer_id" class="form-control">
                              <option value="">Select Digitizer</option>
                                <?php $__empty_1 = true; $__currentLoopData = $digitizerList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $digitizer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <option value="<?php echo e($digitizer->id); ?>"><?php echo e($digitizer->first_name.' '.$digitizer->last_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Approve Order" class="btn btn-success">
                </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Close Modal For Approve-->

   <!-- Modal For Approve submitted work by digitizer-->
      <div class="modal fade" id="acceptDigitizer">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form id="accept-submitted-work" action="<?php echo e(route('digitizer-manager-accept-submitted-work')); ?>" enctype="multipart/form-data" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h4 class="modal-title user-modal-title">Accept Work Submitted By Digitizer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body"> 
                    <div class="loading-bar-spinner" class="spinner" style="display: none;">
                      <div class="spinner-icon"></div>
                    </div> 
                    <input type="hidden" name="accept_order_id"  value="<?php echo e($order->id); ?>">  
                    <div class="form-group row">
                        <div class="col-lg-12 approve-error">
                            <label>Are You Sure ?</label>
                             
                        </div>
                    </div> 
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Yes Sure" class="btn btn-success">
                </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Close Modal For Approve submitted work by digitizer-->

      <!-- modal for reject order and give reason to embroiderer -->
      <div class="modal fade" id="rejectOrder">
          <div class="modal-dialog">
              <div class="modal-content">
                <form id="reject-order-form" action="<?php echo e(route('digitizer-manager-reject-order')); ?>" enctype="multipart/form-data" method="post">
                  <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h4 class="modal-title user-modal-title">Reject order</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body"> 
                        <div class="loading-bar-spinner" class="spinner" style="display: none;">
                          <div class="spinner-icon"></div>
                        </div> 
                        <input type="hidden" name="reject_or_id"  value="<?php echo e($order->id); ?>"> 
                        <div class="form-group row">
                             <div class="col-lg-12 reject-error">
                                <label>Reason For Rejection</label>
                                <select name="reason_id" class="form-control">
                                  <option value="">Select Reason</option>
                                  <?php $__empty_1 = true; $__currentLoopData = $rejectionReason; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>                    
                                    <option value="<?php echo e($reason->id); ?>"><?php echo e($reason->reason); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                </select> 
                            </div>
                        </div> 
                        <div class="form-group row">
                             <div class="col-lg-12 reject-error">
                                <label>Comment</label>
                                <textarea name="comment"  class="form-control"  rows="6" cols="50" placeholder="Leave a comment here"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Reject Order" class="btn btn-success">
                    </div>
                </form>
              </div>
          </div>
      </div>
      <!-- /.modal -->
      <!-- modal for Reject Submitted By Digitizer and give reason to Digitizer -->
        <div class="modal fade" id="rejectDigitizer">
          <div class="modal-dialog">
              <div class="modal-content">
                <form id="reject-submitted-work" action="<?php echo e(route('digitizer-manager-reject-submitted-work')); ?>" enctype="multipart/form-data" method="post">
                  <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h4 class="modal-title user-modal-title">Reject Submitted By Digitizer</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body"> 
                        <div class="loading-bar-spinner" class="spinner" style="display: none;">
                          <div class="spinner-icon"></div>
                        </div> 
                        <input type="hidden" name="reject_order_id"  value="<?php echo e($order->id); ?>">  
                        <div class="form-group row">
                             <div class="col-lg-12 reject-error">
                                <label>Reason For Rejection</label>
                                <select name="reason_id" class="form-control">
                                  <option value="">Select Reason</option>
                                  <?php $__empty_1 = true; $__currentLoopData = $rejectionReason; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>                    
                                    <option value="<?php echo e($reason->id); ?>"><?php echo e($reason->reason); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                                </select> 
                            </div>
                        </div>
                        <div class="form-group row">
                             <div class="col-lg-12 reject-error">
                                <label>Comment</label>
                                <textarea name="comment"  class="form-control"  rows="6" cols="50" placeholder="Leave a comment here"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Reject Submitted By Digitizer" class="btn btn-success">
                    </div>
                </form>
              </div>
          </div>
      </div>
      <!-- /.modal -->

      <!-- modal for update order-->
      <div class="modal fade" id="updateOrder">
          <div class="modal-dialog">
                  <div class="modal-content">
                    <form id="edit-order" action="<?php echo e(route('digitizer-manager-update-order')); ?>" enctype="multipart/form-data" method="post">
                      <?php echo csrf_field(); ?>
                        <div class="modal-header">
                            <h4 class="modal-title user-modal-title">Upload new image</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body"> 
                            <div class="loading-bar-spinner" class="spinner" style="display: none;">
                              <div class="spinner-icon"></div>
                            </div> 
                            <input type="hidden" name="o_id"  value="<?php echo e($order->id); ?>">  
                            <div class="form-group row">                            
                                <div class="col-lg-6 my-error">
                                    <label>Garment type</label>
                                    <select name="garment_id" class="form-control">
                                      <option value="">Select garment type</option>
                                        <?php $__empty_1 = true; $__currentLoopData = $garmentType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $garment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($garment->id); ?>" <?php echo e($order->garment_id == $garment->id ? 'selected' : ''); ?>><?php echo e($garment->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 my-error">
                                    <label>Measurement</label>
                                    <select id="measurement" name="measurement" class="form-control pri-cal">
                                      <option value="">Select measurement</option>
                                      <?php $__empty_1 = true; $__currentLoopData = $priceCalculator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priceInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value='<?php echo e($priceInfo['id']); ?>' <?php echo e($order->measurement == $priceInfo['id'] ? 'selected' : ''); ?>><?php echo e($priceInfo['measurement'] == 1 ? 'Inches' : 'Centimeter'); ?></option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                      <?php endif; ?>
                                    </select>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <div class="col-lg-6 my-error">
                                    <label>Height</label>
                                    <input type="number" id="desired_height" name="desired_height" value="<?php echo e($order->desired_height); ?>" class="form-control pri-cal"  placeholder="Enter your desired height" readonly />
                                </div>
                                <div class="col-lg-6 my-error">
                                    <label>Width</label>
                                    <input type="number" id="desired_width" name="desired_width" value="<?php echo e($order->desired_width); ?>" class="form-control pri-cal" placeholder="Enter your desired width" readonly />
                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-lg-6">                                    
                                  <label>Manual override</label>
                                    <input type="checkbox" id="manual_override" name="manual_override" value="1" class="icheck-primary d-inline ml-2 form-control" />
                                    
                                </div>
                                <div class="col-lg-6 my-error">
                                    <label>Cost:</label>
                                    <input type="text" id="cost_calculate" name="cost_calculate" value="<?php echo e($order->amount); ?>" class="form-control" readonly="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                 <div class="col-lg-6 my-error">
                                    <label>Leave a note</label>
                                    <textarea name="order_message"  class="form-control"  rows="6" cols="50" placeholder="Leave a note here"><?php echo e($order->order_message); ?></textarea>
                                </div>
                                 <div class="col-lg-6 my-error">
                                    <div class="input-field">
                                        <label class="active">Upload a sketch/wireframe</label>
                                        <div class="image-uploader"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <input type="submit" value="Update Order" class="btn btn-success">
                        </div>
                    </form>
                  </div>
          </div>
      </div>
      <!-- /.modal -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('third_party_scripts'); ?>
<script type="text/javascript">
    $.ajaxSetup({   headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  } });
    $('.image-uploader').imageUploader({
        imagesInputName: 'feature_image',
        preloadedInputName: 'old',
        maxFiles: 1
    });
    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    }, 'File size must be less than {0}');
    //Cancel Order And Reject Order request
    $('body').on('click','.action_order',function(){
        if($(this).attr('act-name') == 'edit-order'){
          $('#desired_height').attr('readonly','true');
          $('#desired_width').attr('readonly','true');
          $('#updateOrder').modal('toggle');
        }else if($(this).attr('act-name') == "reject_order"){
          $('#rejectOrder').modal('toggle');
        }else if($(this).attr('act-name') == "approve_order"){
          $('#approveOrder').modal('toggle');
        }else if($(this).attr('act-name') == "reject_digitizer"){
          $('#rejectDigitizer').modal('toggle');
        }else if($(this).attr('act-name') == "accept_digitizer"){
          $('#acceptDigitizer').modal('toggle');
        }else if($(this).attr('act-name') == "reassign-digitizer"){
          $('#reassingDigitizer').modal('toggle');
        }
               
    });


    $('#reassing-digitizer-form').validate({
        submitHandler: function(form,event) {
          $('.loading-bar-spinner').show();
          event.preventDefault();
          form.submit();
        },
        rules: {
          order_digitizer_id:{
              required: true,
          },
        },        
        messages: {
          order_digitizer_id: {
              required : "Please select digitizer first.",
          },  
        },
        errorElement: 'span',           
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.approve-error').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
    });

    $('#approve-order-form').validate({
        submitHandler: function(form,event) {
          $('.loading-bar-spinner').show();
          event.preventDefault();
          form.submit();
        },
        rules: {
          order_digitizer_id:{
              required: true,
          },
        },        
        messages: {
          order_digitizer_id: {
              required : "Please select digitizer first.",
          },  
        },
        errorElement: 'span',           
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.approve-error').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
    });

    $('#accept-submitted-work').validate({
        submitHandler: function(form,event) {
          $('.loading-bar-spinner').show();
          event.preventDefault();
          form.submit();
        },
        rules: {
          order_digitizer_id:{
              required: true,
          },
        },        
        messages: {
          order_digitizer_id: {
              required : "Please select digitizer first.",
          },  
        },
        errorElement: 'span',           
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.approve-error').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
    });

    $('#reject-order-form').validate({
        submitHandler: function(form,event) {
          $('.loading-bar-spinner').show();
          event.preventDefault();
          form.submit();
        },
        rules: {
            reason_id:{
                required: true,
            },
            comment:{
                required: true,
            },
        },
        errorElement: 'span',           
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.reject-error').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
    });
    $('#reject-submitted-work').validate({
        submitHandler: function(form,event) {
          $('.loading-bar-spinner').show();
          event.preventDefault();
          form.submit();
        },
        rules: {
            reason_id:{
                required: true,
            },
            comment:{
                required: true,
            },
        },
        errorElement: 'span',           
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.reject-error').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
    });


    $('#edit-order').validate({
      submitHandler: function(form,event) {
        $('.loading-bar-spinner').show();
        event.preventDefault();
        form.submit();
      },
      rules: {
          "feature_image[]": {
              required: function(){
                if('<?php echo e($order->feature_image); ?>'){
                  return false;
                }else{
                  return true;
                }
              },                  
              extension: "jpg,jpeg,png",
              filesize: 2*1024*1024,
          },
          measurement: {
              required: true
          },
          desired_height: {
              required: true,
          },
          desired_width:{
              required: true
          },
          garment_id:{
              required: true,
          },
          order_message:{
              required: true,
          },
      },
      messages: {
          "feature_image[]": {
              required: "Please select image",
              extension: "Please upload the file only have extension:jpg,jpeg,png",
              filesize: "File size must be less than 2MB",
          },
          measurement: {
              required: "Please select measurement",
          },  
          desired_height: {                 
              required : "Please enter your desired height",
          },
          desired_width: {
              required : "Please enter your desired width",
          },
          garment_id: {
              required : "Please select garment type",
          },
          order_message:{
              required: "Please enter your desired message"
          },  
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

    $('#manual_override').on('change',function(){
      if($(this).is(':checked')){
        $('#desired_height').removeAttr('readonly');
        $('#desired_width').removeAttr('readonly');
      }else{
        $('#desired_height').attr('readonly','true');
        $('#desired_width').attr('readonly','true');
      }
    })

    $('#approveOrder').on('hidden.bs.modal', function(){
        $(this).find('form').trigger('reset');
        $('#approve-order-form').validate().resetForm();
        $("#approve-order-form").find('.is-invalid').removeClass('is-invalid');
    });
    $('#rejectOrder').on('hidden.bs.modal', function(){
      $('#reject-order-form').validate().resetForm();
      $(this).find('form').trigger('reset');
      $("#reject-order-form").find('.is-invalid').removeClass('is-invalid');
    });
    $('#updateOrder').on('hidden.bs.modal', function(){
        $("#edit-order").validate().resetForm();
        $(this).find('form').trigger('reset');
        $("#edit-order").find('.is-invalid').removeClass('is-invalid');
    });
    $('#rejectDigitizer').on('hidden.bs.modal', function(){
        $("#reject-submitted-work").validate().resetForm();
        $(this).find('form').trigger('reset');
        $("#reject-submitted-work").find('.is-invalid').removeClass('is-invalid');
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/punchly/backend/resources/views/digitizer_manager/orderDetail.blade.php ENDPATH**/ ?>