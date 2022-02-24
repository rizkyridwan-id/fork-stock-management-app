<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Http\Request;
class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $data= Session::get('datauser');
        if ($data == null) {
            // return route('login');
            return redirect()->route('login');
        }else{
            return $next($request);
        }
    }
}