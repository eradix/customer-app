<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //must put authorization in header the 'my-secret-token' as value to proceed
        if ($request->header('Authorization') !== 'my_ultimate_secret_token') {
            return response()->json(['message' => "Invalid token!"]);
        }
        return $next($request);
    }
}
