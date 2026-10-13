<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('admin.login')->with('warning', 'Silakan masuk terlebih dahulu untuk mengakses panel admin.');
        }

        if (! Auth::user()->is_active) {
            Auth::logout();

            return redirect()->route('admin.login')->with('error', 'Akun Anda dinonaktifkan. Silakan hubungi Super Administrator.');
        }

        return $next($request);
    }
}
