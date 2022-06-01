<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkApiPasswd
{

    public function handle(Request $request, Closure $next)
    {
        if($request->api_password!== env('API_PASSWORD','dllwgTisY5EPvPKGk57TsQOd')){
            return response()->json(['message'=>'unauthenticatedddddd.']);
        }
        return $next($request);
    }
}
