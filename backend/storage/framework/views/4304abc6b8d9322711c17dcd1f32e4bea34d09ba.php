<?php if(isset($orderList) && count($orderList)): ?>
	<?php $__currentLoopData = $orderList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<div class="item col-xs-4 col-lg-4">
			<div class="thumbnail card">
				<div class="order-content-row">
					<div class="order-content">
						<label class="preview-label">Preview</label>
						<div class="list-preview-image">
						<img src="<?php echo e(asset('orders/'.$order->feature_image)); ?>" />
					</div>
					</div>
					<div class="order-content">
						<label class="order-date-label">Order date</label>
						<h3><?php echo e(date('m-d-Y',strtotime($order->created_at))); ?></h3>
					</div>
					<div class="order-content">
						<label class="order-status-label">Status</label>
						
							<?php if($order->status == '1'): ?>
							<h3><span class="paid-tag">Awaiting Approval</span></h3>
							<?php elseif($order->status == '2'): ?>
							<h3><span class="in-progress-tag">In progress</span></h3>
							<?php elseif($order->status == '3'): ?>
							<h3><span class="rejected-tag">Rejected</span></h3>
							<?php elseif($order->status == '4'): ?>
							<h3><span class="completed-tag">Completed</span></h3>
							<?php elseif($order->status == '9'): ?>
							<h3><span class="rejected-tag">Canceled</span></h3> 
							<?php elseif($order->status == '10'): ?>
							<h3><span class="paid-tag">For Review</span></h3> 
							<?php elseif($order->status == '11'): ?>
							<h3><span class="completed-tag">Completed</span></h3> 
							<?php elseif($order->status == '13'): ?>
							<h3><span class="paid-tag">Reworking</span></h3>
							<?php endif; ?>

					
					</div>
					<div class="order-content">
						<label class="order-output-label">File Type</label>
						<!-- <h3><?php echo e($order->desired_output == 'for_print' ? 'For print' : 'For embroyer'); ?></h3> -->
            <h3>Embroidery files (DST, EMB)</h3> 
					</div>
					<div class="order-content">
						<label class="order-id-label">Order ID</label>
						<h3><?php echo e($order->order_unique_id); ?></h3>
					</div>
					<div class="order-content">
						<label class="order-cost-label">Cost</label>
						<h3><?php echo e('$'.$order->total_amount); ?></h3>
					</div>
					<div class="order-content">
						<label class="order-cost-label"></label>
						<button class="download-btn btn btn-success" onclick="showOrderDetail(<?php echo htmlspecialchars(json_encode($order)); ?>);" >View Details</button>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<div class="pagination_sec w-100 d-flex align-items-center justify-content-center" style="margin-top: 20px;">
        <div>
            <?php echo $orderList->links(); ?>

        </div>
    </div>
    <!---------------------Order Details Popup --------------------------------------->
    <div class="modal fade download-modal" id="download-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="title">
          
      		<h3 id="order_image_name"> </h3>
      		<div class="date-status">
      			<span id="updated_date" class="date"></span> 
      			 <span id="order_status" class="status completed-status"></span> 
             <!-- <a id="edit-order-btn" href="javascript:void(0)" act-name="edit-order" class="completed-tag action_order" data-dismiss="modal" aria-label="Close">Edit</a> -->
      		</div>
      	</div>
      	<div class="modal-prod-details">
      		<div class="modal-prod-img"><img  id="order_image" src="" /> </div>      	
      		<div class="modal-prod-text">
      			<p><span class="detail-type">File Type:</span> <span id="desired_output2" class="type-status"></span></p>
      			<p><span class="detail-type">Garment type:</span> <span id="garment_name" class="type-status"></span></p>
      			<p><span class="detail-type">Desired height:</span> <span id="desired_height" class="type-status">”</span></p>
      			<p><span class="detail-type">Desired width:</span> <span  id="desired_width" class="type-status"></span></p>
      			<p><span class="detail-type">Order ID:</span> <span id="order_unique_id" class="type-status"></span></p>
            <p id="desired_old_height_label"><span class="detail-type">Desired old height:</span> <span id="desired_old_height" class="type-status">”</span></p>
            <p id="desired_old_width_label"><span class="detail-type">Desired old width:</span> <span  id="desired_old_width" class="type-status"></span></p>
            <p  id="assign-digitizer"><span class="detail-type">Assigned Digitizer:</span>  
            <a   onclick='reAssignDigitizer();' id="digitizer-name" class="approveCls" href="javascript:void(0)"></a>
           <div style="display: none;" class="reAssignForm ">
          <form  id="reassing-digitizer-form1" onsubmit="return reassignDigitizerValidation();" action="<?php echo e(route('admin-reassign-digitizer')); ?>" enctype="multipart/form-data" method="post">    <?php echo csrf_field(); ?>           
                                       
                    <input type="hidden" id="approve_or_id2"  name="approve_or_id"  value="" />  
                    <div class="form-group row">
                        <div class="col-lg-12 approve-error">
                            <label>Reassign digitizer</label>
                            <select name="order_digitizer_id" class="form-control">
                              <option value="">Select Digitizer</option>
                                <?php $__empty_1 = true; $__currentLoopData = $digitizerList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $digitizer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <option value="<?php echo e($digitizer->id); ?>"><?php echo e($digitizer->first_name.' '.$digitizer->last_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>  
                   <input type="submit" value="Reassign digitizer" class="btn btn-success">
             
           </form>  
       </div>
            </p>
           <!--  <p  id="rejected-reason"><span class="detail-type">Rejected reason:</span> <span id="rejected-selected-reason" class="type-status"></span></p> -->                      
      			<!-- <p><span class="detail-type">Cost:</span> <span  id="order_amount" class="type-status"></span></p> -->
      		</div>
      	
      	</div>

      </div>
      <div class="modal-footer">
       <h5>Comment</h5>
       <p id="order_message"></p>  
       <div id="rejected-message">         
        <div class="ftr-modal-box repeat-order-box">
        <div class="ftr-dwnld">          
          <h5><span class="reason-heading2">Rejection reason</span> </h5>        
          <p style="margin: 10px 0px"><span id="rejected-selected-reason" class="type-status"></span></p>
        </div>       
      </div> 
       <h5>Rejection Message:</h5>
       <p id="rejected-text"></p>    
       </div>  
	   
	   <div class="Orignal-image"> 
	   	<h5>Orignal Image 
        <span class="orders_buttons float-right"> 
        <a id="approveId" onclick='approveOrder();' class="approveCls cancelBtn btnhide " href="javascript:void(0)">Approve</a>
        <a class="rejectCls btnhide rejectBtn " onclick='rejectOrderForm();' href="#">Reject</a> 
      </span>
      </h5>
      <!-------------  Approve sub Order  Form --------------->
      <div style="display: none;" class="approveForm">
       <form  id="reassing-digitizer-form" onsubmit="return assignDigitizerValidation();" action="<?php echo e(route('admin-approve-order')); ?>" enctype="multipart/form-data" method="post">    <?php echo csrf_field(); ?>           
                   <h4 class="modal-title user-modal-title">Approve order</h4>                    
                    <input type="hidden" id="approve_or_id"  name="approve_or_id"  value="" />  
                    <input type="hidden" id="payment_method2"  name="payment_method"  value="" /> 
                    <div class="form-group row">
                        <div class="col-lg-12 approve-error">
                            <label>Assign Digitizer</label>
                            <select  name="order_digitizer_id" class="form-control">
                              <option value="">Select Digitizer</option>
                                <?php $__empty_1 = true; $__currentLoopData = $digitizerList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $digitizer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <option value="<?php echo e($digitizer->id); ?>"><?php echo e($digitizer->first_name.' '.$digitizer->last_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>  
                   <input type="submit" value="Approve Order" class="btn btn-success">             
       </form>  
       </div>
  <!-------------  Reject  Order  Form --------------->
       <div style="display: none;" class="rejectOrderForm">
           <form id="reject-order-form" onsubmit="return rejectOrderValidation();" action="<?php echo e(route('admin-reject-order')); ?>" enctype="multipart/form-data" method="post">
                  <?php echo csrf_field(); ?>                    
                    <h4 class="modal-title user-modal-title">Reject order</h4>                      
                    <input type="hidden" id="reject_or_id"  name="reject_or_id"  value=""> 
                    <input type="hidden" id="st_payment_intent_id2" name="payment_intent_id" value="">
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
                    <input type="submit" value="Reject Order" class="btn btn-success">                   
            </form>
       </div>

      <div class="ftr-modal-box">
        <div class="ftr-dwnld-left">
          <img id="order_image_download" src=" " />
          <!-- <h4 id="down_image_name"> <span class="file-size">12 MB</span></h4> -->
        </div>
        <div  class="ftr-dwnld-btn"> <a id="downloardBtn" href="" class="btn">Download</a></div>
      </div>
</div>
     <div class="Submitted-buttons">
            <h5 class="completed_files">Digitized files
             <div class="order_btns">
                     <a  onclick="submittedApproveOrder();"   class="btn completed-tag cancelBtn btnSubmittedHide">Accept</a>
                     <a  onclick="submittedrejectOrderForm();" class="btn rejected-tag  rejectBtn  btnSubmittedHide">Reject</a>      
             </div>
            </h5> 
            <!-------------  Approve  Order  Form --------------->
           <div style="display: none;" class="submittedapproveForm">
            <form id="accept-submitted-work"  action="<?php echo e(route('admin-accept-submitted-work')); ?>" enctype="multipart/form-data" method="post">
                 <?php echo csrf_field(); ?> 
                    <!-- <h4 class="modal-title user-modal-title">Accept Work Submitted By Digitizer</h4> -->   
                    <input type="hidden" id="accept_order_id" name="accept_order_id"  value="">  
                    <div class="form-group row">
                        <div class="col-lg-12 approve-error">
                            <label>Are You Sure ?</label>                             
                        </div>
                    </div>  
                    <input type="submit" value="Yes Sure" class="btn btn-success"> 
            </form>

             </div>
            <!-------------  Reject  Order  Form --------------->
             <div style="display: none;" class="submittedrejectOrderForm">
            <form id="reject-submitted-work" onsubmit="return rejectOrderValidation();" action="<?php echo e(route('admin-reject-submitted-work')); ?>" enctype="multipart/form-data" method="post">
                  <?php echo csrf_field(); ?> 
                        <h4 class="modal-title user-modal-title">Reject Digitized files</h4> 
                        <input type="hidden" id="reject_order_id" name="reject_order_id"  value="">  
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
                        <input type="submit" value="Reject Submitted work" class="btn btn-success">                    
                 </form>
             </div> 
          </div> 
            <div class="submitted-work">            
            </div>          
                 
      </div> 
    </div>
  </div>
</div>

 <!-- modal for update order-->
      <div class="modal update-modal fade" id="updateOrder">
          <div class="modal-dialog">
                  <div class="modal-content">
                    <form onsubmit="return validateEditForm(this)" name="edit_order" id="edit-order" action="<?php echo e(route('admin-update-order')); ?>" enctype="multipart/form-data" method="post">
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
                            <input type="hidden" id="o_id" name="o_id"  value="">  
                            <div class="form-group row">                            
                                <div class="col-lg-6 my-error">
                                    <label>Garment type</label>
                                    <select name="garment_id" class="form-control pri-cal minimal-select">
                                      <option value="">Select garment type</option>
                                        <?php $__empty_1 = true; $__currentLoopData = $garmentType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $garment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($garment->id); ?>" <?php echo e($order->garment_id == $garment->id ? 'selected' : ''); ?>><?php echo e($garment->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                    </select>
                                                                     
                                </div>
                                <div class="col-md-6 my-error">
                                    <label>Measurement</label>
                                    <select id="measurement" name="measurement" class="form-control pri-cal minimal-select">
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
                                    <input type="number" id="edit_desired_height" name="desired_height" value="" class="form-control pri-cal"  placeholder="Enter your desired height" readonly />
                                    <span class="my-error"></span>
                                </div>
                                <div class="col-lg-6 my-error">
                                    <label>Width</label>
                                    <input type="number" id="edit_desired_width" name="desired_width" value="" class="form-control pri-cal" placeholder="Enter your desired width" readonly />
                                    
                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-lg-12">                                    
                                  <label>Manual override</label>
                                    <input type="checkbox" id="manual_override" name="manual_override" value="1" class="icheck-primary d-inline ml-2 form-control" />

                                    
                                </div>
                                 <div style="display: none;" class="col-lg-6">
                                    <label>Cost:</label>
                                    <input type="text" id="cost_calculate" name="cost_calculate" value="" class="form-control" readonly="" />
                                    
                                </div> 
                                 <div class="col-lg-12">
                                    <label>Upload a sketch/wireframe</label>
                                    <input type="file" class="form-control" name="feature_image">
                                     
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                 <div class="col-lg-12">
                                    <label>Comments</label>
                                    <textarea name="order_message" id="edit_order_message" class="form-control"  rows="6" cols="50" placeholder="EX: Remove the white background"></textarea>
                                    
                                </div>
                                 <div class="col-lg-12 my-error">
                                  <label>File Type</label>
                                  <select name="desired_output" id="edit_des_output"  class="form-control minimal-select">
                                  <option value="">Select</option>
                                  <option value="for_embroidery_files">Embroidery files (DST, EMB)</option>
                                  </select>
                                </div>
                            </div>
                              
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <input type="submit" value="Update Order" class="downloardButton">
                        </div>
                    </form>
                  </div>
                  
           
          </div>

      </div>
      <!-- /.modal -->
<?php endif; ?><?php /**PATH /var/www/punchly/backend/resources/views/admin/searchOrderRepresent.blade.php ENDPATH**/ ?>