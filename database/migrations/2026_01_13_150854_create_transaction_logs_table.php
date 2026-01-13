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
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('validator_id')->constrained('users')->cascadeOnDelete()->comment('Validator yang mengelola transaksi');
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete()->comment('Penjual yang menerima uang');
            $table->enum('type', ['in', 'out'])->comment('in = uang masuk dari pembeli, out = uang keluar ke penjual');
            $table->decimal('amount', 12, 2)->comment('Jumlah uang');
            $table->decimal('validator_fee', 12, 2)->default(0)->comment('Fee validator (3%)');
            $table->decimal('seller_amount', 12, 2)->default(0)->comment('Jumlah untuk penjual (97%)');
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->text('description')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
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
