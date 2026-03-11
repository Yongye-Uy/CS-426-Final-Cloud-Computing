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
        Schema::table('donations', function (Blueprint $table) {
            $table->enum('payment_method', [
                'cash',
                'check',
                'credit_card',
                'bank_transfer',
                'online',
                'khqr'
            ])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->enum('payment_method', [
                'cash',
                'check',
                'credit_card',
                'bank_transfer',
                'online'
            ])->change();
        });
    }
};