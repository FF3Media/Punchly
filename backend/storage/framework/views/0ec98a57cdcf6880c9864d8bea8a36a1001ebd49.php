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
                             <a style="float: right;" href="<?php echo e(url()->previous()); ?>" class="btn btn-default">Back</a>
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
                            <p>
                                <span class="order_index">Width:</span>
                                <span class="order_value"><?php echo e($order->desired_width); ?></span>
                            </p>
                            <p>
                                <span class="order_index">Height:</span>
                                <span class="order_value"><?php echo e($order->desired_height); ?></span>
                            </p>
                            <p>
                                <span class="order_index">Status:</span>
                                <?php if($order->status == 1): ?>
                                    <span class="badge badge-warning order_value">Waiting for Approval</span>
                                <?php elseif($order->status == 2): ?>
                                    <span class="badge badge-info order_value">In progress</span>
                                <?php elseif($order->status == 3): ?>
                                    <span class="badge badge-warning order_value">Rejected</span>
                                <?php elseif($order->status == 4 || $order->status == 11): ?>
                                    <span class="badge badge-success order_value">Completed</span>
                                <?php elseif($order->status == 10): ?>
                                    <span class="badge badge-info order_value">In progress</span>                              
                                <?php elseif($order->status == 12): ?>
                                    <span class="badge badge-info order_value">In progress</span>
                                <?php elseif($order->status == 13): ?>
                                    <span class="badge badge-info order_value">In progress</span>
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
                                <?php elseif($order->measurement == 2): ?>
                                    <span class="order_value">Centimeter</span>
                                <?php endif; ?></p>
                            <p>
                                <span class="order_index">Garment Type:</span>
                                <span class="order_value"><?php echo e($order->garment->name); ?></span>
                            </p>
                            <p>
                                <span class="order_index">Order By:</span>
                                <span class="order_value"><?php echo e($order->user->first_name.' '.$order->user->last_name); ?></span>
                            </p>
                            <p>
                                <span class="order_index">Order Due Date:</span>
                                <span class="order_value"><?php echo e($order->order_date ? date('m-d-Y',strtotime($order->order_date)) : 'NA'); ?></span>
                            </p>
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
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">                  
                        <strong>Sketch/Wireframe</strong><br>
                        <a href="<?php echo e(route('embroiderer-download-image', $order->feature_image)); ?>">Download Image</a>
                        <img class="img-fluid" src="<?php echo e(asset('orders/'.$order->feature_image)); ?>">
                    </div>
                </div>

                <hr class="mt-5 mb-5">
                <!-- payment method start here -->
                 <?php if($order->status == 11): ?>
                        <div class="row">
                          <div class="col-12">
                            <!-- Main content -->
                            <div class="invoice p-3 mb-3">
                             <div class="row">
                                <div class="col-12">
                                  <h4 class="files_digitizer">  Digitised Files  </h4>
                                </div>
                                <!-- /.col -->
                              </div>
                               <div class="row">
                                  <?php $__currentLoopData = $orderImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allImages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                    
                                   <div class="col-sm-3 invoice-col">              
                                       <!-- <strong>Sketch/Wireframe</strong><br> -->   
                                        <img class="img-fluid" src="<?php echo e(asset('orders/'.$allImages->order_image)); ?>" height="85px" width="100px" />
                                        <div class="imageformat"> <?php echo e($allImages->order_image); ?></div>
                                       <a href="<?php echo e(route('admin-download-image', $allImages->order_image)); ?>">Download Image</a>  
                                    
                                    </div>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                           </div>
                          </div> 
                          </div><!-- /.col -->
                        </div><!-- /.row -->
                          <hr class="mt-5 mb-5">
               <?php endif; ?>


                <div class="row payment-methods">
                    <!-- accepted payments column -->
                    <div class="col-6">
                        <p class="lead">Payment Methods</p>
                        <img src="../../public/card-images/visa.png" alt="Visa">
                        <img src="../../public/card-images/mastercard.png" alt="Mastercard">
                        <img src="../../public/card-images/american-express.png" alt="American Express">
                        <img src="../../public/card-images/paypal2.png" alt="Paypal">
                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                            plugg
                            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                        </p>
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        <p class="lead">Amount Due 2/22/2014</p>
                        <div class="table-responsive">
                            <table class="table ">
                                <tbody>
                                    <tr>
                                        <!--th style="width:50%">Subtotal:</th>
                                            <td>$250.30</td>
                                            </tr>
                                            <tr>
                                            <th>Tax (9.3%)</th>
                                            <td>$10.34</td>
                                            </tr-->
                                    <tr>
                                        <th>Total:</th>
                                        <td>$265.24</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default float-right"><i class="fas fa-print"></i> Print</a>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- payment method ends here -->
            </div>
            <!-- /.invoice -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
   

</div>
<!-- /.container-fluid -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('third_party_scripts'); ?>
<script type="text/javascript">
    $.ajaxSetup({   headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  } });
    $('.image-uploader').imageUploader({
        imagesInputName: 'feature_image',
        preloadedInputName: 'old',
        maxFiles: 1
    });   
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/punchly/backend/resources/views/embroiderer/orderDetail.blade.php ENDPATH**/ ?>