<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user account type is profile allow to next or else block the request
        if (Auth::user() && (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Teacher'))) {
            return $next($request);
        }else{
            abort(403, 'Unauthorized action.'); 
        }    
    }
}
