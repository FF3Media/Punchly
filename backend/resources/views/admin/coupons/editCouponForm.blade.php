@extends('layouts.app')

@section('content')
<?php 
// echo '<pre>'; print_r($data); echo '</pre>';
// die;


?>

 

    <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Coupon</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin-coupons-list') }}">Coupon</a></li>
              <li class="breadcrumb-item active">Edit Coupon</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div  class="col-md-4">
            </div>
            <div class="col-md-8">
              <div style="width: 100%;text-align: right;">
                <a  style="float: right;margin-bottom: 10px;" href="{{ route('admin-coupons-list') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left"></i> Back To Coupon List</a>
              </div>
            </div>
        </div>
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Coupon</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="{{ route('admin-edit-coupon-form') }}" id="couponForm">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <div class="card-body row pb-0">
                  <div class="form-group col-md-4">
                    <label for="exampleInputName1">Name</label>
                    <input type="text" value="{{$data->name}}" name="name" class="form-control" id="name" placeholder="Please Enter Coupon Name">
                    <input type="hidden" value="{{$data->id}}" name="c_id">
                  </div>
                  <div class="form-group col-md-4">
                    <label class = "checkbox-inline">Discount Type</label><br>
                     <input type="radio" id="discount_type_percentage" name="discount_type" value="percentage" {{ ($data->percent_off)? "checked" : "" }} class="input-control discount_type"> Percentage Discount
                     <input type="radio" name="discount_type" value="fixedamt" {{ ($data->amount_off)? "checked" : "" }} class="input-control discount_type"> Fix Amount Discount
                  </div>
                  

                  <div class="form-group col-md-4 fxd-amt" style="display: none;">
                    <label>Discount Amount</label>
                    <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{$data->amount_off}}" name="amount_off" class="form-control" id="amount_off" step="1.00" min=1 placeholder="Please Enter Discount Amount.">
                  </div>
                  <div class="form-group col-md-4 per-amt" style="display: none;">
                    <label>Percent Off</label>
                    <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="percent_off" id="percent_off" value="{{$data->percent_off}}" min=1 class="form-control" placeholder="Please Enter Percent In This (0.01) Format" />
                  </div>

                  <div class="form-group col-md-4">
                    <label>Start Date</label>
                    <input type="text"  value="{{$data->start_date}}" name="start_date" class="form-control" id="start_date"  placeholder="mm-dd-yyyy">
                  </div>

                  <div class="form-group col-md-4" >
                    <label>End Date</label>
                    <input type="text"  value="{{$data->end_date}}" name="end_date" class="form-control" id="end_date"   placeholder="mm-dd-yyyy">
                  </div> 
                   
                   
                  <div class="form-group col-md-4">
                    <label>Max Redemptions</label>
                    <input type="number" value="{{$data->max_redemptions}}" name="max_redemptions" class="form-control calucaltion" id="max_redemptions" min=1 oninput="validity.valid||(value='');" placeholder="Please Enter Max Redemptions.">
                  </div>

                    <div class="form-group col-md-4">
                    <label>Description</label>
                    <textarea name="description"  class="form-control" id="description" >{{$data->description}}</textarea>    
                  </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer pt-0">
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
   
@endsection
{{-- Scripts Section --}}
@section('third_party_scripts')
<script type="text/javascript">
$(document).ready(function () {

    $("input[type='radio']").click(function(){
        var radioValue = $("input[name='discount_type']:checked").val();
        if(radioValue == 'fixedamt'){
          $('.fxd-amt').show();
          $('.per-amt').hide();
        }else if(radioValue == 'percentage'){
          $('.per-amt').show();
          $('.fxd-amt').hide();
        } 

    });

    window.addEventListener("load", function(){
       if($('#discount_type_percentage').is(':checked')) { 
          $('.per-amt').show();
          $('.fxd-amt').hide(); 
        }else{     
          $('.fxd-amt').show();
          $('.per-amt').hide();
        }
   
        });

   $(function () {
    $("#start_date").datepicker({
        numberOfMonths: 1,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 1);
            $("#end_date").datepicker("option", "minDate", dt,{
            dateFormat: 'mm-dd-yy'
        });
        }
    });
    $("#end_date").datepicker({
        numberOfMonths: 1,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() - 1);
            $("#start_date").datepicker("option", "maxDate", dt,{
            dateFormat: 'mm-dd-yy'
        });
        }
    });
});

    $('#couponForm').validate({
      submitHandler: function(form) {
        // do other things for a valid form
        form.submit();
      },
      rules: {
        name: {
          required : true,
        },
        discount_type : {
          required : true,
        },
        currency: {
          required : true,
        },
        amount_off: {
          required : true
        },
        percent_off : {
          required : true
        },
        start_date :{
          required : true
        },
        end_date :{
          required : true
        },
        
      },
      messages: {
        name: {
          required : "Please enter name",
        },
        discount_type : {
          required : "Please select discount type",
        },
        currency : {
          required : "Please select currency.",
        },
        amount_off : {
          required : "Please enter amount in this (0.01) format."
        },
        percent_off : {
          required : "Please enter percent in this (0.01) format."
        },
         start_date : {
          required : "Please select Starting date for coupon."
        },
        end_date : {
          required : "Please select Ending date for coupon."
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
});
</script>
@endsection
