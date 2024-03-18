<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;


class BreadcrumbsMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // $routeName = $request->route()->getName();
        // $routeName = Route::currentRouteName();
        $routeName = $request->segments();
        $breadcrumbs = [];

        // Split the route name by the dot and add each part as a breadcrumb item.
        // $parts = explode('.', $routeName);
        $parts = $routeName;
        $part = "";
        $url = '';
        // dd($parts);
        $i = 0;
        $id = 0;
        $breadcrumbs = [];
        $firstPartUrlArr = [];
        
        foreach ($parts as $part) {
            if($part != 'admin') {
                if(count($parts) === 3) {
                    // http://127.0.0.1:8000/admin/courses/create
                    if($i == 1) {
                        $admin = 'admin';
                        $url = 'admin.' . $part . '.index';
                    } else {
                        $url = 'admin.' . $parts[1] . '.' . $part;
                    }

                    $firstPartUrlArr = [
                        'name' => $parts[1] , 
                        'url' => 'admin.' . $parts[1] . '.index',
                    ];

                } else if(count($parts) === 2) {
                    // http://127.0.0.1:8000/admin/courses/
                    if($i == 1) {
                        $admin = 'admin';
                        $url = 'admin.' . $part . '.index';
                    } else {
                        $url = 'admin.' . $parts[1] . '.' . $part;
                    }

                    $firstPartUrlArr = [
                        'name' => $parts[1] , 
                        'url' => 'admin.' . $parts[1] . '.index',
                    ];

                } else if(count($parts) === 4) {
                    // http://127.0.0.1:8000/admin/courses/1/edit
                    if($i == 1) {
                        $admin = 'admin';
                        $url = 'admin.' . $part . '.index';
                    } else if($i == 3) {
                        $url = 'admin.' . $parts[1] . '.' . $id . '.' . $parts[3];
                    } else if($i == 2) {
                        $url = 'admin.' . $parts[1] . '.' . $part;
                        $id = $parts[2];
                    }

                    $firstPartUrlArr = [
                        'name' => $parts[1] , 
                        'url' => 'admin.' . $parts[1] . '.index',
                    ];

                } else {
                    //http://127.0.0.1:8000/dashboard
                    $url = $part;
                }
            }

            $i++;
        }

        // $breadcrumbs[] = [
        //     'name' => $part, // You can customize the names as needed
        //     'url' => $url,
        // ];

        if ($part == 'dashboard') {
            $breadcrumbs[] = [
                'name' => 'home', 
                'url' => 'admin.dashboard',
            ];
        } else {
            $home_arr = [
                'name' => 'home', 
                'url' => 'admin.dashboard',
            ];

            $new_arr = [
                'name' => $part, // You can customize the names as needed
                'url' => $url,
            ];

            array_push($breadcrumbs, $home_arr, $new_arr);

            if(!empty($firstPartUrlArr)) {
                $newArr = array_merge(
                    array_slice($breadcrumbs, 0, 1), // Elements before the 2nd position
                    [$firstPartUrlArr],         // The value to insert
                    array_slice($breadcrumbs, 1)    // Elements from the 3rd position onwards
                );

                $breadcrumbs = $newArr;
            }
        }

        // dd($breadcrumbs);

        // Share the breadcrumbs with all views.
        view()->share('breadcrumbs', $breadcrumbs);

        return $next($request);
    }
}
