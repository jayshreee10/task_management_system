<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticatePusher
{
    public function handle(Request $request, Closure $next)
    {
        try {
            if ($request->header('Authorization')) {
                JWTAuth::parseToken()->authenticate();
            } else if ($request->cookie('jwt')) {
                // If using JWT in cookie
                $token = $request->cookie('jwt');
                JWTAuth::setToken($token)->authenticate();
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
