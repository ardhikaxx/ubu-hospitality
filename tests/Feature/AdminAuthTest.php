<?php

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SettingsSeeder;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
    $this->seed(SettingsSeeder::class);
    $this->admin = User::where('email', 'admin@ubuhospitality.com')->first();
});

test('login page renders with ubu hospitality cms identity', function () {
    $response = $this->get(route('admin.login'));

    $response->assertStatus(200);
    $response->assertSee('UBU HOSPITALITY');
    $response->assertSee('Masuk ke Dashboard');
});

test('admin can authenticate with valid credentials and access dashboard', function () {
    $response = $this->post(route('admin.login.submit'), [
        'email' => 'admin@ubuhospitality.com',
        'password' => 'AdminUbu2026!',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($this->admin);

    $dashboardResponse = $this->actingAs($this->admin)->get(route('admin.dashboard'));
    $dashboardResponse->assertStatus(200);
    $dashboardResponse->assertSee('Dashboard Operasional');
});

test('admin login fails with invalid credentials and displays error message', function () {
    $response = $this->post(route('admin.login.submit'), [
        'email' => 'admin@ubuhospitality.com',
        'password' => 'WrongPassword123',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('unauthenticated user cannot access protected cms routes', function () {
    $response = $this->get(route('admin.dashboard'));

    $response->assertRedirect(route('admin.login'));
});

test('admin can logout successfully and session is cleared', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.logout'));

    $response->assertRedirect(route('admin.login'));
    $this->assertGuest();
});

test('admin can view and update their profile', function () {
    $profileResponse = $this->actingAs($this->admin)->get(route('admin.profile'));
    $profileResponse->assertStatus(200);
    $profileResponse->assertSee($this->admin->name);

    $updateResponse = $this->actingAs($this->admin)->post(route('admin.profile.update'), [
        'name' => 'Chief Executive Admin',
        'email' => 'admin@ubuhospitality.com',
        'phone' => '081234567890',
    ]);

    $updateResponse->assertRedirect();
    $updateResponse->assertSessionHas('success');

    $this->admin->refresh();
    expect($this->admin->name)->toBe('Chief Executive Admin');
    expect($this->admin->phone)->toBe('081234567890');
});
