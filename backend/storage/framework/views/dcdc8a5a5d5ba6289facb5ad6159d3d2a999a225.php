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
						    <h3><span class="in-progress-tag">Awaiting Approval</span></h3>
						<?php elseif($order->status == '2'): ?>
						    <h3><span class="completed-tag">In progress</span></h3>
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
						<label class="order-output-label">File type</label>
						<!-- <h3><?php echo e($order->desired_output == 'for_print' ? 'For print' : 'For embroyer'); ?></h3> -->
              <h3>Embroidery files (DST, EMB)</h3> 
					</div>
					<div class="order-content">
						<label class="order-id-label">Order ID</label>
						<h3><?php echo e($order->order_unique_id); ?></h3>
					</div>
					<!-- <div class="order-content">
						<label class="order-cost-label">Cost</label>
						<h3><?php echo e('$'.$order->amount); ?></h3>
					</div> -->
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
   <!------------- Details Popup------------------->
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
              <span id="updated_date" class="date"> </span> 
               <span id="order_status" class="status completed-status"></span> 
            </div>
          </div>
          <div class="modal-prod-details">
            <div class="modal-prod-img"><img  id="order_image" src=" " /> </div>          
            <div class="modal-prod-text">
              <p><span class="detail-type">File type:</span> <span id="desired_output2" class="type-status"></span></p>
              <p><span class="detail-type">Garment type:</span> <span id="garment_name" class="type-status"></span></p>
              <p><span class="detail-type">Desired height:</span> <span id="desired_height" class="type-status">”</span></p>
              <p><span class="detail-type">Desired width:</span> <span  id="desired_width" class="type-status"></span></p>
              <p id="desired_old_height_label"><span class="detail-type">Desired old height:</span> <span id="desired_old_height" class="type-status">”</span></p>
              <p id="desired_old_width_label"><span class="detail-type">Desired old width:</span> <span  id="desired_old_width" class="type-status"></span></p>
              <p><span class="detail-type">Order ID:</span> <span id="order_unique_id" class="type-status"></span></p>
              <p  id="assign-digitizer">
                <span class="detail-type">Assigned Digitizer:</span>  
                <span id="fullNameDigitizer" class="type-status"></span>
               <a  onclick='reAssignDigitizer();' class="approveCls" id="digitizer-name" href="javascript:void(0)"></a>
                <div style="display: none;" class="reAssignForm ">
                  <form  id="reassing-digitizer-form" onsubmit="return assignDigitizerValidation();" action="<?php echo e(route('digitizer-manager-reassign-digitizer')); ?>" enctype="multipart/form-data" method="post">    <?php echo csrf_field(); ?>           
                                               
                            <input type="hidden" id="approve_or_id"  name="approve_or_id"  value="" />  
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
            <!-- <p  id="rejected-reason"><span class="detail-type">Rejected reason:</span> <span id="rejected-selected-reason" class="type-status"></span></p> -->
             <!--  <p><span class="detail-type">Cost:</span> <span  id="order_amount" class="type-status"></span></p> -->
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
         <p id="order_message"></p>
            <div class="Orignal-image"> 
          <h5>Orignal Image </h5>
          <div class="ftr-modal-box">
          <div class="ftr-dwnld-left">
            <img id="order_image_download" src=" " />
            <h4 id="down_image_name"> <span class="file-size">12 MB</span></h4>
          </div>
          <div  class="ftr-dwnld-btn"> <a id="downloardBtn" href="" class="btn">Download</a></div>
          </div>      
          </div>
           <div class="Submitted-buttons">
            <h5 class="completed_files">Digitized files
                    <div class="order_btns">
                     <a  onclick="approveOrder();"   class="btn completed-tag cancelBtn btnSubmittedHide">Accept</a> 
                     <a  onclick="rejectOrderForm();" class="btn rejected-tag  rejectBtn  btnSubmittedHide">Reject</a>      
                    </div>
            </h5>
          </div>
          <!-------------  Approve  Order  Form --------------->
	         <div style="display: none;" class="approveForm">
	         	<form id="accept-submitted-work"  action="<?php echo e(route('digitizer-manager-accept-submitted-work')); ?>" enctype="multipart/form-data" method="post">
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
             <div style="display: none;" class="rejectOrderForm">
            <form id="reject-submitted-work" onsubmit="return rejectOrderValidation();" action="<?php echo e(route('digitizer-manager-reject-submitted-work')); ?>" enctype="multipart/form-data" method="post">
                  <?php echo csrf_field(); ?> 
                        <h4 class="modal-title user-modal-title">Reject Digitized file(s)</h4> 
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
                                <label>Comments</label>
                                <textarea name="comment"  class="form-control"  rows="6" cols="50" placeholder="EX: Remove the white background"></textarea>
                            </div>
                        </div>                       
                        <input type="submit" value="Reject Submitted work" class="btn btn-success">                    
                 </form>
             </div>
            
            <div class="submitted-work">            
             </div>          
         
            	 
          </div>
          
        </div>

      

      </div>
    </div>
  </div>
<?php endif; ?><?php /**PATH /var/www/punchly/backend/resources/views/digitizer_manager/orderRepresentReworking.blade.php ENDPATH**/ ?>