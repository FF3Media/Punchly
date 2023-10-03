@if (isset($orderList) && count($orderList))
	@foreach ($orderList as $order)
		<div class="item col-xs-4 col-lg-4">
			<div class="thumbnail card">
				<div class="order-content-row">
					<div class="order-content">
						<label class="preview-label">Preview</label>
						<div class="list-preview-image">
						<img src="{{ asset('orders/'.$order->feature_image) }}" />
					</div>
					</div>
					<div class="order-content">
						<label class="order-date-label">Order date</label>
						<h3>{{ date('m-d-Y',strtotime($order->created_at)) }}</h3>
					</div>
					<div class="order-content">
						<label class="order-status-label">Status</label>
							@if ($order->status == '2')
							<h3><span class="completed-tag">In progress</span></h3>
							@elseif ($order->status == '3')
							<h3><span class="rejected-tag">Rejected</span></h3>
							@elseif ($order->status == '4')
							<h3><span class="completed-tag">Completed</span></h3>
							@elseif ($order->status == '10')
							<h3><span class="paid-tag">For Review</span></h3>
							@elseif ($order->status == '11')
							<h3><span class="completed-tag">Completed</span></h3>       

							@elseif ($order->status == '13')
							<h3><span class="paid-tag">Reworking</span></h3>
						@endif
					</div>
					<div class="order-content">
						<label class="order-output-label">File Type</label>
						<!-- <h3>{{$order->desired_output == 'for_print' ? 'For print' : 'For embroyer' }}</h3> -->
						 <h3>Embroidery files (DST, EMB)</h3> 
					</div>
					<div class="order-content">
						<label class="order-id-label">Order ID</label>
						<h3>{{$order->order_unique_id}}</h3>
					</div>
					<div class="order-content">
						<label class="order-cost-label">Cost</label>
						<h3>{{'$'.$order->amount}}</h3>
					</div>
					<div class="order-content">
						<label class="order-cost-label"></label>
						<button class="download-btn btn btn-success" onclick="showOrderDetail(<?php echo htmlspecialchars(json_encode($order)); ?>);" >View Details</button>
					</div>
				</div>
			</div>
		</div>
	@endforeach
	<div class="pagination_sec w-100 d-flex align-items-center justify-content-center" style="margin-top: 20px;">
        <div>
            {!! $orderList->links() !!}
        </div>
    </div>
@endif

