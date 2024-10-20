<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class is_administrator
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->is_administrator == '1') {
            return redirect('/');
        }

        return $next($request);
    }
}
