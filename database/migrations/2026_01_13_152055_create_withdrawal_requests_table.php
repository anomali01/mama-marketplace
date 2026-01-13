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
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('validator_id')->nullable()->constrained('users')->nullOnDelete()->comment('Validator yang menangani penarikan');
            $table->decimal('amount', 12, 2)->comment('Jumlah penarikan (97% dari total penjualan)');
            $table->decimal('total_sales', 12, 2)->comment('Total penjualan');
            $table->decimal('validator_fee', 12, 2)->comment('Fee validator (3%)');
            $table->string('seller_bank_name', 100)->comment('Nama bank seller');
            $table->string('seller_account_number', 50)->comment('Nomor rekening seller');
            $table->string('seller_account_holder_name', 150)->comment('Nama pemilik rekening seller');
            $table->enum('status', ['pending', 'processing', 'transferred', 'completed', 'rejected'])->default('pending');
            $table->text('note')->nullable();
            $table->string('transfer_proof')->nullable()->comment('Bukti transfer dari validator');
            $table->timestamp('transferred_at')->nullable()->comment('Waktu validator transfer');
            $table->timestamp('completed_at')->nullable()->comment('Waktu seller konfirmasi terima');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
    }
};
