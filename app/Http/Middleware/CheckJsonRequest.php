<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class CheckJsonRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->wantsJson()) {
            return response()
                ->json([
                    'message' => 'Header missing Accept:Application/json',
                    'code' => Response::HTTP_NOT_ACCEPTABLE,
                ]);
        }

        return $next($request);
    }
}
