<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_master_brand')->default(false);
            $table->string('tagline_id')->nullable();
            $table->string('tagline_en')->nullable();
            $table->text('description_id')->nullable();
            $table->text('description_en')->nullable();
            $table->longText('story_id')->nullable();
            $table->longText('story_en')->nullable();
            $table->string('positioning_type')->default('standard'); // syariah, luxury, glamping, standard, master
            $table->json('character_highlights_id')->nullable();
            $table->json('character_highlights_en')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('cover_image_path')->nullable();
            $table->json('gallery_images')->nullable();
            $table->string('accent_color', 30)->default('#1e3a2b');
            $table->string('secondary_color', 30)->default('#c5a059');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title_id')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->text('meta_description_id')->nullable();
            $table->text('meta_description_en')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('is_active');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
