<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description_id')->nullable();
            $table->text('description_en')->nullable();
            $table->unsignedSmallInteger('capacity_guests')->default(2);
            $table->unsignedSmallInteger('bedrooms')->default(1);
            $table->unsignedSmallInteger('bathrooms')->default(1);
            $table->string('beds_configuration')->nullable();
            $table->unsignedSmallInteger('area_sqm')->nullable();
            $table->decimal('price_estimate', 12, 2)->default(0);
            $table->string('sentec_room_type_id')->nullable();
            $table->json('images')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('property_amenity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('amenity_id')->constrained()->cascadeOnDelete();
            $table->unique(['property_id', 'amenity_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_amenity');
        Schema::dropIfExists('property_units');
    }
};
