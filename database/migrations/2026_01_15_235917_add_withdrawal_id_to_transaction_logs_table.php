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
        // Tambahkan foreign key constraint untuk withdrawal_id
        // setelah tabel withdrawal_requests dibuat
        Schema::table('transaction_logs', function (Blueprint $table) {
            $table->foreign('withdrawal_id')
                  ->references('id')
                  ->on('withdrawal_requests')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_logs', function (Blueprint $table) {
            $table->dropForeign(['withdrawal_id']);
        });
    }
};
