{{-- Extends layout --}}
@extends('layouts.app')
{{-- Content --}}
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary" style="margin: 6px !important">
                @if(session()->has('success'))
                <div class="alert alert-success cus-msg-cls" style="text-align: left;">
                    {{ session()->get('success') }}
                </div>
                @elseif(session()->has('failure'))
                <div class="alert alert-danger cus-msg-cls" style="text-align: left;">
                    {{ session()->get('failure') }}
                </div>
                @endif
                <div class="card-header">
                    <h3 class="card-title">Manage Pricing</h3>
                </div>
                <!--begin::Form-->
                <form id="edit-user-profile" class="form" method="post" action="{{ route('admin-manage-price-form') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                       <div class="form-group row">
                            <div class="col-lg-6 my-error">
                                <label>Per Square inch:</label>
                                <input type="text" onkeypress="return isNumberKey(event)" name="inch_price" value="${{$inch}}"    class="form-control" placeholder="$" />
                            </div>
                            <div class="col-lg-6 my-error">
                                <label>Per Square Centimeter:</label>
                                <input type="text" onkeypress="return isNumberKey(event)" name="centimeter_price"  value="${{$centimeter}}"    class="form-control" placeholder="$" />
                            </div>
                        </div>                         
                       
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <input type="submit" class="btn btn-primary mr-2" value="Save" />                                
                            </div>
                        </div>
                    </div>                        
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>
@endsection
{{-- Scripts Section --}}
@section('third_party_scripts')
<script type="text/javascript">
    $.ajaxSetup({headers: {'X-XSRF-TOKEN': decodeURIComponent(/XSRF-Token=([^;]*)/ig.exec(document.cookie)[1])}});
    $(document).ready(function () {
        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, 'File size must be less than {0}');
        $('#edit-user-profile').validate({
            submitHandler: function(form) {
              // do other things for a valid form
              form.submit();
            },
            rules: {
                inch_price:{
                    required: true,
                     
                },
                centimeter_price: {
                    required: true
                    
                },
                 
            },
            messages: {
                inch_price: {
                    required : "Please Enter Price For Inces",
                },
                centimeter_price: {
                    required: "Please Enter Price For Centimeter",
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
        });
    });

//     $(document).ready(function () {
//   //called when key is pressed in textbox
//   $(".onlyNumbers").keypress(function (e) {
//      //if the letter is not digit then display error and don't type anything
//      if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
//         //display error message
//         $("#errmsg").html("Digits Only").show().fadeOut("slow");
//                return false;
//     }
//    });
// });

function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }

</script>
@endsection