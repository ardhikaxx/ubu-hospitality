<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('lang')) {
            $lang = $request->get('lang');
            if (in_array($lang, ['id', 'en'], true)) {
                session(['locale' => $lang]);
            }
        }

        $locale = session('locale', config('app.locale', 'id'));
        app()->setLocale($locale);

        return $next($request);
    }
}
