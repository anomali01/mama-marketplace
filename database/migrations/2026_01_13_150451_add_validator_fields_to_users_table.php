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
            // Field khusus untuk validator - NIM sudah ada di migration sebelumnya
            $table->string('bank_name', 100)->nullable()->after('nim')->comment('Nama bank untuk validator');
            $table->string('account_number', 50)->nullable()->after('bank_name')->comment('Nomor rekening untuk validator');
            $table->string('account_holder_name', 150)->nullable()->after('account_number')->comment('Nama pemilik rekening');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bank_name', 'account_number', 'account_holder_name']);
        });
    }
};
