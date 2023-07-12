<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // if(Auth::check()) {
            //admin 0
            //shipper 1
            //user 2

            if(Auth::user()->loai == '0' ){
                return $next($request);
            } else {
                Auth::logout();
                return redirect('/admin/login')->with('message', 'Vui lòng đăng nhập');
            }
        // } else {
        //     return redirect('/admin/login')->with('message', 'Access denied');

        // }
    }
}
