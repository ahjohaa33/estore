<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class isCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
                // not logged in
        if (! Auth::check()) {
            // send to login
            return redirect()->route('userlogin')->with('error', 'Please login first.');
        }

        $user = Auth::user();

        // logged in but not customer
        if ($user->role !== 'customer') {
            // option 1: forbid
            abort(403, 'You are not allowed to access this page.');
            // OR option 2: redirect somewhere
            // return redirect()->route('home')->with('error', 'Only customers can access this page.');
        }

        return $next($request);
    }
}
