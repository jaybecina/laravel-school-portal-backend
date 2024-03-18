<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;

class Authenticate extends Middleware
{
    // /**
    //  * Get the path the user should be redirected to when they are not authenticated.
    //  */
    // protected function redirectTo(Request $request): ?string
    // {
    //     return $request->expectsJson() ? null : route('login');
    // }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // abort(403, 'Unauthorized');
            abort(response()->json([
                "error"=>"Unauthenticated"
            ],401));
        }
    }

    public function handle($request, Closure $next, ...$guards) {
        if($jwt = $request->cookie("jwt")) {
            $request->headers->set("Authorization", "Bearer " . $jwt);
        }

        $this->authenticate($request, $guards);

        return $next($request);
    }
}
