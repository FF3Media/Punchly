<?php $__env->startSection('content'); ?>
<div class="order-history-list-grid">
<div class="container-fluid">
   
            <div class="row">
                <div class="col-lg-12 my-3">
                  <div class="float-left">
                  <h3>For Review Orders</h3>
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

          <?php echo $__env->make('admin.orderRepresentSubmitted', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
                <!-- <option value="2">In progress</option> -->
				        <option value="4">Completed</option>
				        <option value="10">For Review</option>
				        <option value="13">Reworking</option>
                 </select>
              </div>
              <div class="select-box">
                  <label>Date range</label>
                  <input type="text"  readonly='true' name="daterange" id="daterangepicker" value="" />
              </div>
              </div>
          <button type="button" class="btn btn-primary applyFilter">Apply</button>
            <button type="button" class="btn btn-secondary clearFilter" data-dismiss="modal">Clear all</button>
          </div>
        </div>
      </div>
  </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('third_party_scripts'); ?>
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
         minimumDate = picker.startDate.format('MM-DD-YYYY');
         maximumDate = picker.endDate.format('MM-DD-YYYY');           
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
            url: HOST_URL+"/admin/order-represent-submitted/?page="+page,
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


function approveOrder(){
  $('.approveForm').slideToggle();  
  $('.rejectOrderForm').slideUp();
   }

   function reAssignDigitizer(){
   $('.reAssignForm').slideToggle();  
  
   }

function rejectOrderForm (){
  $('.rejectOrderForm').slideToggle();
  $('.approveForm').slideUp(); 
}
 function showOrderDetail(data){
  console.log(data);
  //hide text or forms after click
  $('.reAssignForm').hide();  
  $('.rejectOrderForm').hide();
  $('.approveForm').hide();
  $('.submitted-work').html(''); 
  $('#assign-digitizer').hide();
  $('#rejected-message').hide();
  $('#rejected-reason').hide();
  $('#approve_or_id').val('');  
  $('#desired_old_height_label').hide();
  $('#desired_old_width_label').hide();

  //end hiding
  
    var status = '';
    var check = '';
    var months = [ "Jan", "Feb", "Mar", "April", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec" ];
    var updated_date = new Date(data.updated_at);
    var month = months[updated_date.getMonth()]; //months from 1-12
    var day = updated_date.getUTCDate();
    var year = updated_date.getUTCFullYear();
    $('#updated_date').text(day+' '+month+' '+year); 

   if(data.desired_output == 'for_embroidery_files'){
   	 $('#desired_output2').text('Embroidery files (DST, EMB)t');
   } 
     $('#garment_name').text(data.garment.name);
     $('#desired_height').text(data.desired_height);
     $('#desired_width').text(data.desired_width);
     $('#order_unique_id').text(data.order_unique_id);
     $('#order_amount').text('$'+data.amount);
     $('#order_message').text(data.order_message);
     $('#order_image_name').text(data.order_name);
      if(data.desired_old_height > 0 && data.desired_old_width > 0 ) {
      $('#desired_old_height').text(data.desired_old_height);
      $('#desired_old_width').text(data.desired_old_width);
      $('#desired_old_height_label').show();
      $('#desired_old_width_label').show();
     }
     if(data.status == 1){
      	check = 'in-progress-tag';
      	status = 'Awaiting Approval';
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
    }else if(data.status == 9){
      	check = 'rejected-tag';
      	status = 'Canceled';
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
    var url = '<?php echo e(route("admin-download-image", ":orderimage")); ?>';
	  url = url.replace(':orderimage', data.feature_image);
	  $('#downloardBtn').attr('href', url);
    //Assign digitizer name
      if(data.status != 1  && data.order_digitizer_id != 0 ){
        if(data.digitizer){
          $('#digitizer-name').text(data.digitizer.first_name);
          $('#assign-digitizer').show();  
        } 
       
          
      }
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

    if(data.status == 10){
        $('.btnSubmittedHide').show()
      }else {
         $('.btnSubmittedHide').hide()
      }
     $.ajax({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "<?php echo e(route('admin-send-order-id')); ?>",
            method:"GET",
            data:{order_id:data.id},
            success:function(data){               
              if(data.isSucceeded){
                  $('.submitted-work').html(data.data);            
                  
                }         
            }
        });
     //assign digitizer
      $('#approve_or_id').val(data.id); 
     //send reject order id 
     $('#reject_order_id').val(data.id);
      //send Accept  order id 
     $('#accept_order_id').val(data.id);   
      //Show model 
    $('#download-modal').modal('toggle');

 }
 
 function rejectOrderValidation(data){
        jQuery('.error2').remove();
        var error=0;
        var field_name= "";         
       if(jQuery("select[name=reason_id]").val() == '') {    
         jQuery("select[name=reason_id]").css('border','1px solid red');
         jQuery("select[name=reason_id]").parent().append('<span class="error2" style="color:red">Please Select Reason For Rejection.</span>');    
        if(field_name == "") {        
            field_name = "select[name=reason_id]"; 
        }   
        error=1;
      }else{      
        jQuery("textarea[name=reason_id]").css('border','1px solid #cacaca');
       }
       if(jQuery("textarea[name=comment]").val() == '') {    
         jQuery("textarea[name=comment]").css('border','1px solid red');
         jQuery("textarea[name=comment]").parent().append('<span class="error2" style="color:red">Comment Cannot be blank.</span>');    
        if(field_name == "") {        
            field_name = "textarea[name=comment]"; 
        }   
        error=1;
      }else{      
        jQuery("textarea[name=comment]").css('border','1px solid #cacaca');
       }
        
         if(error==1){
          if(field_name){
              jQuery("html, body").animate({ scrollTop: jQuery(field_name).parent().find('div').top }, 900);
              jQuery(field_name).focus(); 
          }        
            return false;
         } 
}
 function assignDigitizerValidation(data){
        jQuery('.error2').remove();
        var error=0;
        var field_name= "";         
       if(jQuery("select[name=order_digitizer_id]").val() == '') {    
         jQuery("select[name=order_digitizer_id]").css('border','1px solid red');
         jQuery("select[name=order_digitizer_id]").parent().append('<span class="error2" style="color:red">Please Select Digitizer.</span>');    
        if(field_name == "") {        
            field_name = "select[name=order_digitizer_id]"; 
        }   
        error=1;
      }else{      
        jQuery("textarea[name=order_digitizer_id]").css('border','1px solid #cacaca');
       }
        
        
         if(error==1){
          if(field_name){
              jQuery("html, body").animate({ scrollTop: jQuery(field_name).parent().find('div').top }, 900);
              jQuery(field_name).focus(); 
          }        
            return false;
         } 
}
$(document).on('click', '.deleteimg', function(event){
  var id =$(this).data('id'); 
  swal({   
				title: "Are you sure?", 
			 	text: "You want to image this", 
			 	type: "warning",  
			 	showCancelButton: true,  
			 	confirmButtonColor: "#28b351", 
			 	confirmButtonText: "Yes!",   
			 	closeOnConfirm: false   
			}, 
			function (isConfirm) { 
				if (!isConfirm) return;
				$.ajax({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
				 	url: `<?php echo e(route('admin-delete-order-image')); ?>`,  
				 	type: "POST",  
				 	data: { id : id },         
				 	dataType: "Json", 
			 		success: function (data) {
			 			if(data.isSucceeded){
			 		 		swal.close();
             $('.imgbox-'+id).hide();  

			 			}else{
	         	swal("Error updating!", "Please try again", "error");  
			 			}           
					},          
					error: function (xhr, ajaxOptions, thrownError) {
						swal("Error updating!", "Please try again", "error");  
					}     
			 	});
      }); 
			});  
 
</script>

 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/punchly/backend/resources/views/admin/submittedWorkManagement.blade.php ENDPATH**/ ?>