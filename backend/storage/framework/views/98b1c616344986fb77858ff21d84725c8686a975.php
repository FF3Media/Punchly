
 <!--   Right Slide Model -->
<div class="modal fade new-order-slide slideModel3" style="padding-right:0px;" id="reLoadOrder" tabindex="-1" role="dialog" aria-labelledby="newCreateOrder" aria-hidden="true">

  <div class="modal-dialog modal-dialog-slideout" role="document">
    <form id="reLoad_order" method="post" action="" enctype="multipart/form-data" class="new-order-form">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Re Order <span class="file-name"></span></h5>
        <div class="model-right">
       <!--  <a class="upload-another">Upload another file</a> -->
        <a href="#" type="button" class="slideclose3 upload-another" id="popup3" aria-label="Close">
         <!--  <span aria-hidden="true">×</span> -->
          Upload new file
        </a>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
    </div>

    <div id="loading-bar-spinner" class="spinner" style="display: none;">
                                        <div class="spinner-icon"></div>
                                    </div>
      </div>

      <div class="modal-body">

        <div id="dz-preview-reorder"></div>
       <div  style="display: none;"  class="drobzonefiles">
                            <div class="col-lg-12 my-3">
                                    <div class="drop-browse-div">
                                        <div id='drop_zone3'>
                                            <?php echo csrf_field(); ?>
                                            <!-- You can add extra form fields here -->
                                            <input hidden id="file_reorder" name="file"/>
                                            <!-- You can add extra form fields here -->
                                            <div class="dropzone dropzone-file-area" id="reorderFileUpload">
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
        <input type="hidden" id="order_name3" name="order_name" value="" class="form-control" />
        <input type="hidden" id="reorder_id" name="reorder_id" value="" class="form-control" />
        <div class="row">
        <div class="col my-error">
            <label>Desired output</label>
            <select name="desired_output" id="desired_output_reorder" class="form-control minimal-select">
            <option value="">Select</option>
            <option value="for_embroidery_files">Embroidery files (DST, EMB)</option>
        </select>
        </div>
        <div class="col my-error">
          <label>Garment type</label>
            <select name="garment_id" id="garment_id_reorder" class="form-control minimal-select">
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
            <input  type="number" id="desired_height_reorder" onKeyPress="if(this.value.length==4) return false;" class="pri-cal3" name="desired_height">
            <div class="radio-btns">
              <p><input type="radio" id="in3" class="pri-cal3" name="height_in" value="1" checked><label id="inchlabelReorder"  for="in3">in</label></p>
              <p><input type="radio" id="cm3" class="pri-cal3"  name="height_cm" value="2" ><label id="cmlabelReorder"   for="cm3">cm</label></p>
            </div>
          </div>

        <div class="col my-error">
          <label>Desired width</label>
            <input type="number" id="desired_width_reorder" onKeyPress="if(this.value.length==4) return false;" class="pri-cal3" name="desired_width">
            <div class="radio-btns">
              <p><input type="radio" id="in13" class="pri-cal3" name="width_in" value="1" checked><label id="inchlabel2555" for="in13">in</label></p>
              <p><input type="radio" id="cm13" class="pri-cal3" name="width_cm" value="2" ><label id="cmlabel2555" for="cm13">cm</label></p>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col cost-detail-heading my-error">
        <h4><span class="dark-text">Cost:</span> $<span id='cost_calculate_span2'>X</span> per square <span id='persquare2'>inch/cm</span></h4>
           <input type="text" id="cost_calculate_reorder" name="cost_calculate" value="0" class="form-control" readonly="" />
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
        <button type="submit" class="gray-btn sky-blue" name="clickbtn" value="instant_cart" id="add-reorder-order" >Add to cart</button>
        <button type="submit" class="gray-btn" name="clickbtn" value="instant_checkout" >Instant checkout</button>

      </div>

    </div>
    </form>
  </div>

 </div>
  <script type="text/javascript">

     Dropzone.autoDiscover = true;
     Dropzone.options.reorderFileUpload = {
      url: "<?php echo e(route('embroiderer-reorder')); ?>",
      paramName: "file_reorder",
      addRemoveLinks: true,
      uploadMultiple: false,  //upload multiple files
      maxFilesize: 20,  //20 mb is here the max file upload size constraint

      acceptedFiles: ".jpeg,.jpg,.png,.psd",
      accept: function(file) {
      console.log(file,'test file url')
                            let fileReader = new FileReader();
                            fileReader.onload = (event) => { 
                               
                                $('#dz-preview-reorder').html('<img src="' + event.target.result + '"   alt="">');
                            }
      this.on("addedfile", function(event) {
      while (this.files.length > this.options.maxFiles) {
           this.removeFile(this.files[0]);
      }
      });
      this.on("thumbnail", function(file, dataUrl) {

            console.log(file,'test file url')
                            let fileReader = new FileReader();
                            fileReader.onload = (event) => { 
 
                                $('#dz-preview-reorder').html('<img src="' + event.target.result + '"   alt="">');
                            }
              $('.file-name').text(file.name);
              $('#order_name3').val(file.name);
          });
      fileReader.readAsDataURL(file);
      fileReader.onloadend = function() {
          //$('#userNav').hide("slide", {direction: "left" }, 1000);

           $('.sidebar-mini').css('overflow', 'hidden');
           $('#reLoadOrder').modal('toggle');
           $('.slideModel3').show("slide", { direction: "right" }, 2000);

          let content = fileReader.result;
          $('#file_reorder').val(content);
          file.previewElement.classList.add("dz-success");
      }
      file.previewElement.classList.add("dz-complete");
     },
       maxFiles: 1,
      autoProcessQueue: false
  }
$('.slideclose3').on('click', function(e){
    var myDropzone = Dropzone.forElement("#reorderFileUpload");
      myDropzone.removeAllFiles();
      $('.sidebar-mini').css('overflow', 'scroll');
      $('#drop_zone3 .dz-clickable').trigger('click');
      $('.slideModel3 ').trigger('click');

  });

  $('#reLoadOrder').on('hidden.bs.modal', function () {
     var myDropzone = Dropzone.forElement("#reorderFileUpload");
      myDropzone.removeAllFiles();
      $('.sidebar-mini').css('overflow', 'scroll');
     //  $('#reLoadOrder').modal('hide');
  })
  $("#popup3").click(function() {
    $('#reLoadOrder').modal('hide');
    //showPopup2 = true;
});
   $(document).ready(function(){
        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, 'File size must be less than {0}');
         $("#reLoad_order").validate({
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
                    url: "<?php echo e(route('embroiderer-reorder')); ?>",
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
    $('#cmlabel2555').on('click',function(){
      console.log('in');
         $('#cm3').prop('checked', true);
         $('#in3').prop('checked', false);
         $('#in13').prop('checked', false);
         $('#cm3').attr('value', '2');
         $('#cm13').attr('value', '2');
         $('#in3').attr('value', '');
         $('#in13').attr('value', '');
    });
    $('#cmlabelReorder').on('click',function(){
         $('#cm13').prop('checked', true);
         $('#in3').prop('checked', false);
         $('#in13').prop('checked', false);
         $('#cm3').attr('value', '2');
         $('#cm13').attr('value', '2');
         $('#in3').attr('value', '');
         $('#in13').attr('value', '');

    });
    $('#inchlabel2555').on('click',function(){
         $('#in3').prop('checked', true);
         $('#cm3').prop('checked', false);
         $('#cm13').prop('checked', false);
         $('#cm3').attr('value', '');
         $('#cm13').attr('value', '');
         $('#in3').attr('value', '1');
         $('#in13').attr('value', '1');

    });
    $('#inchlabelReorder').on('click',function(){
         $('#in13').prop('checked', true);
         $('#cm3').prop('checked', false);
         $('#cm13').prop('checked', false);
         $('#cm3').attr('value', '');
         $('#cm13').attr('value', '');
         $('#in3').attr('value', '1');
         $('#in13').attr('value', '1');

    });

});
   $('.pri-cal3').bind('keyup mouseup onchange click', function(e) {
        var height , width , valActual = 0;
        var measurement_inch_and_width = '1';
        var priceInch = "<?php echo isset($shareData) ? $shareData['inch'] : '';?>";
        var priceCentimeter ="<?php echo isset($shareData) ? $shareData['centimeter'] : '';?>";

        height = $('#desired_height_reorder').val();
        width = $('#desired_width_reorder').val();
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
                $('#cost_calculate_reorder').val(valActual);
                $('#cost_calculate_span2').text(valActual);
                $('#persquare2').text(persquare);
            }else if(measurement_inch_and_width == '2'){
                valActual = height*width*priceCentimeter;
                valActual =  valActual.toFixed(2);
                $('#cost_calculate_reorder').val(valActual);
                $('#cost_calculate_span2').text(valActual);
                $('#persquare2').text(persquare);
            }
        }
    });

   function reloadOrderDetail(details){
   console.log(details);
      $('#desired_output_reorder').val('');
      $('#garment_id_reorder').val('');

      if(details.id){
        $('#reorder_id').val(details.id);
      }

      //Desired output
      if(details.desired_output == 'for_embroidery_files'){
      selectFromDropdown('#desired_output_reorder', 'Embroidery files (DST, EMB)')
      }
      //Garments
      if(details.garment.name){
      selectFromDropdown('#garment_id_reorder', details.garment.name)
      }
      if(details.order_name){
        $('#order_name3').val(details.feature_image);
      }
      if(details.feature_image){
       $('#dz-preview-reorder').html('<img src="'+HOST_URL+'/public/orders/'+details.feature_image+'" width="200" height="200" alt="">');
      }
      if(details.measurement){
          if(details.measurement==1){
             $('#in3').prop('checked', true);
             $('#in13').prop('checked', true);
             $('#cm3').prop('checked', false);
             $('#cm13').prop('checked', false);
          }else{
             $('#in3').prop('checked', false);
             $('#in13').prop('checked', false);
             $('#cm3').prop('checked', true);
             $('#cm13').prop('checked', true);
          }

         $('#desired_height_reorder').val(details.desired_height);
         $('#desired_width_reorder').val(details.desired_width);
         $('#cost_calculate_reorder').val(details.amount);
         $('#order_message_reorder').val(details.order_message);
      }


      $('.sidebar-mini').css('overflow', 'hidden');
      $('.slideModel3').show("slide", { direction: "right" }, 2000);
      $('#reLoadOrder').modal('toggle');

 }
 function selectFromDropdown(selector, text) {
  $(selector).find('option').each(function() {
    if ($(this).text() == text) {
      $(selector).val($(this).val());
      return false;
    }
  })
}
</script>
<?php /**PATH /var/www/punchly/backend/resources/views/embroiderer/reloadOrder.blade.php ENDPATH**/ ?>