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
						
					  	@if ($order->status == '1')
						    <h3><span class="paid-tag">Awaiting Approval</span></h3>
					   	@elseif ($order->status == '3')
						    <h3><span class="rejected-tag">Rejected</span>
                  <span>
                  <a id="reorderclick<?php echo $order->id; ?>" id="" onclick="reloadOrderDetail(<?php echo htmlspecialchars(json_encode($order)); ?>);"  href="javascript:void(0)">
                    <i class="fas fa-redo"></i>
                  </a>
                </span></h3>
					    @elseif ($order->status == '4')
					    	<h3><span class="completed-tag">Completed</span></h3>              
					    @elseif ($order->status == '6')
					    	<h3><span class="rejected-tag">Canceled</span></h3>
              @elseif ($order->status == '9')
                <h3><span class="rejected-tag">Canceled</span></h3>
					    @else
					    	<h3><span class="in-progress-tag">In progress</span></h3>
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
            <label class="order-cost-label">Paid</label>
            <h3>{{'$'.$order->total_amount}}</h3>
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
             <span id="invoicedPdf">
                <a href="javascript:void(0)"   onclick="invoiceDownlorad(this);" id="invoiceDownlordPdf" data-orderid="" class="btn">
                   Invoice
                   <i class="fa fa-download" aria-hidden="true"></i>
                </a>
             </span>
             <a href="#" onclick="cancelOrderForm();" id="cancel_btn" class="btn cancelBtn float-right">Cancel</a>
      		</div>
          <!-------------  Reject  Order  Form --------------->
             <div   class="cancelForm">
            <form id="cancel-submitted-work"  action="{{route('embroiderer-cancel-order')}}" enctype="multipart/form-data" method="post">
                  @csrf 
                  <input type="hidden" id="cancel_order_id" name="cancel_order_id"  value="">  
                  <input type="hidden" id="st_payment_intent_id" name="payment_intent_id"  value="">  
                  <input type="hidden" id="order_amount_cancel" name="order_amount"  value="">  
                    <div class="float-right">                         
                            <label>Are You Sure ?</label>   
                            <input type="submit" value="Yes Sure" class="btn  cancelBtn">                           
                        
                    </div>  
                                       
                 </form>
             </div>
      	</div>
      	<div class="modal-prod-details">
      		<div class="modal-prod-img"><img  id="order_image" src="" /> </div>
      	
      		<div class="modal-prod-text">
      			<p><span class="detail-type">File type:</span> <span id="desired_output2" class="type-status"></span></p>
      			<p><span class="detail-type">Garment type:</span> <span id="garment_name" class="type-status"></span></p>
      			<p><span class="detail-type">Desired height:</span> <span id="desired_height_detail" class="type-status">”</span></p>
      			<p><span class="detail-type">Desired width:</span> <span  id="desired_width_detail" class="type-status"></span></p>
            <p id="desired_old_height_label"><span class="detail-type">Desired old height:</span> <span id="desired_old_height" class="type-status">”</span></p>
            <p id="desired_old_width_label"><span class="detail-type">Desired old width:</span> <span  id="desired_old_width" class="type-status"></span></p>
      			<p><span class="detail-type">Order ID:</span> <span id="order_unique_id" class="type-status"></span></p>
            <p><span class="detail-type">Cost:</span> <span  id="order_amount" class="type-status"></span></p>  
      			<!-- <p  id="rejected-reason"><span class="detail-type">Rejected reason:</span> <span id="rejected-selected-reason" class="type-status"></span></p> -->
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

        <div class="ftr-dwnld-btn">
          <a id="reorderclickBtn"   onclick='reOrderclicked();'   class="btn btn-purple reorderclickBtn">Repeat order <i class="fas fa-redo-alt"></i>

        </a>
        <input type="hidden" value="" id="reOrderOpenPopup" name="">
      </div>
      </div>


       <h5>Rejection Message:</h5>
       <p id="rejected-text"></p>    
       </div>	   
	   <div class="Orignal-image"> 
	   	<h5>Orignal Image  
	   	</h5>       
	   <div class="ftr-modal-box">
      	<div class="ftr-dwnld-left">
      		<img id="order_image_download" src=" " />
      		<!-- <h4 id="down_image_name"> <span class="file-size">12 MB</span></h4> -->
      	</div>
      	<div  class="ftr-dwnld-btn"> <a id="downloardBtn" href="" class="btn">Download</a></div>
      </div> 
      	 <div class="submitted-work">
           	
           </div>    
      </div>
      </div> 
    </div>
  </div>
</div>

@endif