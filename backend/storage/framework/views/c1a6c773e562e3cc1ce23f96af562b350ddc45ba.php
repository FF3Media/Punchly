<?php $__env->startSection('content'); ?>
<div class="row mb-2">
          <div class="col-sm-6">
            <h3 class="card-label"><?php echo e(isset($resData) ? $resData->service_title : ''); ?></h3>
          </div>
          <div class="col-sm-6">
         
          </div>
        </div>
<div class="row">
    <div class="col-lg-12">
        <div class="card card-custom custom-shadow">
			<!--begin::Form-->
			<form class="form blog-form" id="page-add-service-form" method="post" enctype="multipart/form-data" action="<?php echo e(route('admin-add-update-service')); ?>">
				<div class="card-body"><?php echo csrf_field(); ?>

					<input type="hidden" name="service_id" value="<?php echo e(isset($resData) ? $resData->id : 0); ?>">
					<div class="form-group row">
						<div class="col-lg-6 my-error">
							<label>Title :</label>
							<input type="text" class="form-control" value="<?php echo e(isset($resData) ? $resData->service_title : ''); ?>" name="service_title" id="service_title" placeholder="Enter Service title">
						</div>
						<div class="col-lg-6 my-error">
							<label>Meta Title :</label>
							<input type="text" class="form-control" value="<?php echo e(isset($resData) ? $resData->meta_title : ''); ?>" name="meta_title" id="meta_title" placeholder="Enter meta title">
						</div> 
						<div class="col-lg-6 my-error">
							<label>Meta Tag</label>
							<input type="text" class="form-control" value="<?php echo e(isset($resData) ? $resData->meta_tag : ''); ?>" name="meta_tag" id="meta_tag" placeholder="Meta tag">
						</div>
						<div class="col-lg-6 my-error">
						<label>Meta Description</label> 
						<input type="text" class="form-control" value="<?php echo e(isset($resData) ? $resData->meta_description : ''); ?>" name="meta_description" id="meta_description" placeholder="Meta Description"> 
						</div>			
					</div> 

					<div class="form-group row">
						<div class="col-lg-6 my-error">
							<label>Services Slug:</label>
							<input type="text" class="form-control" value="<?php echo e(isset($resData) ? $resData->service_slug : ''); ?>" name="service_slug" id="service_slug" placeholder="Enter Service Slug">
						</div>
						<div class="col-lg-6 my-error">
						<label>Services Feature Image:</label>
						 <div class="custom-file">
                          <input type="file" name="feature_image"  value="" id="feature_image" class="form-control   custom-file-input" placeholder="<?php echo e((isset($resData) && $resData->feature_image!=null) ? $resData->feature_image : 'Browse Image'); ?>">         
                             <label class="custom-file-label" for="avatar_image"><?php echo e((isset($resData) && $resData->feature_image!=null) ? $resData->feature_image : 'Browse Image'); ?></label>
                             <input type="hidden" id="old_img" value="<?php echo e((isset($resData) && $resData->feature_image!=null) ? $resData->feature_image : ''); ?>">
                          </div> 
						
						
						</div>			
					</div> 
					<div class="form-group row">
						<div class="col-lg-12 my-error">
							<label>Services Description :</label>
							
								<textarea class="form-control" name="service_description"  id="service_description"><?php echo e(isset($resData) ? $resData->service_description : ''); ?></textarea>
							
						</div>
					</div>

                <div class="form-group row">
                	<div class="col-lg-6">
							<button type="submit" class="btn btn-primary mr-2">Save</button>
							
						</div>
                </div>
					  

				</div>
			</form>
			<!--end::Form-->
		</div>
	</div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('third_party_scripts'); ?>
<script src="https://cdn.ckeditor.com/4.16.0/standard-all/ckeditor.js"></script>
<script type="text/javascript">

$(document).ready(function () {
	//CKEDITOR.replace("blog_description");
	$.ajaxSetup({
        headers: {
            'X-XSRF-TOKEN': decodeURIComponent(/XSRF-Token=([^;]*)/ig.exec(document.cookie)[1])
        }
    });

  var editor1 = CKEDITOR.replace('service_description', {
    extraAllowedContent: 'div',
    height: 460,
    enterMode : CKEDITOR.ENTER_BR,
    shiftEnterMode: CKEDITOR.ENTER_P,
 
    filebrowserUploadUrl: "<?php echo e(route('ckeditor.upload', ['_token' => csrf_token() ])); ?>",
    filebrowserUploadMethod: 'form',

    // Define the toolbar groups as it is a more accessible solution.
    toolbarGroups: [{
        "name": "basicstyles",
        "groups": ["basicstyles"]
      },
      {
        "name": "links",
        "groups": ["links"]
      },
      {
        "name": "paragraph",
        "groups": ["list", "blocks"]
      },
      {
        "name": "document",
        "groups": ["mode"]
      },
      {
        "name": "insert",
        "groups": ["insert"]
      },
      {
        "name": "styles",
        "groups": ["styles"]
      },
      {
        "name": "about",
        "groups": ["about"]
      }
    ],
    // Remove the redundant buttons from toolbar groups defined above.
    removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
  });


 

	$.validator.addMethod('filesize', function (value, element, param) {
		return this.optional(element) || (element.files[0].size <= param)
	}, 'File size must be less than {0}');
	$('#page-add-service-form').validate({
		ignore: [],
		submitHandler: function(form) {
		  // do other things for a valid form
		  form.submit();
		},
	    rules: {
		    service_title: {
		    	required: true
		    },
		    feature_image: {
		    	required: function(){
                    if($("#old_img").val()!=''){
                        return false;
                    }else{
                        return true;
                    }
                },
                extension: "jpg,jpeg,png",
                filesize: 2*1024*1024,
		    }, 
            service_description:{
                required: true,
                minlength:10
            }
	    },
	    messages: {
	    	service_title: {
	    		required: "Please enter a blog slug",
	      	},	
        	feature_image: {	        		
          		required: "Please select the image",
                extension: "Please select jpg,jpeg and png image",
                filesize: "File size must be less than 2MB",
        	}, 
	        service_description:{
                required:"Please enter content here",
                minlength:"Please enter 10 characters"
            }
	    },
	     ignore: '#service_description,.note-editor *',
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
function sendFile(file, editor) {
            data = new FormData();
            data.append("file", file);
            $.ajax({
                data: data,
                type: "POST",
                url: "<?php echo e(route('admin-upload-editor-image')); ?>",
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {
                     $(editor).summernote('editor.insertImage', url, function ($image) {
               // $image.css('width', $image.width() / 2);
                $image.addClass('editor-image');
            });
                }
            });
        }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/punchly/backend/resources/views/admin/cms/serviceCategories/addServiceForm.blade.php ENDPATH**/ ?>