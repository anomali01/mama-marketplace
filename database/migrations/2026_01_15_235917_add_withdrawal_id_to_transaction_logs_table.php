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
        Schema::table('transaction_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->unsignedBigInteger('withdrawal_id')->nullable()->after('order_id');
            $table->decimal('balance_before', 15, 2)->nullable()->after('amount');
            $table->decimal('balance_after', 15, 2)->nullable()->after('balance_before');
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('withdrawal_id')->references('id')->on('withdrawal_requests')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_logs', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['withdrawal_id']);
            $table->dropColumn(['user_id', 'withdrawal_id', 'balance_before', 'balance_after']);
        });
    }
};
