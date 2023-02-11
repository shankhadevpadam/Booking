<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->isAdmin() && $request->route()->named('home')) {
            return redirect()->route('admin.home');
        }

        abort_if(auth()->user()->isAdmin(), Response::HTTP_FORBIDDEN);

        return $next($request);
    }
}
