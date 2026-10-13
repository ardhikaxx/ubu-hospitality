<?php

namespace App\Providers;

use App\Models\Brand;
use App\Services\Navigation\NavigationService;
use App\Services\Payment\DokuPaymentService;
use App\Services\Payment\PaymentServiceInterface;
use App\Services\Sentec\SentecReservationService;
use App\Services\Sentec\SentecServiceInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SentecServiceInterface::class, SentecReservationService::class);
        $this->app->singleton(PaymentServiceInterface::class, DokuPaymentService::class);
        $this->app->singleton(NavigationService::class, NavigationService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Global Numbers-Only Pagination Matching Brand Theme
        Paginator::defaultView('vendor.pagination.numbers-only');
        Paginator::defaultSimpleView('vendor.pagination.numbers-only');

        // View Composer for sharing active brands and navigation in public layout
        View::composer('layouts.public', function ($view) {
            if (Schema::hasTable('brands')) {
                $navBrands = Brand::active()->ordered()->get();
                $view->with('navBrands', $navBrands);
            }
        });
    }
}
