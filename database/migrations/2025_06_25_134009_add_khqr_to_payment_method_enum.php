<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            // Modify the payment_method enum to include 'khqr'
            DB::statement("ALTER TABLE donations MODIFY COLUMN payment_method ENUM('cash', 'check', 'credit_card', 'bank_transfer', 'online', 'khqr') NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            // Revert back to original enum values
            DB::statement("ALTER TABLE donations MODIFY COLUMN payment_method ENUM('cash', 'check', 'credit_card', 'bank_transfer', 'online') NOT NULL");
        });
    }
};
