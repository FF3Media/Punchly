
<?php $__env->startSection('content'); ?>
<script src="https://js.stripe.com/v3/"></script>
    <section class="section-content cart-section bg padding-y">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <?php if(session()->has('success')): ?>
                    <div class="alert alert-success cus-msg-cls" style="text-align: left;">
                        <?php echo e(session()->get('success')); ?>

                    </div>
                    <?php elseif(session()->has('failure')): ?>
                    <div class="alert alert-danger cus-msg-cls" style="text-align: left;">
                        <?php echo e(session()->get('failure')); ?>

                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <main class="col-sm-12">
                    <h3 class="main-heading-cart">Shopping cart</h3>
                    <div class="card cart-card">
                        <div class="table-responsive">
                            <?php $totalAmt=0; ?>
                            <?php $__empty_1 = true; $__currentLoopData = $allOrder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                $totalAmt = $orderDetail->amount + $totalAmt;  
                              
                                  ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <?php endif; ?>
                            <table class="table table-hover shopping-cart-wrap">
                                <thead class="text-muted">
                                    <tr>
                                        <th scope="col">Order</th>
                                        <th scope="col">File Type</th>
                                        <th scope="col">Garment Type</th>
                                        <th scope="col">Desired height</th>
                                        <th scope="col">Desired width</th>
                                        <th scope="col">Cost</th>
                                        <th scope="col" class="text-right"></th>
                                    </tr>
                                </thead>
                                <tbody>      
                                </tbody>
                            </table>
                        </div>
                        <div class="total-checkout">
                            <div class="total">
                                <h4>Total Cost: <span class="total-price">$<span id="totalAmt"><?php echo e(number_format($totalAmt, 2)); ?></span></span></h4>
                            </div>
                            <div class="total">
                                <a href="<?php echo e(url('/embroiderer/checkout-payment')); ?>" class="btn btn-purple btn-primary proceedBtn" style="display: <?php echo e($totalAmt != 0 ? 'block' : 'none'); ?>">Proceed to checkout</a>
                            </div>
                        </div>
                    </div>
                </main>
                
            </div>
        </div>
        <!-- Edit form slide -->
        
<!-- Right Slide Model -->
<div class="modal fade new-order-slide slideModel4" style="padding-right:0px;" id="edit_order" tabindex="-1" role="dialog" aria-labelledby="newCreateOrder" aria-hidden="true">
   
  <div class="modal-dialog modal-dialog-slideout" role="document">
    <form id="edit_order_form" method="post" action="" enctype="multipart/form-data" class="new-order-form"> 

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Order <span class="file-name"></span></h5>
        <div class="model-right">
       <!--  <a class="upload-another">Upload another file</a> -->
        <a href="#" type="button" class="slideclose4 upload-another" id="popup4" aria-label="Close">
         <!--  <span aria-hidden="true">×</span> -->
          Upload new file
        </a> 
        <button type="button" class="close modelcloseCnfrm1" aria-label="Close"   > <span>×</span></button>
    </div>

    <div id="loading-bar-spinner" class="spinner" style="display: none;">
                                        <div class="spinner-icon"></div>
                                    </div>
      </div>
      
      <div class="modal-body"> 

        <div id="dz-preview-editOrder"></div>   
        <div  style="display: none;"  class="drobzonefiles">                               
                            <div class="col-lg-12 my-3">
                                    <div class="drop-browse-div">
                                        <div id='drop_zone4'> 
                                            <?php echo csrf_field(); ?>
                                            <!-- You can add extra form fields here -->
                                            <input hidden id="file_editOrder" name="file"/>
                                            <!-- You can add extra form fields here -->
                                            <div class="dropzone dropzone-file-area" id="editOrderFileUpload">
                                            <div class="dz-default dz-message">
                                            <img src="<?php echo e(asset('backend-images/thimb-img.png')); ?>" />
                                            <h3 class="sbold">Drop your files here, or <span class="color-green">browse</span></h3>
                                            <span>Supports: JPEG, PNG, PSD</span>
                                            </div>
                                            </div> 

                                        </div>
                                    </div>

                            </div>
                            </div>
        <input type="hidden" id="order_name4" name="order_name" value="" class="form-control" />
        <input type="hidden" id="editOrder_id" name="editOrder_id" value="" class="form-control" />
        <div class="row">        
        <div class="col my-error">
            <label>Desired output</label>
            <select name="desired_output" id="desired_output_editOrder" class="form-control minimal-select">
            <option value="">Select</option>
            <option value="for_embroidery_files" selected="selected">Embroidery files (DST, EMB)</option>
        </select>
        </div> 
        <div class="col my-error">
          <label>Garment type</label>
            <select name="garment_id" id="garment_id_editOrder" class="form-control minimal-select">            
              <option value="">Select garment type</option>
              <option value="1">Tee shirt</option>
              <option value="4">Hoodie</option>
              <option value="5">Polo</option>
              <option value="6">Hat</option>
              <option value="7">Beanie</option>
              <option value="8">Towel</option>
              <option value="9">Bathrobe</option>                      
           </select>
        </div> 
      </div>  
      <div class="row"> 
        <div class="col my-error">
          <label>Desired height</label>
            <input  type="number" id="desired_height_editOrder"   class="pri-cal4" name="desired_height">            
            <div class="radio-btns">              
              <p><input type="radio" id="in3" class="pri-cal4" name="height_in" value="1" checked><label id="inchlabeleditOrder"  for="in3">in</label></p>
              <p><input type="radio" id="cm3" class="pri-cal4"  name="height_cm" value="2" ><label id="cmlabeleditOrder"   for="cm3">cm</label></p>
            </div> 
          </div>

        <div class="col my-error">
          <label>Desired width</label>
            <input type="number" id="desired_width_editOrder"   class="pri-cal4" name="desired_width">
            <div class="radio-btns">              
              <p><input type="radio" id="in13" class="pri-cal4" name="width_in" value="1" checked><label id="inchlabel2555" for="in13">in</label></p>
              <p><input type="radio" id="cm13" class="pri-cal4" name="width_cm" value="2" ><label id="cmlabel2555" for="cm13">cm</label></p>
            </div>
        </div>
      </div> 
      <div class="row">
        <div class="col cost-detail-heading my-error">
         <h4><span class="dark-text">Cost:</span> $<span id='cost_calculate_span3'><?php echo $shareData['inch'];?></span> per square <span id='persquare3'>inch</span></h4>
           <input type="text" id="cost_calculate_editOrder" name="cost_calculate" value="0" class="form-control" readonly="" />
        </div>
      </div> 
      <div class="row">        
        <div class="col my-error">
        <label>Comments</label>
            <textarea name="order_message" id='edit_order_message' class="form-control"  rows="6" cols="50" placeholder="EX: Remove the white background"></textarea>
        </div> 
      </div>  
      </div>

      <div class="modal-footer">
        <button type="submit" class="gray-btn sky-blue" name="clickbtn" value="instant_cart" id="add-editOrder-order" >Update Cart</button>
        <button type="submit" class="gray-btn" name="clickbtn" value="instant_checkout" >Instant checkout</button>

      </div> 
        
    </div>
    </form>
  </div>
 
 </div>
      
    </section>
<?php $__env->stopSection(); ?>                  

<?php $__env->startSection('third_party_scripts'); ?>
<script type="text/javascript"> 
    //Validation form edit user 

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'  } });  
    
    /**********************Capital First Letter**********/
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    $(function () {
        var table = $('.shopping-cart-wrap').DataTable({
            processing: true,    
            serverSide: true,
            paging:false,
            searching: false,
            order: false,
            ajax: "<?php echo e(route('embroiderer-cart')); ?>",
            columns: [
                {data: 'feature_image', name: 'feature_image',orderable: false,render:function(data,type,row){
                    var imagUrl = HOST_URL + '/public/users-image/user.png';
                    if(row.feature_image!= null){
                        imagUrl = HOST_URL + '/public/orders/'+row.feature_image;
                    }                   
                    return "<div class='cart-img-div'><img class='img-fluid' src=\"" + imagUrl + "\"/><div>";       
                }},
                {data: 'desired_output', name: 'desired_output',orderable: false,render:function(data,type,row){
                    var dName = '';
                    if(row.desired_output == 'for_embroidery_files'){
                        dName = 'Embroidery files (DST, EMB)';
                    } 
                    return capitalizeFirstLetter(dName);
                }},
                {data: 'garment_id', name: 'garment_id',orderable: false,render:function(data,type,row){
                    return capitalizeFirstLetter(row.garment.name);
                }},
                {data: 'desired_height', name: 'desired_height',orderable: false,render:function(data,type,row){
                    var measurement = '';
                    if(row.measurement == 1){
                        measurement = 'in';
                    }else if(row.measurement == 2){
                        measurement = 'cm';
                    }
                    return row.desired_height +' '+ measurement;
                }},
                {data: 'desired_width', name: 'desired_width',orderable: false,render:function(data,type,row){
                    var measurement = '';
                    if(row.measurement == 1){
                        measurement = 'in';
                    }else if(row.measurement == 2){
                        measurement = 'cm';
                    }
                    return row.desired_width +' '+ measurement;
                }},
                {data: 'amount', name: 'amount',orderable: false,render:function(data,type,row){
                    return '$'+row.amount;
                }},
                {data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

           
    });
 
          
    //Delete Item From Shping Cart
    $('body').on('click', '.delete-item-from-shopping-cart', function() {
        var order_id = $(this).attr('order_id');
        var order_amt = $(this).attr('order_amt');
        if(order_id != '') {
            swal({
                title: "Are you sure?",
                text: "You want to delete this order from shopping cart.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28b351",
                confirmButtonText: "Yes!",
                closeOnConfirm: false,
            }, function(isConfirm) {
                if(!isConfirm) return;
                $.ajax({
                    url: `<?php echo e(route('embroiderer-cart-remove')); ?>`,
                    type: "POST",
                    data: { order_id: order_id  },
                    dataType: "Json",
                    success: function(response) {
                        swal.close();
                        toastr.options.timeOut = 2000;
                        if(response.isSucceeded) {
                              // Remove from cart
                             var cartCount = $('#cartCount').text();
                             var afterMinusOne = cartCount-1;
                             $('#cartCount').text(afterMinusOne);
                             //end remove from cart
                            var totalPrv = $('#totalAmt').html();                            
                            var freshTotal = totalPrv - order_amt;
                            $('#totalAmt').html(freshTotal); 
                            if (freshTotal == 0) { 
                               $('.proceedBtn').hide();
                            }
                            toastr.success(response.message);
                            $('.shopping-cart-wrap').DataTable().ajax.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal.close();
                        toastr.error(response.message);
                    }
                });
            });
        }
    });

   //edit form scripts

Dropzone.autoDiscover = true;
     Dropzone.options.editOrderFileUpload = {
      url: "<?php echo e(route('embroiderer-update-cart-order')); ?>",
      paramName: "file_editOrder",
      addRemoveLinks: true,
      uploadMultiple: false,  //upload multiple files
      maxFilesize: 20,  //20 mb is here the max file upload size constraint
     
      acceptedFiles: ".jpeg,.jpg,.png,.psd",
      accept: function(file) {       
      let fileReader = new FileReader();
      this.on("addedfile", function(event) {
      while (this.files.length > this.options.maxFiles) {
           this.removeFile(this.files[0]);
      }
      });
      this.on("thumbnail", function(file, dataUrl) {
             $('#dz-preview-editOrder').html('<img src="'+dataUrl+'" alt="">');
              $('.file-name').text(file.name);
              $('#order_name4').val(file.name);   
          });
      fileReader.readAsDataURL(file);
      fileReader.onloadend = function() {   
          //$('#userNav').hide("slide", {direction: "left" }, 1000);
          
          // $('.sidebar-mini').css('overflow', 'hidden');
           //$('#edit_order').modal('toggle');     
           //$('.slideModel4').show("slide", { direction: "right" }, 2000);  
              $('#edit_order').modal({
                backdrop: 'static',
                keyboard: false
             }).show("slide", { direction: "right",  backdrop: 'static' }, 2000);     
          
          let content = fileReader.result;         
          $('#file_editOrder').val(content);
          file.previewElement.classList.add("dz-success");      }
      file.previewElement.classList.add("dz-complete");
     }, 
       maxFiles: 1,
      autoProcessQueue: false
  } 
$('.slideclose4').on('click', function(e){
    var myDropzone = Dropzone.forElement("#editOrderFileUpload");
      myDropzone.removeAllFiles(); 
      $('.sidebar-mini').css('overflow', 'scroll');       
      $('#drop_zone4 .dz-clickable').trigger('click');
      $('.slideModel4 ').trigger('click');
    
  });
  $(".modelcloseCnfrm1").on('click', function(){
  swal({   
                title: "Are you sure?", 
                text: "You want to close", 
                type: "warning",  
                showCancelButton: true,  
                confirmButtonColor: "#28b351", 
                confirmButtonText: "Yes!",   
                closeOnConfirm: false   
            }, 
            function (isConfirm) { 
        if (!isConfirm) {
          return;
        }
        $('#edit_order').modal('toggle');
        swal.close();
        $(".modal-backdrop").hide(); 
        $(".invalid-feedback").hide(); 
        $('.is-invalid').removeClass('is-invalid'); 
        $("#edit_order_form")[0].reset(); 
        var myDropzone = Dropzone.forElement("#editOrderFileUpload");
            myDropzone.removeAllFiles();          
             $('.sidebar-mini').css('overflow', 'hidden');
            });
});



 
  // $('#edit_order').on('hidden.bs.modal', function () {
  //    var myDropzone = Dropzone.forElement("#editOrderFileUpload");
  //     myDropzone.removeAllFiles(); 
  //     $('.sidebar-mini').css('overflow', 'scroll');
  //    //  $('#edit_order').modal('hide');
  // })
  $("#popup4").click(function() {
    $('#edit_order').modal('hide');
    //showPopup2 = true;
});
   $(document).ready(function(){       
        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, 'File size must be less than {0}');
         $("#edit_order_form").validate({
            submitHandler: function(form,e) {
               e.preventDefault();               
              // let's select and cache all the fields
             var $inputs = $(form).find("input, select, button, textarea");
             // serialize the data in the form
             var serializedData = $(form).serialize();      
            // $inputs.prop("disabled", true);  
             $('.spinner').show();              
              $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('embroiderer-update-cart-order')); ?>",
                    data: serializedData,
                    dataType: "json",
                    success: function(res) {                 
                         if(res.isSucceeded){                          
                         if(res.redirect == 'instant_cart') {                         
                             window.location.href = "/backend/embroiderer/cart";
                             }else{

                               window.location.href = "/backend/embroiderer/checkout-payment";
                             } 
                             $('.spinner').hide();

                         }else{

                         }
                    },
                    error: function (jqXHR, exception) {

                    }
              });

            },
            rules: {                 
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
                
                // order_message:{
                //     required: true,
                // },
                 
                desired_output:{
                    required:true
                }
            },
            messages: {
                order_name: {
                    required:"Please enter order name",
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
                  
                // order_message:{
                //     required: "Please enter your desired message"
                // },
                desired_output:{
                    required: "Please select the File Type"
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
         
    }); 


   $(document).ready(function(){
    $('#cmlabel2555').on('click',function(){
      console.log('in');
         $('#cm3').prop('checked', true); 
         $('#in3').prop('checked', false);
         $('#in13').prop('checked', false);          
         $('#cm3').attr('value', '2');  
         $('#cm13').attr('value', '2');  
         $('#in3').attr('value', '');  
         $('#in13').attr('value', '');

         $('#cost_calculate_span3').text("<?php echo $shareData['centimeter'];?>");   
         $('#persquare3').text('cm');

    });
    $('#cmlabeleditOrder').on('click',function(){
         $('#cm13').prop('checked', true); 
         $('#in3').prop('checked', false);
         $('#in13').prop('checked', false);
         $('#cm3').attr('value', '2');  
         $('#cm13').attr('value', '2');  
         $('#in3').attr('value', '');  
         $('#in13').attr('value', '');

         $('#cost_calculate_span3').text("<?php echo $shareData['centimeter'];?>");   
         $('#persquare3').text('cm');

 
    });
    $('#inchlabel2555').on('click',function(){
         $('#in3').prop('checked', true); 
         $('#cm3').prop('checked', false);
         $('#cm13').prop('checked', false);
         $('#cm3').attr('value', '');  
         $('#cm13').attr('value', '');  
         $('#in3').attr('value', '1');  
         $('#in13').attr('value', '1');

         $('#cost_calculate_span3').text("<?php echo $shareData['inch'];?>");   
         $('#persquare3').text('inch');
 
    });
    $('#inchlabeleditOrder').on('click',function(){
         $('#in13').prop('checked', true); 
         $('#cm3').prop('checked', false);
         $('#cm13').prop('checked', false);
         $('#cm3').attr('value', '');  
         $('#cm13').attr('value', '');  
         $('#in3').attr('value', '1');  
         $('#in13').attr('value', '1');

         $('#cost_calculate_span3').text("<?php echo $shareData['inch'];?>");   
         $('#persquare3').text('inch');
 
    });

});   
   $('.pri-cal4').bind('keyup mouseup onchange click', function(e) {      
        var height , width , valActual = 0;
        var measurement_inch_and_width = '1'; 
        var priceInch = "<?php echo $shareData['inch'];?>"; 
        var priceCentimeter ="<?php echo $shareData['centimeter'];?>";
       
        height = $('#desired_height_editOrder').val();
        width = $('#desired_width_editOrder').val();
        inch = $("input[name=height_in]:checked").val();
        cm = $("input[name=width_cm]:checked").val();
        var persquare='';
         if(inch == 1){ 
          measurement_inch_and_width = 1 ; 
          persquare='inch';
         }
         if(cm == 2){ 
           measurement_inch_and_width = 2 ;       
           persquare='cm';       
         }           
        if(height && width && measurement_inch_and_width){
            if(measurement_inch_and_width == '1'){
                valActual = height*width*priceInch;
                valActual =  valActual.toFixed(2);
                $('#cost_calculate_editOrder').val(valActual);  
            }else if(measurement_inch_and_width == '2'){
                valActual = height*width*priceCentimeter;
                valActual =  valActual.toFixed(2);
                $('#cost_calculate_editOrder').val(valActual);    
            }            
        }
    });
      
      //Edit Cart Order 
      $('body').on('click','.action_order',function(){
       var order_id = $(this).attr('order_id');        
        if($(this).attr('act-name') == 'edit-order'){  
             $.ajax({
                    url: `<?php echo e(route('embroiderer-get-cart-order')); ?>`,
                    type: "POST",
                    data: { order_id: order_id  },
                    dataType: "Json",
                    success: function(response) {  
                    console.log(response.orders.garment_id); 
                    $("#garment_id_editOrder").val(response.orders.garment_id); 
                    $('#order_name4').val(response.orders.feature_image);                    
                     
                    if(response.orders.measurement==1){
                        $('#in3').prop('checked', true); 
                        $('#in13').prop('checked', true); 
                        $('#cm3').prop('checked', false);
                        $('#cm13').prop('checked', false);
                        $('#cost_calculate_span3').text("<?php echo $shareData['inch'];?>");   
                        $('#persquare3').text('inch');
                    }else{
                        $('#in3').prop('checked', false); 
                        $('#in13').prop('checked', false); 
                        $('#cm3').prop('checked', true);
                        $('#cm13').prop('checked', true);
                        $('#cost_calculate_span3').text("<?php echo $shareData['centimeter'];?>");   
                        $('#persquare3').text('cm');
                    }                    
                    $("#desired_height_editOrder").val(response.orders.desired_height);                    
                    $("#desired_width_editOrder").val(response.orders.desired_width);                    
                    $("#cost_calculate_editOrder").val(response.orders.amount);                    
                    $("#edit_order_message").val(response.orders.order_message);                       
                    $('#dz-preview-editOrder').html('<img src="'+HOST_URL+'/public/orders/'+response.orders.feature_image+'")}}"  alt="">');               
                    $("#showing_edit_order_image").text(response.orders.feature_image);                    
                    $("#editOrder_id").val(response.orders.id);                    
                    $('#edit_order').modal({
                            backdrop: 'static',
                            keyboard: false
                         }).show("slide", { direction: "right",  backdrop: 'static' }, 2000); 
                    },
                    error: function(xhr, ajaxOptions, thrownError) {                      
                        toastr.error(response.message);
                    }
                });        
          
         }  
               
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/punchly/backend/resources/views/embroiderer/cart.blade.php ENDPATH**/ ?>