<?php

use App\Models\PartnershipLead;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SettingsSeeder;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
    $this->seed(SettingsSeeder::class);
});

test('partnership page renders with benefit calculator and partner application form', function () {
    $response = $this->get('/partnership');

    $response->assertStatus(200);
    $response->assertSee('Maksimalkan Potensi Properti');
    $response->assertSee('Model Kerja Sama');
    $response->assertSee('Ajukan Properti Anda');
});

test('submitting a valid partnership lead creates record with unique reference number', function () {
    $postData = [
        'owner_name' => 'Bambang Trihatmojo',
        'email' => 'bambang@example.com',
        'phone' => '081234567890',
        'owner_city' => 'Jakarta Selatan',
        'property_name' => 'Villa Candi Jogja',
        'property_type' => 'villa',
        'property_address' => 'Jl. Kaliurang KM 12, Sleman',
        'city' => 'Sleman',
        'land_size_sqm' => 500,
        'building_size_sqm' => 300,
        'number_of_rooms' => 4,
        'partnership_model' => 'revenue_sharing',
        'current_status' => 'ready_to_operate',
        'proposal_notes' => 'Ingin bergabung dengan brand Ubu Villa.',
    ];

    $response = $this->post(route('partnership.store'), $postData);

    $response->assertRedirect(route('partnership.index'));
    $response->assertSessionHas('reference_no');

    $this->assertDatabaseHas('partnership_leads', [
        'owner_name' => 'Bambang Trihatmojo',
        'email' => 'bambang@example.com',
        'property_name' => 'Villa Candi Jogja',
        'pipeline_status' => 'new',
    ]);

    $lead = PartnershipLead::where('email', 'bambang@example.com')->first();
    expect($lead)->not->toBeNull();
    expect($lead->reference_no)->toMatch('/^PRT-\d{6}-\d{4}$/');
    expect($lead->status_history)->toBeArray();
});

test('submitting partnership lead fails when required fields are missing', function () {
    $response = $this->post(route('partnership.store'), [
        'owner_name' => '',
        'email' => 'invalid-email',
    ]);

    $response->assertSessionHasErrors([
        'owner_name',
        'email',
        'phone',
        'property_name',
        'property_type',
        'property_address',
        'city',
        'partnership_model',
        'current_status',
    ]);
    $this->assertDatabaseCount('partnership_leads', 0);
});
