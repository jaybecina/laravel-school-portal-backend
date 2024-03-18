<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
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
        // header("Access-Control-Allow-Origin: *");

        // // ALLOW OPTIONS METHOD
        // $headers = [
        //     'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
        //     'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
        // ];
        // if($request->getMethod() == "OPTIONS") {
        //     // The client-side application can set only headers allowed in Access-Control-Allow-Headers
        //     return Response::make('OK', 200, $headers);
        // }

        // $response = $next($request);
        // foreach($headers as $key => $value)
        //     $response->header($key, $value);
        // return $response;

        $response = $next($request);

        // Allow specific domains to access the API
        $response->header('Access-Control-Allow-Origin', '*');

        // Allow specific HTTP methods
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

        // Allow specific headers
        $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;

    }
}
