<?php $__env->startSection('content'); ?>
<script src="https://js.stripe.com/v3/"></script>
<style type="text/css">
    .read-only{
    background-color: '#dedada' !important;
    }
    .pri-cal::-webkit-inner-spin-button, 
    .pri-cal::-webkit-outer-spin-button { 
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0; 
    }

    .optionGroup {
                                    font-weight: bold;
                                    font-style: italic;
                                    background-color: red;
                                }
                                    
                                .optionChild {
                                    padding-left: 15px;
                                }
   
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary" style="margin: 6px !important">
                <div class="card-header">
                    <h3 class="card-title">Create New Order</h3>                     
                </div>
                <!--begin::Form-->
                <form id="create_order" class="form" method="post" action="<?php echo e(route('embroiderer-create-order')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-body">
                        <div class="form-group row">                            
                            <div class="col-lg-6 my-error">
                                <label>Order name</label>
                                <input type="text" name="order_name" value="" class="form-control" placeholder="Enter Order Name" />
                            </div>
                            <div class="col-lg-6 my-error">
                                <label>Measurement</label>
                                <select name="measurement" class="form-control pri-cal" id="measurement">
                                    <option value="">Select measurement</option>
                                    <option value="1">Inches</option>
                                    <option value="2">Centimeter</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 my-error">
                                <label>Height</label>
                                <input type="number" id="desired_height" name="desired_height" value="" class="form-control pri-cal"  placeholder="Enter your desired height" />
                            </div>
                            <div class="col-lg-6 my-error">
                                <label>Width</label>
                                <input type="number" id="desired_width" name="desired_width" value="" class="form-control pri-cal" placeholder="Enter your desired width" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 my-error">
                                <label>Garment type</label>
                                <select name="garment_id" class="form-control">                                    
                                    <option value="">Select garment type</option>
                                    <?php $__empty_1 = true; $__currentLoopData = $garments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $garment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($garment->id); ?>"><?php echo e($garment->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-lg-6 my-error">
                                <label>Cost:</label>
                                <input type="text" id="cost_calculate" name="cost_calculate" value="0" class="form-control" readonly="" />
                            </div>                            
                        </div>
                        <div class="form-group row">
                             <div class="col-lg-6 my-error">
                                <label>Leave a note</label>
                                <textarea name="order_message"  class="form-control"  rows="6" cols="50" placeholder="Leave a note here"></textarea>
                            </div>
                             <div class="col-lg-6 my-error">
                                <div class="input-field">
                                    <label class="active">Upload a sketch/wireframe</label>
                                    <div class="image-uploader"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                              <div class="col-lg-6 my-error">
                                <label>Order required date</label>
                                <input type="text" name="delivery_date" id="datepicker" placeholder="mm-dd-yyyy" class="form-control" />
                            </div>   

                             <div class="col-lg-6 my-error">
                                 <label>Desired Output</label>
                                <select name="desired_output" class="form-control pri-cal" id="desired_output">
                                    <option value="">Select Desired Output</option>
                                    <option value="for_print">For Print</option>
                                    <option value="for_embroyer">For Embroyer</option>
                                </select>
                            </div> 

                        </div>
                        <div class="form-group row">                               

                             <div class="col-lg-6 my-error">
                                <label>Coupon</label>
                                <input type="text"  onkeyup="checkCouponValidate(this)" name="coupon_id" id="coupon_id" placeholder="Coupon" class="form-control" />
                                <div style="color:red"  class="errorcoupone"></div>
                            </div> 

                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 new_order_submit">
                                <input type="submit" class="btn btn-primary mr-2" value="Add to cart" id="add-card" />
                                <a href="<?php echo e(route('embroiderer-order-management')); ?>" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>                        
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>  
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('third_party_scripts'); ?>
<script type="text/javascript"> 
    //Validation form edit user
    var cardForm='';
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'  } }); 
    $(document).ready(function(){
        $("#datepicker").datepicker({
            dateFormat: 'mm-dd-yy'
        });
        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, 'File size must be less than {0}');
        $("#create_order").validate({
            submitHandler: function(form,e) {
              form.submit();
              e.preventDefault();           
            },
            rules: {
                order_name: {
                    required: true
                },
                measurement: {
                    required: true
                },
                desired_height: {
                    required: true,
                },
                desired_width:{
                    required: true
                },
                garment_id:{
                    required: true,
                },
                "avatar[]":{
                    required: true,
                    extension: "jpg,jpeg,png",
                    filesize: 5*1024*1024,
                },
                order_message:{
                    required: true,
                },
                delivery_date:{
                    required: true,
                },
                desired_output:{
                    required:true
                }
            },
            messages: {
                order_name: {
                    required:"Please enter order name",
                },
                measurement: {
                    required: "Please select measurement",
                },  
                desired_height: {                 
                    required : "Please enter your desired height",
                },
                desired_width: {
                    required : "Please enter your desired width",
                },
                garment_id: {
                    required : "Please select garment type",
                },
                avatar:{
                    required: "Please select the image",
                    extension: "Please select jpg,jpeg and png image",
                    filesize: "File size must be less than 2MB",
                },
                delivery_date:{
                    required: "Please select the delivery date"
                },
                "avatar[]":{
                    required: "Please select at least one image",
                    extension: "Please upload the file only have extension:jpg,jpeg,png",
                    filesize: "Maximum File upload size is 5MB",
                },
                order_message:{
                    required: "Please enter your desired message"
                },
                desired_output:{
                    required: "Please select the desired output"
                }
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
        $('.image-uploader').imageUploader({
            imagesInputName: 'avatar',
            preloadedInputName: 'old',
            maxFiles: 1
        });
    });

    $('.pri-cal').bind('keyup mouseup', function(e) {
        var height , width , valActual = 0;
        var measurement = '1'; 
        var priceInch = '<?php echo $inch ?>'; 
        var priceCentimeter = '<?php echo $centimeter ?>';
        height = $('#desired_height').val();
        width = $('#desired_width').val();
        measurement = $('#measurement').val();
        if(height && width && measurement){
            if(measurement == '1'){
                valActual = height*width*priceInch;
                valActual =  valActual.toFixed(2);
                $('#cost_calculate').val(valActual);    
            }else if(measurement == '2'){
                valActual = height*width*priceCentimeter;
                valActual =  valActual.toFixed(2);
                $('#cost_calculate').val(valActual);    
            }            
        }
    });

    function checkCouponValidate(element){
           var coupon = $(element).val();         
         if (coupon) {              
          $.ajax({
            type: "POST",
            url: "<?php echo e(route('embroiderer-check-coupon')); ?>",
            data: {coupon:coupon},
            dataType: "json",
            success: function(res) {                 
                if(res == 1){
                    $('.errorcoupone').text(' ');
                   
                    $('#add-card').removeAttr('disabled');
                }else{
                    $('.errorcoupone').text('Coupon not valid');
                     $('#add-card').attr("disabled", true);
                    
                } 
            },
            error: function (jqXHR, exception) {

            }
        });
      }else{

         $('#add-card').removeAttr('disabled');
          $('.errorcoupone').text(' ');
      }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/punchly/backend/resources/views/embroiderer/orderForm.blade.php ENDPATH**/ ?>