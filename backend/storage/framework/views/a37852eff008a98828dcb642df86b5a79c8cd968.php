 
<div class="row">
    <div class="col-lg-12">
    	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
			     
		 <div class="section-heading-home text-center">
         <div class="container-fluid admin-table-container">
          <div class="row mb-2">
          <div class="col-sm-6">
            <h3 class="card-label">List of Blog Categories</h3>
          </div>
          <div class="col-sm-6">
            <button type="button" class="btn btn-sm btn-primary float-right   action-blog-edit-btn"  blog-cat-id="" page-name="" act-name="edit-blog-cat" data-toggle="modal" data-target="#add-bog-cat-modal" data-id="0">Add New Category</button>
          </div>
        </div>
        </div>
                   </div>

        <div class="container-fluid admin-table-container">
		<div class="row mb-2">
		<div class="col-sm-12">
		<div class="card card-custom">
			
			<div class="card-body">
				
				<!--begin: Datatable-->
				<div class="table-responsive">
				<table class="table yajra-datatable blog-cat-adm" style="margin-top: 13px !important">
					<thead>
						<tr>
							<th>Name</th>
							<th>Actions</th>
						</tr>
					</thead>
				</table>
			</div>
				<!--end: Datatable-->
				<!-- /.modal -->
			    <div class="modal fade" id="add-bog-cat-modal">
			        <div class="modal-dialog">
			            <form id="add-blog-category-form" action="<?php echo e(route('admin-add-blog-category')); ?>" method="post" enctype="multipart/form-data">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <h4 class="modal-title scout-title">Add New Category</h4>
			                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                        <span aria-hidden="true">&times;</span></button>
			                    </div>
			                    <div class="modal-body">
			                       
			                        <?php echo csrf_field(); ?>
			                        <div class="form-group">
			                        <label>Name</label>
			                        <input type="text" onkeyup="duplicateslug(this)" autocomplete="off"  name="name" value="" id="name">
			                        <span style="color:red;" class="errorslug"></span>
			                        <input type="hidden" name="blog_cat_id" id="blog_cat_id" value="">
			                    	</div>
			                    	
			                    </div>
			                    <div class="modal-footer justify-content-between">
			                        <button type="button" class="btn btn-outline-light btn-secondary" data-dismiss="modal">Cancel</button>
			                        <button type="submit" class="btn btn-primary " id="add-blog-cat-button">Submit</button>
			                    </div>
			                </div>
			            </form>
			        </div>
			    </div>
			    <!-- /.modal -->
			</div>
		</div>

	</div>

	</div>

</div>


		<!--end::Card-->
    </div>
</div>
 <?php /**PATH /var/www/punchly/backend/resources/views/admin/cms/categoriesManagement/blog_categories_list.blade.php ENDPATH**/ ?>