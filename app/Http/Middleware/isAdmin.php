<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // make sure user is logged in
        if (!auth()->check()) {
            return redirect()->route('userlogin');
        }

        // adjust this condition to your users table
        // e.g. 'is_admin' == 1  OR  'role' == 'admin'
        $user = auth()->user();
        if ($user->role !== 'admin') {
            return abort(403, 'You are not allowed to access this page');
        }

        return $next($request);
    }
}

