<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        try {
            if (!$token = JWTAuth::getToken()) {
                return $this->error('error', 'Token not provided', 401);
            }

            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return $this->error('error', 'User not found', 401);
            }
        } catch (\Exception $e) {
            return $this->error('error', $e->getMessage(), 401);
        }
        return $next($request);
    }
}
