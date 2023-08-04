

<?php $__env->startSection('content'); ?>
<style>
.dropzone .dz-preview .dz-image {
    
    
    width: auto !important;
    height: auto !important;
     
}
 </style>
<div class="order-history-list-grid">
    <div class="container-fluid embroidererSection">
        <div class="row">
            <div class="col-sm-12">
                <?php if(session()->has('success')): ?>
                <div class="alert alert-success cus-msg-cls" style="text-align: left;">
                    <?php echo e(session()->get('success')); ?>

                </div>
                <?php elseif(session()->has('failure')): ?>
                <div class="alert alert-danger cus-msg-cls" style="text-align: left;">
                    <?php echo e(session()->get('failure')); ?>

                </div>
                <?php endif; ?>
            </div>
        </div>
        <form id="create_order" method="post" action="" enctype="multipart/form-data" class="new-order-form">
            <div class="row">
                <div class="col-lg-12 my-3">
                    <div class="float-left">
                        <h3>Upload Image</h3>
                    </div>
                </div>
                <div class="col-lg-12 my-3">
                    <div class="drop-browse-div">
                        <div id='drop_zone'>
                            <?php echo csrf_field(); ?>
                            <!-- You can add extra form fields here -->
                            <input hidden id="file" name="file" />
                            <!-- You can add extra form fields here -->
                            <div class="dropzone dropzone-file-area" id="fileUpload">
                                <div class="dz-default dz-message">
                                    <img src="<?php echo e(asset('backend-images/thimb-img.png')); ?>" />
                                    <h3 class="sbold">Drop your files here, or <span class="color-green">browse</span>
                                    </h3>
                                    <span>Supports: JPEG, PNG, PSD</span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="modal fade new-order-slide slideModel" style="padding-right:0px !important;" id="createOrder"
                tabindex="-1" role="dialog" aria-labelledby="createOrder" aria-hidden="true">
                <div class="modal-dialog modal-dialog-slideout" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New Order <span class="file-name"></span>
                            </h5>
                            <div class="model-right">
                                <!--  <a class="upload-another">Upload another file</a> -->
                                <a href="#" type="button" class="slideclose upload-another" data-dismiss="modal"
                                    aria-label="Close">
                                    <!--  <span aria-hidden="true">×</span> -->
                                    Upload new file
                                </a>

                                <button type="button" class="close modelcloseCnfrm1"> <span
                                        aria-hidden="true">×</span></button>
                                <div id="loading-bar-spinner" class="spinner" style="display: none;">
                                    <div class="spinner-icon"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">

                            <div id="dz-preview"></div>
                            <input type="hidden" id="order_name" name="order_name" value="" class="form-control" />
                            <div class="row">
                                <div class="col my-error">
                                    <label>File Type</label>
                                    <select name="desired_output" id="desired_output"
                                        class="form-control minimal-select">
                                        <option value="">Select</option>
                                        <option value="for_embroidery_files">Embroidery files (DST, EMB)</option>
                                    </select>
                                </div>
                                <div class="col my-error">
                                    <label>Garment type</label>
                                    <select name="garment_id" class="form-control minimal-select">
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
                                    <input type="number" id="desired_height" class="pri-cal"
                                        onKeyPress="if(this.value.length==5) return false;" name="desired_height">
                                    <div class="radio-btns">
                                        <p><input type="radio" id="in" class="pri-cal" name="height_in" value="1"
                                                checked><label id="inchlabel" for="in">in</label></p>
                                        <p><input type="radio" id="cm" class="pri-cal" name="height_cm" value="2"><label
                                                id="cmlabel" for="cm">cm</label></p>
                                    </div>
                                </div>

                                <div class="col my-error">
                                    <label>Desired width</label>
                                    <input type="number" id="desired_width" class="pri-cal"
                                        onKeyPress="if(this.value.length==4) return false;" name="desired_width">
                                    <div class="radio-btns">
                                        <p><input type="radio" id="in1" class="pri-cal" name="width_in" value="1"
                                                checked><label id="inchlabel2" for="in1">in</label></p>
                                        <p><input type="radio" id="cm1" class="pri-cal" name="width_cm" value="2"><label
                                                id="cmlabel2" for="cm1">cm</label></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col cost-detail-heading my-error">
                                    <h4><span class="dark-text">Cost:</span> $<span
                                            id='cost_calculate_span'><?php echo $inch;?></span> per square <span
                                            id='persquare'>inch</span></h4>
                                    <input type="text" id="cost_calculate" name="cost_calculate" value="0"
                                        class="form-control" readonly="" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col my-error">
                                    <label>Comments</label>
                                    <textarea name="order_message" class="form-control" rows="6" cols="50"
                                        placeholder="EX: Remove the white background"></textarea>
                                </div>
                            </div>
                        </div>
                        <?php if(Auth::user()): ?>
                        <div class="modal-footer">
                            <button type="submit" class="gray-btn" name="clickbtn" value="instant_cart"
                                id="add-card">Add to cart</button>
                            <button type="submit" class="gray-btn" name="clickbtn" value="instant_checkout">Instant
                                checkout</button>
                        </div>
                        <?php else: ?>
                          <div class="modal-footer">
                              <a href="<?php echo e(route('login')); ?>" class="abtn gray-btn"
                                  id="add-card">Add to cart</a>
                              <a href="<?php echo e(route('login')); ?>" class="abtn gray-btn">Instant
                                  checkout</a>
                          </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-lg-12 my-3">
                <div class="float-left">
                    <h3>Order history</h3>
                </div>
                <div class="float-right">
                    <div class="btn-group">
                        <div class="grid-list-btns">
                            <button class="btn active" id="list">List View</button>
                            <button class="btn" id="grid">Grid View</button>
                        </div>
                        <button class="filter-btn" data-toggle="modal" data-target="#filterModal">Filters <i
                                class="fas fa-filter"></i>
                    </div>
                </div>
            </div>
        </div>
        <div id="products" class="view-group row list-group-item">
            <div class="div-responsive">
                <div class="page_loader roleMe" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="renderOrder row">

                    <?php echo $__env->make('embroiderer.orderRepresent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                </div>
            </div>
            <!----------------------Modal Open For Filter Functionality ----------->
            <div class="modal fade-out" id="filterModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Filters</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="select-section">
                                <div class="select-box">
                                    <label>File Type</label>
                                    <select class="form-control minimal-select" id="desired_output_filter">
                                        <option value="">Select</option>
                                        <option value="for_embroidery_files">Embroidery files (DST, EMB)</option>
                                    </select>
                                </div>
                                <div class="select-box">
                                    <label>Status</label>
                                    <select class="form-control minimal-select" id="status">
                                        <option value="">Select</option>
                                        <option value="1">Waiting for approval</option>
                                        <option value="2">In progress</option>
                                        <option value="3">Rejected</option>
                                        <option value="4">Completed</option>
                                        <option value="9">Canceled</option>
                                    </select>
                                </div>
                                <div class="select-box">
                                    <label>Date range</label>
                                    <input type="text" name="daterange" id="daterangepicker" value="" />
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary applyFilter">Apply</button>
                            <button type="button" class="btn btn-secondary clearFilter" data-dismiss="modal">Clear
                                all</button>
                        </div>
                    </div>
                </div>
            </div>

            <?php $__env->stopSection(); ?>

            <?php $__env->startSection('third_party_scripts'); ?>
            <script type="text/javascript">
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $(document).ready(function () {
                    var end = moment().add(29, 'days').format('L');
                    var start = moment().format('L');
                    filter_data(1);
                    var minimumDate = 0,
                        maximumDate = 0,
                        status = 0,
                        desired_output = '';
                    $('input[name="daterange"]').daterangepicker({
                        autoUpdateInput: false,
                        locale: {
                            cancelLabel: 'Clear'
                        }
                    });
                    $('input[name="daterange"]').on('apply.daterangepicker', function (ev, picker) {
                        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate
                            .format('MM/DD/YYYY'));
                        minimumDate = picker.startDate.format('MM-DD-YYYY');
                        maximumDate = picker.endDate.format('MM-DD-YYYY');
                    });
                    $('input[name="daterange"]').on('cancel.daterangepicker', function (ev, picker) {
                        $(this).val('');
                    });

                    $('.applyFilter').click(function () {
                        var result = $('#daterangepicker').val().split('-');
                        minimumDate = result[0];
                        maximumDate = result[1];
                        var page = 1;
                        $('#filterModal').modal('toggle');
                        filter_data(page);

                    });
                    $('.clearFilter').click(function () {
                        var elements = document.getElementsByTagName("select");
                        $("input[name=search]").val('');
                        $('input[name="daterange"]').val('');
                        for (var ii = 0; ii < elements.length; ii++) {
                            elements[ii].value = "";
                        }
                        var page = 1;
                        $('#filterModal').modal('toggle');
                        filter_data(page);
                    });

                    function filter_data(page) {
                        status = $('#status').val();
                        desired_output = $('#desired_output_filter').val();
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: HOST_URL + "/embroiderer/orderRepresent/?page=" + page,
                            method: "GET",
                            data: {
                                minimumDate: minimumDate,
                                maximumDate: maximumDate,
                                status: status,
                                desired_output: desired_output
                            },
                            success: function (data) {
                                $('.roleMe').css('display', 'none');
                                if (data.isSucceeded) {
                                    $('.renderOrder').html(data.data);
                                } else {
                                    $('.renderOrder').html(data.data);
                                }
                            }
                        });
                    }
                    $(document).on('click', '.pagination a', function (event) {
                        $('.roleMe').css('display', 'flex');
                        event.preventDefault();
                        var page = $(this).attr('href').split('page=')[1];
                        $('#hidden_page').val(page);
                        $('li').removeClass('active');
                        $(this).parent().addClass('active');
                        filter_data(page);
                    });
                    $('#list').click(function () {
                        $('#products').addClass('list-group-item');
                    });
                    $('#grid').click(function () {
                        $('#products').removeClass('list-group-item');
                        $('#products').addClass('grid-group-item');
                    });
                    $('.grid-list-btns button').click(function () {
                        $(".grid-list-btns button").removeClass("active");
                        $(this).addClass("active");
                    });

                });

                Dropzone.autoDiscover = true;
                Dropzone.options.fileUpload = {
                    url: "<?php echo e(route('embroiderer-create-order')); ?>",
                    paramName: "file",
                    addRemoveLinks: true,
                    uploadMultiple: false, //upload multiple files
                    maxFilesize: 20, //20 mb is here the max file upload size constraint

                    acceptedFiles: ".jpeg,.jpg,.png,.psd",
                    accept: function (file) {
                        let fileReader = new FileReader();
                        fileReader.onload = (event) => { 
                            $('#dz-preview').html('<img src="' + event.target.result + '"   alt="">');
                        }
                        this.on("addedfile", function (event) {
                            console.log(event)
                            while (this.files.length > this.options.maxFiles) {
                                this.removeFile(this.files[0]);
                            }
                        });
                        this.on("thumbnail", function (file, dataUrl) {
                            console.log(file,'test file url')
                            let fileReader = new FileReader();
                            fileReader.onload = (event) => { 
                                $('#dz-preview').html('<img src="' + event.target.result + '"   alt="">');
                            }
                           // $('#dz-preview').html('<img src="' + dataUrl + '"  alt="">');
                            $('.file-name').text(file.name);
                            $('#order_name').val(file.name);
                        });

                        fileReader.readAsDataURL(file);
                        fileReader.onloadend = function () {
                            $('.sidebar-mini').css('overflow', 'hidden');
                            // $('.slideModel').show("slide", { direction: "right",backdrop: 'static' }, 2000);
                            $(".slideModel").modal({
                                backdrop: 'static',
                                keyboard: false
                            }).show("slide", {
                                direction: "right",
                                backdrop: 'static'
                            }, 2000);
                            //  $('.slideModel').modal({	backdrop: 'static'});
                            $('#createOrder').modal('toggle');
                            let content = fileReader.result;
                            $('#file').val(content);
                            file.previewElement.classList.add("dz-success");
                        }
                        file.previewElement.classList.add("dz-complete");
                    },
                    maxFiles: 10,
                    autoProcessQueue: false
                }
                $('.slideclose').on('click', function (e) {
                    var myDropzone = Dropzone.forElement("#fileUpload");
                    myDropzone.removeAllFiles();
                    $('.sidebar-mini').css('overflow', 'scroll');
                    $('#drop_zone .dz-clickable').trigger('click');

                });
                $('#createOrder').on('hidden.bs.modal', function () {
                    var myDropzone = Dropzone.forElement("#fileUpload");
                    myDropzone.removeAllFiles();
                    $('.sidebar-mini').css('overflow', 'scroll');
                })

                $(document).ready(function () {
                    $('#cmlabel2').on('click', function () {
                        $('#cm').prop('checked', true);
                        $('#in').prop('checked', false);
                        $('#in1').prop('checked', false);
                        $('#cm').attr('value', '2');
                        $('#cm1').attr('value', '2');
                        $('#in').attr('value', '');
                        $('#in1').attr('value', '');
                        $('#cost_calculate_span').text("<?php echo $centimeter;?>");
                        $('#persquare').text('cm');
                    });
                    $('#cmlabel').on('click', function () {
                        $('#cm1').prop('checked', true);
                        $('#in').prop('checked', false);
                        $('#in1').prop('checked', false);
                        $('#cm').attr('value', '2');
                        $('#cm1').attr('value', '2');
                        $('#in').attr('value', '');
                        $('#in1').attr('value', '');
                        $('#cost_calculate_span').text("<?php echo $centimeter;?>");
                        $('#persquare').text('cm');

                    });
                    $('#inchlabel2').on('click', function () {
                        $('#in').prop('checked', true);
                        $('#cm').prop('checked', false);
                        $('#cm1').prop('checked', false);
                        $('#cm').attr('value', '');
                        $('#cm1').attr('value', '');
                        $('#in').attr('value', '1');
                        $('#in1').attr('value', '1');
                        $('#cost_calculate_span').text("<?php echo $inch;?>");
                        $('#persquare').text('cm');

                    });
                    $('#inchlabel').on('click', function () {
                        $('#in1').prop('checked', true);
                        $('#cm').prop('checked', false);
                        $('#cm1').prop('checked', false);
                        $('#cm').attr('value', '');
                        $('#cm1').attr('value', '');
                        $('#in').attr('value', '1');
                        $('#in1').attr('value', '1');
                        $('#cost_calculate_span').text("<?php echo $inch;?>");
                        $('#persquare').text('cm');

                    });

                });

                $(document).ready(function () {

                    $.validator.addMethod('filesize', function (value, element, param) {
                        return this.optional(element) || (element.files[0].size <= param)
                    }, 'File size must be less than {0}');
                    var validaterOrder = $("#create_order").validate({
                        submitHandler: function (form, e) {
                            e.preventDefault();
                            $('.spinner').show();
                            // let's select and cache all the fields
                            var $inputs = $(form).find("input, select, button, textarea");
                            // serialize the data in the form
                            var serializedData = $(form).serialize();
                            $inputs.prop("disabled", true);

                            $.ajax({
                                type: "POST",
                                url: "<?php echo e(route('embroiderer-create-order')); ?>",
                                data: serializedData,
                                dataType: "json",
                                success: function (res) {
                                    if (res.isSucceeded) {
                                        if (res.redirect == 'instant_cart') {
                                            window.location.href =
                                                "/backend/embroiderer/cart";
                                        } else {
                                            window.location.href =
                                                "/backend/embroiderer/checkout-payment";
                                        }
                                        $('.spinner').show();

                                    } else {

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
                            desired_width: {
                                required: true
                            },
                            garment_id: {
                                required: true,
                            },

                            // order_message: {
                            //     required: true,
                            // },

                            desired_output: {
                                required: true
                            }
                        },
                        messages: {
                            order_name: {
                                required: "Please enter order name",
                            },
                            desired_height: {
                                required: "Please enter your desired height",
                            },
                            desired_width: {
                                required: "Please enter your desired width",
                            },
                            garment_id: {
                                required: "Please select garment type",
                            },

                            // order_message: {
                            //     required: "Please enter your desired message"
                            // },
                            desired_output: {
                                required: "Please select the file type"
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
                $('.pri-cal').bind('keyup mouseup onchange click', function (e) {
                    var height, width, valActual = 0;
                    var measurement_inch_and_width = '1';
                    var priceInch = "<?php echo $inch;?>";
                    var priceCentimeter = "<?php echo $centimeter;?>";
                    height = $('#desired_height').val();
                    width = $('#desired_width').val();
                    inch = $("input[name=height_in]:checked").val();
                    cm = $("input[name=width_cm]:checked").val();
                    var persquare = '';
                    var persquareInchCm = "<?php echo $inch;?>";
                    if (inch == 1) {
                        measurement_inch_and_width = 1;
                        persquare = 'inch';
                        persquareInchCm = priceInch;
                    }
                    if (cm == 2) {
                        measurement_inch_and_width = 2;
                        persquare = 'cm';
                        persquareInchCm = priceCentimeter;
                    }
                    if (height && width && measurement_inch_and_width) {
                        if (measurement_inch_and_width == '1') {
                            valActual = height * width * priceInch;
                            valActual = valActual.toFixed(2);
                            $('#cost_calculate').val(valActual);
                            $('#cost_calculate_span').text(persquareInchCm);
                            $('#persquare').text(persquare);
                        } else if (measurement_inch_and_width == '2') {
                            valActual = height * width * priceCentimeter;
                            valActual = valActual.toFixed(2);
                            $('#cost_calculate').val(valActual);
                            $('#cost_calculate_span').text(persquareInchCm);
                            $('#persquare').text(persquare);
                        }
                    }
                });

                function cancelOrderForm() {
                    $('.cancelForm').slideToggle();
                }

                function showOrderDetail(data) {

                    $('#rejected-message').hide();
                    $('.cancelForm').hide();
                    $('#rejected-reason').hide();
                    $('.submitted-work').html('');
                    $('#cancel_btn').hide();
                    $('#cancel_order_id').val('');
                    $('#st_charge_id').val('');
                    $('#invoicedPdf').hide();
                    $('#desired_old_height_label').hide();
                    $('#desired_old_width_label').hide();
                    console.log(data);
                    //send order detail to Order detail poppup
                    var status = '';
                    var check = '';
                    var months = ["Jan", "Feb", "Mar", "April", "May", "June", "July", "Aug", "Sep", "Oct", "Nov",
                        "Dec"];
                    var updated_date = new Date(data.updated_at);
                    var month = months[updated_date.getMonth()]; //months from 1-12
                    var day = updated_date.getUTCDate();
                    var year = updated_date.getUTCFullYear();
                    $('#updated_date').text(day + ' ' + month + ' ' + year);
                    if (data.desired_output == 'for_print') {
                        $('#desired_output2').text('For print');
                    } else {
                        $('#desired_output2').text('For embroyer');
                    }
                    $('#garment_name').text(data.garment.name);
                    $('#desired_height_detail').text(data.desired_height);
                    $('#desired_width_detail').text(data.desired_width);
                    $('#order_unique_id').text(data.order_unique_id);
                    // if(data.coupon_id != null){
                    //     $('#order_amount').text('$' + data.amount_after_coupon);

                    // }else{

                    //     $('#order_amount').text('$' + data.amount);
                    // }

                    $('#order_amount').text('$' + data.amount);
                    
                    $('#order_message').text(data.order_message);
                    $('#order_image_name').text(data.order_name);
                    if (data.desired_old_height > 0 && data.desired_old_width > 0) {
                        $('#desired_old_height').text(data.desired_old_height);
                        $('#desired_old_width').text(data.desired_old_width);
                        $('#desired_old_height_label').show();
                        $('#desired_old_width_label').show();
                    }
                    if (data.status == 1) {
                        check = 'paid-tag';
                        status = 'Waiting for Approval';
                        $('#cancel_btn').show();
                    } else if (data.status == 2) {
                        check = 'in-progress-tag';
                        status = 'In progress';
                    } else if (data.status == 3) {
                        check = 'rejected-tag';
                        status = 'Rejected';
                    } else if (data.status == 4) {
                        check = 'completed-tag';
                        status = 'Completed';
                    } else if (data.status == 7) {
                        check = 'rejected-tag';
                        status = 'Refund pending';
                    } else if (data.status == 9) {
                        check = 'rejected-tag';
                        status = 'canceled';
                    } else if (data.status == 8) {
                        check = 'rejected-tag';
                        status = 'Refund failed';
                    } else if (data.status == 6) {
                        check = 'rejected-tag';
                        status = 'Refund succeeded';
                    }
                    $('#order_status').text(status);
                    $('#order_status').removeClass();
                    $('#order_status').addClass(check);
                    $('#order_image').attr('src', HOST_URL + '/public/orders/' + data.feature_image);
                    $('#down_image_name').text(data.order_name);
                    $('#order_image_download').attr('src', HOST_URL + '/public/orders/' + data.feature_image);
                    var url = '<?php echo e(route("embroiderer-download-image", ":orderimage")); ?>';
                    url = url.replace(':orderimage', data.feature_image);
                    $('#downloardBtn').attr('href', url);
                    //rejected message
                    if (data.status == 3) {
                        if (data.comment) {
                            $('#rejected-message').show();
                            $('#rejected-text').text(data.comment);
                        }
                        if (data.rejection_reason) {
                            $('#rejected-reason').show();
                            $('#rejected-selected-reason').text(data.rejection_reason.reason);
                        }
                    }
                    //end details

                    //Cancel Order Form
                    $('#cancel_order_id').val(data.id);
                    if (data.payment_details != null && data.status == 1) {

                        $('#st_payment_intent_id').val(data.payment_details.st_payment_intent_id);
                    }
                    if (data.amount_after_coupon > 0) {
                        $('#order_amount_cancel').val(data.amount_after_coupon);
                    } else {
                        $('#order_amount_cancel').val(data.amount);
                    }
                    //invoice Button
                    if (data.status == 4) {
                        $('#invoicedPdf').show();
                        $('#invoiceDownlordPdf').attr("data-orderid", data.id)

                    }

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "<?php echo e(route('embroiderer-send-order-id')); ?>",
                        method: "GET",
                        data: {
                            order_id: data.id
                        },
                        success: function (data) {
                            if (data.isSucceeded) {
                                $('.submitted-work').html(data.data);

                            }
                        }
                    });
                    //reorderclickbtn
                    $('#reOrderOpenPopup').val('reorderclick' + data.id);

                    //Show model
                    $('#download-modal').modal('toggle');

                }

                $(".modelcloseCnfrm1").on('click', function () {
                    swal({
                            title: "Are you sure?",
                            text: "You want to close",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#28b351",
                            confirmButtonText: "Yes!",
                            closeOnConfirm: false
                        },
                        function (isConfirm) {
                            if (!isConfirm) {
                                return;
                            }
                            $('.slideModel').modal('toggle');
                            $(".modal-backdrop").hide();
                            swal.close();
                            $("#create_order")[0].reset();
                            $(".invalid-feedback").hide();
                            $('.is-invalid').removeClass('is-invalid');
                            var myDropzone = Dropzone.forElement("#fileUpload");
                            myDropzone.removeAllFiles();
                            $('.sidebar-mini').css('overflow', 'scroll');
                        });
                });

                function invoiceDownlorad(orderID) {
                    orderId = '';
                    var orderId = $(orderID).attr('data-orderid');


                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "<?php echo e(route('embroiderer-send-invoice-data')); ?>",
                        method: "GET",
                        data: {
                            order_id: orderId
                        },
                        xhrFields: {
                            responseType: 'blob'
                        },
                        success: function (response) {
                            var blob = new Blob([response]);
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = "Invoice.pdf";
                            link.click();

                        },
                        error: function (blob) {
                            console.log(blob);
                        }
                    });

                }







                function reOrderclicked() {
                    var clickBtn = $('#reOrderOpenPopup').val();
                    $('#' + clickBtn).trigger('click');
                }

            </script>


            <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/punchly/backend/resources/views/embroiderer/ordersManagement.blade.php ENDPATH**/ ?>