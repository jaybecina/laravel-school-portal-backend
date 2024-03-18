<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCurriculumParameter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('curriculum')) {
            return $next($request);
        }

        // Redirect or return an error response to restrict access.
        // return redirect()->route('restrictedAccessRoute'); // Replace 'restrictedAccessRoute' with the actual route or response you want to return.
        return redirect()->route('admin.enrollments.index')
                    ->with('danger','No curriculum selected to create new enrollment');
    }
}
