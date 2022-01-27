<?php $__env->startSection('content'); ?>
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
                        <?php if($order->status == 2 || $order->status == 13): ?>
                          <button act-name="submitted_work" class="btn btn-success btn-sm action_order">Submitted Work</button> 
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
                    <p>
                      <span class="order_index">Order Id:</span>
                      <span class="order_value"><?php echo e($order->order_unique_id); ?></span>
                    </p>
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
                      <span class="badge badge-success order_value">Work Submitted</span>
                      <?php endif; ?>
                       <?php if($order->status == 13): ?>
                      <span class="badge badge-warning order_value">Reworking</span>
                      <?php endif; ?>
                      <?php if($order->status == 11): ?>
                      <span class="badge badge-success order_value">Accept Submitted Work</span>
                      <?php endif; ?>
                    </p>
                    <p>
                      <span class="order_index">Order Name:</span>
                      <span class="order_value"><?php echo e($order->order_name); ?></span>
                    </p>
                    <p>
                      <span class="order_index">Measurement:</span>
                      <?php if($order->measurement == 1): ?>
                        <span class="order_value">Inches</span>
                      <?php endif; ?>
                      <?php if($order->measurement == 2): ?>
                        <span class="order_value">Centimeter</span>
                      <?php endif; ?>
                    </p>
                    <p>
                      <span class="order_index">Garment Type:</span>
                      <span class="order_value"><?php echo e($order->garment->name); ?></span>
                    </p>
                    <p>
                      <span class="order_index">Order Due Date:</span>
                      <span class="order_value"><?php echo e($order->order_date ? date('m-d-Y',strtotime($order->order_date)) : 'NA'); ?></span>
                    </p>
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

                  </h4>
                </div>
                <!-- /.col -->
              </div>
               <div class="row">
                  <?php $__currentLoopData = $orderImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allImages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                    
                 <div class="col-sm-3 invoice-col">              
                   <!-- <strong>Sketch/Wireframe</strong><br> -->   
                    <img class="img-fluid" src="<?php echo e(asset('orders/'.$allImages->order_image)); ?>">
                    <div class="imageformat"> <?php echo e($allImages->order_image); ?></div>
                 <!--   <a href="<?php echo e(route('digitizer-manager-download-image', $allImages->order_image)); ?>">Download Image</a>   -->
                
                </div>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
           </div>
          </div> 
          </div><!-- /.col -->
        </div><!-- /.row -->
         <?php endif; ?>
      </div><!-- /.container-fluid -->
 
      <!-- Modal For Submitted Work-->
      <div class="modal fade" id="submittedWork">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form id="submitted-work-form" action="<?php echo e(route('digitizer-submitted-work')); ?>" enctype="multipart/form-data" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h4 class="modal-title user-modal-title">Submitted Work</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body"> 
                    <div id="loading-bar-spinner" class="spinner" style="display:none;">
                      <div class="spinner-icon"></div>
                    </div> 
                    <input type="hidden" name="o_id"  value="<?php echo e($order->id); ?>">  
                    <input type="hidden" name="order_status"  value="<?php echo e($order->status); ?>">  
                    <div class="form-group row">
                      <div class="col-lg-12 my-error">
                          <div class="input-field">
                              <label class="active">Upload a sketch/wireframe</label>
                              <div class="image-uploader"></div>
                          </div>
                      </div>
                    </div> 
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Submitted Work" class="btn btn-success">
                </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Close Modal For Submitted Work-->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('third_party_scripts'); ?>
<script type="text/javascript">
    
    $.ajaxSetup({   headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  } });
    
    $('.image-uploader').imageUploader({
        imagesInputName: 'order_image',
        preloadedInputName: 'old',
        maxFiles: 10
    });
    
    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    }, 'File size must be less than {0}');
    
    //Cancel Order And Reject Order request
    $('body').on('click','.action_order',function(){
        if($(this).attr('act-name') == "submitted_work"){
          $('#submittedWork').modal('toggle');
        }        
    });

      $('#submitted-work-form').validate({
          submitHandler: function(form,event) {
            $('#loading-bar-spinner').show();
            form.submit();
          },
          rules: {
              "order_image[]": {
                  required: true,
                  extension: "jpg,jpeg,png",
                  filesize: 30*1024*1024,
              },
          },
          messages: {
              "order_image[]": {
                  required: "Please select at least one image",
                  extension: "Please upload the file only have extension:jpg,jpeg,png",
                  filesize: "File size must be less than 30MB",
                  
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
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/punchly/backend/resources/views/digitizer/orderDetail.blade.php ENDPATH**/ ?>