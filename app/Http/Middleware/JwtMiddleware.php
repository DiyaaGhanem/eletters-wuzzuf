<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use \Illuminate\Http\Response as status;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Http;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $me = Http::withHeaders([
            'Authorization' => 'Bearer ' . request()->bearerToken(),
            'Accept' => 'application/json'
        ])->get(env('AUTH_URL') . '/me');

        if ($me->successful()) {
            return $next($request);
        }

        return response()->json([
            'status' => HttpResponse::HTTP_FORBIDDEN,
            'message' => 'Token invalied',
        ], HttpResponse::HTTP_FORBIDDEN);
    }
}
