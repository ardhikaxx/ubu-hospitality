<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('name_id');
            $table->string('name_en');
            $table->string('category')->default('general'); // general, room, outdoor, service, syariah
            $table->string('icon')->default('bi-check2-circle');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('destination_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('headline_id')->nullable();
            $table->string('headline_en')->nullable();
            $table->longText('description_id')->nullable();
            $table->longText('description_en')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->default('Yogyakarta');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 11, 7)->nullable();
            $table->text('google_maps_url')->nullable();
            $table->unsignedSmallInteger('max_guests')->default(2);
            $table->unsignedSmallInteger('bedrooms')->default(1);
            $table->unsignedSmallInteger('bathrooms')->default(1);
            $table->string('beds_description')->nullable();
            $table->unsignedSmallInteger('area_sqm')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->decimal('starting_price_display', 12, 2)->default(0);
            $table->string('currency', 5)->default('IDR');
            $table->boolean('has_private_pool')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_syariah')->default(false);
            $table->string('sentec_property_id')->nullable()->unique();
            $table->string('booking_engine_url')->nullable();
            $table->longText('house_rules_id')->nullable();
            $table->longText('house_rules_en')->nullable();
            $table->string('checkin_time', 10)->default('14:00');
            $table->string('checkout_time', 10)->default('12:00');
            $table->text('cancellation_policy_id')->nullable();
            $table->text('cancellation_policy_en')->nullable();
            $table->json('nearby_attractions')->nullable();
            $table->integer('sort_order')->default(0);
            $table->string('status', 20)->default('published'); // published, draft, archived
            $table->string('meta_title_id')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->text('meta_description_id')->nullable();
            $table->text('meta_description_en')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('status');
            $table->index('is_featured');
            $table->index('has_private_pool');
            $table->index('is_syariah');
            $table->index('city');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
        Schema::dropIfExists('amenities');
    }
};
