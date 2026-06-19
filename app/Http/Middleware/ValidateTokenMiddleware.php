<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateTokenMiddleware
{
    /*
     * Main function of the middleware
     * Request $request -> represents the request (headers, body, query params, cookies, auth, session)
     * Clousure $next -> This middleware finished, continue with the process
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Checking there is a token saved in session memory
        if(!session('token')) {
            return redirect('login');
        }

        // Checking the user token has permissions
        if(session('user')['role'] != 'Admin' && session('user')['role'] != 'Receptionist') {
            return redirect('login');
        }

        return $next($request);
    }
}
