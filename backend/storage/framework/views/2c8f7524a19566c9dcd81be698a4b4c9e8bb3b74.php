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
					<?php if($order->status == '2'): ?>
					<h3><span class="in-progress-tag">In progress</span></h3>
					<?php elseif($order->status == '3'): ?>
					<h3><span class="rejected-tag">Rejected</span></h3>
					<?php elseif($order->status == '4'): ?>
					<h3><span class="completed-tag">Completed</span></h3>
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

 
<?php endif; ?><?php /**PATH /var/www/punchly/backend/resources/views/digitizer/orderRepresent.blade.php ENDPATH**/ ?>