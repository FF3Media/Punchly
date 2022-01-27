<?php

namespace App\Providers;

use App\PriceCalculator;
use App\Order;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    { 
        
            view()->composer('*', function ($view){

              if(Auth::check()){
                $getcartItems = '';
                $priceCalculator = PriceCalculator::all();
                $inch = 0 ; $centimeter = 0;
                if(count($priceCalculator)){        
                    $priceCalculator = $priceCalculator->toArray();
                    $inch = $priceCalculator[0]['desired_price']; 
                    $centimeter = $priceCalculator[1]['desired_price'];
                } 
                $getcartItems = Order::where('status',5)->where('user_id',Auth::user()->id)->get();    
                $view->with('shareData', compact('inch','centimeter','getcartItems'));
            }
          });  
 
    }
}
