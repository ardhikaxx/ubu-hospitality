<?php

use App\Models\Brand;
use App\Models\Property;
use Database\Seeders\BrandsAndPropertiesSeeder;
use Database\Seeders\PagesAndNavigationsSeeder;
use Database\Seeders\PromotionsAndExperiencesSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SettingsSeeder;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
    $this->seed(SettingsSeeder::class);
    $this->seed(BrandsAndPropertiesSeeder::class);
    $this->seed(PromotionsAndExperiencesSeeder::class);
    $this->seed(PagesAndNavigationsSeeder::class);
});

test('home page renders successfully with ubu hospitality branding and featured villas', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Ubu Hospitality');
    $response->assertSee('Ubu Villa');
    $response->assertSee('Buruj Villa');
    $response->assertSee('images/branding/logo-light.png');
    $response->assertSee('footer-logo');
});

test('stay listing page renders with properties and search widget', function () {
    $response = $this->get('/stay');

    $response->assertStatus(200);
    $response->assertSee('Cari Akomodasi');
    $response->assertSee('Filter Properti');
});

test('property detail page renders with rich information, amenities, and booking button', function () {
    $property = Property::where('status', 'published')->first();

    $response = $this->get('/stay/'.$property->slug);

    $response->assertStatus(200);
    $response->assertSee($property->name);
    $response->assertSee('Pesan Sekarang');
});

test('brand showcase page renders brand identity and its villas', function () {
    $brand = Brand::where('slug', 'buruj-villa')->first();

    $response = $this->get('/brand/'.$brand->slug);

    $response->assertStatus(200);
    $response->assertSee($brand->name);
    $response->assertSee('Syariah');
});

test('offers listing page renders promotional vouchers', function () {
    $response = $this->get('/offer');

    $response->assertStatus(200);
    $response->assertSee('Penawaran Eksklusif');
});

test('experiences listing page renders curated activities', function () {
    $response = $this->get('/experience');

    $response->assertStatus(200);
    $response->assertSee('Aktivitas');
});

test('about page and contact page render static corporate information', function () {
    $responseAbout = $this->get('/about');
    $responseAbout->assertStatus(200);
    $responseAbout->assertSee('Tentang Ubu Hospitality');

    $responseContact = $this->get('/contact');
    $responseContact->assertStatus(200);
    $responseContact->assertSee('Hubungi Ubu Hospitality');
});

test('sitemap xml generates valid xml structure for search engines', function () {
    $response = $this->get('/sitemap.xml');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/xml');
    $response->assertSee('<urlset', false);
    $response->assertSee('http', false);
});

test('robots txt returns standard crawler guidelines', function () {
    $response = $this->get('/robots.txt');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
    $response->assertSee('User-agent: *');
    $response->assertSee('Disallow: /admin/');
});

test('new authentic pages celebrity, packages, life-at-ubu, csr, and career render successfully', function () {
    $celebrity = $this->get('/celebrity');
    $celebrity->assertStatus(200);
    $celebrity->assertSee('Celebrity Staycation');
    $celebrity->assertSee('Verrel Bramasta');

    $packages = $this->get('/packages');
    $packages->assertStatus(200);
    $packages->assertSee('Paket Wisata & Layanan Tambahan');
    $packages->assertSee('Floating Breakfast');

    $life = $this->get('/life-at-ubu');
    $life->assertStatus(200);
    $life->assertSee('Life at Ubu');
    $life->assertSee('Master of Warmth');

    $csr = $this->get('/csr');
    $csr->assertStatus(200);
    $csr->assertSee('Tumbuh Bersama');
    $csr->assertSee('Pemberdayaan Warga Lokal');

    $career = $this->get('/career');
    $career->assertStatus(200);
    $career->assertSee('Bergabung Bersama Ubu Hospitality');
    $career->assertSee('Private Villa Butler Specialist');

    $redirect = $this->get('/carrer');
    $redirect->assertRedirect('/career');
});

test('footer renders official payment partner badges and contacts', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Partner Pembayaran Resmi');
    $response->assertSee('bca.webp');
    $response->assertSee('mandiri.webp');
    $response->assertSee('mastercard.webp');
    $response->assertSee('0823-2000-3297');
});

test('navbar anchor sections and coupons exist in respective views', function () {
    $home = $this->get('/');
    $home->assertStatus(200);
    $home->assertSee('id="brands"', false);

    $about = $this->get('/about');
    $about->assertStatus(200);
    $about->assertSee('id="company_story"', false);
    $about->assertSee('id="hospitality_standards"', false);
    $about->assertSee('id="brands"', false);

    $partnership = $this->get('/partnership');
    $partnership->assertStatus(200);
    $partnership->assertSee('id="partnership_models"', false);
    $partnership->assertSee('id="submit"', false);

    $offers = $this->get('/offer');
    $offers->assertStatus(200);
    $offers->assertSee('id="coupons"', false);
    $offers->assertSee('UBUWELCOME');
});

test('experience categories filter properly for events and tours', function () {
    $events = $this->get('/experience?category=event');
    $events->assertStatus(200);
    $events->assertSee('Acara dan Pertemuan');

    $tours = $this->get('/experience?category=tour');
    $tours->assertStatus(200);
    $tours->assertSee('Pengalaman Lokal');
});

test('canonical url redirects from codeapps website work smoothly', function () {
    $this->get('/join-us')->assertRedirect('/partnership');
    $this->get('/promotion')->assertRedirect('/offer');
    $this->get('/promo')->assertRedirect('/offer');
    $this->get('/villa')->assertRedirect('/stay');
    $this->get('/villas')->assertRedirect('/stay');
    $this->get('/about-us')->assertRedirect('/about');
    $this->get('/contact-us')->assertRedirect('/contact');
    $this->get('/term-condition')->assertRedirect('/terms');
    $this->get('/terms-and-conditions')->assertRedirect('/terms');
});

test('mobile navbar renders compact actions and modern draw menu', function () {
    $response = $this->get('/');
    $response->assertStatus(200);

    // Verify compact mobile action buttons
    $response->assertSee('mobile-nav-actions');
    $response->assertSee('mobile-action-btn mobile-search-btn');
    $response->assertSee('mobile-action-btn mobile-drawer-btn');
    $response->assertSee('drawer-hamburger-bars');

    // Verify draw menu offcanvas container and header
    $response->assertSee('mobile-draw-menu');
    $response->assertSee('id="mobileMenuOffcanvas"', false);
    $response->assertSee('btn-drawer-close');
    $response->assertSee('drawer-search-card');

    // Verify collapsible navigation groups
    $response->assertSee('#collapseAbout', false);
    $response->assertSee('#collapseStay', false);
    $response->assertSee('#collapseExperience', false);
    $response->assertSee('#collapseOffer', false);
    $response->assertSee('#collapsePartnership', false);

    // Verify footer actions inside draw menu
    $response->assertSee('drawer-lang-toggle');
    $response->assertSee('btn-drawer-wa');
    $response->assertSee('Cek Ketersediaan & Booking', false);
});

test('properties listing renders sticky desktop filter sidebar and mobile offcanvas drawer', function () {
    $response = $this->get(route('stay.index'));
    $response->assertStatus(200);

    // Verify desktop sticky filter sidebar
    $response->assertSee('Filter Properti');
    $response->assertSee('sticky-top');

    // Verify mobile filter action bar and offcanvas drawer
    $response->assertSee('propertyFilterOffcanvas');
    $response->assertSee('Filter & Urutkan Properti', false);
});
