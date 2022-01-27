<?php $__env->startSection('content'); ?>
<style type="text/css">
	.dataTables_wrapper .dataTable th:before {content:none !important;}
	.dataTables_wrapper .dataTable th:after {content:none !important;}
</style>

 <div class="container-fluid admin-table-container">
<div class="row mb-2">
          <div class="col-sm-6">
            <h3 class="card-label">List of services</h3>
          </div>
          <div class="col-sm-6">
            <a id="" href="<?php echo e(route('admin-service-form')); ?>" class="btn btn-sm float-right btn_sec_all"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>
          </div>
        </div>

<div class="row">
	 <?php if(session()->has('success')): ?>
            <div class="alert alert-success alluser-page-suc" style="text-align: left;float: left;width: 100%;">
                <?php echo e(session()->get('success')); ?>

            </div>
            <script type="text/javascript">setTimeout(function(){ $('.alluser-page-suc').fadeOut(); }, 3000);</script>
        <?php elseif(session()->has('failure')): ?>
            <div class="alert alert-danger alluser-page-suc" style="text-align: left; left;float: left;width: 100%;">
                <?php echo e(session()->get('failure')); ?>

            </div>
            <script type="text/javascript">setTimeout(function(){ $('.alluser-page-suc').fadeOut(); }, 3000);</script>
        <?php endif; ?>
    <div class="col-lg-12">
    	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
		<script type="text/javascript">setTimeout(function(){ jQuery('.scout-list-success').fadeOut(); }, 3000);</script>
		<div class="card card-custom">
			
			<div class="card-body">
				<!--begin: Datatable-->
				<div class="table-responsive">
				<table class="table yajra-datatable table-responsive-sm blog-list-mb" style="margin-top: 13px !important;">
					<thead>
						<tr>
							<th>ID</th>
							<th>Image</th>
							<th>Service Name</th> 
							<th>Service Slug</th> 
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('third_party_scripts'); ?>
<script type="text/javascript">
  	$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  	$(document).ready(function(){
  		var table = $('.yajra-datatable').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: "<?php echo e(route('admin-service-list')); ?>",
	        columns: [
	             {data: 'id', name: 'id'},
	            {data: 'DT_RowIndex', id: 'DT_RowIndex',orderable: false,render:function(data,type,row){	       
	            	var imagUrl = '';
	                   
	            		imagUrl = HOST_URL + '/public/pages/blogs/'+row.feature_image;
	            		return "<img src=\"" + imagUrl + "\" height=\"50\"/>";
	            	
	            		
	            	        
	            }},
	            {data: 'service_title', name: 'service_title'},
	            {data: 'service_slug', name: 'service_slug'},
	          
	            {
	                data: 'action', 
	                name: 'action', 
	                orderable: false, 
	                searchable: true
	            },
	        ],
	        order: [[1, 'asc']]
	    });
  	});
	$(document).on("click",".action-service-delete-btn",function(){
		     var service_id=$(this).attr('service-id');
        swal({
            title: "Are you sure?",
            text: "You want to delete this service.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            closeOnConfirm: false
            },
            function (isConfirm) {
            if (!isConfirm) return;
            $.ajax({
            url: `<?php echo e(route("admin-delete-service")); ?>`,
            type: "POST",
            data: { service_id : service_id},
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

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/punchly/backend/resources/views/admin/cms/serviceCategories/servicesList.blade.php ENDPATH**/ ?>