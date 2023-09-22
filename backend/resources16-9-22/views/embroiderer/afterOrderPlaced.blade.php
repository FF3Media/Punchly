
<link href="https://punchly.io/backend/public/css/app.css" rel="stylesheet">
<style type="text/css">

.order-successfully .order-succee-inner {
    box-shadow: 0 0 3px 0 #2bc0ba63;
    border-radius: 4px;
    overflow: hidden;
    max-width: 460px;
}
.order-successfully {
    display: flex;
    justify-content: center;
    height: 100vh;
    align-items: center;
}
.order-successfully .order-succee-inner h4.title {
    background-color: #2BC0BA;
    font-size: 22px;
    color: #fff;
    padding: 12px;
}
.order-su-in {
    padding: 20px 20px 30px;
}
.order-su-in p {
    font-size: 15px;
    color: #757575;
    line-height: 23px;
    letter-spacing: 0.3px;
}
.order-succee-inner a.btn {
    background-color: #2bc0ba;
    border-color: #2bc0ba;
    font-size: 16px;
    letter-spacing: 0.5px;
    margin-top: 12px;
}
.order-su-in .orders {
    display: flex;
    gap: 8px;
}
</style>
<section class="content m-0 pt-4">
<div class="container">
<div class="order-successfully">
	<div class="order-succee-inner">
	<span class="icon-circle"><i class="fas fa-check"></i></span>
	<h4 class="title" id="dynMessage">Your order successfully placed</h4>
	<div class="order-su-in">
	<p>You can now track the status of your order on the Embroiderer Portal page</p>
@if(Session::has('cartOrdres'))
@php
$cartorder  = Session::get('cartOrdres');
@endphp   
 @foreach($cartorder as $value)  
	  <div class="orders">	  	
	  	<label>Order id</label>
	  	 <div class="order_id"> {{ $value->order_unique_id }}</div>
	  </div>
 @endforeach
  
          
@endif

<a href="https://punchly.io/backend/embroiderer/order-management" class="btn btn-secondary">Proceed to Home Page</a>
</div>	
</div>
</div>
</div>

</section>
