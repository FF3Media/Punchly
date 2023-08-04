@extends('layouts.app')
@section('content')
<script src="https://js.stripe.com/v3/"></script>
<script src="https://www.paypal.com/sdk/js?client-id={{config('services.paypal.client_id')}}&intent=authorize"></script>
<div class="checkout-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-12 col-sm-12 my-3">
                <h3 class="main-heading-cart">Checkout</h3>
                <div class="coupon-box my-error">
                                <label>Coupon</label>
                                <div class="couponDiv">
                                    <input type="text"  onkeyup="CheckcouponBeforeApply();" name="coupon_id" id="coupon_id" placeholder="Coupon" class="form-control couponIdValue" />
                                     <button onclick="checkCouponValidate();" class="btn-purple  applyCouponCls" id="applyCoupon">Apply</button>
                                   <input type="hidden"  id="coupon_valid" name="coupon_valid" value="">

                                </div>
                                 
                                <div style="color:red"  class="errorcoupone"></div>
                            </div> 
                <div class="payment-box position-sticky" id="paymentModals" style="top:90px;">
                    <div class="modal-dialog common-width-popup"> 
                        <div class="form-common-class">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div id="loading-bar-spinner" class="spinner" style="display: none;">
                                        <div class="spinner-icon"></div>
                                    </div>
                                   
                                    <form action="//httpbin.org/post" method="POST" class="" id="castle">
                                        
                                        <input type="hidden" name="token" />
                                        <div class="beforecoupen">
                                        <div class="form-group row">
                                            <div class="col-lg-12 my-error p-0 m-0">
                                                <label class="w-100">Payment method</label>
                                                {{-- <select class="js-example-programmatic minimal-select" id="pMethod"> --}}
                                                    {{-- <option value="stripe">Credit or debit card</option> --}}
                                                    {{-- <option value="paypal">Paypal</option> --}}
                                                    {{-- @forelse ($cardDetail as $key => $card)
                                                        @php if($key == 0){ @endphp
                                                            <option class="optionGroup" disabled="">Saved payment methods</option>
                                                        @php } @endphp
                                                        <option value="{{$card->card_id}}">************{{$card->last4}}</option>
                                                    @empty
                                                    @endforelse --}}
                                                {{-- </select> --}}
                                                <ul class="pay-imgs list-unstyled d-flex align-items-center m-0">
                                                    <li><img src="{{ asset('card-images/visa-icon.png') }}" /></li>
                                                    <li><img src="{{ asset('card-images/master-card-icon.png') }}" /></li>
                                                    <li><img src="{{ asset('card-images/paypal-icon.png') }}" /></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!--stripe creditcard html -->
                                        <div  style="display: none;" class="group main-card-detail-div">
                                            <label class="common-label-card card-number">
                                                <span>Card number</span>
                                                <div id="card-number-element" class="field"></div>
                                                <span class="brand"><i class="pf pf-credit-card" id="brand-icon"></i></span>
                                            </label>
                                            <label class="common-label-card expiry-date">
                                                <span>Expiry date</span>
                                                <div id="card-expiry-element" class="field"></div>
                                            </label>
                                            <label class="common-label-card cvc-class">
                                                <span>CVV/CVC</span>
                                                <div id="card-cvc-element" class="field"></div>
                                            </label>
                                            <label style="display: none;">
                                            <span>Postal code</span>
                                            <input id="postal-code" name="postal_code" class="field" placeholder="90210" />
                                            </label>
                                            <p class="save-payment-check"><input type="checkbox" id="save_method" name="save_method" value="1" /> Save payment method</p>
                                        </div>
                                         <!-- End stripe creditcard html -->
                                        @if(count($allOrder) >=1 )
                                         <!-- <button type="submit" class="btn-purple checkoutBtn"   >Checkout</button> -->
                                        <button class="btn-purple checkoutBtnWithoutFormSubmit"  style="display: none;">Checkout</button>   
                                        @else

                                        <!-- <button type="submit" class="btn-purple checkoutBtn" disabled="true" >Checkout</button> -->
                                        <button class="btn-purple checkoutBtnWithoutFormSubmit" disabled="true" style="display: none;" >Checkout</button>  
                                        @endif
                                         
                                        <div id="paypal-button-container" ></div>
                                      
                                        <div class="outcome">
                                            <div class="error"></div>
                                            <div class="success" style="display: none;">
                                                Success! Your Stripe token is <span class="token"></span>
                                            </div>
                                        </div>
                                    </div>
                                    @if(count($allOrder) >=1 )
                                        <button class="btn-purple checkoutBtnWithoutFormSubmitWithZero" id="amountZeroButton"  disabled="true"  style="display: none;">Checkout</button>
                                   
                                    @endif
                                    </form> 
                                     
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             
            <div class="col-lg-7 col-md-12 col-sm-12 my-3">          

                <div class="cart-right-side"> 
                    <h4>Your cart</h4>
                    @php $totalAmt=0; @endphp
                    <div id="clearOrder">
                        @forelse ($allOrder as $order)
                        	@php $totalAmt = $order->amount + $totalAmt; @endphp
                            <div class="single-cart-item">
                                <div class="product-cart-img">
                                    <img src="{{ $order->feature_image ? asset('orders/'.$order->feature_image) : asset('backend-images/cart-list-product.jpg') }}" />
                                </div>
                                <div class="product-cart-details d-flex align-items-start">
                                    <div class="left-product-cart-detail">
                                        <div class="product-cart-title">
                                            <h3>{{$order->order_name}}</h3>
                                        </div>
                                        <ul>
                                            <li><span class="cart-detail-heading">File Type:</span> <span class="cart-detail-output"><!-- {{$order->desired_output == 'for_print' ? 'For print' : 'For embroyer' }} -->
                                                Embroidery files (DST, EMB)
                                            </span></li>
                                            <li><span class="cart-detail-heading">Garment type:</span> <span class="cart-detail-output">{{ $order->garment->name}}</span></li>
                                            <li><span class="cart-detail-heading">Desired height:</span> <span class="cart-detail-output">{{$order->desired_height}}</span></li>
                                            <li><span class="cart-detail-heading">Desired width:</span> <span class="cart-detail-output"> {{$order->desired_width}}</span></li>
                                        </ul>
                                    </div>
                                     <?php
                                     $addtaxs='';
                                     $totalAmount = $order->amount;
                                        if($taxs){
                                            if($taxs['total_percentage'] > 0 ){
                                              $amt = $order->amount;
                                              $percentage = $taxs['total_percentage'];
                                              $addtaxs = round($amt*($percentage/100),2);
                                              $amt += $amt*($percentage/100);
                                              $totalAmount = round($amt,2);
                                            } 
                                     } 
                                      ?> 
                                    <div class="right-product-cart-detail">
                                        <span class="product-cart-price"><b>Amount</b> ${{$order->amount}}
                                                 <span  id="discount{{$order->id}}" class="discountcls"><span class='disIDRemove' id='disId{{$order->id}}'><b>Discount</b>0</span></span>  
                                                <span class="taxescls" id="taxes{{$order->id}}"><b>{{$finaleTaxsNames}}</b> @if(!empty($addtaxs))${{$addtaxs}}@endif</span>                             
                                                <span class="disCountTaxesCls"  id="afterDiscountTaxes{{$order->id}}"></span>
                                            </span>
                                    </div>
                                </div>
                                <div class="total-price">
                                    <span class="total" id="total" ><b>Total</b> ${{$totalAmount}}</span> 
                                    <span class="afterCouponClsTotal" id="afterCouponTotal{{$order->id}}" > </span>  
                                </div>
                            </div>
                              <?php  $cartempty = 1; ?>
                        @empty
                        <?php 
                         //paypal button hide if cartempty 0

                          $cartempty = 0; ?>
                           <div class="single-cart-item">
                            <div class="empty-cart">
                            <h2>Your Cart is Empty</h2>
                            <p>Please Create Order to checkout</p>
                            </div>
                            </div>
                        @endforelse
                    </div>
                    <input type="hidden" name="totalAmt" value="{{ number_format($totalAmt,2) }}">
                    <input type="hidden" name="afretcpn" id="afretcpn" value="">

                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal for error -->
<div class="modal message-popup error-message" id="error-meesage-pop-up" style="">
    <div class="modal-dialog common-width-popup">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group row">
                        <span class="icon-circle"><i class="fas fa-exclamation"></i></span>
                        <h4 class="title">Oops!<br> Something went wrong</h4>
                        <p>We’ll take you back to checkout so can try again</p>
                        <button type="button" class="btn btn-secondary btn-purple" data-dismiss="modal">Back to checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->

<!-- modal for error -->
<div class="modal message-popup error-message" id="error-meesage-for-stripe" style="">
    <div class="modal-dialog common-width-popup">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close reload" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group row">
                        <span class="icon-circle"><i class="fas fa-exclamation"></i></span>
                        <h6 class="title stripeErrors">  </h6   >
                        <p>We’ll take you back to checkout so can try again</p>
                        <button type="button" class="btn btn-secondary btn-purple" data-dismiss="modal">Back to checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->

<!-- modal for message -->
<div class="modal message-popup" id="meesage-pop-up" style="" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog common-width-popup">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close reload" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group row" >
                        <span class="icon-circle"><i class="fas fa-check"></i></span>
                        <h4 class="title" id="dynMessage">Your order successfully placed</h4>
                        <p>You can now track the status of your order on the Embroiderer Portal page</p>
                        <a href="{{ route('embroiderer-order-management') }}" class="btn btn-secondary" >Proceed to Home Page</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- /.modal -->
@endsection
@section('third_party_scripts')
<script type="text/javascript">
let discountAmount = 0;
$('.reload').click(function(){
    location.reload(true);
    });

    $.ajaxSetup({
        headers: {
            'X-XSRF-TOKEN': decodeURIComponent(/XSRF-Token=([^;]*)/ig.exec(document.cookie)[1])
        }
    });
    /**********************Start Stripe Working**********/
    var stripe = Stripe('pk_test_51In362Ek3ovLTtXtigbRpirOJCw6TN0PvuW634A59Aj3K1o6k72gM8va6q6T4OBk8d1YDH69IKjNDF3TqJRmBN0200gMY40CMC');
    var elements = stripe.elements();
    
    var style = {
      base: {
        iconColor: '#666EE8',
        color: '#31325F',
        lineHeight: '40px',
        fontWeight: 300,
        fontFamily: 'Helvetica Neue',
        fontSize: '15px',
    
        '::placeholder': {
          color: '#CFD7E0',
        },
      },
    };
    
    var cardNumberElement = elements.create('cardNumber', {
      style: style
    });
    cardNumberElement.mount('#card-number-element');
    
    var cardExpiryElement = elements.create('cardExpiry', {
      style: style
    });
    cardExpiryElement.mount('#card-expiry-element');
    
    var cardCvcElement = elements.create('cardCvc', {
      style: style
    });
    cardCvcElement.mount('#card-cvc-element'); 
    
    function setOutcome(result) {
      var successElement = document.querySelector('.success');
      var errorElement = document.querySelector('.error');
      successElement.classList.remove('visible');
      errorElement.classList.remove('visible');
    
      if (result.token) {
        var pMethod = $('#pMethod').val();
        var saveMethod = 0;
        if($('#coupon_valid').val() == 1){
        var coupon_id = $('#coupon_id').val();
        }else{
        var coupon_id ='';
        }           
         
        if ($("#save_method").is(":checked")) {
            saveMethod = 1;
        }
        $('.spinner').show();
        $('.checkoutBtn').prop('disabled', true);
        $.ajax({
            url: '{{ route("embroiderer-create-charge") }}',
            type: 'POST',
            data: { token: result.token , paymentMethod:pMethod , saveMethod:saveMethod , coupon_id:coupon_id  },
            success: function(response) {
                setTimeout(function() {
                    $('.spinner').hide();
                    $('.checkoutBtn').prop('disabled', false);
                    if(response.isSucceeded) {
                        
                        $('#meesage-pop-up').modal('toggle');
                    } else {
                         
                        if(response.isSucceeded == false){ 
                          
                           $('.stripeErrors').text(response.message);
                           $('#error-meesage-for-stripe').modal('toggle');

                        }
                      
                       
                    }
                }, 2000);
            }
        });
      } else if (result.error) {
        errorElement.textContent = result.error.message;
        errorElement.classList.add('visible');
      }
    }
    
    var cardBrandToPfClass = {
      'visa': 'pf-visa',
      'mastercard': 'pf-mastercard',
      'amex': 'pf-american-express',
      'discover': 'pf-discover',
      'diners': 'pf-diners',
      'jcb': 'pf-jcb',
      'unknown': 'pf-credit-card',
    }
    
    function setBrandIcon(brand) {
    	var brandIconElement = document.getElementById('brand-icon');
      var pfClass = 'pf-credit-card';
      if (brand in cardBrandToPfClass) {
      	pfClass = cardBrandToPfClass[brand];
      }
      for (var i = brandIconElement.classList.length - 1; i >= 0; i--) {
      	brandIconElement.classList.remove(brandIconElement.classList[i]);
      }
      brandIconElement.classList.add('pf');
      brandIconElement.classList.add(pfClass);
    }
    
    cardNumberElement.on('change', function(event) {
    	// Switch brand logo
    	if (event.brand) {
      	setBrandIcon(event.brand);
      }
    
    	setOutcome(event);
    });
    
    document.querySelector('#castle').addEventListener('submit', function(e) {
      e.preventDefault();
      var options = {
        address_zip: document.getElementById('postal-code').value,
      };
      stripe.createToken(cardNumberElement, options).then(setOutcome);
    });

    $('#pMethod').on('change',function(){
    	if($(this).val() != 'stripe'){
    		$('.main-card-detail-div').hide();	
    		$('.checkoutBtn').hide();
    		if($(this).val() == 'paypal'){  
                
                var cartempty = '<?php echo  $cartempty; ?>';                    
                if(cartempty == 0){
                    $('#paypal-button-container').hide();
                }else{
                    $('#paypal-button-container').show();  
                    $('.checkoutBtnWithoutFormSubmit').hide();
                    
                 } 
    			
    		}else{
    			$('.checkoutBtnWithoutFormSubmit').show();	
    			$('#paypal-button-container').hide();	
    		}    		
    	}else{
    		$('.main-card-detail-div').show();
    		$('.checkoutBtn').show();
    		$('.checkoutBtnWithoutFormSubmit').hide();
    		$('#paypal-button-container').hide();
    	}
    });

    

    $('.checkoutBtnWithoutFormSubmit').click(function(){
    	var pMethod = $('#pMethod').val();
        var saveMethod = 0;
        if($('#coupon_valid').val() == 1){
        var coupon_id = $('#coupon_id').val();
        }else{
        var coupon_id ='';
        }

        if ($("#save_method").is(":checked")) {
            saveMethod = 1;
        }
        $('.spinner').show();
        $('.checkoutBtnWithoutFormSubmit').prop('disabled', true);
        $.ajax({
            url: '{{ route("embroiderer-create-charge") }}',
            type: 'POST',
            data: { paymentMethod:pMethod , saveMethod:saveMethod , coupon_id:coupon_id  },
            success: function(response) {
                setTimeout(function() {
                    $('.spinner').hide();
                    $('.checkoutBtnWithoutFormSubmit').prop('disabled', false);
                    if(response.isSucceeded) {
                       // $('#meesage-pop-up').modal({backdrop: 'static', keyboard: false});
                        $('#meesage-pop-up').modal('toggle');
                    } else {
                        $('#error-meesage-pop-up').modal('toggle');
                    }
                }, 2000);
            }
        });
    })


    $('.checkoutBtnWithoutFormSubmitWithZero').click(function(){
    	var pMethod = $('#pMethod').val();
        var saveMethod = 0;
        if($('#coupon_valid').val() == 1){
        var coupon_id = $('#coupon_id').val();
        }else{
        var coupon_id ='';
        }

        if ($("#save_method").is(":checked")) {
            saveMethod = 1;
        }
        $('.spinner').show();
        $('.checkoutBtnWithoutFormSubmit').prop('disabled', true);
        $.ajax({
            url: '{{ route("embroiderer-create-charge") }}',
            type: 'POST',
            data: { paymentMethod:pMethod , saveMethod:saveMethod , coupon_id:coupon_id  },
            success: function(response) {
                setTimeout(function() {
                    $('.spinner').hide();
                    $('.checkoutBtnWithoutFormSubmit').prop('disabled', false);
                    if(response.isSucceeded) {
                       // $('#meesage-pop-up').modal({backdrop: 'static', keyboard: false});
                      //  $('#meesage-pop-up').modal('toggle');
                      redirect_route = "{{route('embroiderer-successfully-place-order')}}";
                      window.location.replace(redirect_route);
                    } else {
                        $('#error-meesage-pop-up').modal('toggle');
                    }
                }, 2000);
            }
        });
    })

    /***********************End Stripe ********************/

    /*******************Start Paypal **********************/

      paypal.Buttons({
    //    fundingSource: paypal.FUNDING.PAYPAL,
      	style:  {
	    	layout:  'vertical',
	    	color:   'blue',
	    	shape:   'rect',
	    	label:   'paypal',
	    },
        createOrder: function(data, actions) {
           
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: discountAmount == 0 ? '{{$totalAmt}}' : discountAmount
              }
            }]
          });
        },
        onError: function (err) {
        	$('.spinner').hide();
    		// For example, redirect to a specific error page
	    	window.location.href = "/your-error-page-here";
	  	},
        onApprove: function(data, actions) {
        	$('.spinner').show();
		  // Authorize the transaction
		  	actions.order.authorize().then(function(authorization) {
			    // Get the authorization id
			    var authorizationID = authorization.purchase_units[0].payments.authorizations[0].id
			    var orderID = data.orderID; 
                if($('#coupon_valid').val() == 1){
                    var coupon_id = $('#coupon_id').val();
                }else{
                     var coupon_id ='';
                 } 
			    // Optional message given to purchaser
			    // Call your server to validate and capture the transaction
			    $.ajax({
		            url: '{{ route("embroiderer-create-order-paypal") }}',
		            type: 'POST',
		            headers: {
					  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
		            data: { authorization:authorization , order_id:orderID , coupon_id:coupon_id , _token : $('meta[name="csrf-token"]').attr('content'),   },
		            success: function(response) {
		                setTimeout(function() {
		                    $('.spinner').hide();
		                    if(response.isSucceeded) {
		                      //  $('#meesage-pop-up').modal('toggle');
                               window.location.href = "{{ route('embroiderer-successfully-place-order')}}";
                                $('#clearOrder').html('');
		                    } else {
                               // console.log(response);
		                        $('#error-meesage-pop-up').modal('toggle');
		                    }
		                }, 2000);
		            }
		        });
			});
		}
      }).render('#paypal-button-container'); // Display payment options on your web page

    /******************End Paypal *************************/
 function checkCouponValidate(){
           var coupon = $('.couponIdValue').val();         
         if (coupon) {              
          $.ajax({
            type: "POST",
            url: "{{ route('embroiderer-check-coupon') }}",
            data: {coupon:coupon},
            dataType: "json",
            success: function(res) {  
                   var addAfterCoupen = 0;
                if(res.coupan_exist == 1){ 
                     $.each(res, function( index, value ) {                                    
                      $('#discount'+index).html("<span class='disIDRemove'><b>Discount</b> $"+value.discount+"</span>");                      
                      $('#afterDiscountTaxes'+index).html("<span><b>Taxes</b>$"+value.taxs+"</span>");
                     // $('#afterDiscountTaxes'+index).html("<span><b>{{$finaleTaxsNames}}</b>$"+value.taxs+"</span>");
                      $('#afterDiscountTaxes'+index).show(); 
                      $('#afterCouponTotal'+index).html("<b>Total</b>$"+value.total+"</span>"); 
                      if(typeof value.total == 'number' ){
                        addAfterCoupen += value.total;                          
                      }  
                      $('.total').hide(); 
                      $('.afterCouponClsTotal').show();
                      $('#taxes'+index).hide();
                    }); 
                     discountAmount = addAfterCoupen;  
                     if(res.orderWithZeroAmount==1){
                        $('.beforecoupen').hide();
                        $('#amountZeroButton').show();
                        $('#amountZeroButton').removeAttr('disabled');
                        $('#paypal-button-container').hide();
                        $('.checkoutBtnWithoutFormSubmit').show();
                        $('#paymentModals .modal-body').css("padding-bottom", "21px");
                         $('#pMethod').val('discountCoupen'); 
                     }else{ 
                        $('#amountZeroButton').hide();
                        $('.beforecoupen').show();
                     }
                        
                          if(res.afterCouponSubtotal==0){
                                $('.beforecoupen').hide();
                                $('#amountZeroButton').show();
                                $('#amountZeroButton').removeAttr('disabled');
                                $('#paypal-button-container').hide();
                                $('.checkoutBtnWithoutFormSubmit').show();
                                $('#paymentModals .modal-body').css("padding-bottom", "21px");
                                $('#pMethod').val('discountCoupen'); 
                            
                          }
                     $('.errorcoupone').text(' ');
                     $('#coupon_valid').val('1');
                     $('.checkoutBtn').removeAttr('disabled');  
                     $('.checkoutBtnWithoutFormSubmit').removeAttr('disabled');
                     
                }else{ 
                   
                     $('.disCountTaxesCls').hide();
                     $('.taxescls').show();
                     $('.total').show(); 
                     $('.afterCouponClsTotal').hide();                                    
                     $('#coupon_valid').val('0');                     
                     $('.discountcls').html("<span class='disIDRemove'><b>Discount</b>0</span>");                     
                     $('.errorcoupone').text('Please Enter valid coupon');
                     $('.checkoutBtn').attr("disabled", true);
                     $('#paypal-button-container').show();
                     $('.checkoutBtnWithoutFormSubmit').hide();
                     $('.checkoutBtnWithoutFormSubmit').attr("disabled", true);
                    
                } 
                
            },
            error: function (jqXHR, exception) {
            }
        });
      }else{
       
          $('.checkoutBtn').removeAttr('disabled');
          $('.checkoutBtnWithoutFormSubmit').removeAttr('disabled');
         
          $('.errorcoupone').text(' ');
      }
    }

    function CheckcouponBeforeApply(){
           var coupon = $('.couponIdValue').val();         
         if (coupon) {              
          $.ajax({
            type: "POST",
            url: "{{ route('embroiderer-check-coupon') }}",
            data: {coupon:coupon},
            dataType: "json",
            success: function(res) {
                if(res.coupan_exist == 1){   
                                
                     $('.errorcoupone').text(' ');
                     $('#coupon_valid').val('1');
                     $('.checkoutBtn').removeAttr('disabled');
                     $('.checkoutBtnWithoutFormSubmit').removeAttr('disabled');
                }else{                                                    
                     $('#coupon_valid').val('0');                                      
                     $('.errorcoupone').text('Please Enter valid coupon');
                     $('.checkoutBtn').attr("disabled", true);
                     $('.checkoutBtnWithoutFormSubmit').attr("disabled", true);
                     $('#amountZeroButton').hide();
                     $('.beforecoupen').show();
                    
                } 
            },
            error: function (jqXHR, exception) {
            }
        });
      }else{
       
          $('#paypal-button-container').show();
          $('.total').show(); 
          $('.afterCouponClsTotal').hide();                                    
          $('#coupon_valid').val('0');                     
          $('.discountcls').html("<span class='disIDRemove'><b>Discount</b>0</span>");  
          $('.checkoutBtnWithoutFormSubmit').hide();
          $('.checkoutBtn').removeAttr('disabled');
          $('.checkoutBtnWithoutFormSubmit').removeAttr('disabled');
          $('.errorcoupone').text(' ');
      }
    }

</script>
@endsection