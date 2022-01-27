<!-- Start Create Order Modal -->
      <form id="new_create_order" name='createOrderPopup' method="post" action="" enctype="multipart/form-data" class="new-order-form">
        <div class="modal fade download-modal modelwidth" id="create_new_orders" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">	  
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
                <div class="modal-body"> 
            
                            <div class="row">
                                <div class="col-lg-12 my-3">
                                    <div class="orderHeading">
                                    <h3 style="text-align: center;">Create New</h3>
                                    </div>
                                </div>
                            <div class="col-lg-12 my-3">
                                    <div class="drop-browse-div">
                                        <div id='drop_zone2'> 
                                            <?php echo csrf_field(); ?>
                                            <!-- You can add extra form fields here -->
                                            <input hidden id="file_new" name="file"/>
                                            <!-- You can add extra form fields here -->
                                            <div class="dropzone dropzone-file-area" id="newfileUpload">
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

                  
                </div>
            </div>
        <div class="modal-footer">
        </div>
        </div> 
  </div>
   <!--   Right Slide Model -->
<div class="modal fade new-order-slide slideModel2" style="padding-right:0px;" id="newCreateOrder" tabindex="-1" role="dialog" aria-labelledby="newCreateOrder" aria-hidden="true">
  <div class="modal-dialog modal-dialog-slideout" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Order <span class="file-name"></span></h5>
        <div class="model-right">
       <!--  <a class="upload-another">Upload another file</a> -->
        <a href="#" type="button" class="slideclose2 upload-another"  id="popup2" aria-label="Close">
         <!--  <span aria-hidden="true">×</span> -->
          Upload new file
        </a>
        <button type="button" class="close modelcloseCnfrm"   > <span aria-hidden="true">×</span></button>
    </div>

    <div id="loading-bar-spinner" class="spinner" style="display: none;">
                                        <div class="spinner-icon"></div>
                                    </div>
      </div>
      <div class="modal-body"> 

        <div id="dz-preview-img"></div> 
        <input type="hidden" id="order_name4" name="order_name" value="" class="form-control" />
        <div class="row">        
        <div class="col my-error">
            <label>Desired output</label>
            <select name="desired_output" id="desired_output_new" class="form-control minimal-select">
            <option value="">Select</option> 
            <option value="for_embroidery_files">Embroidery files (DST, EMB)</option>
        </select>
        </div> 
        <div class="col my-error">
          <label>Garment type</label>
            <select name="garment_id" class="form-control minimal-select">             
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
            <input  type="number" id="desired_height_new" onKeyPress="if(this.value.length==4) return false;" class="pri-cal2" name="desired_height">            
            <div class="radio-btns">              
              <p><input type="radio" id="in2" class="pri-cal2" name="height_in" value="1" checked><label id="inchlabel552"  for="in2">in</label></p>
              <p><input type="radio" id="cm2" class="pri-cal2"  name="height_cm" value="2" ><label id="cmlabel552"   for="cm2">cm</label></p>
            </div> 
          </div>

        <div class="col my-error">
          <label>Desired width</label>
            <input type="number" id="desired_width_new" onKeyPress="if(this.value.length==4) return false;" class="pri-cal2" name="desired_width">
            <div class="radio-btns">              
              <p><input type="radio" id="in12" class="pri-cal2" name="width_in" value="1" checked><label id="inchlabel2552" for="in12">in</label></p>
              <p><input type="radio" id="cm12" class="pri-cal2" name="width_cm" value="2" ><label id="cmlabel2552" for="cm12">cm</label></p>
            </div>
        </div>
      </div> 
      <div class="row">
        <div class="col cost-detail-heading my-error">
          <h4><span class="dark-text">Cost:</span> $<span id='cost_calculate_span1'><?php echo $shareData['inch'];?></span> per square <span id='persquare1'>inch</span></h4>
           <input type="text" id="cost_calculate_new" name="cost_calculate" value="0" class="form-control" readonly="" />
        </div>
      </div> 
      <div class="row">        
        <div class="col my-error">
            <label>Comments</label>
            <textarea name="order_message"  class="form-control"  rows="6" cols="50" placeholder="EX: Remove the white background"></textarea>
        </div> 
      </div>  
      </div>
      <div class="modal-footer">
        <button type="submit" class="gray-btn" name="clickbtn" value="instant_cart" id="add-new-order" >Add to cart</button>
        <button type="submit" class="gray-btn" name="clickbtn" value="instant_checkout" >Instant checkout</button>
      </div> 
      
    
    </div>
  </div>
 </div>
   </form>
  <!-- End Create Order Modal -->
  
<script type="text/javascript">
	
     Dropzone.autoDiscover = true;
     Dropzone.options.newfileUpload = {
      url: "<?php echo e(route('embroiderer-create-order')); ?>",
      paramName: "file_new",
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
        $('#dz-preview-img').html('<img src="'+dataUrl+'"   alt="">');
              
              $('.file-name').text(file.name);
              $('#order_name4').val(file.name);   
          });
      fileReader.readAsDataURL(file);
      fileReader.onloadend = function() {   
          //$('#userNav').hide("slide", {direction: "left" }, 1000);
           
          
           $('.sidebar-mini').css('overflow', 'hidden');             
         //  $('#newCreateOrder').modal('toggle');
           $("#create_new_orders").modal('hide');   
           $('.slideModel2').modal({
            backdrop: 'static',
            keyboard: false
        }).show("slide", { direction: "right",	backdrop: 'static' }, 2000);      
          
          let content = fileReader.result;         
          $('#file_new').val(content);
          file.previewElement.classList.add("dz-success");
      }
      file.previewElement.classList.add("dz-complete");
     }, 
       maxFiles: 1,
      autoProcessQueue: false
  } 
$('.slideclose2').on('click', function(e){
    var myDropzone = Dropzone.forElement("#newfileUpload");
      myDropzone.removeAllFiles(); 
      $('.sidebar-mini').css('overflow', 'scroll');       
      $('#drop_zone2 .dz-clickable').trigger('click');
      $('.slideModel2 ').trigger('click');
    
  });
$("#popup2").click(function() {
    $('#newCreateOrder').modal('hide');
    //showPopup2 = true;
});
  $('#newCreateOrder').on('hidden.bs.modal', function () {
     var myDropzone = Dropzone.forElement("#newfileUpload");
      myDropzone.removeAllFiles(); 
      $('.sidebar-mini').css('overflow', 'scroll');
  })
   $(document).ready(function(){  
     
        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, 'File size must be less than {0}');
      var validaterOrder1=  $("#new_create_order").validate({
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
                    url: "<?php echo e(route('embroiderer-create-order')); ?>",
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
         
    }); 

   $(document).ready(function(){
    $('#cmlabel2552').on('click',function(){ 
         $('#cm2').prop('checked', true); 
         $('#in2').prop('checked', false);
         $('#in12').prop('checked', false);          
         $('#cm2').attr('value', '2');  
         $('#cm12').attr('value', '2');  
         $('#in2').attr('value', '');  
         $('#in12').attr('value', '');
         $('#cost_calculate_span1').text("<?php echo $shareData['centimeter'];?>");   
         $('#persquare1').text('cm');
    });
    $('#cmlabel552').on('click',function(){ 
         $('#cm12').prop('checked', true); 
         $('#in2').prop('checked', false);
         $('#in12').prop('checked', false);
         $('#cm2').attr('value', '2');  
         $('#cm12').attr('value', '2');  
         $('#in2').attr('value', '');  
         $('#in12').attr('value', '');

         $('#cost_calculate_span1').text("<?php echo $shareData['centimeter'];?>");   
         $('#persquare1').text('cm');
 
    });
    $('#inchlabel2552').on('click',function(){ 
         $('#in2').prop('checked', true); 
         $('#cm2').prop('checked', false);
         $('#cm12').prop('checked', false);
         $('#cm2').attr('value', '');  
         $('#cm12').attr('value', '');  
         $('#in2').attr('value', '1');  
         $('#in12').attr('value', '1');

         $('#cost_calculate_span1').text("<?php echo $shareData['inch'];?>");   
         $('#persquare1').text('inch');
 
    });
    $('#inchlabel552').on('click',function(){ 
         $('#in12').prop('checked', true); 
         $('#cm2').prop('checked', false);
         $('#cm12').prop('checked', false);
         $('#cm2').attr('value', '');  
         $('#cm12').attr('value', '');  
         $('#in2').attr('value', '1');  
         $('#in12').attr('value', '1');
         $('#cost_calculate_span1').text("<?php echo $shareData['inch'];?>");   
         $('#persquare1').text('inch');   
 
    });

});  

  $(".modelcloseCnfrm").on('click', function(){
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
        $('.slideModel2').modal('toggle');
        swal.close();
        $(".modal-backdrop").hide(); 
        $(".invalid-feedback").hide(); 
        $('.is-invalid').removeClass('is-invalid'); 
        $("#new_create_order")[0].reset(); 
        var myDropzone = Dropzone.forElement("#newfileUpload");
            myDropzone.removeAllFiles(); 
            $('.sidebar-mini').css('overflow', 'scroll'); 
			});
});

   $('.pri-cal2').bind('keyup mouseup onchange click', function(e) {      
        var height , width , valActual = 0;
        var measurement_inch_and_width = '1'; 
        var priceInch = "<?php echo $shareData['inch'];?>"; 
        var priceCentimeter ="<?php echo $shareData['centimeter'];?>";
       
        height = $('#desired_height_new').val();
        width = $('#desired_width_new').val();
        inch = $("input[name=height_in]:checked").val();
        cm = $("input[name=width_cm]:checked").val(); 
         if(inch == 1){ 
          measurement_inch_and_width = 1 ; 

         }
         if(cm == 2){ 
           measurement_inch_and_width = 2 ;    
           persquare='cm';    
          persquareInchCm2=priceCentimeter; 
         }           
        if(height && width && measurement_inch_and_width){
            if(measurement_inch_and_width == '1'){
                valActual = height*width*priceInch;
                valActual =  valActual.toFixed(2);
                $('#cost_calculate_new').val(valActual);    
            }else if(measurement_inch_and_width == '2'){
                valActual = height*width*priceCentimeter;
                valActual =  valActual.toFixed(2);
                $('#cost_calculate_new').val(valActual);    
            }            
        }
    });
</script> 
<?php /**PATH /var/www/punchly/backend/resources/views/embroiderer/CreateNewOrderPopup.blade.php ENDPATH**/ ?>