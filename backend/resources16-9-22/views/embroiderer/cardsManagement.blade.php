@extends('layouts.app')

@section('content')
<script src="https://js.stripe.com/v3/"></script>
<style type="text/css">
    /**
    * The CSS shown here will not be introduced in the Quickstart guide, but shows
    * how you can use CSS to style your Element's container.
    */
    .StripeElement {
    box-sizing: border-box;
    height: 40px;
    padding: 10px 12px;
    border: 1px solid transparent;
    border-radius: 4px;
    background-color: white;
    box-shadow: 0 1px 3px 0 #e6ebf1;
    -webkit-transition: box-shadow 150ms ease;
    transition: box-shadow 150ms ease;
    width: 100%;
    }
    .StripeElement--focus {
    box-shadow: 0 1px 3px 0 #cfd7df;
    }
    .StripeElement--invalid {
    border-color: green;
    }
    .StripeElement--webkit-autofill {
    background-color: #fefde5 !important;
    }
    #card-errors{
    font-size: 80%;
    color: #dc3545;
    }   
    #order_table_info{
        display: none;
    }
</style>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    @if (session('success'))
                        <div class="alert alert-success cus-msg-cls ">
                            {{ session('success') }}
                        </div>
                    @elseif(session('failure'))
                      <div class="alert alert-danger cus-msg-cls">
                            {{ session('failure') }}
                        </div>          
                    @endif
                    <!-- jquery validation -->
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon2-supermarket text-primary"></i>
                                </span>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h3 class="card-label">Card Detail</h3>
                                    </div>
                                    <div class="col-sm-6">
                                        <a href="#" id="add-card" data-toggle="modal" data-target="#paymentModal" class="btn_sec_all"><i class="fas fa-credit-card"></i> Add New Card</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <!-- <div class="card-body"> -->
                        <div class="card-body">
                            <table class="table table-bordered yajra-datatable"  id="order_table">
                                <thead>
                                    <tr>
                                        <th>Your credit and debit cards</th>
                                        <th>Expires</th>
                                        <th>Funding</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
        <!-- /.modal -->
        <div class="modal fade" id="paymentModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title user-modal-title">Add Card</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body"> 
                        <div id="loading-bar-spinner" class="spinner" style="display: none;">
                            <div class="spinner-icon"></div>
                        </div>                  
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label>
                                    <span>Card</span>
                                    <div id="card-element" class="field"></div>
                                </label>
                                <span style="color: red; text-align: center;" id="st-err"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button id="card-button" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal -->
    </section>
    <!-- /.content -->
@endsection
@section('third_party_scripts')
<script type="text/javascript">
    var editObj = {};    
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'  } });    
    var table = '';    
    var tableRowsChecked = false;    
    var tableRowsManuallyChecked = false;    
    function format ( d ) {
        var clsSet = 'default-card';
        var clsDefText = 'Set as Default'
        var showDel = 'inline-block';
        if(d.status == '1'){
            clsSet = 'no-default-card';
            clsDefText = 'Default';
            showDel = 'none';
    }
    editObj = d;
    var x = escapeHtml(JSON.stringify(d));
    return '<table class="format-table card-manage" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;width:100%;" >'+
                '<tr>'+
                    '<td class="credit-info '+clsSet+'" card_id="'+d.card_id+'"><a  href="javascript:void(0)">'+clsDefText+'</a> Payment Method</td>'+
                    '<td class=" last_btn-td more-sctions-td">'+
                        '<a href="javascript:void(0)" class="edit btn btn-danger btn-sm mb-enabl action-card-btn" style="display:'+showDel+'" card_id="'+d.card_id+'"> <i data-toggle="tooltip" data-placement="top" title="Delete" class="fa fa-trash" aria-hidden="true"></i></a>'+

                    '</td>'+
                '</tr>'+
            '</table>';
    }
    $(document).ready(function(){    
        $('.loader').show();
        table = $('#order_table').DataTable({    
            processing: true,    
            serverSide: true,
            paging:false,
            searching: false,
            order: false,
            ajax: "{{ route('embroiderer-cards-management') }}",    
            columns: [   
                  {'className': 'details-control credit-info',data: 'last4',name:'las4',orderable: false,render:function(data, type, row){ 
        
                    var brIcon = '';    
                    if(row.brand == 'Visa'){    
                      brIcon = '<i class="fab fa-cc-visa"></i>';    
                    }else if(row.brand == 'MasterCard'){    
                      brIcon = '<i class="fab fa-cc-mastercard"></i>';    
                    }else if(row.brand == 'American Express'){    
                      brIcon = '<i class="fab fa-cc-amex"></i>';    
                    }    
                    return brIcon+'   '+capitalizeFirstLetter(row.brand+ ' ending in ' +row.last4);    
                  }},    
                  {'className': 'details-control expire-info',data: 'test',name:'test',orderable: false,render:function(data, type, row){     
                    return capitalizeFirstLetter(row.exp_month+'/'+row.exp_year);    
                  }},    
                  {'className': 'details-control' ,data: 'funding', name: 'funding',orderable: false,render:function(data, type, row){     
                    return capitalizeFirstLetter(row.funding);    
                  }},   
                  {'className': 'details-control' ,data: 'status', name: 'status', orderable: false,render:function(data, type, row){ 
                    var st = 'Deactive';
                    var check = 'badge badge-danger';
                    if(row.status == 1){
                        check = 'badge badge-success';
                        st = 'Active';
                    }
                    return '<span class="'+check+'">'+st+'</span>';   
                  }},       
                  // {data: 'action',name: 'action', orderable: false, searchable: false},         
            ],
        });

        // Array to track the ids of the details displayed rows
        var detailRows = [];
     
        $('#order_table').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );
     
            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();
     
                // Remove from the 'open' array
                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );
                row.child( format( row.data() ) ).show();
     
                // Add to the 'open' array
                if ( idx === -1 ) {
                    detailRows.push( tr.attr('id') );
                }
            }
        });
     
        // On each draw, loop over the `detailRows` array and show any child rows
        table.on( 'draw', function () {
            $.each( detailRows, function ( i, id ) {
                $('#'+id+' td.details-control').trigger( 'click' );
            });
        });
    }); 

    $('body').on('click','.default-card',function(){
        var card_id = $(this).attr('card_id');
        if(card_id != ''){
            swal({   
                title: "Are you sure?", 
                text: "You want to set this card default for your account.", 
                type: "warning",  
                showCancelButton: true,  
                confirmButtonColor: "#28b351", 
                confirmButtonText: "Yes!",   
                closeOnConfirm: false,
            },
            function (isConfirm) { 
            if (!isConfirm) return;
                $.ajax({
                    url: `{{ route('embroiderer-set-default-card') }}`,  
                    type: "POST",  
                    data: { card_id : card_id},         
                    dataType: "Json", 
                    success: function (data) {
                        toastr.options.timeOut = 3000;
                        if(data.isSucceeded){
                            swal.close();                           
                            toastr.success(data.message);
                            table.ajax.reload();
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

    /**********************Capital First Letter**********/
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    /**********************Start Stripe Working**********/
    var stripe = Stripe('pk_test_51GvculJtMGvAFFxtLw6Gd6YfbBp84V0uskWhEVuVtFi35hcqq9hTjYhtZFdSrCYzUZEaY9uynFvDPZ6Xl9s46qrn00S3BlzwnU');
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');
    const cardButton = document.getElementById('card-button');
    cardButton.addEventListener('click', async (e) => {  
        stripe.createToken(cardElement).then(function(result) {
            if (result.error) {
              $('#st-err').html(result.error.message);
            } else {
              $('#st-err').html('');
              $('.spinner').show();
              $('#card-button').prop('disabled', true);
              $.ajax({
                  url: '{{ route("embroiderer-add-card") }}',
                  type: 'POST',
                  data: { token : result.token },
                  success: function(response){
                    
                      setTimeout(function(){ 
                          $('.spinner').hide(); 
                          $('#paymentModal').modal('toggle');
                          $('#card-button').prop('disabled', false); 
                          toastr.options.timeOut = 3000;
                          if(response.isSucceeded){                         
                                toastr.success(response.message);
                                table.ajax.reload();
                          }else{
                                toastr.error(response.message);
                          }
                      },2000);                   
                  }
              });
            }
        });
    }); 
    $('.modal').on('hidden.bs.modal', function(){
        $('#st-err').html('');
        cardElement.clear();
    });
    $('body').on('click','.action-card-btn',function(){
        var card_id = $(this).attr('card_id');
        if(card_id != ''){
            swal({   
                title: "Are you sure?", 
                text: "You want to delete this card.", 
                type: "warning",  
                showCancelButton: true,  
                confirmButtonColor: "#28b351", 
                confirmButtonText: "Yes!",   
                closeOnConfirm: false,
            },
            function (isConfirm) { 
            if (!isConfirm) return;
                $.ajax({
                    url: `{{ route('embroiderer-delete-card') }}`,  
                    type: "POST",  
                    data: { card_id : card_id},         
                    dataType: "Json", 
                    success: function (data) {
                        toastr.options.timeOut = 3000;
                        if(data.isSucceeded){
                            swal.close();                           
                            toastr.success(data.message);
                            table.ajax.reload();
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

    function escapeHtml(text) {
      var map = {'&': '&amp;','<': '&lt;','>': '&gt;','"': '&quot;',"'": '&#039;'};
      return text.toString().replace(/[&<>"']/g, function(m) { return map[m]; });
    }
</script>
@endsection