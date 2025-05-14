<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// 認証機能追加
use Illuminate\Support\Facades\Auth;

class EnsureProfileIsComplete
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
        if (is_null($request->user()->profile)) {
            return redirect()->route('profile.edit');
        }

        return $next($request);
    }
}
