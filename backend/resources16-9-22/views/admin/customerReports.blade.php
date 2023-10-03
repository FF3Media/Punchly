{{-- Extends layout --}}
@extends('layouts.app')
{{-- Content --}}
@section('content')
<style type="text/css">
	.dataTables_wrapper .dataTable th:before {content:none !important;}
	.dataTables_wrapper .dataTable th:after {content:none !important;}
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">

<div class="container-fluid admin-table-container">

<div class="row">
							<div class="col-sm-6">
							    <h3 class="card-label">Customer Reports</h3>
						    </div>
						    <div class="col-sm-6">
						        {{-- <a href="{{ route('admin-user-form') }}" class="btn_sec_all"><i class="fas fa-user"></i> Add User</a> --}}
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
					<table class="table yajra-datatable scrolltbl" id="customer-report-table" style="margin-top: 13px !important">
						<thead>
							<tr> 
								<th>Client First Name</th>
								<th>Client Last Name</th>
								<th>Email</th>							
                				<th>Country</th>
								<th>State</th>
								<th>City</th>
								<th>Number of orders</th>
								<th>Sales Total</th>
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
@endsection
{{-- Scripts Section --}}
@section('third_party_scripts')
<script type="text/javascript">
	$.ajaxSetup({   headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  } });
	var old_user_img = ''; 	
  	$(document).ready(function(){
  		var table = $('#customer-report-table').DataTable({
			dom: 'Bf'+'<"scroll_section"t>'+'rip',
			buttons: [
				{ extend: 'csv', text: 'Export CSV', 'className': 'btn btn-success', 'filename': 'customer_report' }
			],
	        processing: true,
	        serverSide: true,
	        ajax: "{{ route('customer-reports') }}",
	        columns: [				
				{data: 'first_name', name: 'first_name'},
				{data: 'last_name', name: 'last_name'},
	            {data: 'email', name: 'email'},
              	// {data: 'created_at', name: 'created_at'},
              	{data: 'country', name: 'country'},
				{data: 'state', name: 'state'},
				{data: 'city', name: 'city'},
	            {data: 'total_orders', name: 'total_orders'},
	            {data: 'total_spent',name: 'total_spent' ,render:function(data, type, row){ 
	                if(row.total_spent != ''){
                     return '$'+row.total_spent;
	                }       
	            }},
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
			 			if(data.isSuccess){
			 		 		swal.close();
			 		 		$('.customer-report-table').DataTable().ajax.reload();
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
			 		 		$('.customer-report-table').DataTable().ajax.reload();
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
	 		 		$('.customer-report-table').DataTable().ajax.reload();
	 			}else{
           			toastr.error(data.message);
	 			}           
			}
	 	});
  	}
  	
</script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script> 


@endsection