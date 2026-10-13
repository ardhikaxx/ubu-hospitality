<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partnership_leads', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no', 30)->unique();
            $table->string('owner_name');
            $table->string('company_name')->nullable();
            $table->string('email');
            $table->string('phone', 30);
            $table->string('property_name');
            $table->string('property_type')->default('villa'); // villa, glamping, resort, hotel, land, other
            $table->text('property_address');
            $table->string('city')->default('Yogyakarta');
            $table->unsignedInteger('land_size_sqm')->nullable();
            $table->unsignedInteger('building_size_sqm')->nullable();
            $table->unsignedSmallInteger('number_of_rooms')->nullable();
            $table->string('partnership_model')->default('full_management'); // full_management, revenue_sharing, branding_only, consultation
            $table->string('current_status')->default('ready_to_operate'); // ready_to_operate, under_construction, design_planning, land_only
            $table->longText('proposal_notes')->nullable();
            $table->longText('internal_notes')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->string('pipeline_status', 30)->default('new'); // new, contacted, survey_scheduled, under_review, negotiation, approved, rejected
            $table->json('status_history')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('pipeline_status');
            $table->index('property_type');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partnership_leads');
    }
};
