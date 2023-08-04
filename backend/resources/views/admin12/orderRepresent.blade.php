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
                <h3><span class="paid-tag">Waiting for Approval</span></h3>
            @elseif ($order->status == '2')
                <h3><span class="in-progress-tag">In progress</span></h3>
            @elseif ($order->status == '3')
                <h3><span class="rejected-tag">Rejected</span></h3>
            @elseif ($order->status == '4')
                <h3><span class="completed-tag">Completed</span></h3>
            @elseif ($order->status == '9')
                <h3><span class="rejected-tag">Canceled</span></h3> 
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
             <a id="edit-order-btn" href="javascript:void(0)" act-name="edit-order" class="completed-tag cancelBtn action_order float-right" data-dismiss="modal" aria-label="Close">Edit</a>
      		</div>
      	</div>

      	<div class="modal-prod-details">
      		<div class="modal-prod-img"><img  id="order_image" src="" /> </div>
      	
      		<div class="modal-prod-text">
      			<p><span class="detail-type">File type:</span> <span id="desired_output2" class="type-status"></span></p>
      			<p><span class="detail-type">Garment type:</span> <span id="garment_name" class="type-status"></span></p>
      			<p><span class="detail-type">Desired height:</span> <span id="desired_height" class="type-status">”</span></p>
      			<p><span class="detail-type">Desired width:</span> <span  id="desired_width" class="type-status"></span></p>
            <p id="desired_old_height_label"><span class="detail-type">Desired old height:</span> <span id="desired_old_height" class="type-status">”</span></p>
            <p id="desired_old_width_label"><span class="detail-type">Desired old width:</span> <span  id="desired_old_width" class="type-status"></span></p>
      			<p><span class="detail-type">Order ID:</span> <span id="order_unique_id" class="type-status"></span></p>
            <p  id="assign-digitizer"><span class="detail-type">Assigned Digitizer:</span>  
        <a   onclick='reAssignDigitizer();' id="digitizer-name" class="approveCls" href="javascript:void(0)"></a>
        <div style="display: none;" class="reAssignForm ">
          <form  id="reassing-digitizer-form" onsubmit="return reAssignDigitizerValidation();" action="{{ route('admin-reassign-digitizer')}}" enctype="multipart/form-data" method="post">    @csrf           
                                       
                    <input type="hidden" id="approve_or_id"  name="approve_or_id"  value="" />  
                    <div class="form-group row">
                        <div class="col-lg-12 approve-error">
                            <label>Reassign digitizer</label>
                            <select id="order_assign_digitizer" name="order_digitizer_id" class="form-control">
                              <option value="">Select Digitizer</option>
                                @forelse ($digitizerList as $digitizer)
                                    <option value="{{ $digitizer->id }}">{{ $digitizer->first_name.' '.$digitizer->last_name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>  
                   <input type="submit" value="Reassign digitizer" class="btn btn-success">
             
           </form>  
       </div>

            </p>
            <p  id="rejected-reason"><span class="detail-type">Rejected reason:</span> <span id="rejected-selected-reason" class="type-status"></span></p>
                      
      			 <p><span class="detail-type">Cost:</span> <span  id="order_amount" class="type-status"></span></p>  
      		</div>
      	
      	</div>

      </div>
      <div class="modal-footer">
       <h5>Comment</h5>
       <p id="order_message"></p>  
       <div id="rejected-message">
       <h5>Rejected Message:</h5>
       <p id="rejected-text"></p>    
       </div>  
	   
	   <div class="Orignal-image"> 
	   	<h5>Orignal Image 
        <span class="orders_buttons float-right"> 
        <a id="approveId" onclick='approveOrder();' class="approveCls cancelBtn btnhide " href="javascript:void(0)">Approve</a>
        <a class="rejectCls btnhide rejectBtn" onclick='rejectOrderForm();' href="#">Reject</a> 
      </span>
	   	</h5>

	   	<!-------------  Approve  Order  Form --------------->
	   	<div style="display: none;" class="approveForm">
	   	 <form  id="reassing-digitizer-form2" onsubmit="return assignDigitizerValidation();" action="{{ route('admin-approve-order')}}" enctype="multipart/form-data" method="post">    @csrf           
                   <h4 class="modal-title user-modal-title">Approve order</h4>                    
                    <input type="hidden" id="approve_or_id2"  name="approve_or_id"  value="" />  
                    <input type="hidden" id="payment_method"  name="payment_method"  value="" /> 
                    <input type="hidden" id="pay_authorization_id"  name="pay_authorization_id"  value="" />  
                    <input type="hidden" id="pay_order_amount"  name="order_amount"  value="" />  
                    <div class="form-group row">
                        <div class="col-lg-12 approve-error">
                            <label>Assign Digitizer</label>
                            <select id="assign-order-digitizer" name="order_digitizer_id" class="form-control">
                              <option value="">Select Digitizer</option>
                                @forelse ($digitizerList as $digitizer)
                                    <option value="{{ $digitizer->id }}">{{ $digitizer->first_name.' '.$digitizer->last_name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>  
                   <input type="submit" value="Approve Order" class="btn btn-success">
             
       </form>  
       </div>
	<!-------------  Reject  Order  Form --------------->
       <div style="display: none;" class="rejectOrderForm">
           <form id="reject-order-form" onsubmit="return rejectOrderValidation();" action="{{ route('admin-reject-order')}}" enctype="multipart/form-data" method="post">
                  @csrf                    
                    <h4 class="modal-title user-modal-title">Reject order</h4>                      
                    <input type="hidden" id="reject_or_id"  name="reject_or_id"  value=""> 
                    <input type="hidden" id="st_payment_intent_id" name="payment_intent_id" value="">
                    <div class="form-group row">
                      <div class="col-lg-12 reject-error">
                        <label>Reason For Rejection</label>
                          <select name="reason_id" class="form-control">
                          <option value="">Select Reason</option>
                          @forelse ($rejectionReason as $reason)                    
                          <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
                          @empty
                          @endforelse
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
      		<img id="order_image_download" src=" " /><span id='ori-img'></span>
      		<!-- <h4 id="down_image_name"> <span class="file-size">12 MB</span></h4> -->
      	</div>
      	<div  class="ftr-dwnld-btn"> <a id="downloardBtn" href="" class="btn">Download</a></div>
      </div>
      </div>
      </div> 
    </div>
  </div>
</div>

 <!-- modal for update order-->
      <div class="modal update-modal fade" id="updateOrder">
          <div class="modal-dialog">
                  <div class="modal-content">
                    <form onsubmit="return validateEditForm(this)" name="edit_order" id="edit-order" action="{{ route('admin-update-order')}}" enctype="multipart/form-data" method="post">
                      @csrf
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
                                    <select id="garment_id_edit" name="garment_id" class="form-control pri-cal minimal-select">
                                      <option value="">Select garment type</option>
                                        @forelse ($garmentType as $garment)
                                            <option value="{{ $garment->id }}" {{ $order->garment_id == $garment->id ? 'selected' : '' }}>{{ $garment->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                                                     
                                </div>
                                <div class="col-md-6 my-error">
                                    <label>Measurement</label>
                                    <select id="measurement" name="measurement" class="form-control pri-cal minimal-select">
                                      <option value="">Select measurement</option>
                                      @forelse($priceCalculator as $priceInfo)
                                        <option value='{{ $priceInfo['id'] }}' {{ $order->measurement == $priceInfo['id'] ? 'selected' : '' }}>{{ $priceInfo['measurement'] == 1 ? 'Inches' : 'Centimeter' }}</option>
                                      @empty
                                      @endforelse
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
                                         <input type="checkbox" onclick="munual_override(this);" id="edit_manual_override" name="manual_override" value="1" class="icheck-primary d-inline ml-2 form-control" />

                                    
                                </div>
                                 <div style="display: none;" class="col-lg-6">
                                    <label>Cost:</label>
                                    <input type="text" id="cost_calculate" name="cost_calculate" value="" class="form-control" readonly="" />
                                    
                                </div> 
                                 <div class="col-lg-12">
                                    <label>Upload a sketch/wireframe</label>
                                    <div class="custom-file">
                                    <input type="file"  class="form-control custom-file-input"   name="feature_image">            
                                    <label class="custom-file-label" for="edit_order_image" id="showing_edit_order_image"></label>
                                    <input type="hidden" id="edit_order_image" name="old_order_image" value="" /> 
                                    </div>                          
                                    
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
@endif