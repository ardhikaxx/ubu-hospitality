<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_id');
            $table->string('name_en');
            $table->string('slug')->unique();
            $table->text('description_id')->nullable();
            $table->text('description_en')->nullable();
            $table->timestamps();
        });

        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('blog_categories')->cascadeOnDelete();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->string('title_id');
            $table->string('title_en');
            $table->string('slug')->unique();
            $table->text('excerpt_id')->nullable();
            $table->text('excerpt_en')->nullable();
            $table->longText('content_id');
            $table->longText('content_en')->nullable();
            $table->string('featured_image')->nullable();
            $table->unsignedSmallInteger('reading_time_minutes')->default(3);
            $table->json('related_property_ids')->nullable();
            $table->string('status', 20)->default('published'); // published, draft, scheduled, archived
            $table->dateTime('published_at')->nullable();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->string('meta_title_id')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->text('meta_description_id')->nullable();
            $table->text('meta_description_en')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('status');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('blog_categories');
    }
};
