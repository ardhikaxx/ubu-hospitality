<?php

use App\Models\Brand;
use App\Models\Destination;
use App\Models\MediaFile;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;
use App\Services\ImageUploadService;
use Database\Seeders\BrandsAndPropertiesSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SettingsSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
    $this->seed(SettingsSeeder::class);
    $this->seed(BrandsAndPropertiesSeeder::class);

    $this->admin = User::where('email', 'admin@ubuhospitality.com')->first();
});

test('image upload service processes, resizes, and saves image without storage:link', function () {
    $service = app(ImageUploadService::class);
    $file = UploadedFile::fake()->image('test_villa.jpg', 1600, 1200);

    $path = $service->processAndStore($file, 'test_properties', 'test_main');

    expect($path)->toStartWith('uploads/test_properties/');
    expect(File::exists(public_path($path)))->toBeTrue();
    expect(File::exists(storage_path($path)))->toBeTrue();

    // Verify stream route serves without storage:link
    $response = $this->get('/'.$path);
    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'image/webp');
    $response->assertHeader('Cache-Control', 'immutable, max-age=31536000, public');

    // Clean up
    $service->delete($path);
    expect(File::exists(public_path($path)))->toBeFalse();
    expect(File::exists(storage_path($path)))->toBeFalse();
});

test('admin can upload featured image when creating property and it serves without storage:link', function () {
    $brand = Brand::first();
    $destination = Destination::first();
    $type = PropertyType::first();
    $fakeImage = UploadedFile::fake()->image('prambanan_villa.png', 800, 600);

    $response = $this->actingAs($this->admin)->post(route('admin.properties.store'), [
        'brand_id' => $brand->id,
        'destination_id' => $destination->id,
        'property_type_id' => $type->id,
        'name' => 'Ubu Villa Upload Test',
        'city' => 'Sleman',
        'address' => 'Jl. Kaliurang KM 12',
        'description_id' => 'Deskripsi villa upload test',
        'bedrooms' => 2,
        'bathrooms' => 2,
        'max_guests' => 4,
        'starting_price_display' => 1200000,
        'status' => 'published',
        'featured_image_file' => $fakeImage,
    ]);

    $response->assertRedirect(route('admin.properties.index'));

    $property = Property::where('name', 'Ubu Villa Upload Test')->first();
    expect($property)->not->toBeNull();
    expect($property->featured_image)->toStartWith('uploads/properties/');

    // Check file exists in both public and storage uploads
    expect(File::exists(public_path($property->featured_image)))->toBeTrue();

    // Verify public route streams without storage link
    $imgResponse = $this->get('/'.$property->featured_image);
    $imgResponse->assertStatus(200);

    // Test replace image on update
    $newFakeImage = UploadedFile::fake()->image('updated_villa.jpg', 800, 600);
    $oldPath = $property->featured_image;

    $updateResponse = $this->actingAs($this->admin)->put(route('admin.properties.update', $property), [
        'brand_id' => $brand->id,
        'destination_id' => $destination->id,
        'property_type_id' => $type->id,
        'name' => 'Ubu Villa Upload Test Updated',
        'slug' => $property->slug,
        'city' => 'Sleman',
        'description_id' => 'Deskripsi villa upload test updated',
        'bedrooms' => 2,
        'bathrooms' => 2,
        'max_guests' => 4,
        'starting_price_display' => 1300000,
        'status' => 'published',
        'featured_image_file' => $newFakeImage,
    ]);

    $updateResponse->assertRedirect(route('admin.properties.index'));
    $property->refresh();

    expect($property->featured_image)->not->toBe($oldPath);
    expect(File::exists(public_path($oldPath)))->toBeFalse();
    expect(File::exists(public_path($property->featured_image)))->toBeTrue();

    // Test delete property removes image from disk
    $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.properties.destroy', $property));
    $deleteResponse->assertRedirect(route('admin.properties.index'));
    expect(File::exists(public_path($property->featured_image)))->toBeFalse();
});

test('admin media library uploads and deletes without storage:link', function () {
    $fakeFile = UploadedFile::fake()->image('banner_media.jpg', 1000, 800);

    $response = $this->actingAs($this->admin)->post(route('admin.media.store'), [
        'file' => $fakeFile,
        'alt_text_id' => 'Banner Media Test',
        'caption' => 'Keterangan Banner',
    ]);

    $response->assertRedirect();
    $media = MediaFile::where('alt_text_id', 'Banner Media Test')->first();
    expect($media)->not->toBeNull();
    expect($media->path)->toStartWith('uploads/media/');
    expect(File::exists(public_path($media->path)))->toBeTrue();

    // Verify media url works
    expect($media->url)->toBe(asset($media->path));

    // Delete media
    $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.media.destroy', $media));
    $deleteResponse->assertRedirect();
    expect(File::exists(public_path($media->path)))->toBeFalse();
});

test('home page jelajahi lokasi section renders authentic city landmark images', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Jelajahi Lokasi');
    $response->assertSee('Destinasi Terbaik di Yogyakarta');
    $response->assertSee('Sleman');
    $response->assertSee('Kaliurang');
    $response->assertSee('Bantul');
    $response->assertSee('Kota Yogyakarta');

    // Verify all 4 authentic landmark photos are referenced in HTML
    $response->assertSee('images/destinations/sleman.jpg');
    $response->assertSee('images/destinations/kaliurang.jpg');
    $response->assertSee('images/destinations/bantul.jpg');
    $response->assertSee('images/destinations/kota-yogyakarta.jpg');
});
