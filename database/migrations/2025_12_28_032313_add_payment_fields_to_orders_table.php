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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_proof')->nullable()->after('payment_method'); // Bukti transfer
            $table->enum('payment_status', ['unpaid', 'pending_confirmation', 'confirmed', 'rejected'])->default('unpaid')->after('payment_proof');
            $table->string('delivery_proof')->nullable()->after('payment_status'); // Bukti terima barang
            $table->text('notes')->nullable()->after('delivery_proof'); // Catatan tambahan
            $table->timestamp('confirmed_at')->nullable()->after('notes'); // Waktu konfirmasi pembayaran
            $table->timestamp('packed_at')->nullable()->after('confirmed_at'); // Waktu dikemas
            $table->timestamp('shipped_at')->nullable()->after('packed_at'); // Waktu dikirim
            $table->timestamp('delivered_at')->nullable()->after('shipped_at'); // Waktu diterima
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_proof',
                'payment_status',
                'delivery_proof',
                'notes',
                'confirmed_at',
                'packed_at',
                'shipped_at',
                'delivered_at'
            ]);
        });
    }
};
