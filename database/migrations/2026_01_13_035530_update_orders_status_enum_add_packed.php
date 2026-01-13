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
        // Mengubah ENUM status untuk menambahkan status 'confirmed' dan 'packed'
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'confirmed', 'paid', 'packed', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke ENUM semula
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending'");
    }
};
