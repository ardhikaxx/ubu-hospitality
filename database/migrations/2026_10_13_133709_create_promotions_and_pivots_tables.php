<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('slug')->unique();
            $table->string('title_id');
            $table->string('title_en');
            $table->string('subtitle_id')->nullable();
            $table->string('subtitle_en')->nullable();
            $table->longText('description_id')->nullable();
            $table->longText('description_en')->nullable();
            $table->string('discount_type', 20)->default('percentage'); // percentage, fixed_amount
            $table->decimal('discount_value', 12, 2)->default(0);
            $table->string('banner_image')->nullable();
            $table->date('booking_period_start');
            $table->date('booking_period_end');
            $table->date('stay_period_start');
            $table->date('stay_period_end');
            $table->longText('terms_conditions_id')->nullable();
            $table->longText('terms_conditions_en')->nullable();
            $table->boolean('is_new_user_only')->default(false);
            $table->boolean('is_popup')->default(false);
            $table->string('popup_cta_text')->nullable();
            $table->string('popup_cta_link')->nullable();
            $table->integer('priority')->default(0);
            $table->string('status', 20)->default('published'); // published, draft, expired
            $table->string('sentec_promo_sync_status', 30)->default('local_display_only');
            $table->timestamps();

            $table->index('status');
            $table->index('priority');
            $table->index(['booking_period_start', 'booking_period_end']);
            $table->index(['stay_period_start', 'stay_period_end']);
        });

        Schema::create('promotion_brand', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->constrained()->cascadeOnDelete();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->unique(['promotion_id', 'brand_id']);
            $table->timestamps();
        });

        Schema::create('promotion_property', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->unique(['promotion_id', 'property_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_property');
        Schema::dropIfExists('promotion_brand');
        Schema::dropIfExists('promotions');
    }
};
