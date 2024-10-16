<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the authenticated user has the 'admin' role
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            return $next($request);
        }

        // Redirect or return a 403 error if the user is not an admin
        return redirect('/')->with('error', 'You do not have access to this page.');
        // or abort(403, 'Unauthorized action.');
    }
}
