<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_id');
            $table->string('title_en');
            $table->string('subtitle_id')->nullable();
            $table->string('subtitle_en')->nullable();
            $table->string('status', 20)->default('published');
            $table->string('meta_title_id')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->text('meta_description_id')->nullable();
            $table->text('meta_description_en')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
        });

        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->string('section_key');
            $table->string('title_id')->nullable();
            $table->string('title_en')->nullable();
            $table->string('subtitle_id')->nullable();
            $table->string('subtitle_en')->nullable();
            $table->longText('content_id')->nullable();
            $table->longText('content_en')->nullable();
            $table->string('media_path')->nullable();
            $table->json('extra_data')->nullable(); // For repeatable blocks, stats, FAQs, accordion
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['page_id', 'sort_order']);
            $table->index('section_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_sections');
        Schema::dropIfExists('pages');
    }
};
