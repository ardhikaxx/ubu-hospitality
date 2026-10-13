<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('video_url')->nullable()->after('featured_image');
            $table->text('google_maps_embed_url')->nullable()->after('google_maps_url');
            $table->string('virtual_tour_url')->nullable()->after('video_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['video_url', 'google_maps_embed_url', 'virtual_tour_url']);
        });
    }
};
