<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = Auth::user();

        if (! $user || ! $user->hasPermission($permission)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Anda tidak memiliki hak akses untuk tindakan ini.'], 403);
            }

            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak: Anda tidak memiliki izin untuk modul tersebut.');
        }

        return $next($request);
    }
}
