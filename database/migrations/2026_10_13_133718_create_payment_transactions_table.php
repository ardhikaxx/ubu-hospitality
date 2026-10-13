<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 50)->unique();
            $table->string('reservation_reference', 50)->nullable()->index();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone', 30);
            $table->decimal('amount', 14, 2);
            $table->string('currency', 5)->default('IDR');
            $table->string('payment_channel', 50)->nullable();
            $table->string('status', 30)->default('pending'); // pending, paid, failed, expired, cancelled
            $table->string('doku_invoice_number')->nullable();
            $table->text('doku_payment_url')->nullable();
            $table->json('raw_request')->nullable();
            $table->json('raw_response')->nullable();
            $table->json('callback_payload')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
