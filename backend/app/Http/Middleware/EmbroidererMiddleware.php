<?php

namespace App\Http\Middleware;

use Closure;

class EmbroidererMiddleware
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
        }else if($request->user()->user_role == '2'){
            return redirect()->route('digitizer-manager-dashboard');
        }else if($request->user()->user_role == '3'){
            return redirect()->route('digitizer-dashboard');
        }
        return $next($request);
    }
}
