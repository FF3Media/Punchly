{{-- Extends layout --}}
@extends('layouts.app')
{{-- Content --}}
@section('content')
<style type="text/css">
	.dataTables_wrapper .dataTable th:before {content:none !important;}
	.dataTables_wrapper .dataTable th:after {content:none !important;}
</style>
<div class="container-fluid admin-table-container">

<div class="row">
							<div class="col-sm-6">
							    <h3 class="card-label">List Of Users</h3>
						    </div>
						    <div class="col-sm-6">
						        <a href="{{ route('admin-user-form') }}" class="btn_sec_all"><i class="fas fa-user"></i> Add User</a>
					        </div>
					    </div>

	<div class="row">
	    <div class="col-lg-12">
	    	<meta name="csrf-token" content="{{ csrf_token() }}" />
	       	<!--begin::Card-->
	       	@if (session('success'))
			    <div class="alert alert-success cus-msg-cls ">
			        {{ session('success') }}
			    </div>
			@elseif(session('failure'))
				<div class="alert alert-danger cus-msg-cls">
			        {{ session('failure') }}
			    </div>			    
			@endif
			<div class="card card-custom">
				
				<div class="card-body">
					<div class="table-responsive">
					<!--begin: Datatable-->
					<table class="table yajra-datatable" style="margin-top: 13px !important">
						<thead>
							<tr>
								<th>Image</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>email</th>
								<th>Role</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
					</table>
					<!--end: Datatable-->
				</div>
				</div>
			</div>
			<!--end::Card-->
	    </div>
	</div>
</div>
<!-- /.modal -->
<div class="modal fade" id="user-list-modal">
    <div class="modal-dialog">
        <form id="user-list-modal-form" action="" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title user-modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">                   
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-6 my-error">
                            <label>First Name:</label>
                            <input type="text" id="first_name" name="first_name" value="" class="form-control" placeholder="Enter first name" />
                        </div>
                        <div class="col-lg-6 my-error">
                            <label>Last Name:</label>
                            <input type="text" id="last_name" name="last_name" value="" class="form-control" placeholder="Enter last name" />
                        </div>
                    </div> 
                    <div class="form-group row">
                        <div class="col-lg-6 my-error">
                            <label>Mobile:</label>
                            <input type="text" id="mobile" name="mobile" value="" class="form-control" placeholder="Enter your mobile number" />
                        </div>
                        <div class="col-lg-6 my-error">
                            <label>Address:</label>
                            <input type="text" id="address" name="address" value="" class="form-control" placeholder="Enter your address" />
                        </div>
                    </div>
                    <div class="form-group row">
                    	<div class="col-lg-6 my-error">
                            <label>Image:</label>
                            <input type="file" id="avatar" name="avatar" class="form-control" />
                            <input type="hidden" id="u_id" name="u_id"  value="" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-outline-light" value="Submit" />
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /.modal -->
@endsection
{{-- Scripts Section --}}
@section('third_party_scripts')
<script type="text/javascript">
	$.ajaxSetup({   headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  } });
	var old_user_img = ''; 	
  	$(document).ready(function(){
  		var table = $('.yajra-datatable').DataTable({
  			// "columnDefs": [
		   //      { "targets": [1,4], "searchable": false }
		   //  ],
	        processing: true,
	        serverSide: true,
	        ajax: "{{ route('admin-users-list') }}",
	        columns: [
	            {data: 'avatar', name: 'avatar',orderable: false,render:function(data,type,row){	       
	            	var imagUrl = HOST_URL + '/public/users-image/user.png';
	            	if(row.avatar != null){
	            		if(row.avatar.indexOf("http") != -1){
		            		imagUrl = row.avatar;
		            	}else{
		            		imagUrl = HOST_URL + '/public/users-image/'+row.avatar;
		            	}
	            	}	            	
	            	return "<img src=\"" + imagUrl + "\" height=\"50\"  width=\"75\"/>";           		         
	            }},
	            {data: 'first_name', name: 'first_name'},
	            {data: 'last_name', name: 'last_name'},
	            {data: 'email', name: 'email'},
	            {data: 'user_role', name: 'user_role',render:function(data, type, row){
	            	var user_role = '';
	            	if(row.user_role == 1){
	            		user_role = 'Admin'; 
	            	}else if(row.user_role == 2){
	            		user_role = 'Digitizer Manager';
	            	}else if(row.user_role == 3){
	            		user_role = 'Digitizer';
	            	}else if(row.user_role == 4){
	            		user_role = 'Embroiderer';
	            	}
	            	return user_role;
	            }}, 
	            {data: 'status', name: 'status',orderable: false,render:function(data, type, row){ 
	            	var check = 'btn btn-danger btn-sm'; var status = 'Inactive'; var id = btoa(row.id);
	                if(row.status == 1){
                      check = 'btn btn-success btn-sm';
                      status = 'Active';
	                }
	                return `<i data-id=`+id+` data-status=`+row.status+` class="status_checks btn `+check+`">`+status+`</i>`;	        
	            }},
	            {  data: 'action',name: 'action', orderable: false, searchable: false },
	        ],
	        order: [[1, 'asc']]
	    });

  		// Code for update status
	    $(document).on('click','.status_checks',function(){
			var id = $(this).data('id');
			var status= $(this).data("status") == 1 ? 0 : 1;
			var msg = status == 0 ? 'Inactive' : 'Active';
			swal({   
				title: "Are you sure?", 
			 	text: "You want to "+msg+" this", 
			 	type: "warning",  
			 	showCancelButton: true,  
			 	confirmButtonColor: "#28b351", 
			 	confirmButtonText: "Yes!",   
			 	closeOnConfirm: false   
			}, 
			function (isConfirm) { 
				if (!isConfirm) return;
				$.ajax({
				 	url: `{{ route('admin-change-user-status') }}`,  
				 	type: "POST",  
				 	data: { id : id , status : status},         
				 	dataType: "Json", 
			 		success: function (data) {
			 			if(data.isSucceeded){
			 		 		swal.close();
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

  		//Validation form edit user
  		$.validator.addMethod('filesize', function (value, element, param) {
        	return this.optional(element) || (element.files[0].size <= param)
    	}, 'File size must be less than {0}');
	  	$("#user-list-modal-form").validate({
			submitHandler: function(form) {
	          // do other things for a valid form
	          event.preventDefault();
	          editUser(form);
	        },
	        rules: {
	            first_name: {
	                required: true
	            },
	            last_name: {
	                required: true,
	            },
	            address:{
	                required: true
	            },
	            mobile:{
	                required: true,
	                digits: true,
	                minlength: 10,
	                maxlength: 10,
	                remote: {
	                    url: `{{ route('check-mobile-exist') }}`,
	                    data: {'checkAction':'edit-user' , id : function(){
              				return $('#user-list-modal-form :input[name="u_id"]').val();
          				}},
	                    type: "post",
	                    headers: {
	                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                    }
	                },
	            },
	            avatar:{
	                required: function(){
	                    if(old_user_img != ''){
	                        return false;
	                    }else{
	                        return true;
	                    }
	                },
	                extension: "jpg,jpeg,png",
	                filesize: 2*1024*1024,
	            },
	        },
	        messages: {
	            first_name: {
	                required: "Please enter your first name",
	            },  
	            last_name: {                 
	                required : "Please enter your last name",
	            },
	            address: {
	                required : "Please enter your address",
	            },
	            mobile: {
	                required : "Please enter your mobile number",
	                remote: "This mobile number already exist"
	            },
	            avatar:{
	                required: "Please select the image",
	                extension: "Please select jpg,jpeg and png image",
	                filesize: "File size must be less than 2MB",
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

	//Edit button funct
  	$(document).on('click','.action-user-cls',function(){  		
  		var userId = $(this).attr('user-id');
  		userId = atob(userId);
  		var action = $(this).attr('action');
  		if(action == 'edit-user'){  			
	  		var userData = JSON.parse($(this).attr('user-data'));
	  		old_user_img = userData.avatar;
  			$('#user-list-modal').modal('toggle');
  			var actionUrl = `{{ route('admin-edit-user') }}`;
  			$('#user-list-modal-form').attr('action',actionUrl);
  			$('.user-modal-title').html('Edit User');
  			$('#last_name').val(userData.last_name);
  			$('#u_id').val(userData.id);
  			$('#first_name').val(userData.first_name);
  			$('#address').val(userData.address);
  			$('#mobile').val(userData.mobile);
  		}else if(action == 'delete-user'){
  			swal({   
				title: "Are you sure?", 
			 	text: "You want to delete this user.", 
			 	type: "warning",  
			 	showCancelButton: true,  
			 	confirmButtonColor: "#28b351", 
			 	confirmButtonText: "Yes!",   
			 	closeOnConfirm: false   
			},
			function (isConfirm) { 
			if (!isConfirm) return;
				$.ajax({
				 	url: `{{ route('admin-delete-user') }}`,  
				 	type: "POST",  
				 	data: { id : userId},         
				 	dataType: "Json", 
			 		success: function (data) {
			 			toastr.options.timeOut = 3000;
			 			if(data.isSuccess){
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
  		}		
  	});

  	//Ajax call for edit user
  	function editUser(form){
    	var formData = new FormData(form);
		$.ajax({
		 	url: `{{ route('admin-edit-user') }}`,  
		 	type: "POST",  
		 	data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,   
	 		success: function (data) {
	 			$('#user-list-modal').modal('toggle');
	 			toastr.options.timeOut = 1500; // 1.5s
	 			if(data.isSuccess){
	 				toastr.success(data.message);
	 		 		$('.yajra-datatable').DataTable().ajax.reload();
	 			}else{
           			toastr.error(data.message);
	 			}           
			}
	 	});
  	}
  	
</script>
@endsection