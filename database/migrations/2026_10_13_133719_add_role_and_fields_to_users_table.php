<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->after('id')->constrained('roles')->nullOnDelete();
            $table->string('phone', 30)->nullable()->after('email');
            $table->string('avatar_url')->nullable()->after('phone');
            $table->boolean('is_active')->default(true)->after('avatar_url');
            $table->dateTime('last_login_at')->nullable()->after('is_active');
            $table->text('two_factor_secret')->nullable()->after('last_login_at');
            $table->text('two_factor_recovery_codes')->nullable()->after('two_factor_secret');
            $table->dateTime('two_factor_confirmed_at')->nullable()->after('two_factor_recovery_codes');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn([
                'role_id',
                'phone',
                'avatar_url',
                'is_active',
                'last_login_at',
                'two_factor_secret',
                'two_factor_recovery_codes',
                'two_factor_confirmed_at',
            ]);
        });
    }
};
