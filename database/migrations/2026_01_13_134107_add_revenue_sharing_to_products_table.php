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
        Schema::table('products', function (Blueprint $table) {
            // Persentase bagi hasil yang diusulkan penjual untuk validator (0-100)
            $table->decimal('seller_proposed_validator_share', 5, 2)->nullable()->after('rejection_reason')->comment('Persentase untuk validator yang diusulkan penjual');
            
            // Persentase bagi hasil yang diusulkan validator (jika menolak usulan penjual)
            $table->decimal('validator_proposed_validator_share', 5, 2)->nullable()->after('seller_proposed_validator_share')->comment('Persentase untuk validator yang diusulkan validator');
            
            // Persentase bagi hasil yang disepakati (setelah disetujui)
            $table->decimal('agreed_validator_share', 5, 2)->nullable()->after('validator_proposed_validator_share')->comment('Persentase untuk validator yang disepakati');
            
            // Status bagi hasil: pending (menunggu), negotiation (dalam negosiasi), agreed (disepakati)
            $table->enum('revenue_share_status', ['pending', 'negotiation', 'agreed'])->default('pending')->after('agreed_validator_share');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'seller_proposed_validator_share',
                'validator_proposed_validator_share',
                'agreed_validator_share',
                'revenue_share_status'
            ]);
        });
    }
};
