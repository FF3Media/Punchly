<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        if($request->user()->user_role == '2'){
            return redirect()->route('digitizer-manager-dashboard');
        }else if($request->user()->user_role == '3'){
            return redirect()->route('digitizer-dashboard');
        }else if($request->user()->user_role == '4'){
            return redirect()->route('profile-edit');
        }
        return $next($request);
    }
}
