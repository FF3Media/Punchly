<?php

namespace App\Http\Middleware;

use Closure;

class DigitizerManagerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->user_role == '1'){
            return redirect()->route('admin-dashboard');
        }else if($request->user()->user_role == '3'){
            return redirect()->route('digitizer-dashboard');
        }else if($request->user()->user_role == '4'){
            return redirect()->route('profile-edit');
        }
        return $next($request);
    }
}
