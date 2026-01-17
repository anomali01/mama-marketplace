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
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->comment('User yang terkait dengan transaksi');
            $table->foreignId('order_id')->nullable()->constrained('orders')->cascadeOnDelete();
            $table->unsignedBigInteger('withdrawal_id')->nullable();
            $table->enum('type', [
                'order_income',           // Pendapatan dari order
                'validator_commission',   // Komisi validator
                'withdrawal',             // Penarikan saldo
                'refund',                 // Pengembalian dana
                'adjustment'              // Penyesuaian manual
            ])->comment('Tipe transaksi');
            $table->decimal('amount', 12, 2)->comment('Jumlah uang');
            $table->decimal('balance_before', 12, 2)->default(0)->comment('Saldo sebelum transaksi');
            $table->decimal('balance_after', 12, 2)->default(0)->comment('Saldo setelah transaksi');
            $table->enum('status', ['pending', 'completed', 'cancelled', 'failed'])->default('pending');
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Note: Foreign key untuk withdrawal_id akan ditambahkan di migration 
            // 2026_01_15_235917 setelah tabel withdrawal_requests dibuat
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_logs');
    }
};
