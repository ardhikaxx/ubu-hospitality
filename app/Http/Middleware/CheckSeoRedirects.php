<?php

namespace App\Http\Middleware;

use App\Models\SeoRedirect;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class CheckSeoRedirects
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only run for GET requests and skip admin or api
        if ($request->isMethod('GET') && ! $request->is('admin*') && ! $request->is('api*')) {
            if (! Schema::hasTable('seo_redirects')) {
                return $next($request);
            }

            $path = '/'.ltrim($request->path(), '/');

            $redirect = SeoRedirect::active()
                ->where('source_url', $path)
                ->orWhere('source_url', $request->fullUrl())
                ->first();

            if ($redirect) {
                $redirect->increment('hits');

                return redirect($redirect->target_url, $redirect->status_code ?: 301);
            }
        }

        return $next($request);
    }
}
