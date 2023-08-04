



<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card card-custom custom-shadow">
			<!--begin::Form-->
			<form class="form blog-form" id="page-add-blog-form" method="post" enctype="multipart/form-data" action="<?php echo e(route('admin-add-update-blog')); ?>">
				<div class="card-body"><?php echo csrf_field(); ?>
					<input type="hidden" name="blog_id" value="<?php echo e(isset($resData) ? $resData->id : 0); ?>">
					<div class="form-group row">
						<div class="col-lg-6 my-error">
							<label>Blog Title:</label>
							<input type="text" class="form-control" value="<?php echo e(isset($resData) ? $resData->blog_title : ''); ?>" name="blog_title" id="blog_title" placeholder="Enter Blog title">
						</div>
						<div class="col-lg-6 my-error">
						<label>Blog Feature Image:</label>
						<input type="file" name="feature_image"  value="" id="feature_image" class="form-control" placeholder="Browse Image">
						<input type="hidden" id="old_img" value="<?php echo e((isset($resData) && $resData->feature_image!=null) ? $resData->feature_image : ''); ?>">
						</div>			
					</div>
					<div class="form-group row">
						<div class="col-lg-6 my-error">
							<label>Blog Category:</label>
						 <select class="form-control minimal-select" name="blog_category_id" id="blog_category_id">
	                        <option value="">Select category</option>
	                         <?php $__empty_1 = true; $__currentLoopData = $blogCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
	                            <option value="<?php echo e($cat->id); ?>" <?php echo e((isset($resData) && $resData->blog_category_id==$cat->id) ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
	                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

	                        <?php endif; ?>
	                    </select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-12 my-error">
							<label>Blog Description :</label>
							
								<textarea class="form-control" name="blog_description"  id="blog_description"><?php echo e(isset($resData) ? $resData->blog_description : ''); ?></textarea>
							
						</div>
					</div>

					<!-- <div class="form-group row">
						<div class="col-lg-12">
						<div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Blog Details Section One</h3>
                            </div>
                            <div class="card-body">
                                <div class="contact_us_content">
                                   
                                    <div class="add_banner_html">                                         
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">
                                                 
                                                <label>Heading:</label>
                                                <input type="text" name="section_one_heading" class="form-control"
                                                    value="" id="title"
                                                    placeholder="Enter heading" required>
                                            </div>
                                            <div class="col-lg-6 my-error">                                               
                                                    <label>Description:</label>                                                    
                                                    <textarea class="form-control editor" name="section_one_description" id="section_one_description"></textarea>
                                            </div>
                                                                                       
                                        </div>          
                                    </div>
                                     <div class="form-group row">                                      
                                          <div class="col-lg-6 my-error">
                                              <label>Image:</label>
                                              <div class="input-group">
                                                  <div class="custom-file">
                                                      <input type="file" name="section_one_image" value=""
                                                          id="banner_image"
                                                          class="form-control banner_image custom-file-input"
                                                          placeholder=""
                                                          accept="image/*"
                                                           />
                                                     
                                                      <label class="custom-file-label"
                                                          for="banner_image"></label>
                                                  </div>
                                              </div>
                                            </div> 
                                         
                                    </div>
                                   
                                  </div>
                                 
                                  </div>
                                  </div>
					</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-12">
						<div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Blog Details Section Two</h3>
                            </div>
                            <div class="card-body">
                                <div class="contact_us_content">
                                   
                                    <div class="add_banner_html">                                         
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">
                                                 
                                                <label>Heading:</label>
                                                <input type="text" name="section_two_heading" class="form-control"
                                                    value="" id="section_two_heading"
                                                    placeholder="Enter heading" required>
                                            </div>
                                            <div class="col-lg-6 my-error">                                               
                                                    <label>Description:</label>                                                    
                                                    <textarea class="form-control editor" name="section_two_description" id="section_two_description"></textarea>
                                            </div>
                                                                                       
                                        </div>          
                                    </div>
                                     <div class="form-group row">                                      
                                          <div class="col-lg-6 my-error">
                                              <label>Image One:</label>
                                              <div class="input-group">
                                                  <div class="custom-file">
                                                      <input type="file" name="section_two_image_one" value=""
                                                          id="section_two_image_one"
                                                          class="form-control banner_image custom-file-input"
                                                          placeholder=""
                                                          accept="image/*"
                                                           />
                                                     
                                                      <label class="custom-file-label"
                                                          for="section_two_image"></label>
                                                  </div>
                                              </div>
                                            </div> 
                                            <div class="col-lg-6 my-error">
                                              <label>Image Two:</label>
                                              <div class="input-group">
                                                  <div class="custom-file">
                                                      <input type="file" name="section_two_image_two" value=""
                                                          id="section_two_image_two"
                                                          class="form-control banner_image custom-file-input"
                                                          placeholder=""
                                                          accept="image/*"
                                                           />
                                                     
                                                      <label class="custom-file-label"
                                                          for="section_two_image_two"></label>
                                                  </div>
                                              </div>
                                            </div> 

                                         
                                    </div>
                                   
                                  </div>
                                 
                                  </div>
                                  </div>
					</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-12">
						<div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Blog Details Section Three</h3>
                            </div>
                            <div class="card-body">
                                <div class="contact_us_content">
                                   
                                    <div class="add_banner_html">                                         
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                                 
                                                <label>Heading:</label>
                                                <input type="text" name="section_three_heading" class="form-control"
                                                    value="" id="section_three_heading"
                                                    placeholder="Enter heading" required>
                                            </div>
                                            <div class="col-lg-6 my-error">                                               
                                                    <label>Description:</label>                                                    
                                                    <textarea class="form-control editor" name="section_three_description" id="section_three_description"></textarea>
                                            </div>
                                                                                       
                                        </div>          
                                    </div>
                                    
                                   
                                  </div>
                                 
                                  </div>
                                  </div>
					</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-12">
						<div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Blog Details Section Four</h3>
                            </div>
                            <div class="card-body">
                                <div class="contact_us_content">
                                   
                                    <div class="add_banner_html">                                         
                                        <div class="form-group row">
                                            <div class="col-lg-6 my-error">                                                 
                                                <label>Heading:</label>
                                                <input type="text" name="section_four_heading" class="form-control"
                                                    value="" id="section_four_heading"
                                                    placeholder="Enter heading" required>
                                            </div>
                                            <div class="col-lg-6 my-error">                                               
                                                    <label>Description:</label>                                                    
                                                    <textarea class="form-control editor" name="section_four_description" id="section_four_description"></textarea>
                                            </div>
                                                                                       
                                        </div> 
                                        <div class="form-group row">                                      
                                          <div class="col-lg-6 my-error">
                                              <label>Image One:</label>
                                              <div class="input-group">
                                                  <div class="custom-file">
                                                      <input type="file" name="section_four_image_one" value=""
                                                          id="section_four_image_one"
                                                          class="form-control banner_image custom-file-input"
                                                          placeholder=""
                                                          accept="image/*"
                                                           />
                                                     
                                                      <label class="custom-file-label"
                                                          for="section_four_image_one"></label>
                                                  </div>
                                              </div>
                                            </div> 
                                            <div class="col-lg-6 my-error">
                                              <label>Image Two:</label>
                                              <div class="input-group">
                                                  <div class="custom-file">
                                                      <input type="file" name="section_four_image_two" value=""
                                                          id="section_four_image_two"
                                                          class="form-control banner_image custom-file-input"
                                                          placeholder=""
                                                          accept="image/*"
                                                           />
                                                     
                                                      <label class="custom-file-label"
                                                          for="section_four_image_two"></label>
                                                  </div>
                                              </div>
                                            </div> 

                                         
                                    </div>
                                    <div class="form-group row">                                      
                                          <div class="col-lg-6 my-error">
                                              <label>Image Three:</label>
                                              <div class="input-group">
                                                  <div class="custom-file">
                                                      <input type="file" name="section_four_image_three" value=""
                                                          id="section_four_image_three"
                                                          class="form-control banner_image custom-file-input"
                                                          placeholder=""
                                                          accept="image/*"
                                                           />
                                                     
                                                      <label class="custom-file-label"
                                                          for="section_four_image_three"></label>
                                                  </div>
                                              </div>
                                            </div> 
                                            <div class="col-lg-6 my-error">
                                              <label>Image Four:</label>
                                              <div class="input-group">
                                                  <div class="custom-file">
                                                      <input type="file" name="section_four_image_four" value=""
                                                          id="section_four_image_four"
                                                          class="form-control banner_image custom-file-input"
                                                          placeholder=""
                                                          accept="image/*"
                                                           />                                                     
                                                      <label class="custom-file-label"
                                                          for="section_four_image_four"></label>
                                                  </div>
                                              </div>
                                            </div> 

                                         
                                    </div>          
                                    </div>
                                    
                                   
                                  </div>
                                 
                                  </div>
                                  </div>
							</div>
							</div> -->
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

  var editor1 = CKEDITOR.replace('blog_description', {
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


/*  $.summernote.dom.emptyPara = "";


	$('#blog_description').summernote({

    placeholder: '',
    tabsize: 2,
    height: 250,

    popover: {
  		image: [
  			['remove', ['removeMedia']]
  		],
    },

    toolbar: [
      ['font', ['bold']],
      ['para', ['ul', 'ol']],
      ['insert', ['video', 'link', 'picture']],
      ['view', ['codeview', 'help']]
    ],

    codemirror: { // codemirror options
     theme: 'monokai'
    },

	  callbacks: {
      onImageUpload : function(files, editor, welEditable) {
       	for(var i = files.length - 1; i >= 0; i--) {
          sendFile(files[i], this);
      	}
  	  }
    }

  }).on("summernote.enter", function(we, e) {
    console.log('test');
    // e.shiftKey = true;
    // var editable = layout.editable();
     document.execCommand('insertHTML', false, '<br><br>');
        // $(this).summernote('pasteHTML', '<br>');
        e.preventDefault();
  });*/

	$.validator.addMethod('filesize', function (value, element, param) {
		return this.optional(element) || (element.files[0].size <= param)
	}, 'File size must be less than {0}');
	$('#page-add-blog-form').validate({
		ignore: [],
		submitHandler: function(form) {
		  // do other things for a valid form
		  form.submit();
		},
	    rules: {
		    blog_title: {
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
		    blog_category_id:{
	          	required: true,
	        },
	        blog_description:{
                required: true,
                minlength:10
            }
	    },
	    messages: {
	    	blog_title: {
	    		required: "Please enter a blog slug",
	      	},	
        	feature_image: {	        		
          		required: "Please select the image",
                extension: "Please select jpg,jpeg and png image",
                filesize: "File size must be less than 2MB",
        	},
        	blog_category_id: {
          		required : "Please Select Blog Category",
       		},
	        blog_description:{
                required:"Please enter content here",
                minlength:"Please enter 10 characters"
            }
	    },
	     ignore: '#blog_description,.note-editor *',
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/punchly/backend/resources/views/admin/cms/blogManagement/addBlogForm.blade.php ENDPATH**/ ?>