<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        app()->setLocale(LaravelLocalization::getCurrentLocale());
        return $next($request);
    }
}
