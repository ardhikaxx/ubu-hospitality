<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('title_id');
            $table->string('title_en');
            $table->string('slug')->unique();
            $table->string('category')->default('adventure'); // wellness, culinary, adventure, family, culture, meeting
            $table->text('short_description_id')->nullable();
            $table->text('short_description_en')->nullable();
            $table->longText('content_id')->nullable();
            $table->longText('content_en')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->string('price_display')->nullable();
            $table->string('location')->nullable();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('property_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('sort_order')->default(0);
            $table->string('status', 20)->default('published'); // published, draft
            $table->string('meta_title_id')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->text('meta_description_id')->nullable();
            $table->text('meta_description_en')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('category');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
