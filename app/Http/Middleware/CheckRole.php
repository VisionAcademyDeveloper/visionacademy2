<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        if ($request->user() == null) {
            return Response::json([
                'success' => false,
                'message' => 'You have to login first'
            ], 401);
        }

        if (!$request->user()->hasAnyRole(explode('|', $roles))) {
            return Response::json([
                'success' => false,
                'message' => 'Access Denied!'
            ], 401);
        }

        return $next($request);
    }
}
