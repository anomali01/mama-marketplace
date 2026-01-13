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
        Schema::table('users', function (Blueprint $table) {
            // Field untuk rekening seller (untuk menerima hasil penjualan)
            $table->string('seller_bank_name', 100)->nullable()->after('account_holder_name')->comment('Nama bank untuk seller');
            $table->string('seller_account_number', 50)->nullable()->after('seller_bank_name')->comment('Nomor rekening untuk seller');
            $table->string('seller_account_holder_name', 150)->nullable()->after('seller_account_number')->comment('Nama pemilik rekening seller');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['seller_bank_name', 'seller_account_number', 'seller_account_holder_name']);
        });
    }
};
