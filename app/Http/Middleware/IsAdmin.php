<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
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
        if(auth()->guard('pengguna')->user()->Is_admin == 2){
            return $next($request);
        }
        if(auth()->guard('pengguna')->user()->Is_admin == 1){
            return $next($request);
        }
        if(auth()->guard('pengguna')->user()->Is_admin == 0){
            return redirect()->route('kasir.index');
        }

        return redirect()->route('pos.login')->with('error',"You don't have admin access.");
    }
}
