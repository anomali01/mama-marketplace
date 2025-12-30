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
            $table->string('shop_name', 100)->nullable()->after('phone');
            $table->text('shop_description')->nullable()->after('shop_name');
            $table->text('shop_address')->nullable()->after('shop_description');
            $table->string('shop_image')->nullable()->after('shop_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['shop_name', 'shop_description', 'shop_address', 'shop_image']);
        });
    }
};
