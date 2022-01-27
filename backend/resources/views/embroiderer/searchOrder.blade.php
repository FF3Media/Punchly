@extends('layouts.app')

@section('content')
<div class="order-history-list-grid">
<div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 my-3">
                  <div class="float-left">
                  <h3>Search results</h3>
                  </div>
                <div class="float-right">
                    <div class="btn-group">
                      <div class="grid-list-btns">
                      <button class="btn" id="list">List View</button>
                      <button class="btn active" id="grid">Grid View</button>
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

          @include('embroiderer.searchOrderRepresent')

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
                          <option value="1">Awaiting Approval</option>
                          <option value="2">In progress</option>
                          <option value="3">Rejected</option>
                          <option value="4">Completed</option>
                          <option value="6">Canceled</option>
                 </select>
              </div>
              <div class="select-box">
                  <label>Date range</label>
                  <input type="text" name="daterange" id="daterangepicker" value="01/01/2021 - 01/15/2021" />
              </div>
              </div>
          <button type="button" class="btn btn-primary applyFilter">Apply</button>
            <button type="button" class="btn btn-secondary clearFilter" data-dismiss="modal">Clear all</button>
          </div>
        </div>
      </div>
  </div>
 
@endsection

@section('third_party_scripts')
<script type="text/javascript">
  $.ajaxSetup({   headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  } });

  $(document).ready(function(){
    var searchParam="{{request()->query('search')}}";
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
      searchParam=""; 
      //remove url string   
      var uri = window.location.toString();
      if (uri.indexOf("?") > 0) {
          var clean_uri = uri.substring(0, uri.indexOf("?"));
          window.history.replaceState({}, document.title, clean_uri);
      }
      var elements = document.getElementsByTagName("select");
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
          url: HOST_URL+"/embroiderer/searchOrderRepresent/?page="+page,
          method:"GET",
          data:{minimumDate:minimumDate, maximumDate:maximumDate , status:status, desired_output:desired_output , searchParam : searchParam},
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
  $('.pri-cal').bind('keyup mouseup onchange', function(e) {      
      var height , width , valActual = 0;
      var measurement_inch_and_width = '1'; 
      var priceInch = "<?php echo $inch;?>"; 
      var priceCentimeter ="<?php echo $centimeter;?>";
      height = $('#desired_height').val();
      width = $('#desired_width').val();
      inch = $("input[name=height_in]:checked").val();
      cm = $("input[name=width_cm]:checked").val();
       if(inch == 1){ 
        measurement_inch_and_width = 1 ;
       }
       if(cm == 2){ 
         measurement_inch_and_width = 2 ;         
       }           
      if(height && width && measurement_inch_and_width){
          if(measurement_inch_and_width == '1'){
              valActual = height*width*priceInch;
              valActual =  valActual.toFixed(2);
              $('#cost_calculate').val(valActual);    
          }else if(measurement_inch_and_width == '2'){
              valActual = height*width*priceCentimeter;
              valActual =  valActual.toFixed(2);
              $('#cost_calculate').val(valActual);    
          }            
      }
  });
  function showOrderDetail(data){
   
  $('#rejected-message').hide();
  $('.cancelForm').hide();
  $('#rejected-reason').hide();
  $('.submitted-work').html(''); 
  $('#cancel_btn').hide();
  $('#cancel_order_id').val('');
  $('#st_charge_id').val('');
  $('#invoicedPdf').hide();
  $('#desired_old_height_label').hide();
  $('#desired_old_width_label').hide();
  console.log(data);
    //send order detail to Order detail poppup
    var status = '';
    var check = '';
    var months = [ "Jan", "Feb", "Mar", "April", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec" ];
    var updated_date = new Date(data.updated_at);
    var month = months[updated_date.getMonth()]; //months from 1-12
    var day = updated_date.getUTCDate();
    var year = updated_date.getUTCFullYear();
    $('#updated_date').text(day+' '+month+' '+year);
   if(data.desired_output == 'for_print'){
     $('#desired_output2').text('For print');
   }else{
     $('#desired_output2').text('For embroyer');
    }      
     $('#garment_name').text(data.garment.name);
     $('#desired_height_detail').text(data.desired_height);
     $('#desired_width_detail').text(data.desired_width);
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
      check = 'paid-tag';
      status = 'Awaiting Approval';
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
      }else if(data.status == 9){
      check = 'rejected-tag';
      status = 'canceled';
      }else if(data.status == 8){
      check = 'rejected-tag';
      status = 'Refund failed';
      }else if(data.status == 6){
      check = 'rejected-tag';
      status = 'Refund succeeded';
      }else if(data.status == 11){
      check = 'completed-tag';
      status = 'Completed';
      } 
      $('#order_status').text(status); 
      $('#order_status').removeClass(); 
      $('#order_status').addClass(check);
      $('#order_image').attr('src',HOST_URL+'/public/orders/'+data.feature_image);    
      $('#down_image_name').text(data.order_name); 
      $('#order_image_download').attr('src',HOST_URL+'/public/orders/'+data.feature_image);
      var url = '{{ route("embroiderer-download-image", ":orderimage") }}';
      url = url.replace(':orderimage', data.feature_image); 
      $('#downloardBtn').attr('href', url);       
      //rejected message
      if(data.status == 3){
        if(data.comment){
          $('#rejected-message').show();
          $('#rejected-text').text(data.comment);
        }
        if(data.rejection_reason){
          $('#rejected-reason').show();
          $('#rejected-selected-reason').text(data.rejection_reason.reason);
        }       
      }

      //invoice Button
       if(data.status == 4){
         $('#invoicedPdf').show();
        }
      //end details  

      //Cancel Order Form
      $('#cancel_order_id').val(data.id);
      if(data.payment_details != null && data.status == 1){

       $('#st_payment_intent_id').val(data.payment_details.st_payment_intent_id);
       }
      if(data.amount_after_coupon > 0){
         $('#order_amount_cancel').val(data.amount_after_coupon);
      }else{
         $('#order_amount_cancel').val(data.amount);
      }
     

      $.ajax({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('embroiderer-send-order-id')}}",
            method:"GET",
            data:{order_id:data.id},
            success:function(data){               
              if(data.isSucceeded){
                  $('.submitted-work').html(data.data);            
                  
                }         
            }
        });     
       
      //Show model 
      $('#download-modal').modal('toggle');

 }  
</script>
@endsection