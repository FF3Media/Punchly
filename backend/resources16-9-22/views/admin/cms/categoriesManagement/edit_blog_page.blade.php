{{-- Extends layout --}}
@extends('layouts.app')
<!-- <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script> -->
{{-- Content --}}
@section('content')
<div class="row">
	 @if(session()->has('success'))
            <div class="alert alert-success alluser-page-suc" style="text-align: left;float: left;width: 100%;">
                {{ session()->get('success') }}
            </div>
            <script type="text/javascript">setTimeout(function(){ $('.alluser-page-suc').fadeOut(); }, 3000);</script>
        @elseif(session()->has('failure'))
            <div class="alert alert-danger alluser-page-suc" style="text-align: left; left;float: left;width: 100%;">
                {{ session()->get('failure') }}
            </div>
            <script type="text/javascript">setTimeout(function(){ $('.alluser-page-suc').fadeOut(); }, 3000);</script>
        @endif
   
</div>
@include('admin.cms.categoriesManagement.blog_categories_list')
@endsection
{{-- Scripts Section --}}
@section('third_party_scripts')
<script type="text/javascript">
$(document).ready(function () {
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
	$('#page-privacy-policy').validate({
		ignore: [],
		submitHandler: function(form) {
		  // do other things for a valid form
		  form.submit();
		},
	    rules: {
		    page_slug: {
		    	required: true
		    },
		    page_meta: {
		    	required: true,
		    },
		    page_title:{
	          	required: true,
	        },
	        page_description:{
	          	required: true
	        },
	        page_content:{
                required: function() {
                 	CKEDITOR.instances.page_content.updateElement();
                },
                minlength:10
            }
	    },
	    messages: {
	    	page_slug: {
	    		required: "Please enter a page slug",
	      	},	
        	page_description: {	        		
          		required : "Please enter a page description",
        	},
        	page_title: {
          		required : "Please enter a page title",
       		},
        	page_meta: {
          		required : "Please enter page meta",
        	},
	        page_content:{
                required:"Please enter content here",
                minlength:"Please enter 10 characters"
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

	$("#add-blog-category-form").validate({
		submitHandler: function(form) {

		  // do other things for a valid form
		  //form.submit();
		},
            rules: {
                name:{
                  required: true,
                  minlength:3
                }, 
                
            }
           
        });



      $("body").on('click', '#add-blog-cat-button', function() {
        		if($("#add-blog-category-form").valid())
    	{
    		let myForm = document.getElementById('add-blog-category-form');
    		myForm.submit();
    	}
    });
 

       var table = $('.yajra-datatable').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: "{{ route('admin-blog-categories-list') }}",
	        columns: [
	            
	            {data: 'name', name: 'name'},
	            {

	                data: 'action', 
	                name: 'action', 
	                orderable: false, 
	                searchable: true
	            },
	        ],
	        order: [[1, 'asc']]
	    });

        $(document).on("click",".action-blog-edit-btn",function(){
		    var url = '',title = '', cnt_modal = '', pub_val = '';
		    if($(this).attr('act-name') == 'edit-blog-cat' && $(this).attr('blog-cat-id')!=0){
		      	title = 'Update Blog Category';
		    }
		    else{
		    		title = 'Add Blog Category';
		    }
		    $('#name').val($(this).attr('page-name'));
		    $('.modal-title').html(title);   
		    $('#blog_cat_id').val($(this).attr('blog-cat-id'));
		   
		});
		$(document).on("click",".action-blog-cat-delete-btn",function(){
		    var blog_cat_id=$(this).attr('blog-cat-id');
        swal({
            title: "Are you sure?",
            text: "You want to delete this Category.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            closeOnConfirm: false
            },
            function (isConfirm) {
            if (!isConfirm) return;
            $.ajax({
            url: `{{ route("admin-delete-blog-category") }}`,
            type: "POST",
            data: { blog_cat_id : blog_cat_id},
            dataType: "Json",
            success: function (data) {
            toastr.options.timeOut = 1500;
            if(data.isSucceeded){
            swal.close();
            toastr.success(data.message);
            $('.yajra-datatable').DataTable().ajax.reload();
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
});


 function duplicateslug(element){
           var name = $(element).val(); 
         if (name.length > 3) {   
         	 
          $.ajax({
            type: "POST",
            url: "{{ route('admin-cat-slug-checking') }}",
            data: {name:name},
            dataType: "json",
            success: function(res) {            	 
                if(res == 1){
                    $('.errorslug').text('Already Exists');
                    $('#add-blog-cat-button').attr("disabled", true);;
                }else{
                	$('.errorslug').text(' ');
                	$('#add-blog-cat-button').removeAttr('disabled');
                } 
            },
            error: function (jqXHR, exception) {

            }
        });
      }
    }

</script>
@endsection