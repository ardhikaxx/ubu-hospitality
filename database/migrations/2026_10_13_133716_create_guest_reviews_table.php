<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guest_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('guest_name');
            $table->string('guest_origin')->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->longText('review_text_id');
            $table->longText('review_text_en')->nullable();
            $table->date('review_date');
            $table->string('source', 20)->default('google'); // google, sentec, direct
            $table->string('google_review_id')->nullable();
            $table->string('avatar_url')->nullable();
            $table->boolean('is_verified')->default(true);
            $table->boolean('is_featured')->default(true);
            $table->string('status', 20)->default('published'); // published, hidden
            $table->timestamps();

            $table->index('status');
            $table->index('rating');
            $table->index('is_featured');
            $table->index('source');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_reviews');
    }
};
