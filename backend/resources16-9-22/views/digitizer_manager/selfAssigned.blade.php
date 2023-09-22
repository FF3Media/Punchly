@extends('layouts.app')

@section('content')
<div class="order-history-list-grid">
<div class="container-fluid">
   
            <div class="row">
                <div class="col-lg-12 my-3">
                  <div class="float-left">
                  <h3>Orders List</h3>
                  </div>
                <div class="float-right">
                    <div class="btn-group">
                      <div class="grid-list-btns">
                      <button class="btn active" id="list">List View</button>
                      <button class="btn" id="grid">Grid View</button>
                      </div>
                    <button class="filter-btn" data-toggle="modal" data-target="#filterModal">Filters <i class="fas fa-filter"></i>
                    </div>
                  </div>
                </div>
            </div>

            <div id="products" class="view-group row list-group-item">
              <div class="div-responsive">           
              <div class="page_loader roleMe" style="display: none;">
              <div class="spinner-border text-primary" role="status">
              <span class="sr-only">Loading...</span> 
              </div>
              </div>
              <div class="renderOrder row">
              @include('digitizer_manager.selfAssignManagement')

              </div>
            </div>
  <!----------------------Modal Open For Filter Functionality ----------->
            <div class="modal fade-out" id="filterModal" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Filters</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="select-section">
                        <div class="select-box">
                          <label>File Type</label>
                          <select class="form-control minimal-select" id="desired_output">
                            <option value="">Select</option>
                            <option value="for_embroidery_files">Embroidery files (DST, EMB)</option>
                        </select>
                      </div>
                      <div class="select-box">
                          <label>Status</label>
                          <select class="form-control minimal-select" id="status">
                          <option value="">Select</option>
                                  <option value="2">In progress</option>
                                  <option value="13">Reworking</option>
                                  <option value="10">For Review</option>
                         </select>
                      </div>
                      <div class="select-box">
                          <label>Date range</label>
                          <input type="text" readonly='true' name="daterange" id="daterangepicker" value="" />
                      </div>
                      </div>
                  <button type="button" class="btn btn-primary applyFilter">Apply</button>
                    <button type="button" class="btn btn-secondary clearFilter" data-dismiss="modal">Clear all</button>
                  </div>
                </div>
              </div>
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
             <a href="javascript:void(0);" onclick="submittedWorkFiles();"  id="submitted_work" class="rejected-tag action_order float-right cancelBtn">Submit Work</a>               
          </div>
          <div style="display: none;" class="newWordSubmitted">
        
        <form id="submitted-work-form" action="{{ route('digitizer-manager-self-submitted-work')}}" enctype="multipart/form-data" method="post">
                @csrf              
                    <h4 class="modal-title user-modal-title">Digitized files</h4>   
                     <div id="loading-bar-spinner" class="spinner" style="display:none;">
                      <div class="spinner-icon"></div>
                    </div> 
                    <input type="hidden" id="o_id" name="o_id"  value="">  
                    <input type="hidden" id="order_status_submited" name="order_status"  value="">  
                    <div class="form-group row">
                      <div class="col-lg-12 my-error">
                          <div class="input-field">
                            <!--   <label class="active">Upload a sketch/wireframe</label> -->
                              <div class="image-uploader-box"></div>
                          </div>
                      </div>
                    </div>         
                             
                    <input type="submit" onclick="submitworkForm('submitted-work-form');" id="digi-submit-work" value="Submit Work" class="btn btn-success">
               
            </form>
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
           <!--  <p  id="rejected-reason"><span class="detail-type">Rejection reason:</span> <span id="rejected-selected-reason" class="type-status"></span></p> -->
                      
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
         <h5>Orignal Image </h5> 
      
         <div class="ftr-modal-box">
          <div class="ftr-dwnld-left">
          <img id="order_image_download" src=" " />
          <span id='ori-img'></span>
        <!--  <h4 id="down_image_name"> <span class="file-size">12 MB</span></h4> -->
        </div>
        <div  class="ftr-dwnld-btn"> <a id="downloardBtn" href="" class="btn">Download</a></div>
      </div>
      </div>

      <div class="submitted-work">
            
           </div> 
      </div> 
    </div>
  </div>
</div>
@endsection

@section('third_party_scripts')
<script type="text/javascript">
  $.ajaxSetup({   headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  } });

  $(document).ready(function(){
    var end = moment().add(29, 'days').format('L');
    var start = moment().format('L');
    filter_data(1);

    var minimumDate= 0 , maximumDate = 0 , status = 0 , desired_output='';
    $('input[name="daterange"]').daterangepicker({  
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
    });
    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
         minimumDate = picker.startDate.format('MM/DD/YYYY');
         maximumDate = picker.endDate.format('MM/DD/YYYY');
       });
        $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    $('.applyFilter').click(function(){
      var result = $('#daterangepicker').val().split('-');
      minimumDate = result[0];
      maximumDate = result[1];
      var page = 1; 
      $('#filterModal').modal('toggle');
      filter_data(page);

    });
    $('.clearFilter').click(function(){       
      var elements = document.getElementsByTagName("select");
          $('input[name="daterange"]').val('');
          $("input[name=search]").val('');
          for (var ii=0; ii < elements.length; ii++) {             
              elements[ii].value = "";  

          }

      var page = 1; 
      $('#filterModal').modal('toggle');
      filter_data(page);
    });
    
    function filter_data(page){
      status = $('#status').val();
      desired_output = $('#desired_output').val();
        $.ajax({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: HOST_URL+"/digitizer-manager/selfAssingedRepresent/?page="+page,
            method:"GET",
            data:{minimumDate:minimumDate, maximumDate:maximumDate , status:status, desired_output:desired_output},
            success:function(data){
              $('.roleMe').css('display','none');
                if(data.isSucceeded){
                  $('.renderOrder').html(data.data);
                }else{
                  $('.renderOrder').html(data.data);
                }
            }
        });
    }


    $(document).on('click', '.pagination a', function(event){
      $('.roleMe').css('display','flex');
      event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        $('#hidden_page').val(page);
        $('li').removeClass('active');
        $(this).parent().addClass('active');
        filter_data(page);
    }); 
    $('#list').click(function(){
      $('#products').addClass('list-group-item');
    });
    $('#grid').click(function(){
      $('#products').removeClass('list-group-item');
      $('#products').addClass('grid-group-item');
    }); 
    $('.grid-list-btns button').click(function () {
      $(".grid-list-btns button").removeClass("active");
      $(this).addClass("active");
    });

  });

  function submittedWorkFiles(){
  	$('.newWordSubmitted').slideToggle();
  }

 
 function showOrderDetail(data){
  $('.rejectOrderForm').hide();
  $('.approveForm').hide();
  $('.newWordSubmitted').hide();
  $('#submitted_work').hide();   
  $('.submitted-work').hide();  
  $('#rejected-message').hide();
  $('#rejected-reason').hide();  
    //send order detail to Order detail poppup
    var status = '';
    var check = '';
    var months = [ "Jan", "Feb", "Mar", "April", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec" ];
    var updated_date = new Date(data.updated_at);
    var month = months[updated_date.getMonth()]; //months from 1-12
    var day = updated_date.getUTCDate();
    var year = updated_date.getUTCFullYear();
    $('#updated_date').text(day+' '+month+' '+year); 

     if(data.desired_output == 'for_embroidery_files'){
     	 $('#desired_output2').text('Embroidery files (DST, EMB)');
     }       
     $('#garment_name').text(data.garment.name);
     $('#desired_height').text(data.desired_height);
     $('#desired_width').text(data.desired_width);
     $('#order_unique_id').text(data.order_unique_id);
     $('#order_amount').text('$'+data.total_amount);
     $('#order_message').text(data.order_message);
     $('#order_image_name').text(data.order_name);
      if(data.status == 1){
      check = 'paid-tag';
      status = 'Waiting for Approval';
      $('#cancel_btn').show();
      }else if(data.status == 2){
      check = 'in-progress-tag';
      status = 'In progress';
      }else if(data.status == 3){
      check = 'rejected-tag';
      status = 'Rejected';
      }else if(data.status == 4){
      check = 'completed-tag';
      status = 'Completed';
      }else if(data.status == 7){
      check = 'rejected-tag';
      status = 'Refund pending';
      }else if(data.status == 8){
      check = 'rejected-tag';
      status = 'Refund failed';
      }else if(data.status == 6){
      check = 'rejected-tag';
      status = 'Refund succeeded';
      }else if(data.status == 10){
      check = 'paid-tag';
      status = 'For Review';
      }else if(data.status == 11){
      check = 'completed-tag';
      status = 'Completed';
      }else if(data.status == 13){
      check = 'paid-tag';
      status = 'Reworking';
      }
      $('#order_status').text(status); 
      $('#order_status').removeClass(); 
      $('#order_status').addClass(check);
      $('#order_image').attr('src',HOST_URL+'/public/orders/'+data.feature_image);    
      $('#down_image_name').text(data.order_name); 
      $('#order_image_download').attr('src',HOST_URL+'/public/orders/'+data.feature_image);
       $('#ori-img').text(data.feature_image);
      var url = '{{ route("digitizer-download-image", ":orderimage") }}';
      url = url.replace(':orderimage', data.feature_image);
      
      //rejected message
      if(data.status == 13 ){
        if(data.comment){
          $('#rejected-message').show();
          $('#rejected-text').text(data.comment);
        }
        if(data.rejection_reason){
          $('#rejected-reason').show();
          $('#rejected-selected-reason').text(data.rejection_reason.reason);
        }
       
      } 
      //end details 
      // Showing digitizer
      $('#downloardBtn').attr('href', url);  
      $('#o_id').val(data.id); 
      $('#order_status_submited').val(data.status); 
      // $('#cost_calculate').val(data.amount); 
      if(data.status == 2 || data.status == 13)  {
         $('#submitted_work').show();

      }   

      $.ajax({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('digitizer-send-order-id')}}",
            method:"GET",
            data:{order_id:data.id},
            success:function(data){               
              if(data.isSucceeded){
                  $('.submitted-work').html(data.data); 
                  $('.submitted-work').show();             
                  
                }         
            }
        }); 
      //Show model 
      $('#download-modal').modal('toggle');

 }  
 
   $('.image-uploader-box').imageUploader({
        imagesInputName: 'order_image',
        preloadedInputName: 'old',
        maxFiles: 10,
    });

  //  $('#submitted-work-form').validate({
  //         submitHandler: function(form,event) {
  //           $('#loading-bar-spinner').show();
  //           form.submit();
  //         },
  //         rules: {
  //             "order_image[]": {
  //                 required: true,
  //                 extension: "jpg,jpeg,png",
  //                 filesize: 30*1024*1024,
  //             },
  //         },
  //         messages: {
  //             "order_image[]": {
  //                 required: "Please select at least one image",
  //                 extension: "Please upload the file only have extension:jpg,jpeg,png",
  //                 filesize: "File size must be less than 30MB",
                  
  //             },  
  //         },
  //         errorElement: 'span',           
  //         errorPlacement: function (error, element) {
  //           error.addClass('invalid-feedback');
  //           element.closest('.my-error').append(error);
  //         },
  //         highlight: function (element, errorClass, validClass) {
  //           $(element).addClass('is-invalid');
  //         },
  //         unhighlight: function (element, errorClass, validClass) {
  //           $(element).removeClass('is-invalid');
  //         }
  //     }); 
  
  
  const submitworkForm = (form_id) => {
	  var form = $("#"+form_id);
    form.validate({
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
    },$("#digi-submit-work").attr('disabled','disabled'),
      form.submit(), 
    
    );
       
}
</script>

 
@endsection