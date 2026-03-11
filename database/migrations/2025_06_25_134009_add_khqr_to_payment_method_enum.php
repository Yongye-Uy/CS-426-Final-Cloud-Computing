<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {

            // drop old column
            $table->dropColumn('payment_method');

        });

        Schema::table('donations', function (Blueprint $table) {

            // recreate with new values
            $table->enum('payment_method', [
                'cash',
                'check',
                'credit_card',
                'bank_transfer',
                'online',
                'khqr'
            ]);

        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {

            $table->dropColumn('payment_method');

        });

        Schema::table('donations', function (Blueprint $table) {

            $table->enum('payment_method', [
                'cash',
                'check',
                'credit_card',
                'bank_transfer',
                'online'
            ]);

        });
    }
};