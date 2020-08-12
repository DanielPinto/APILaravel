<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Administrator
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
        //return response()->json(['message'=> auth('api')->user()]);
        if(!(auth('api')->user()->nivel == '1')){
            return response()->json(['message'=>'Unauthorization']);
        }

        return $next($request);
    }
}
