<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NewsHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasHeader('content-type')) {
            if ($request->header('content-type') == 'application/json') {
                return $next($request);
            }
        }

        abort(400, "Set 'Accept' value to 'application/json'");
    }
}
