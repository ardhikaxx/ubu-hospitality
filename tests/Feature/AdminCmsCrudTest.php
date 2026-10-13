<?php

use App\Models\Brand;
use App\Models\Destination;
use App\Models\PartnershipLead;
use App\Models\PropertyType;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\BrandsAndPropertiesSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SettingsSeeder;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
    $this->seed(SettingsSeeder::class);
    $this->seed(BrandsAndPropertiesSeeder::class);

    $this->admin = User::where('email', 'admin@ubuhospitality.com')->first();
});

test('admin can create and update a brand', function () {
    $createResponse = $this->actingAs($this->admin)->post(route('admin.brands.store'), [
        'name' => 'Royal Ubu Heritage',
        'slug' => 'royal-ubu-heritage',
        'positioning_type' => 'luxury',
        'tagline_id' => 'Boutique Heritage Resort',
        'tagline_en' => 'Boutique Heritage Resort',
        'description_id' => 'Koleksi villa heritage eksklusif.',
        'is_active' => 1,
        'sort_order' => 5,
    ]);

    $createResponse->assertRedirect(route('admin.brands.index'));
    $createResponse->assertSessionHas('success');

    $this->assertDatabaseHas('brands', [
        'name' => 'Royal Ubu Heritage',
        'slug' => 'royal-ubu-heritage',
        'positioning_type' => 'luxury',
        'is_active' => 1,
    ]);

    $brand = Brand::where('slug', 'royal-ubu-heritage')->first();

    $updateResponse = $this->actingAs($this->admin)->put(route('admin.brands.update', $brand), [
        'name' => 'Royal Ubu Heritage Villas',
        'slug' => 'royal-ubu-heritage-villas',
        'positioning_type' => 'luxury',
        'tagline_id' => 'Updated Tagline',
        'tagline_en' => 'Updated Tagline EN',
        'description_id' => 'Deskripsi baru villa heritage.',
        'is_active' => 1,
        'sort_order' => 10,
    ]);

    $updateResponse->assertRedirect(route('admin.brands.index'));
    $this->assertDatabaseHas('brands', [
        'id' => $brand->id,
        'name' => 'Royal Ubu Heritage Villas',
    ]);
});

test('admin can create a property under a brand', function () {
    $brand = Brand::first();
    $destination = Destination::first();
    $type = PropertyType::first();

    $postData = [
        'brand_id' => $brand->id,
        'destination_id' => $destination->id,
        'property_type_id' => $type->id,
        'name' => 'Ubu Villa Prambanan View',
        'slug' => 'ubu-villa-prambanan-view',
        'city' => 'Sleman',
        'address' => 'Jl. Solo KM 14, Sleman, Yogyakarta',
        'headline_id' => 'Villa Mewah Dekat Candi Prambanan',
        'headline_en' => 'Luxury Villa Near Prambanan Temple',
        'description_id' => 'Villa privat dengan pemandangan megah dan private pool.',
        'bedrooms' => 3,
        'bathrooms' => 3,
        'max_guests' => 8,
        'starting_price_display' => 1750000,
        'has_private_pool' => 1,
        'is_syariah' => 0,
        'status' => 'published',
        'sentec_property_id' => 'SENTEC-UV-099',
    ];

    $response = $this->actingAs($this->admin)->post(route('admin.properties.store'), $postData);

    $response->assertRedirect(route('admin.properties.index'));
    $this->assertDatabaseHas('properties', [
        'name' => 'Ubu Villa Prambanan View',
        'sentec_property_id' => 'SENTEC-UV-099',
        'status' => 'published',
    ]);
});

test('admin can manage partnership leads pipeline and export csv', function () {
    $lead = PartnershipLead::create([
        'reference_no' => 'PRT-202610-0999',
        'owner_name' => 'Hendra Kusuma',
        'email' => 'hendra@example.com',
        'phone' => '081234567899',
        'property_name' => 'Villa Merapi Indah',
        'property_type' => 'villa',
        'property_address' => 'Pakem, Sleman',
        'city' => 'Sleman',
        'partnership_model' => 'full_management',
        'current_status' => 'ready_to_operate',
        'pipeline_status' => 'new',
        'status_history' => [],
    ]);

    // Review Lead Page
    $showResponse = $this->actingAs($this->admin)->get(route('admin.partnerships.show', $lead));
    $showResponse->assertStatus(200);
    $showResponse->assertSee('PRT-202610-0999');
    $showResponse->assertSee('Hendra Kusuma');

    // Update Status
    $statusResponse = $this->actingAs($this->admin)->post(route('admin.partnerships.status', $lead), [
        'pipeline_status' => 'survey_scheduled',
        'status_note' => 'Jadwal survey lokasi disepakati 25 Oktober 2026.',
    ]);

    $statusResponse->assertRedirect();
    $lead->refresh();
    expect($lead->pipeline_status)->toBe('survey_scheduled');

    // Update Notes & Assignee
    $notesResponse = $this->actingAs($this->admin)->post(route('admin.partnerships.notes', $lead), [
        'internal_notes' => 'Aset sangat potensial dengan 4 kamar dan kolam renang besar.',
        'assigned_to' => $this->admin->id,
    ]);

    $notesResponse->assertRedirect();
    $lead->refresh();
    expect($lead->internal_notes)->toBe('Aset sangat potensial dengan 4 kamar dan kolam renang besar.');
    expect($lead->assigned_to)->toBe($this->admin->id);

    // Export CSV
    $exportResponse = $this->actingAs($this->admin)->get(route('admin.partnerships.export'));
    $exportResponse->assertStatus(200);
    $exportResponse->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
});

test('admin can update platform settings', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.settings.update'), [
        'company_name' => 'PT Ubu Hospitality Indonesia Sejahtera',
        'contact_whatsapp' => '+6289911223344',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    expect(Setting::get('company_name'))->toBe('PT Ubu Hospitality Indonesia Sejahtera');
    expect(Setting::get('contact_whatsapp'))->toBe('+6289911223344');
});
