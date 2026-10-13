<?php

use App\Http\Controllers\Admin\AmenityController as AdminAmenityController;
use App\Http\Controllers\Admin\AuditLogController as AdminAuditLogController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ExperienceController as AdminExperienceController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\Admin\NavigationController as AdminNavigationController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PartnershipController as AdminPartnershipController;
use App\Http\Controllers\Admin\PromotionController as AdminPromotionController;
use App\Http\Controllers\Admin\PropertyController as AdminPropertyController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\SeoController as AdminSeoController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/cookies', [PageController::class, 'cookies'])->name('cookies');

// Brands
Route::get('/brand/{slug}', [BrandController::class, 'show'])->name('brand.show');

// Properties (Stay)
Route::get('/stay', [PropertyController::class, 'index'])->name('stay.index');
Route::get('/stay/{slug}', [PropertyController::class, 'show'])->name('stay.show');
Route::get('/stay/{slug}/book', [PropertyController::class, 'book'])->name('stay.book');
Route::get('/api/stay/{slug}/availability', [PropertyController::class, 'checkAvailabilityApi'])->name('api.stay.availability');

// Offers / Promotions
Route::get('/offer', [OfferController::class, 'index'])->name('offer.index');
Route::get('/offer/{slug}', [OfferController::class, 'show'])->name('offer.show');

// Experiences
Route::get('/experience', [ExperienceController::class, 'index'])->name('experience.index');
Route::get('/experience/{slug}', [ExperienceController::class, 'show'])->name('experience.show');

// Partnership
Route::get('/partnership', [PartnershipController::class, 'index'])->name('partnership.index');
Route::post('/partnership/submit', [PartnershipController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('partnership.store');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Technical SEO: Sitemap & Robots
Route::get('/sitemap.xml', [SitemapController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

// Payment Webhook & Mock Sandbox
Route::post('/payment/doku/webhook', [PaymentController::class, 'dokuWebhook'])->name('payment.doku.webhook');
Route::get('/payment/mock-checkout/{invoice}', [PaymentController::class, 'mockCheckout'])->name('payment.mock-checkout');
Route::post('/payment/mock-complete/{invoice}', [PaymentController::class, 'mockComplete'])->name('payment.mock-complete');

/*
|--------------------------------------------------------------------------
| Admin CMS Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Auth
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Protected CMS Area
    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profile', [AdminAuthController::class, 'showProfile'])->name('profile');
        Route::post('/profile', [AdminAuthController::class, 'updateProfile'])->name('profile.update');

        // Hospitality Modules
        Route::resource('brands', AdminBrandController::class);
        Route::resource('properties', AdminPropertyController::class);
        Route::resource('amenities', AdminAmenityController::class)->except(['create', 'edit', 'show']);

        // Marketing & Content Modules
        Route::resource('promotions', AdminPromotionController::class);
        Route::resource('experiences', AdminExperienceController::class);
        Route::resource('blog', AdminBlogController::class);

        // Partnership Leads
        Route::get('/partnerships', [AdminPartnershipController::class, 'index'])->name('partnerships.index');
        Route::get('/partnerships/export', [AdminPartnershipController::class, 'export'])->name('partnerships.export');
        Route::get('/partnerships/{lead}', [AdminPartnershipController::class, 'show'])->name('partnerships.show');
        Route::post('/partnerships/{lead}/status', [AdminPartnershipController::class, 'updateStatus'])->name('partnerships.status');
        Route::post('/partnerships/{lead}/notes', [AdminPartnershipController::class, 'updateNotes'])->name('partnerships.notes');

        // Content & Structure
        Route::get('/pages', [AdminPageController::class, 'index'])->name('pages.index');
        Route::get('/pages/{page}/edit', [AdminPageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{page}', [AdminPageController::class, 'update'])->name('pages.update');
        Route::put('/pages/section/{section}', [AdminPageController::class, 'updateSection'])->name('pages.section.update');

        Route::resource('navigations', AdminNavigationController::class)->except(['create', 'edit', 'show']);

        Route::get('/media', [AdminMediaController::class, 'index'])->name('media.index');
        Route::post('/media', [AdminMediaController::class, 'store'])->name('media.store');
        Route::delete('/media/{media}', [AdminMediaController::class, 'destroy'])->name('media.destroy');

        Route::resource('reviews', AdminReviewController::class)->except(['create', 'edit', 'show']);

        // SEO & Redirects
        Route::get('/seo', [AdminSeoController::class, 'index'])->name('seo.index');
        Route::post('/seo/settings', [AdminSeoController::class, 'updateSettings'])->name('seo.settings');
        Route::post('/seo/redirects', [AdminSeoController::class, 'storeRedirect'])->name('seo.redirects.store');
        Route::put('/seo/redirects/{redirect}', [AdminSeoController::class, 'updateRedirect'])->name('seo.redirects.update');
        Route::delete('/seo/redirects/{redirect}', [AdminSeoController::class, 'destroyRedirect'])->name('seo.redirects.destroy');

        // System Administration
        Route::resource('users', AdminUserController::class)->except(['create', 'edit', 'show']);
        Route::get('/audit-logs', [AdminAuditLogController::class, 'index'])->name('audit-logs.index');
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });
});
