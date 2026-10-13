<?php

use App\Models\Property;
use App\Services\Sentec\SentecServiceInterface;
use Carbon\Carbon;
use Database\Seeders\BrandsAndPropertiesSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SettingsSeeder;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
    $this->seed(SettingsSeeder::class);
    $this->seed(BrandsAndPropertiesSeeder::class);
    $this->property = Property::whereNotNull('sentec_property_id')->first();
});

test('sentec service resolves availability and estimated rates', function () {
    $service = app(SentecServiceInterface::class);

    $checkIn = Carbon::tomorrow()->format('Y-m-d');
    $checkOut = Carbon::tomorrow()->addDays(2)->format('Y-m-d');

    $availability = $service->checkAvailability($this->property->sentec_property_id, $checkIn, $checkOut, 2);

    expect($availability)->toBeArray();
    expect($availability['available'])->toBeTrue();
    expect($availability['currency'])->toBe('IDR');
    expect($availability)->toHaveKey('nights');
    expect($availability)->toHaveKey('total_rate');
    expect($availability['is_mock'])->toBeTrue();
});

test('sentec booking url includes property code, dates, and guest parameters', function () {
    $service = app(SentecServiceInterface::class);

    $url = $service->generateBookingUrl($this->property, [
        'check_in' => '2026-11-01',
        'check_out' => '2026-11-03',
        'guests' => 4,
    ]);

    expect($url)->toContain('booking.ubuhospitality.com');
    expect($url)->toContain('property_id='.$this->property->sentec_property_id);
    expect($url)->toContain('check_in=2026-11-01');
    expect($url)->toContain('check_out=2026-11-03');
    expect($url)->toContain('guests=4');
    expect($url)->toContain('ref=ubuhospitality.com');
});
