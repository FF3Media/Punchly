<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Order;
use Auth;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['layouts.app'], function ($view) {
            if(!Auth::user()){
                $view->with('cartCount', 0);
            }else{
                $view->with('cartCount', Order::where(['user_id' => Auth::user()->id, 'status' => 5])->count());
            }
        });
    }
}
