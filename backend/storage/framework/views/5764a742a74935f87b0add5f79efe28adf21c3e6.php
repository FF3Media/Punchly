

<?php $__env->startSection('content'); ?>

    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid admin-table-container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Coupon List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo e(route('admin-dashboard')); ?>">Dashboard</a></li>
              <li class="breadcrumb-item active">Coupon List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid admin-table-container">
        <?php if(session()->has('success')): ?>
          <div class="alert alert-success ad-cou-list-pa" style="text-align: left;">
              <?php echo e(session()->get('success')); ?>

          </div>
          <script type="text/javascript">setTimeout(function(){ $('.ad-cou-list-pa').fadeOut(); }, 3000);</script>
        <?php elseif(session()->has('failure')): ?>
          <div class="alert alert-danger" style="text-align: left;">
              <?php echo e(session()->get('failure')); ?>

          </div>
          <script type="text/javascript">setTimeout(function(){ $('.ad-cou-list-pa').fadeOut(); }, 3000);</script>
        <?php endif; ?>
        <div class="row">
          <div  class="col-md-4">
          </div>
          <div class="col-md-8">
            <div style="width: 100%;text-align: right;">
              <a  style="float: right;margin-bottom: 10px;" href="<?php echo e(route('admin-coupon-form')); ?>" class="btn btn-primary create-new-coupon"><i class="fas fa-receipt"></i> Create New Coupon</a>
            </div>
          </div>
        </div>
        <div class="modal fade" id="modal-info">
          <div class="modal-dialog">
            <form id="delete-coupon-form" action="" method="post">
            <div class="modal-content" id="modelChange">
              <div class="modal-header">
                <h4 class="modal-title">Info Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <p id="cnt-modal"></p>
                <span id="dynInput"></span>
                <?php echo csrf_field(); ?>
                <input type="hidden" name="couponId" value="" id="couponId">                
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary btn-outline-light"data-dismiss="modal" onclick="formSubmit()">Yes</button>
              </div>
            </div>
            </form>

            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-custom">
             
              <!-- /.card-header -->
                <!-- <div class="card-body"> -->
                <div class="card-body table-responsive custom-responsive">
                  <div class="table-responsive">
                <table class="table table-head-fixed subscriptionTable data-table">
                  <thead>
                    <tr>
                     <!--  <th>Sr.No</th> -->
                      <th>Name</th>
                      <th>Coupon</th>
                      <th>Description</th>
                      <th><span class="couponType">'%' or 'Amount'</span></th>
                      <th>Currency</th>
                      <th>Start Date</th>  
                       <th>End Date</th> 
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            </div>
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('third_party_scripts'); ?>
<script type="text/javascript">
$(document).ready(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?php echo e(route('admin-coupons-list')); ?>",
        columns: [
            // {data: 'DT_RowIndex',name:'DT_RowIndex'},
            {data: 'name',name:'name'},
            {data: 'coupon_id',name:'coupon_id'},
            {data: 'description',name:'description'},
            {data: 'coupon_type',name:'coupon_type','orderable': false,render: function ( data, type, row ) {
                return row.amount_off === null ? row.percent_off+'%' : '$'+row.amount_off
            }},
            {data: 'currency',name:'currency',render: function ( data, type, row ) {
                return row.currency === null ? 'Null' : row.currency.toUpperCase()
            }},
            {data: 'start_date',name:'start_date'},
            {data: 'end_date',name:'end_date'},
            // {data: 'duration_in_months',name:'duration_in_months',render: function ( data, type, row ) {
            //     return row.duration_in_months === null ? 0 : row.duration_in_months
            // }},
            // {data: 'times_redeemed',name:'times_redeemed'},
            // {data: 'max_redemptions',name:'max_redemptions'},
            // {data: 'valid',name:'valid',render: function ( data, type, row ) {
            //     return row.valid == 1 ? '<span style="color:green;font-weight: 600;cursor: auto !important;">Valid</span>' : '<span style="color:red;font-weight: 600;cursor: auto !important;">Invalid</span>'
            // }},
            {'className': ' last_btn-td more-sctions-td',data: 'action', first_name: 'action', orderable: false, searchable: false},
        ]
    });
});

$(document).on("click",".action-coup-btn",function(){
    var url = '';
    var title = '';
    var cnt_modal = '';
    var pub_val = '';
    if($(this).attr('act-name') == 'del'){
      url = '<?php echo e(route("admin-delete-coupon")); ?>';
      title = 'Delete Coupon';
      cnt_modal = 'Are you sure to delete this coupon permanently?';  
     // $('#modelChange').removeClass('bg-danger bg-info').addClass('bg-danger');
    }else if($(this).attr('act-name') == 'pub'){
      url = '<?php echo e(route("admin-publish-coupon")); ?>';
      pub_val = $(this).attr('pub-val');
      if(pub_val == '0'){
        title = 'Publish Coupon';
        cnt_modal = 'Are you sure to publish this coupon?';  
       // $('#modelChange').removeClass('bg-danger bg-info').addClass('bg-danger');
      }else if(pub_val == '1'){
        cnt_modal = 'Are you sure to unpublish this coupon permanently?';  
        title = 'Unpublish Coupon';
        //$('#modelChange').removeClass('bg-danger bg-info').addClass('bg-info');
      }
      $('#dynInput').html('<input type="hidden" name="publish" value="'+pub_val+'">');
    }
    $('.modal-title').html(title);   
    $("#delete-coupon-form").attr('action', url);
    $('#cnt-modal').html(cnt_modal);
    $('#couponId').val($(this).attr('cp-id'));
  });

function formSubmit(){
  $("#delete-coupon-form").submit();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/punchly/backend/resources/views/admin/coupons/couponsList.blade.php ENDPATH**/ ?>