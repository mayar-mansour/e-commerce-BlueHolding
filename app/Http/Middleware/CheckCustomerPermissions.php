<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckCustomerPermissions
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
        
        if (Auth::check() && Auth::user()->hasRole('customer')) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
