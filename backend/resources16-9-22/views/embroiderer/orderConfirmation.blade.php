@extends('layouts.app')

@section('content')
<div class="container">
    <style type="text/css">.col-md-12.confirmation {
    text-align: center;
    margin: 80px auto;
}</style>
<div class="col-md-12 confirmation" >
    
    <span class="icon-circle"><i class="fas fa-check"></i></span>
        <?php
     
          foreach ($orderIds as $ids) { ?>

            <div class="orders">
                Order id: <?php echo $ids['order_id']; ?> 
                
            </div>
 
    <?php      }
        ?>
    <h4 class="title" id="dynMessage">Your order successfully placed</h4>
    <p>You can now track the status of your order on the Embroiderer Portal page</p>
    <a href="{{ route('embroiderer-order-management') }}" class="btn btn-secondary" >Proceed To Order Page</a>
</div>
 
</div>

 

@endsection

@section('third_party_scripts')

@endsection