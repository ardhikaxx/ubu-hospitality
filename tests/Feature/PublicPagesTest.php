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
